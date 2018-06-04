<?php

/*
 * Shortcode for embedding cards style module
 * [cards name='web name']
 * [card title='section title' size='med' type='top' footer='Update May 4, 2018' image='image-url' color='gray10'] content [/card]
 * [card title='section title' size='xs' type='bottom' action='<a href="some-url">Text</a>' image='image-url' color='gray10'] content [/card]
 * [card title='section title' size='xs' image='image-url' color='gray10'] content [/card]
 * [/cards]
 * [cards name='Horizontal']
 * [card title='section title' size='med' type='left' footer='Update May 4, 2018' image='image-url' color='gray10'] content [/card]
 * [card title='section title' size='med' type='right boxed' image='image-url' color='gray10'] content [/card]
 * [card title='section title' size='xl' image='image-url' color='gray10'] content [/card]
 * [/cards]
 * 
 * Types:
 *  Top: Image appears above all text
 *  Bottom: Image appears below all text
 *  Left: Image floats to the left of the text
 *  Right: Image floats to the right of the text
 *  Boxed: Adds padding around image for left and right types
 * 
 * Sizes: (will wrap and expand to fill area)
 *  blank / none = full width of the container (preferred if adding into columns)
 *  xl = 44em ~ 3/4 width on desktop
 *  lrg = 39em ~ 2/3 width on desktop
 *  med = 29em ~ 1/2 width on desktop
 *  sml = 19em ~ 1/3 width on desktop
 *  xs = 14em ~ 1/4 width on desktop
 * 
 * Options:
 *  footer: Add footer information below all text (gray background)
 *  action: Add action element below the main content (transparent)
 *  image: URL of image
 *  alt: Alt tag for image (Required for accessibility)
 *  color: color class for card background
 * 
 */

class UAMS_CardsShortcode
{

    function __construct()
    {

      add_filter('the_content', array( $this, 'wpex_fix_shortcodes' ) );

        add_shortcode('cards', array($this, 'cards_handler'));
        add_shortcode('card', array($this, 'card_handler'));
        // add_shortcode('card_options', array($this, 'card_options_handler'));
    }

    function wpex_fix_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );

        $content = strtr($content, $array);
        return $content;
    }

    function cards_handler( $atts, $content )
    {
        $cards_atts = shortcode_atts( array(
          'name' => '',
        ), $atts);

        if ( empty( $content ) )
            return 'No content inside the accordion element. Make sure your close your accordion element. Required stucture: [accordion][section]content[/section][/accordion]';

        $output = do_shortcode( $content );
        return sprintf( '<h2>%s</h2><section class="cards">%s</section>', $cards_atts['name'], $output );
    }

    function card_handler( $atts, $content )
    {
        $card_atts = shortcode_atts( array(
          'title' => '',
          'size' => '',
          'image' => '',
          'color' => '',
          'type' => '',
          'link' => '',
          'alt' => '',
          'action' => '',
          'footer' => '',
        ), $atts);

        $size = '';
        $type = '';
        $color = '';
        $image = '';
        $alt = '';
        $link = '';
        $endlink = '';
        $action = '';
        $footer = '';
        if ( empty( $content ) ){
          $content = 'No content for this section.  Make sure you wrap your content like this: [card]Content here[/card]';
        }

        if ($card_atts['size']) {
            $size = ' ' . $card_atts['size'];
        }

        if ($card_atts['color']) {
            $color = ' '. $card_atts['color'];
        }

        if ($card_atts['type']) {
            $type = ' ' . $card_atts['type'];
        }

        if ($card_atts['link']) {
            $link = '<a href="' . $card_atts['link'] . '">';
            $endlink = '</a>';
        }

        if ($card_atts['alt']) {
            $alt = ' alt="' . $card_atts['alt'] .'" ';
        }

        if ($card_atts['image']) {
            $image = '<div class="card-image">'. $link .'<img src="'. $card_atts['image'] .'"'. $alt .' />'. $endlink .'</div>';
        }

        if ($card_atts['action']) {
            $action = '<div class="card-action">'. $card_atts['action'] .'</div>';
        }

        if ($card_atts['footer']) {
            $footer = '<div class="card-footer">'. $card_atts['footer'] .'</div>';
        }


        $output = do_shortcode( $content );
        return sprintf( '<article class="card%s%s%s">%s<div class="card-stack"><div class="card-content">%s<h3>%s</h3>%s%s</div>%s%s</div></article>', $type, $size, $color, $image, $link, $card_atts['title'], $endlink, apply_filters( 'the_content', $output ), $action, $footer );
    }

    // function card_options_handler( $atts, $content )
    // {
    //   $card_options_atts = shortcode_atts( array(
    //     'title' => '',
    //     'size' => '',
    //     'image' => '',
    //     'color' => '',
    //     'type' => '',
    //     'action' => '',
    //     'footer' => '',
    //   ), $atts);

    //   $size = '';
    //   $type = '';
    //   $color = '';
    //   $action = '';
    //   $footer = '';
    //   if ( empty( $content ) ){
    //     $content = 'No content for this section.  Make sure you wrap your content like this: [card]Content here[/card]';
    //   }

    //   if ($card_options_atts['size']) {
    //       $size = ' ' . $card_options_atts['size'];
    //   }

    //   if ($card_options_atts['color']) {
    //       $color = ' '. $card_options_atts['color'];
    //   }

    //   if ($card_options_atts['type']) {
    //       $type = ' ' . $card_options_atts['color'];
    //   }

    //   if ($card_options_atts['action']) {
    //       $action = '<div class="card-action">'. $card_options_atts['action'] .'</div>';
    //   }

    //   if ($card_options_atts['footer']) {
    //       $footer = '<div class="card-footer">'. $card_options_atts['footer'] .'</div>';
    //   }


    //   $output = do_shortcode( $content );
    //   return sprintf( '<article class="card%s"><div class="card-image">%s</div><div class="card-stack"><div class="card-content"><h3>%s</h3>%s%s</div></div></article>', $section_atts['title'], $active, apply_filters( 'the_content', $output ) );
    // }
}