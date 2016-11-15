<?php

if ( ! function_exists( 'tailor_shortcode_uams_button_element' ) ) {

    /**
     * Defines the shortcode rendering function for the custom content element.
     *
     * @param array $atts
     * @param string $content
     * @param string $tag
     * @return string
     */
    function tailor_shortcode_uams_button_element( $atts, $content = null, $tag ) {

	    $default_atts = apply_filters( 'tailor_shortcode_default_atts_' . $tag, array() );
	    $atts = shortcode_atts( $default_atts, $atts, $tag );

/*
	    $atts = shortcode_atts( array(
		    'id'           	=>  '',
		    'class'        	=>  '',
		    'style'        	=>  '',
 		    'btn_size'      =>  '',
 		    'href'			=>  '',
 		    'target'		=>  '',
	    ), $atts, $tag );
*/
		$size = "{$atts['btn_size']}";

		if(empty($size)){
			$size = "none";
        }

        $class = explode( ' ', "uams-btn btn-{$atts['style']} btn-{$size} {$atts['class']}" );

        if(empty($content)){
            echo 'No text in this button';
            return;
        }

        if ( ! empty( $atts['href'] ) ) {
		    $href = 'href="' . esc_url( $atts['href'] ) . '"';
		    $href .= ! empty( $atts['target'] ) ? ' target="_blank"' : '';
	    }
	    else {
		    $href = '';
	    }

        $class_string = implode($class, ' ');

        return sprintf('<p><a class="%s" %s>%s</a></p>', $class_string, $href, $content);

    }

    add_shortcode( 'tailor_uams_button', 'tailor_shortcode_uams_button_element' );
}