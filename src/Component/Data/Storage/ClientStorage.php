<?php

namespace App\Component\Data\Storage;

use App\Component\Data\Entities\Client;

class ClientStorage extends BaseStorage
{
    protected function getClass(): string
    {
        return Client::class;
    }
}
