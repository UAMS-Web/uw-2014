<?php

/*
 *  Button shortcode allows for styled buttons to be added to content
 *  [button color='gray' type='type' url='link url' size='small']Button Text[/button]
 *  optional small attribute makes the button small.  Assume large if not present
 */

class UAMS_Button
{

    private static $types = array('plus', 'go', 'external', 'play');

    function __construct()
    {
        add_shortcode('button', array($this, 'button_handler'));
    }

    function button_handler($atts, $content)
    {
        $attributes = (object) $atts;

        $classes = array('uams-btn');

        $btnColors = shortcode_atts( array(
            'color' => 'none',
        ), $atts );


        $color = 'btn-' . $btnColors['color'];

        if(empty($content) && empty($attributes->text)){
            echo 'No text in this button';
            return;
        }

        if (isset($attributes->type)){
            $type = strtolower($attributes->type);
            if (in_array($type, $this::$types)){
                array_push($classes, 'btn-' . $type);
            }
        }

        $url = '#';
        if (isset($attributes->url)){
            $url = $attributes->url;
        }

        if (property_exists($attributes, 'small')){
            array_push($classes, 'btn-sm');
        }

        if (isset($attributes->size)){
            if (in_array($attributes->size, array('small', 'sm'))){
                array_push($classes, 'btn-sm');
            } elseif (in_array($attributes->size, array('large', 'lg'))) {
                array_push($classes, 'btn-lg');
            }
        }

        if (isset($attributes->text)){
            $content = $attributes->text;
        }

        $class_string = implode($classes, ' ');

        return sprintf('<a class="%s %s" href="%s">%s</a>', $class_string, $color, $url, $content);
    }
}
