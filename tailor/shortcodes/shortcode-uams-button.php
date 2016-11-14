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

/*	    $html_atts = array(
		    'id'            =>  empty( $atts['id'] ) ? null : $atts['id'],
		    'class'         =>  $class,
		    'data'          =>  array(),
	    );


	    $html_atts = apply_filters( 'tailor_shortcode_html_attributes', $html_atts, $atts, $tag );
	    $html_atts['class'] = implode( ' ', (array) $html_atts['class'] );
	    $html_atts = tailor_get_attributes( $html_atts );
*/

        $class_string = implode($class, ' ');

        return sprintf('<p><a class="%s" %s>%s</a></p>', $class_string, $href, $content);

/*	    $id = ( '' !== $atts['id'] ) ? 'id="' . esc_attr( $atts['id'] ) . '"' : '';
	    $class = trim( esc_attr( "tailor-element tailor-custom-content {$atts['class']}" ) );

	    // Do something with the element settings
	    $html = '<div ' . trim( "{$id} class=\"{$class}\"" ) . '>';
	    $html .= '<p>This is a sample content element.</p>';


	    if ( ! empty( $atts['setting_1'] ) ) {
		    $html .= '<p>Setting 1: ' . esc_attr( $atts['setting_1'] ) . '</p>';
	    }
	    if ( ! empty( $atts['setting_2'] ) ) {
		    $html .= '<p>Setting 2: ' . esc_attr( $atts['setting_2'] ) . '</p>';
	    }


	    return $html . '</div>';*/
    }

    add_shortcode( 'tailor_uams_button', 'tailor_shortcode_uams_button_element' );
}