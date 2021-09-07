<?php

namespace App;

use App\Component\App\ApplicationInterface;
use Psr\Container\ContainerInterface;
use Swoole\Server;

abstract class Kernel implements KernelInterface
{
    protected ?ContainerInterface $container = null;
    protected Server $server;
    protected ApplicationInterface $application;

    public function __construct(Server $server, ApplicationInterface $application)
    {
        $this->server = $server;
        $this->application = $application;
    }

    public function setContainer(ContainerInterface $container): static
    {
        $this->container = $container;
        return $this;
    }

    public function listen(): void
    {
        $this->server->start();
    }

    abstract public function handle(Server $server, string $data, array $clientInfo): void;
}
