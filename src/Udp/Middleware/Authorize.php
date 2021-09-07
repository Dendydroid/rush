<?php

namespace App\Udp\Middleware;

use App\Component\Data\Entities\AuthToken;
use App\Component\Data\Storage\AuthTokenStorage;
use App\Component\Data\Entities\Client;
use App\Udp\Request\Packet;
use Psr\Log\LoggerInterface;

class Authorize extends BaseMiddleware
{
    private LoggerInterface $logger;
    private AuthTokenStorage $authTokenStorage;

    public function __construct(LoggerInterface $logger, AuthTokenStorage $authTokenStorage)
    {
        $this->logger = $logger;
        $this->authTokenStorage = $authTokenStorage;
    }

    public function __invoke(Client $client, Packet $packet): bool
    {
        $this->logger->info("Current tokens [{$packet->getRoute()}]", [$currentTokens = $this->authTokenStorage->getAll()]);
        /** @var AuthToken|null $token */
        $token = $this->authTokenStorage->getItem($client->getId());
        if ($packet->getRoute() !== 'auth' && $token !== null) {
            if ($token->getToken() !== $packet->getAuthToken()) {
                $this->logger->info('Failed to authorize token: ' . $packet->getAuthToken(), [
                    'tokens' => $currentTokens,
                    '$token' => $token->getToken(),
                    '$packet->getAuthToken()' => $packet->getAuthToken(),
                ]);
                return false;
            }
        } else {
            $this->authTokenStorage->remove($client->getId());
            $authToken = (new AuthToken())->setToken($tokenValue = sha1($client->getId() . time()));
            $this->authTokenStorage->add($authToken, $client->getId());
            $this->logger->info("Added authToken $tokenValue for client {$client->getId()} to table");
            $packet->setAuthToken($tokenValue);
        }
        return true;
    }
}
