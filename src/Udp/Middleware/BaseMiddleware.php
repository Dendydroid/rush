<?php

namespace App\Udp\Middleware;

use App\Component\Data\Entities\Client;
use App\Udp\Request\Packet;

abstract class BaseMiddleware
{
    abstract public function __invoke(Client $client, Packet $packet);
}
