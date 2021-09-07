<?php

namespace App\Component\Data\Entities;

class Player extends BaseEntity
{
    public ?string $id = null;

    public ?string $name = null;

    public ?string $country = null;

    public int $x = 0;

    public int $y = 0;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;
        return $this;
    }

    public function moveX(float $x): void
    {
        $this->x += $x;
    }

    public function moveY(float $y): void
    {
        $this->y += $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function setX(int $x): static
    {
        $this->x = $x;
        return $this;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function setY(int $y): static
    {
        $this->y = $y;
        return $this;
    }
}