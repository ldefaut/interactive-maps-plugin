<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\View;

abstract class AbstractView
{
    public function __construct(protected array $props = [])
    {
        $this->render();
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }

    abstract public function render(): string|null;

    public function getProps(): array
    {
        return $this->props;
    }

    public function enqueueAssets(): void
    {
    }

    public function setProps(array $props): void
    {
        $this->props = $props;
    }
}
