<?php

namespace App\Component\App;

abstract class BaseApplication implements ApplicationInterface
{
    protected string $environment;

    abstract public function getApplication(): string;

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): static
    {
        $this->environment = $environment;
        return $this;
    }
}
