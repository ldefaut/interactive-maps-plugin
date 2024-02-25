<?php

declare(strict_types=1);

namespace LDefaut\WpPlugin\InteractiveMaps\View;

use http\Exception\InvalidArgumentException;
use LDefaut\WpPlugin\InteractiveMaps\Entity\CoordinatesDto;
use LDefaut\WpPlugin\InteractiveMaps\Entity\InteractiveMap;
use LDefaut\WpPlugin\InteractiveMaps\Entity\MapPoint;

use function LDefaut\WpPlugin\InteractiveMaps\dd;

class ShortcodeView extends AbstractView
{
    protected InteractiveMap $interactiveMap;
    public function render(): ?string
    {
        $this->setObjects();

        $html = '<div id="interactive-map-plugin-'. $this->interactiveMap->getId() .'" 
            class="interactive-map-plugin">';
        $html .= '<div 
                class="map-image"
                data-start-x="'. $this->interactiveMap->getStartCoordinates()->getX() .'"
                data-start-y="'. $this->interactiveMap->getStartCoordinates()->getY() .'"
                data-end-x="'. $this->interactiveMap->getEndCoordinates()->getX() .'"
                data-end-y="'. $this->interactiveMap->getEndCoordinates()->getY() .'"
                >';
        $html .= '<img src="'. $this->interactiveMap->getMap() .'">';
        $html .= '</div>';
        $html .= '<div class="map-points">';
        foreach ($this->interactiveMap->getMapPoints() as $mapPoint) {
            $html .= '<div 
                        class="map-point" 
                        data-x-coordinate="'. $mapPoint->getCoordinates()->getX().'"
                        data-y-coordinate="'. $mapPoint->getCoordinates()->getY() .'"
                        >';
            $html .= '<h5>'. $mapPoint->getTitle() .'</h5>';
            $html .= $mapPoint->getDescription() ?
                '<p>'. $mapPoint->getDescription() .'</p>' : '';
            $html .= "</div>";
        }
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    private function setObjects(): void
    {
        $props = $this->getProps();
        $wpPost = $props['interactiveMap'];
        assert($wpPost instanceof \WP_Post);
        $acfFields = get_fields($wpPost->ID);

        if (is_array($acfFields) === false || count($acfFields) === 0) {
            throw new InvalidArgumentException('Missing Acf fields for object');
        }

        $mapPoints = [];
        if (array_key_exists('map_points_linked', $acfFields)) {
            foreach ($acfFields['map_points_linked'] as $mapPointPost) {
                assert($mapPointPost instanceof \WP_Post);
                $mapPoints[] = new MapPoint(
                    $mapPointPost->post_title,
                    $mapPointPost->post_content,
                    new CoordinatesDto(
                        (float) get_field('map_point_coordinates_x', $mapPointPost->ID),
                        (float) get_field('map_point_coordinates_y', $mapPointPost->ID)
                    )
                );
            }
        }

        if (array_key_exists('image_map', $acfFields) === false) {
            throw new InvalidArgumentException('Missing Map image');
        }
        $map = $acfFields['image_map'];

        if (
            array_key_exists('coordinates', $acfFields) === false
            || array_key_exists('start_x', $acfFields['coordinates']) === false
            || array_key_exists('start_y', $acfFields['coordinates']) === false
            || array_key_exists('end_x', $acfFields['coordinates']) === false
            || array_key_exists('end_y', $acfFields['coordinates']) === false
        ) {
            throw new InvalidArgumentException('Missing map coordinates');
        }

        $startCoordinates = new CoordinatesDto(
            (float) $acfFields['coordinates']['start_x'],
            (float) $acfFields['coordinates']['start_y']
        );
        $endCoordinates = new CoordinatesDto(
            (float) $acfFields['coordinates']['end_x'],
            (float) $acfFields['coordinates']['end_y']
        );

        $this->interactiveMap = new InteractiveMap(
            $wpPost->ID,
            $wpPost->post_title,
            $map,
            $startCoordinates,
            $endCoordinates
        );
        $this->interactiveMap->setMapPoints($mapPoints);
    }

    public function enqueueAssets(): void
    {
        if (file_exists(sprintf('%sassets/css/shortcode.css', plugin_dir_path(dirname(__DIR__))))) {
            wp_enqueue_style(
                'interactive-map-shortcode-style',
                sprintf('%s/assets/css/shortcode.css', plugin_dir_url(dirname(__DIR__)))
            );
        }
        if (file_exists(sprintf('%sassets/js/shortcode.js', plugin_dir_path(dirname(__DIR__))))) {
            wp_enqueue_script(
                'interactive-map-shortcode-script',
                sprintf('%sassets/js/shortcode.js', plugin_dir_url(dirname(__DIR__)))
            );
        }
    }
}
