<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\Controller;

use LDefaut\WpPlugin\InteractiveMaps\Entity\PostTypeDto;
use LDefaut\WpPlugin\InteractiveMaps\Hook\InteractiveMap;
use LDefaut\WpPlugin\InteractiveMaps\View\PluginAdminView;

class PluginInit
{
    protected PostTypeDto $interactiveMap;
    protected PostTypeDto $mapPoint;
    public function __construct()
    {
        add_action('init', [$this, 'pluginPrefixSetupPostType']);
        register_activation_hook(__FILE__, [$this, 'pluginPrefixActivate']);
        register_deactivation_hook(__FILE__, [$this, 'pluginPrefixDeactivate']);

        if (is_admin()) {
            add_action('admin_menu', [$this, 'pluginOptionsPage']);
            add_filter(
                'manage_interactive-maps_posts_columns',
                [$this, 'setInteractiveMapsColumns']
            );
            add_action(
                'manage_interactive-maps_posts_custom_column',
                [$this, 'fillInteractiveMapColumn'],
                10,
                2
            );
        }
    }

    public function pluginPrefixSetupPostType(): void
    {
        $this->interactiveMap = new PostTypeDto(
            'interactive-maps',
            'Interactive Maps',
            'Interactive Map',
        );
        $this->mapPoint = new PostTypeDto(
            'map-points',
            'Map Points',
            'Map Point',
            'edit.php?post_type=' . $this->interactiveMap->getId(),
        );
    }

    public function pluginPrefixActivate(): void
    {
        // Trigger our function that registers the custom post type plugin.
        $this->pluginPrefixSetupPostType();
        // Clear the permalinks after the post type has been registered.
        flush_rewrite_rules();
    }

    public function pluginPrefixDeactivate(): void
    {
        // Unregister the post type, so the rules are no longer in memory.
        unregister_post_type($this->interactiveMap->getId());
        unregister_post_type($this->mapPoint->getId());
        // Clear the permalinks to remove our post type's rules from the database.
        flush_rewrite_rules();
    }

    public function pluginOptionsPage(): void
    {
        // PLUGIN INDEX PAGE
        add_submenu_page(
            'edit.php?post_type=' . $this->interactiveMap->getId(),
            'Plugin Index',
            'Plugin Index',
            'manage_options',
            'plugin-index',
            [$this, 'displayIndex'],
            -1
        );
    }

    /**
     * @param array<string> $columns
     * @return array<string>
     */
    public function setInteractiveMapsColumns(array $columns): array
    {
        unset($columns['generated_shortcut']);
        $date = $columns['date'];
        unset($columns['date']);
        $columns['generated_shortcut'] = __('Generated shortcut', 'your_text_domain');
        $columns['date'] = $date;

        return $columns;
    }

    public function fillInteractiveMapColumn(string $column, string $postId): void
    {
        if ($column === 'generated_shortcut') {
            echo sprintf('[%s id=%s]', InteractiveMap::SHORTCODE_NAME, $postId);
        }
    }

    public function displayIndex(): void
    {
        $props = [
            'title' => $this->interactiveMap->getName()
        ];

        new PluginAdminView($props);
    }
}
