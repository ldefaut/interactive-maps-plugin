<?php

/**
 * @package Interactive Maps Plugin
 */

/**
 * Plugin Name: Interactive Maps Plugin
 * Version: 1.0.0
 * Author: Louis DEFAUT
 * Author URI: https://louisdefaut.fr
 * Text Domain: ldefaut_interactive_maps
 */

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps;

use LDefaut\WpPlugin\InteractiveMaps\Controller\PluginInit;

const PLUGIN_DOMAIN = 'interactive-maps';
class InteractiveMaps {
    private array $includeFolders = [
        "src/Helper",
        "src/Entity",
        "src/Repository",
        "src/Controller",
        "src/Hook",
        "src/View"
    ];

    private array $instanciateFolder = [
        "src/Controller",
        "src/Hook"
    ];

    public function __construct() {
        $this->includeFiles();
        $this->instanciateClasses();
    }

    /** Inclut les fichiers */
    public function includeFiles(): void
    {
        foreach ($this->includeFolders as $folder) {
            // Dans chaque dossier, on inclut chaque fichiers php
            foreach (glob(plugin_dir_path( __FILE__ ). "$folder/*.php") as $filename) {
                include_once "$filename";
            }
        }
    }

    /** Instancie les fichiers */
    public function instanciateClasses(): void
    {
        if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
            require_once dirname( __FILE__ ) . '/vendor/autoload.php';
        }

        foreach ($this->instanciateFolder as $folder) {
            foreach (glob(plugin_dir_path( __FILE__ ). "$folder/*.php") as $filepath) {
                $class = sprintf(
                    '%s\%s\%s',
                    __NAMESPACE__,
                    str_replace('src/', '', $folder),
                    basename($filepath, ".php")
                );

                new $class();
            }
        }
    }
}

new InteractiveMaps();