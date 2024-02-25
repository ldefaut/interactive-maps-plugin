<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\View;

abstract class AbstractView
{
    /** @param array<mixed> $props */
    public function __construct(protected array $props = [])
    {
        $this->render();
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    abstract public function render(): string|null;

    /** @return array<mixed> */
    public function getProps(): array
    {
        return $this->props;
    }

    public function enqueueAssets(): void
    {
    }

    /** @param array<mixed> $props */
    public function setProps(array $props): void
    {
        $this->props = $props;
    }
}
