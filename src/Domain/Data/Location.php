<?php

namespace App\Domain\Data;

class Location
{
    private float $x;
    private float $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function setX(float $x): static
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function setY(float $y): static
    {
        $this->y = $y;
        return $this;
    }
}