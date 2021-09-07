<?php

use App\Udp\Middleware\Authorize;

return [
    Authorize::class => DI\autowire(Authorize::class),
];
