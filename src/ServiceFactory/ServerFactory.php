<?php

namespace App\ServiceFactory;

use App\Component\Core\DIContainer;
use App\KernelInterface;
use Swoole\Server;

final class ServerFactory
{
    public function create(array $serverConfig): Server
    {
        $server = new Server($serverConfig['host'], (int)$serverConfig['port'], SWOOLE_BASE, SWOOLE_SOCK_UDP);
        $server->set(
            [
                'worker_num' => 8,
                'daemonize' => false,
                'backlog' => 128,
            ]
        );

        $server->on(
            'Packet',
            function ($server, $clientInfo, $data) {
                /** @var KernelInterface $kernel */
                $kernel = DIContainer::getContainer()->get(KernelInterface::class);
                $kernel->handle($server, $clientInfo, $data);
            }
        );

        return $server;
    }
}
