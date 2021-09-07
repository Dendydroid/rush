<?php

namespace App\ServiceFactory\Storage;

use App\Component\Data\Storage\AuthTokenStorage;

final class AuthTokenStorageFactory
{
    public function create(): AuthTokenStorage
    {
        return new AuthTokenStorage(1024);
    }
}
