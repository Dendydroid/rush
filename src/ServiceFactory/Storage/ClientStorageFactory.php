<?php

namespace App\ServiceFactory\Storage;

use App\Component\Data\Storage\ClientStorage;

final class ClientStorageFactory
{
     public function create(): ClientStorage
    {
        return new ClientStorage(1024);
    }
}
