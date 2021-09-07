<?php

namespace App\Component\App;

use App\Component\Enum\ApplicationEnum;

class RushApplication extends BaseApplication
{
    public function getApplication(): string
    {
        return ApplicationEnum::DEFAULT_APP;
    }
}
