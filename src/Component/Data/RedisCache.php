<?php

namespace App\Component\Data;

use Redis;

class RedisCache implements CacheInterface
{
    protected Redis $client;

    public function __construct()
    {
        $this->client = new Redis();
    }

    public function set(string $key, $data): void
    {
        $this->client->set($key, $data);
    }

    public function get(string $key)
    {
        return $this->client->get($key);
    }

    public function clear(): void
    {
        $this->client->flushAll();
    }

    public function getKeys(?string $pattern = "*"): void
    {
        $this->client->keys($pattern);
    }

    public function getClient(): Redis
    {
        return $this->client;
    }

    public function has(string $key): bool
    {
        return $this->client->exists($key);
    }
}
