<?php

namespace App\ServiceFactory;

use App\Component\App\ApplicationInterface;
use App\Component\App\RushApplication;
use JetBrains\PhpStorm\Pure;

final class ApplicationFactory
{
    #[Pure] public function create(): ApplicationInterface
    {
        return new RushApplication();
    }
}
