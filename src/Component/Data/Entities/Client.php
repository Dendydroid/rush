<?php

namespace App\Component\Data\Entities;

class Client extends BaseEntity
{
    public ?int $address = null;
    public ?int $port = null;
    public ?int $serverPort = null;
    public ?float $lastRequestTime = null;
    public ?int $socket = null;
    public ?array $user = null;
    public ?string $id = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getAddress(): ?int
    {
        return $this->address;
    }

    public function setAddress(?int $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort(?int $port): static
    {
        $this->port = $port;
        return $this;
    }

    public function getServerPort(): ?int
    {
        return $this->serverPort;
    }

    public function setServerPort(?int $serverPort): static
    {
        $this->serverPort = $serverPort;
        return $this;
    }

    public function getLastRequestTime(): ?float
    {
        return $this->lastRequestTime;
    }

    public function setLastRequestTime(?float $lastRequestTime): static
    {
        $this->lastRequestTime = $lastRequestTime;
        return $this;
    }

    public function getSocket(): ?int
    {
        return $this->socket;
    }

    public function setSocket(?int $socket): static
    {
        $this->socket = $socket;
        return $this;
    }

    public function getUser(): ?array
    {
        return $this->user;
    }

    public function setUser(?array $user): static
    {
        $this->user = $user;
        return $this;
    }
}
