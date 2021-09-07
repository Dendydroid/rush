<?php

namespace App;

use App\Component\App\ApplicationInterface;
use App\Component\Core\DIContainer;
use App\Component\Data\Entities\AuthToken;
use App\Component\Data\Entities\Client;
use App\Component\Data\Storage\AuthTokenStorage;
use App\Component\Data\Storage\ClientStorage;
use App\Component\Data\Entities\Player;
use App\Component\Data\Storage\PlayerStorage;
use App\Udp\CommandController\BaseCommandController;
use App\Udp\Controller\BaseController;
use App\Udp\Middleware\BaseMiddleware;
use App\Udp\Request\CommandPacket;
use App\Udp\Request\Packet;
use App\Udp\Request\Response;
use Psr\Log\LoggerInterface;
use Swoole\Server;
use Throwable;

class RushKernel extends Kernel
{
    protected LoggerInterface $logger;
    protected ClientStorage $clientStorage;
    protected AuthTokenStorage $authTokenStorage;
    protected PlayerStorage $playerStorage;
    protected array $udpConfig;
    protected array $routes;
    protected array $commandRoutes;

    public function __construct(
        Server $server,
        ApplicationInterface $application,
        LoggerInterface $logger,
        ClientStorage $clientStorage,
        AuthTokenStorage $authTokenStorage,
        PlayerStorage $playerStorage,
        array $udpConfig,
    ) {
        parent::__construct($server, $application);
        $this->logger = $logger;
        $this->clientStorage = $clientStorage;
        $this->authTokenStorage = $authTokenStorage;
        $this->playerStorage = $playerStorage;
        $this->udpConfig = $udpConfig;
        $this->routes = DIContainer::getContainer()->get('routes');
        $this->commandRoutes = DIContainer::getContainer()->get('command_routes');
    }

    private function convertIp(string $address): int
    {
        return ip2long($address);
    }

    private function maxStaleConnectionSeconds(): int
    {
        return 10 * 60;
    }

    private function clearOldConnections(): void
    {
        /**
         * @var string $id
         * @var Client $client
         */
        foreach ($this->clientStorage->getAll() as $id => $client) {
            if ($client->getLastRequestTime() < (time() - $this->maxStaleConnectionSeconds())) {
                $this->clientStorage->remove($id);
                $this->authTokenStorage->remove($id);
            }
        }
    }

    private function resolvePacket(string $data): Packet|CommandPacket|null
    {
        try {
            [$route, $authToken, $jsonData] = explode($this->udpConfig['packet']['separator'], $data);

            if ($authToken === $_ENV['RCON_PASS']) {
                $packet = (new CommandPacket())
                    ->setData(json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR))
                    ->setAuthToken($authToken)
                    ->setRoute($route);
            } else {
                $this->logger->info('PACKET', [$route, $authToken, $jsonData]);
                $packet = (new Packet())
                    ->setData(json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR))
                    ->setAuthToken($authToken)
                    ->setRoute($route);
            }
        } catch (Throwable) {
            $this->logger->error("Invalid packet was received:\n ($data)");
            return null;
        }
        return $packet;
    }

    public function addPlayer(string $id, Player $player): void
    {
        $this->playerStorage->add($player, $id);
    }

    public function updatePlayer(string $id, Player $player): void
    {
        $this->playerStorage->update($id, $player);
    }

    public function getPlayers(): array
    {
        return $this->playerStorage->getAll();
    }

    public function resetData(): void
    {
        $this->authTokenStorage->clear();
        $this->clientStorage->clear();
        $this->playerStorage->clear();
    }

    public function getPlayerByClient(Client $client): ?Player
    {
        $this->logger->info("players search for {$client->getId()}", $this->getPlayers());
        foreach ($this->getPlayers() as $player) {
            if ($player->getId() === $client->getId()) {
                return $player;
            }
        }
        return null;
    }

    public function sendToPlayer(Player $player, array $data, ?string $command = null): void
    {
        $response = new Response();
        if ($command !== null) {
            $response->setCommand($command);
        }
        foreach ($data as $key => $value) {
            $response->addData($key, $value);
        }
        /** @var Client $client */
        $client = $this->clientStorage->getItem($player->getId());
        /** @var AuthToken $authToken */
        $authToken = $this->authTokenStorage->getItem($player->getId());
        $response->setAuthToken($authToken->getToken());
        $this->server->sendto(long2ip($client->getAddress()), $client->getPort(), $response);
    }

    public function handle(Server $server, string $data, array $clientInfo): void
    {
//        $this->clientStorage->clear();
//        $this->clearOldConnections();

        if ($packet = $this->resolvePacket($data)) {
            # RCON commands handling
            if ($packet instanceof CommandPacket) {
                if (!array_key_exists($packet->getRoute(), $this->commandRoutes)) {
                    $this->logger->error("RCON has requested unknown route {$packet->getRoute()}");
                } else {
                    $route = $this->commandRoutes[$packet->getRoute()];
                    [$controllerClass, $method] = $route['controller'];
                    /** @var BaseCommandController $controller */
                    $controller = $this->container->get($controllerClass);
                    $controller->$method($packet);
                    return;
                }
            }

            $ip = $this->convertIp($clientInfo['address']);
            $port = $clientInfo['port'];
            $clientId = $ip . $port;
            /** @var Client|null $client */
            if ($client = $this->clientStorage->getItem($clientId)) {
                $this->logger->info('Client exists: ' . $clientId);
                $client->setLastRequestTime($clientInfo['dispatch_time'])
                    ->setId($clientId)
                    ->setAddress($ip)
                    ->setServerPort($clientInfo['server_port'])
                    ->setPort($port)
                    ->setSocket($clientInfo['server_socket']);
                $this->clientStorage->update($clientId, $client);
            } else {
                $this->logger->info('Adding new client: ' . $clientId);
                $client = (new Client())
                    ->setAddress($ip)
                    ->setId($clientId)
                    ->setServerPort($clientInfo['server_port'])
                    ->setPort($clientInfo['port'])
                    ->setLastRequestTime($clientInfo['dispatch_time'])
                    ->setSocket($clientInfo['server_socket']);
                $this->clientStorage->remove($clientId);
                $this->clientStorage->add($client, $clientId);
            }

            if (!array_key_exists($packet->getRoute(), $this->routes)) {
                $this->logger->error("{$clientInfo['address']} has requested unknown route {$packet->getRoute()}");
            } else {
                $route = $this->routes[$packet->getRoute()];
                if (!empty($route['middlewares'])) {
                    foreach ($route['middlewares'] as $middlewareClass) {
                        /** @var BaseMiddleware $middleware */
                        $middleware = $this->container->get($middlewareClass);
                        if (!$middleware($client, $packet)) {
                            return;
                        }
                    }
                }
                [$controllerClass, $method] = $route['controller'];
                /** @var BaseController $controller */
                $controller = $this->container->get($controllerClass);
                $controller->setClient($client);
                /** @var Response $response */
                if ($response = $controller->$method($packet)) {
                    $response->setAuthToken($packet->getAuthToken());
                    $this->server->sendto(
                        $clientInfo['address'],
                        $clientInfo['port'],
                        $response,
                        $clientInfo['server_socket']
                    );
                }
            }
        }
    }
}
