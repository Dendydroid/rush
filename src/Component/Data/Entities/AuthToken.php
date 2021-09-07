<?php

namespace App\Component\Data\Entities;

class AuthToken extends BaseEntity
{
    public ?string $token = null;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): static
    {
        $this->token = $token;
        return $this;
    }
}
