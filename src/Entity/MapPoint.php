<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\Entity;

class MapPoint
{
    public function __construct(
        protected string $title,
        protected ?string $description,
        protected CoordinatesDto $coordinates
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCoordinates(): CoordinatesDto
    {
        return $this->coordinates;
    }

    public function setCoordinates(CoordinatesDto $coordinates): void
    {
        $this->coordinates = $coordinates;
    }
}
