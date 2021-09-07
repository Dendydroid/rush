<?php

namespace App\Component\Data\Storage;

use App\Component\Data\Entities\AuthToken;

class AuthTokenStorage extends BaseStorage
{
    protected function getClass(): string
    {
        return AuthToken::class;
    }
}
