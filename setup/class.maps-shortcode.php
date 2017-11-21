<?php

/*
 *  Maps shortcode allows for map area to be added to content
 *  [map building='135' width='100%' height='480' ][/map]
 *  Width default is 100%. Height default is 480px.
 */

class UAMS_Map
{

    private static $buildingcode = array('127','116','117','118','119','120','121','122','123','124','125','128','129','126','131','130','132','133','134','135','136','137','138','139','141','142','143','144','145','146','147','148','149','150','151','152','153','154','115','2','3','4','7','6');

    const URL = '//maps.uams.edu/full-screen/?markerid=';

    function __construct()
    {
        add_shortcode('map', array($this, 'map_handler'));
    }

    function map_handler($atts, $content)
    {
        $attributes = (object) $atts;

        $classes = array('uams-btn');

        if (isset($attributes->building)){
            $building = esc_attr($attributes->building);
            if (!in_array($building, $this::$buildingcode)){
                return sprintf('Building "%s" is not supported', $building);
            }
        }
        else {
            return 'required attribute "building" missing';
        }

        $width = '100%';
        if (isset($attributes->width)){
            $width = $attributes->width;
        }

        $height = '480px';
        if (isset($attributes->height)){
            $height = $attributes->height;
        }

        $return = '<div class="uams-campus-map">
                  <iframe width="'. $width .'" height="'. $height .'" src="'.self::URL.$building.'" frameborder="0"></iframe>
                  <a href="https://maps.uams.edu/map-mashup/?markerid='.$building.'" target="_blank">View full map</a>
                </div>';

        return $return;
    }
}
