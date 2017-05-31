<?php

// allows child them overwriting of either whole UAMS object or just parts
if (!function_exists('setup_uams_object')){
    function setup_uams_object() {
        require( get_template_directory() . '/setup/class.uams.php' );
        $UAMS = new UAMS();
        do_action('extend_uams_object', $UAMS);
        return $UAMS;
    }
}

$UAMS = setup_uams_object();

// Custom colors
function webcenter_scripts() {
	if(wp_script_is('wp-color-picker', 'enqueued')){
		wp_enqueue_script( 'webcenter-scripts', get_template_directory() . '/assets/admin/js/custom-color.js');
	}
}

add_action('admin_enqueue_scripts', 'webcenter_scripts');

// Custom Validation rule for Home Slider Content
/*
add_filter('acf/validate_value/name=hs_content', 'hs_content_character_count', 10, 4);

function hs_content_character_count( $valid, $value, $field, $input ){

    // bail early if value is already invalid
    if( !$valid ) {

        return $valid;

    }

    if( strlen($value) > 210 ) {

        $valid = 'You can\'t enter more that ~180 characters';

    }


    // return
    return $valid;


};
*/

/*ACF*/
// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path( $path ) {
    $path = get_template_directory() . '/_includes/acf-pro/';
    return $path;
}

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {
    $dir = get_template_directory_uri() . '/_includes/acf-pro/';
    return $dir;
}

// 3. Hide ACF field group menu item
//if ( ! has_filter( 'acf/settings/show_admin' ) ) {
//	add_filter('acf/settings/show_admin', '__return_false');
//}
// 4. Include ACF
include_once( get_template_directory() . '/_includes/acf-pro/acf.php' );

// check for 'action_menu_active' meta key on pages and add a body class if meta value equals '1'
add_filter('body_class','uams_custom_field_body_class');
function uams_custom_field_body_class( $classes ) {
	global $post;
	if ( is_page() && ( '1' == get_post_meta( $post->ID, 'action_menu_active', true ) ) ) {

		$classes[] = 'action-bar';

	}
	/* Add custom class of uams-primary if the item is checked in the backend */
	if ( get_option('primary_uams_site') ) {

		$classes[] = 'uams-primary';

	}

	// return the $classes array
	return $classes;
}

/* Add custom class of uams-primary if the item is checked in the backend */

/**
 * Loads the custom Tailor elements.
 */
function tailor_load_custom_element() {
	include trailingslashit( get_template_directory() ) . 'tailor/elements/class-custom-content.php';
//	include trailingslashit( get_template_directory() ) . 'tailor/elements/class-custom-wrapper.php';
//	include trailingslashit( get_template_directory() ) . 'tailor/elements/class-custom-container.php';
//	include trailingslashit( get_template_directory() ) . 'tailor/elements/class-custom-child.php';
	include trailingslashit( get_template_directory() ) . 'tailor/shortcodes/shortcode-custom-content.php';
//	include trailingslashit( get_template_directory() ) . 'tailor/shortcodes/shortcode-custom-wrapper.php';
//	include trailingslashit( get_template_directory() ) . 'tailor/shortcodes/shortcode-custom-container.php';
//	include trailingslashit( get_template_directory() ) . 'tailor/shortcodes/shortcode-custom-child.php';
	include trailingslashit( get_template_directory() ) . 'tailor/elements/class-uams-button.php';
	include trailingslashit( get_template_directory() ) . 'tailor/shortcodes/shortcode-uams-button.php';
}

add_action( 'tailor_load_elements', 'tailor_load_custom_element', 20 );



/**
 * Registers the custom Tailor elements.
 *
 * @param Tailor_Elements $element_manager
 */
function tailor_register_custom_element( $element_manager ) {

	// The element PHP class is derived from the element tag.  To specify a custom class name, use 'class_name'
	// The element type can be specified using 'type'.  Possible values are 'container', 'wrapper', 'child' and 'content'
	$element_manager->add_element(
		'tailor_custom_content',                                        // Shortcode tag
		array(
			'label'             =>  __( 'Custom content' ),             // Label displayed in the element list
			'description'       =>  __( 'A custom content element' ),   // Description displayed in the element list
			'badge'             =>  __( 'Custom' ),                     // Badge displayed in the element list
		)
	);

	$element_manager->add_element( 'tailor_uams_button', array(
		'label'             =>  __( 'UAMS Button' ),
		'description'       =>  __( 'UAMS Custom Button' ),
		'badge'             =>  __( 'UAMS' ),
	) );

	// If your custom wrapper, container or child has a custom child view container, you will need to create extend
	// the default
/*
	$element_manager->add_element( 'tailor_custom_wrapper', array(
		'label'             =>  __( 'Custom wrapper' ),
		'description'       =>  __( 'A custom wrapper element' ),
		'badge'             =>  __( 'Custom' ),
		'type'              =>  'wrapper',
	) );

	$element_manager->add_element( 'tailor_custom_container', array(
		'label'             =>  __( 'Custom container' ),
		'description'       =>  __( 'A custom container element' ),
		'badge'             =>  __( 'Custom' ),
		'type'              =>  'container',
		'child'             =>  'tailor_custom_child',
	) );

	$element_manager->add_element( 'tailor_custom_child', array(
		'label'             =>  __( 'Custom child' ),
		'type'              =>  'child',
	) );
*/
}

add_action( 'tailor_register_elements', 'tailor_register_custom_element' );



/**
 * Registers custom views and behaviors
 */
function tailor_add_custom_views() {
	wp_enqueue_script(
		'tailor-custom-scripts',
		get_template_directory_uri() . '/tailor/assets/js/dist/canvas' . ( SCRIPT_DEBUG ? '.js' : '.min.js' ),
		array( 'tailor-canvas' ),
		null,
		true
	);
}

add_action( 'tailor_canvas_enqueue_scripts', 'tailor_add_custom_views', 99 );



/**
 * Registers custom styles
 */
function tailor_add_custom_styles() {
	wp_enqueue_style(
		'tailor-custom-styles',
		get_template_directory_uri() . '/tailor/assets/css/frontend' . ( SCRIPT_DEBUG ? '.css' : '.min.css' ),
		array(),
		null
	);
}

add_action( 'wp_enqueue_scripts', 'tailor_add_custom_styles' );



/**
 * Modifies default row elements.
 *
 * @param Tailor_Row_Element $row_element
 */
function tailor_modify_row( $row_element ) {

	// Get the row collapse setting
	$style_setting = $row_element->get_setting( 'collapse' );

	// Set the default value to 'desktop' to have columns display on desktop only
	$style_setting->default = 'desktop';
}

add_action( 'tailor_element_register_controls_tailor_row', 'tailor_modify_row' );



/**
 * Modifies default button elements.
 *
 * @param Tailor_Button_Element $button_element
 */
function tailor_modify_button( $button_element ) {

	// Get the button element's and style setting
	$style_setting = $button_element->get_setting( 'style' );

	// Set the default value to primary
	$style_setting->default = 'primary';

	// Remove the style control
	//$button_element->remove_control( 'style' );
}

add_action( 'tailor_element_register_controls_tailor_button', 'tailor_modify_button' );



/**
 * Adds a new control to the Tailor button.
 *
 * @param Tailor_Button_Element $button_element
 */
function tailor_add_button_control( $button_element ) {

	$button_element->add_setting( 'show_icon', array(
		'sanitize_callback'     =>  'tailor_sanitize_text',
	) );

	$button_element->add_control( 'show_icon', array(
		'label'                 =>  __( 'Show icon?' ),
		'type'                  =>  'switch',
		'priority'              =>  45, // Position before icon control
		'section'               =>  'general',
	) );
}

add_action( 'tailor_element_register_controls_tailor_button', 'tailor_add_button_control' );



/**
 * Modify the default control arguments for the Button element.
 *
 * @param array $control_args
 * @param Tailor_Button_Element $button_element
 *
 * @return array $control_args
 */
function tailor_modify_button_icon_control( $control_args, $button_element ) {
	$control_args['dependencies'] = array(
		'show_icon'             => array(
			'condition'             =>  'not',
			'value'                 =>  '',
		),
	);
	return $control_args;
}

add_action( 'tailor_control_args_tailor_button_icon', 'tailor_modify_button_icon_control', 10, 2 );

/**
 * Removes some default elements.
 *
 * @param Tailor_Elements $element_manager
 */
function tailor_remove_default_elements( $element_manager ) {
	$element_manager->remove_element( 'tailor_carousel' );
	$element_manager->remove_element( 'tailor_toggles' );

}
add_action( 'tailor_register_elements', 'tailor_remove_default_elements' );

/**
 * Modifies the default colorpicker palettes.
 *
 * @param array $control_args
 *
 * @return array $control_args
 */
if (!function_exists('uams_tailor_modify_colorpicker')){
	function uams_tailor_modify_colorpicker( $control_args ) {
		$control_args['palettes'] = array(
			'#9d2235',
			'#212121',
			'#bdbdbd',
			'#ffffff',
			'#2e8540',
			'#355b7a',
			'#fdb81e',
		);
		return $control_args;
	}
	add_action( 'tailor_control_args_colorpicker', 'uams_tailor_modify_colorpicker' );
}

/* Add Woocommerce Supprt */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}