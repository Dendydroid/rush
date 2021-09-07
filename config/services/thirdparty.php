<?php

use App\Api\GeoApi;
use App\ServiceFactory\GeoApiFactory;
use App\ServiceFactory\GuzzleClientFactory;
use GuzzleHttp\Client;

return [
    Client::class => DI\factory([GuzzleClientFactory::class, 'create']),
    GeoApi::class => DI\factory([GeoApiFactory::class, 'create'])
        ->parameter('apiConfig', DI\get('api'))
];
