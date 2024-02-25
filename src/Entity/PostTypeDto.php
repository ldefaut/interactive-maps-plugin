<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\Entity;

use const LDefaut\WpPlugin\InteractiveMaps\PLUGIN_DOMAIN;

class PostTypeDto
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected string $singularName,
        protected string|bool $showInMenu = true
    ) {
        register_post_type(
            $this->id,
            [
                'public' => true,
                'show_in_menu' => $this->showInMenu,
                'labels' => [
                    'name' => __($this->name, PLUGIN_DOMAIN),
                    'singular_name' => __($this->singularName, PLUGIN_DOMAIN),
                    'add_new_item' => __('Add new ' . $this->singularName, PLUGIN_DOMAIN),
                    'name_admin_bar' => __('Add new ' . $this->singularName, PLUGIN_DOMAIN),
                ],
            ]
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSingularName(): ?string
    {
        return $this->singularName;
    }

    public function isShowInMenu(): bool|string
    {
        return $this->showInMenu;
    }
}
