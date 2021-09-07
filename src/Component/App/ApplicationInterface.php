<?php

namespace App\Component\App;

interface ApplicationInterface
{
    public function getApplication(): string;
    public function getEnvironment(): string;
    public function setEnvironment(string $environment): static;
}
