<?php

namespace App\Udp\Controller;

use App\Api\GeoApi;
use App\Component\Data\Storage\ClientStorage;
use App\Component\Database\User;
use App\Component\Enum\ClientCommandEnum;
use App\Component\Data\Entities\Player;
use App\KernelInterface;
use App\Component\Data\Entities\Client;
use App\Udp\Request\Packet;
use App\Udp\Request\Response;
use Psr\Log\LoggerInterface;

class InitController extends BaseController
{
    private LoggerInterface $logger;
    private User $userRepo;
    private ClientStorage $clientStorage;
    private KernelInterface $kernel;
    private GeoApi $geoApi;

    public function __construct(
        LoggerInterface $logger,
        ClientStorage $clientStorage,
        KernelInterface $kernel,
        GeoApi $geoApi
    ) {
        $this->logger = $logger;
        $this->clientStorage = $clientStorage;
        $this->kernel = $kernel;
        $this->geoApi = $geoApi;
        $this->userRepo = User::build();
    }

    public function authenticate(Packet $packet): Response
    {
        $data = $packet->getData();
        $email = $data['email'] ?? null;
        $pass = $data['pass'] ?? null;

        $user = $this->userRepo->findUserByEmail($email);

        if ($user !== null && md5($pass) === $user['password']) {
            $this->logger->info('User Data', $user);

            /** @var Client $client */
            $client = $this->clientStorage->getItem($this->getClient()->getId());
            $client->setUser($user)
                ->setPort($this->getClient()->getPort())
                ->setAddress(
                    $this->getClient()
                        ->getAddress()
                )
                ->setSocket(
                    $this->getClient()->getSocket()
                );
            $this->clientStorage->update($client->getId(), $client);

            $this->logger->info('Current clients', [$this->clientStorage->getAll()]);

            $country = $this->geoApi->getCountryData(long2ip($client->getAddress()));

            /** @var Player|null $player */
            $player = $this->kernel->getPlayerByClient($client);
            if ($player === null) {
                $player =
                    new Player();
                if ($country !== null) {
                    $player->setCountry($country['country_code2']);
                }
                $address = $client->getAddress();
                $player->setId($client->getId())
                    ->setName($client->getUser()['email']);
                $this->kernel->addPlayer(
                    $player->getId(),
                    $player
                );

                $this->logger->info('Added new player ' . $player->getId(), [
                    'Current players' => $this->kernel->getPlayers()
                ]);
            }

            return (new Response())
                ->addData('name', $player->getName())
                ->addData('country', $player->getCountry())
                ->setCommand(ClientCommandEnum::IDLE);
        }

        return (new Response())
            ->setCommand(ClientCommandEnum::FUCKOFF);
    }
}
