<?php

namespace App\Component\Core;

use DI\Container;

class DIContainer
{
    public static Container $container;

    public static function getContainer(): Container
    {
        return static::$container;
    }

    public static function setContainer(Container $container): void
    {
        static::$container = $container;
    }
}
