<?php

namespace App\ServiceFactory;

use App\Component\App\ApplicationInterface;
use App\Component\Data\Storage\AuthTokenStorage;
use App\Component\Data\Storage\ClientStorage;
use App\Component\Data\Storage\PlayerStorage;
use App\KernelInterface;
use App\RushKernel;
use Psr\Log\LoggerInterface;
use Swoole\Server;

final class KernelFactory
{
    public function create(
        Server $server,
        ApplicationInterface $application,
        LoggerInterface $logger,
        ClientStorage $clientStorage,
        AuthTokenStorage $authTokenStorage,
        PlayerStorage $playerStorage,
        array $udp,
    ): KernelInterface {
        return new RushKernel($server, $application, $logger, $clientStorage, $authTokenStorage, $playerStorage, $udp);
    }
}
