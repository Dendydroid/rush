<?php

return [
    'environment' => $_ENV['ENVIRONMENT'],
    'server' => [
        'rconPassword' => $_ENV['RCON_PASS'],
        'host' => $_ENV['SERVER_HOST'],
        'port' => $_ENV['SERVER_PORT'],
    ],
    'udp' => [
        'packet' => [
            'separator' => '|'
        ]
    ],
    'api' => [
        'geo' => [
            'url' => $_ENV['GEO_API_URL'],
            'key' => $_ENV['GEO_API_KEY'],
        ]
    ]
];
