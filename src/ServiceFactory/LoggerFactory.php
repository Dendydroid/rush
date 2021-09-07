<?php

namespace App\ServiceFactory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

final class LoggerFactory
{
    public function create(): LoggerInterface
    {
        $logger = new Logger('dump');
        $logger->pushHandler(new StreamHandler(DUMP_LOG_PATH, Logger::INFO));
        return $logger;
    }
}
