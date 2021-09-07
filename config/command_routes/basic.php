<?php

use App\Udp\CommandController\ClearController;
use App\Udp\CommandController\TickController;

return [
    'tick' => [
        'controller' => [TickController::class, 'tick'],
    ],
    'clear' => [
        'controller' => [ClearController::class, 'clearData'],
    ]
];
