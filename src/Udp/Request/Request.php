<?php

namespace App\Udp\Request;

class Request
{
    protected string $data;

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;
        return $this;
    }
}