<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\Entity;

class CoordinatesDto
{
    public function __construct(protected float $x, protected float $y)
    {
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function setX(float $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function setY(float $y): self
    {
        $this->y = $y;

        return $this;
    }
}
