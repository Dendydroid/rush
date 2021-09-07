<?php

namespace App\Udp\CommandController;

use App\KernelInterface;
use App\Udp\Request\CommandPacket;
use Psr\Log\LoggerInterface;

class ClearController extends BaseCommandController
{
    private KernelInterface $kernel;
    private LoggerInterface $logger;

    public function __construct(KernelInterface $kernel, LoggerInterface $logger)
    {
        $this->kernel = $kernel;
        $this->logger = $logger;
    }

    public function clearData(CommandPacket $packet): void
    {
        $this->logger->info("Resetting server data..");
        $this->kernel->resetData();
    }
}
