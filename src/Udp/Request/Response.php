<?php

namespace App\Udp\Request;

use JsonException;

class Response
{
    protected array $data = [];
    protected ?string $command = null;
    protected ?string $authToken = null;

    public function addData(string $key, $data): static
    {
        $this->data[$key] = $data;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function setCommand(?string $command): static
    {
        $this->command = $command;
        return $this;
    }

    public function getAuthToken(): ?string
    {
        return $this->authToken;
    }

    public function setAuthToken(?string $authToken): static
    {
        $this->authToken = $authToken;
        return $this;
    }

    /** @throws JsonException */
    public function __toString(): string
    {
        return "{$this->getCommand()}|{$this->getAuthToken()}|" . json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}
