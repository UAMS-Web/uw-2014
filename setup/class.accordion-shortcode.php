<?php

/*
 * Shortcode for embedding accordion style module
 * [accordion name='web name']
 * [section title='section title'] content [/section]
 * [section title='section title'] content [/section]
 * [section title='section title'] content [/section]
 * [/accordion]
 */

class UAMS_AccordionShortcode
{

    function __construct()
    {

      add_filter('the_content', array( $this, 'wpex_fix_shortcodes' ) );

        add_shortcode('accordion', array($this, 'accordion_handler'));
        add_shortcode('section', array($this, 'section_handler'));
        add_shortcode('subsection', array($this, 'subsection_handler'));

        // register accordion script, if needed
        function register_uams_accordion() {
			wp_register_script('uams-accordion', get_template_directory_uri() . '/js/uams.accordionmodule.js', array(), '1.0', true);
		}
		add_action( 'init', 'register_uams_accordion' );
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

    function accordion_handler( $atts, $content )
    {
        $accordion_atts = shortcode_atts( array(
          'name' => '',
        ), $atts);

        if ( empty( $content ) )
            return 'No content inside the accordion element. Make sure your close your accordion element. Required stucture: [accordion][section]content[/section][/accordion]';

        // Enqueue accordion script
        wp_enqueue_script('uams-accordion');

        $output = do_shortcode( $content );
        return sprintf( '<div id="accordion uams-accordion-shortcode"><h3>%s</h3><div class="js-accordion" data-accordion-prefix-classes="uams-accordion-shortcode">%s</div></div>', $accordion_atts['name'], $output );
    }

    function section_handler( $atts, $content )
    {
        $section_atts = shortcode_atts( array(
          'title' => '',
        ), $atts);

        if ( empty( $content ) ){
          $content = 'No content for this tile.  Make sure you wrap your content like this: [tile]Content here[/tile]';
        }
        $output = do_shortcode( $content );
        return sprintf( '<h2 class="js-accordion__header">%s</h2><div class="js-accordion__panel">%s</div>', $section_atts['title'], apply_filters( 'the_content', $output ) );
    }

    function subsection_handler( $atts, $content )
    {
        $section_atts = shortcode_atts( array(
          'title' => '',
        ), $atts);

        if ( empty( $content ) ){
          $content = 'No content for this tile.  Make sure you wrap your content like this: [tile]Content here[/tile]';
        }
        $output = do_shortcode( $content );
        return sprintf( '<h3 class="js-accordion__header uams-accordion-subheader">%s</h3><div class="js-accordion__panel">%s</div>', $section_atts['title'], apply_filters( 'the_content', $output ) );
    }
}
