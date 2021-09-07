<?php

namespace App\Component\Data\Storage;

use App\Component\Data\Entities\Player;

class PlayerStorage extends BaseStorage
{
    protected function getClass(): string
    {
        return Player::class;
    }
}
