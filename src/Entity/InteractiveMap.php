<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\Entity;

class InteractiveMap
{
    /** @param array<MapPoint> $mapPoints */
    public function __construct(
        protected int $id,
        protected string $title,
        protected string $map,
        protected CoordinatesDto $startCoordinates,
        protected CoordinatesDto $endCoordinates,
        protected array $mapPoints = []
    ) {
    }

    public function getMapPoints(): array
    {
        return $this->mapPoints;
    }

    public function setMapPoints(array $mapPoints): self
    {
        $this->mapPoints = $mapPoints;

        return $this;
    }

    public function getStartCoordinates(): CoordinatesDto
    {
        return $this->startCoordinates;
    }

    public function setStartCoordinates(CoordinatesDto $startCoordinates): self
    {
        $this->startCoordinates = $startCoordinates;

        return $this;
    }

    public function getEndCoordinates(): CoordinatesDto
    {
        return $this->endCoordinates;
    }

    public function setEndCoordinates(CoordinatesDto $endCoordinates): self
    {
        $this->endCoordinates = $endCoordinates;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMap(): string
    {
        return $this->map;
    }

    public function setMap(string $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
