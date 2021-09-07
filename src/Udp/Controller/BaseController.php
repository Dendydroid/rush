<?php

namespace App\Udp\Controller;

use App\Component\Data\Entities\Client;

/* This controller handles packets from client */
abstract class BaseController
{
    protected Client $client;

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getClient(): CLient
    {
        return $this->client;
    }
}
