<?php

namespace App\ServiceFactory;

use GuzzleHttp\Client;

final class GuzzleClientFactory
{
    public function create(): Client
    {
        return new Client();
    }
}
