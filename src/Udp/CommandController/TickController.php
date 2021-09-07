<?php

namespace App\Udp\CommandController;

use App\Component\Enum\ClientCommandEnum;
use App\Component\Data\Entities\Player;
use App\KernelInterface;
use App\Udp\Request\CommandPacket;
use Psr\Log\LoggerInterface;

class TickController extends BaseCommandController
{
    private KernelInterface $kernel;
    private LoggerInterface $logger;

    public function __construct(KernelInterface $kernel, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->logger = $logger;
    }

    public function tick(CommandPacket $packet): void
    {
        foreach ($players = $this->kernel->getPlayers() as $id => $player) {
            $otherPlayers = [];
            foreach ($players as $otherId => $otherPlayer) {
                if ($id !== $otherId) {
                    $otherPlayers[] = $otherPlayer->toArray();
                }
            }
            $this->kernel->sendToPlayer(
                $player,
                $sendData = [
                    'x' => $player->getX(),
                    'y' => $player->getY(),
                    /** @var Player $otherPlayer */
                    'players' => $otherPlayers
                ],
                ClientCommandEnum::POS
            );
//            $this->logger->info('Tick send to player ' . $player->getName(), $sendData);
        }
    }
}
