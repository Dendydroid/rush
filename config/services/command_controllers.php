<?php

use App\Udp\CommandController\TickController;

return [
    TickController::class => DI\autowire(TickController::class),
];
