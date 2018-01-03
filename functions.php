<?php

// allows child theme overwriting of either whole UAMS object or just parts
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
		wp_enqueue_script( 'webcenter-scripts', get_template_directory_uri() . '/assets/admin/js/custom-color.js');
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


/* Add Woocommerce Supprt */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


/* Update sitemap on publish post & page */
add_action( 'publish_post', 'sitemap' );
add_action( 'publish_page', 'sitemap' );
/* Function to create sitemap.xml */
function sitemap() {
  $posts = get_posts( array(
    'numberposts' => -1,
    'orderby' => 'modified',
    'post_type' => array( 'post', 'page' ),
    'order' => 'DESC'
  ));

  header('Content-Type: text/xml; charset=' . get_bloginfo('charset'), true);
  header('X-Robots-Tag: noindex, follow', true);
  $sitemap .= '<?xml version="1.0" encoding="' . get_bloginfo('charset') . '"?> <?xml-stylesheet type="text/xsl" href="' . get_stylesheet_directory_uri() . '/sitemap.xsl' . '"?> <!-- generated-on="' . date('Y-m-d\TH:i:s+00:00') . '" --> <!-- generator="University of Arkansas for Medical Sciences (UAMS)" --> <!-- generator-url="http://www.uams.edu/" --> <!-- generator-version="1.0" --> <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"> ';
  $sitemap .= '<url> <loc>' . esc_url( home_url( "/" ) ) . '</loc> <changefreq>Daily</changefreq> <priority>1.0</priority> </url>';
  foreach( $posts as $post ) {
	  setup_postdata( $post);
	  $postdate = explode( " ", $post->post_modified ); $sitemap .= '<url> <loc>' . get_permalink( $post->ID ) . '</loc> <lastmod>' . $postdate[0] . 'T' . $postdate[1] . '+00:00' . '</lastmod> <changefreq>Weekly</changefreq> <priority>0.5</priority> </url>';
  }
  $sitemap .= '</urlset>';
  $fop = fopen( ABSPATH . "sitemap.xml", 'w' );
  fwrite( $fop, $sitemap );
  fclose( $fop );
}

add_filter('allowed_http_origins', 'add_allowed_origins');

function add_allowed_origins($origins) {
    $origins[] = 'http://www.uams.edu';
    $origins[] = 'http://www.uams.dev'; //Dev URL
    return $origins;
}

// Enqueue Font Awesome.
add_action( 'wp_enqueue_scripts', 'custom_load_font_awesome' );
function custom_load_font_awesome() {
    wp_enqueue_script( 'font-awesome-all', get_bloginfo('template_directory') . '/js/fontawesome-all.min.js', array(), null, true );
    //wp_enqueue_script( 'font-awesome-light', get_bloginfo('template_directory') . '/js/fa-light.min.js', array(), null );
    //wp_enqueue_script( 'font-awesome-brands', get_bloginfo('template_directory') . '/js/fa-brands.min.js', array(), null );
    wp_enqueue_script( 'font-awesome', get_bloginfo('template_directory') . '/js/fontawesome.min.js', array(), null );
}

add_filter( 'script_loader_tag', 'add_defer_attribute', 10, 2 );
/**
 * Filter the HTML script tag of `font-awesome` script to add `defer` attribute.
 *
 * @param string $tag    The <script> tag for the enqueued script.
 * @param string $handle The script's registered handle.
 *
 * @return   Filtered HTML script tag.
 */
function add_defer_attribute( $tag, $handle ) {
    if (( 'font-awesome-all' === $handle ) || ( 'font-awesome-light' === $handle ) || ( 'font-awesome-brands' === $handle )) {
    	return str_replace( ' src', ' defer src', $tag );
	} else {
		return $tag;
	}
}

