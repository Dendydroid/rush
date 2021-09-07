<?php

namespace App\Component\Debug;

use JetBrains\PhpStorm\ArrayShape;
use Throwable;

class CommonErrorFormatter
{
    #[ArrayShape([
        "message" => "string",
        "location" => "string",
        "stack" => "array"
    ])] public static function formatException(
        Throwable $throwable
    ): array {
        return [
            "message" => $throwable->getMessage(),
            "location" => $throwable->getFile() . ":" . $throwable->getLine(),
            "stack" => $throwable->getTrace(),
        ];
    }
}
