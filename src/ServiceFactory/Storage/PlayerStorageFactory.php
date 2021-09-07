<?php

namespace App\ServiceFactory\Storage;

use App\Component\Data\Storage\PlayerStorage;

final class PlayerStorageFactory
{
    public function create(): PlayerStorage
    {
        return new PlayerStorage(1024);
    }
}
