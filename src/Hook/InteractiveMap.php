<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\Hook;

use http\Exception\InvalidArgumentException;
use http\Exception\RuntimeException;
use LDefaut\WpPlugin\InteractiveMaps\View\ShortcodeView;

class InteractiveMap
{
    public const SHORTCODE_NAME = 'interactive-map';
    public function __construct()
    {
        add_shortcode(self::SHORTCODE_NAME, [$this, 'interactiveMapShortcut']);
    }

    public function interactiveMapShortcut(array $args): ?string
    {
        $attributes = shortcode_atts(['id' => null], $args);
        extract($attributes);

        if ($id === null) {
            throw new InvalidArgumentException('Id argument should not be null');
        }

        $interactiveMap = get_post((int) $id);
        if ($interactiveMap instanceof \WP_Post === false) {
            throw new RuntimeException('Unknown map provided');
        }

        $props = [
            'interactiveMap' => $interactiveMap
        ];

        $shortcodeView = new ShortcodeView($props);

        return $shortcodeView->render();
    }
}
