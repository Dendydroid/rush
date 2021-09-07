<?php

namespace App\Component\Data\Entities;

use App\Component\Debug\ArrayHelper;
use JsonException;

abstract class BaseEntity
{
    public function toArray(): array
    {
        return ArrayHelper::objectToArray($this);
    }

    /** @throws JsonException */
    public function __toString(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}