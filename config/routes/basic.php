<?php

use App\Udp\Controller\InitController;
use App\Udp\Controller\MovementController;
use App\Udp\Middleware\Authorize;

return [
    'auth' => [
        'middlewares' => [Authorize::class],
        'controller' => [InitController::class, 'authenticate'],
    ],
    'move' => [
        'middlewares' => [Authorize::class],
        'controller' => [MovementController::class, 'move'],
    ]
];
