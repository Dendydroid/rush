<?php

use App\Component\App\ApplicationInterface;
use App\Component\Data\CacheInterface;
use App\KernelInterface;
use App\ServiceFactory\ApplicationFactory;
use App\ServiceFactory\CacheFactory;
use App\ServiceFactory\KernelFactory;
use App\ServiceFactory\LoggerFactory;
use App\ServiceFactory\PdoFactory;
use App\ServiceFactory\ServerFactory;
use Psr\Log\LoggerInterface;
use Swoole\Server;

return [
    ApplicationInterface::class => DI\factory([ApplicationFactory::class, 'create']),
    LoggerInterface::class => DI\factory([LoggerFactory::class, 'create']),
    KernelInterface::class => DI\factory([KernelFactory::class, 'create'])
        ->parameter('udp', DI\get('udp')),
    Server::class => DI\factory([ServerFactory::class, 'create'])
        ->parameter('serverConfig', DI\get('server')),
    CacheInterface::class => DI\factory([CacheFactory::class, 'create']),
    PDO::class => DI\factory([PdoFactory::class, 'create']),
];
