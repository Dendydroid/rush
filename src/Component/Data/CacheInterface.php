<?php

namespace App\Component\Data;

interface CacheInterface
{
    public function set(string $key, $data): void;

    public function get(string $key);

    public function has(string $key): bool;

    public function clear(): void;

    public function getKeys(?string $pattern = null): void;

    public function getClient();
}
