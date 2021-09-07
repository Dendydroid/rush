<?php

namespace App;

use App\Component\Data\Entities\Player;
use App\Component\Data\Entities\Client;
use Psr\Container\ContainerInterface;
use Swoole\Server;

interface KernelInterface
{
    public function listen();

    public function handle(Server $server, string $data, array $clientInfo);

    public function setContainer(ContainerInterface $container);

    public function addPlayer(string $id, Player $player);

    public function updatePlayer(string $id, Player $player);

    /** @return Player[] */
    public function getPlayers(): array;

    public function sendToPlayer(Player $player, array $data, ?string $command = null);

    public function getPlayerByClient(Client $client): ?Player;

    public function resetData(): void;
}
