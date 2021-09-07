<?php

use App\Component\Data\Storage\AuthTokenStorage;
use App\Component\Data\Storage\ClientStorage;
use App\Component\Data\Storage\PlayerStorage;
use App\ServiceFactory\Storage\AuthTokenStorageFactory;
use App\ServiceFactory\Storage\ClientStorageFactory;
use App\ServiceFactory\Storage\PlayerStorageFactory;

return [
    # Storage for client connections
    ClientStorage::class => DI\factory([ClientStorageFactory::class, 'create']),
    AuthTokenStorage::class => DI\factory([AuthTokenStorageFactory::class, 'create']),
    PlayerStorage::class => DI\factory([PlayerStorageFactory::class, 'create']),
];
