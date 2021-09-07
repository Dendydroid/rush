<?php

namespace App\ServiceFactory;

use App\Component\Data\CacheInterface;
use App\Component\Data\RedisCache;

final class CacheFactory
{
    public function create(): CacheInterface
    {
        $client = new RedisCache();
        $client->getClient()->connect($_ENV['REDIS_HOST']);
        return $client;
    }
}
