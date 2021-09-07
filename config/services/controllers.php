<?php

use App\Udp\Controller\InitController;

return [
    InitController::class => DI\autowire(InitController::class),
];
