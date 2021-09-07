<?php

namespace App\ServiceFactory;

use App\Api\GeoApi;
use GuzzleHttp\Client;
use JetBrains\PhpStorm\Pure;

final class GeoApiFactory
{
    #[Pure] public function create(Client $client, array $apiConfig): GeoApi
    {
        return new GeoApi($client, $apiConfig['geo']['url'], $apiConfig['geo']['key']);
    }
}
