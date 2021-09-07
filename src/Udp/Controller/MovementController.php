<?php

namespace App\Udp\Controller;

use App\KernelInterface;
use App\Udp\Request\Packet;
use Psr\Log\LoggerInterface;

class MovementController extends BaseController
{
    private LoggerInterface $logger;
    private KernelInterface $kernel;
    private const SPEED = 2;

    public function __construct(
        LoggerInterface $logger,
        KernelInterface $kernel,
    ) {
        $this->logger = $logger;
        $this->kernel = $kernel;
    }

    public function move(Packet $packet): void
    {
        $data = $packet->getData();
        $player = $this->kernel->getPlayerByClient($this->getClient());
        $this->logger->info(
            'move for',
            [
                'player' => $player!== null ? $player->getId(): 'null',
                'client' => $this->getClient()->getId(),
                'data' => $data
            ]
        );
        if ($player !== null) {
            $player->moveX($data['x'] * self::SPEED);
            $player->moveY($data['x'] * self::SPEED);
            $this->logger->info('New player coords: ', [
                'x' => $player->getX(),
                'y' => $player->getY(),
                'player' => $player,
                'gettype' => gettype($player->getId()),
                'id' => $player->getId(),
            ]);
            $this->kernel->updatePlayer($player->getId(), $player);
            $this->logger->info("PLAYERS", $this->kernel->getPlayers());
        }
    }
}
