<?php

/*
 * Shortcode for embedding tab style module
 * link is optional (#linkname)
 * [tabs name='web name']
 * [tab title='tab title' link='linkname1'] content [/tab]
 * [tab title='tab title' link='linkname2'] content [/tab]
 * [tab title='tab title' link='linkname3'] content [/tab]
 * [/tabs]
 */

class UAMS_TabsShortcode
{

    function __construct()
    {

      add_filter('the_content', array( $this, 'wpex_fix_shortcodes' ) );

        add_shortcode('tabs', array($this, 'tabs_handler'));
        add_shortcode('tab', array($this, 'tab_handler'));

        // register accordion script, if needed
        function register_uams_tabs() {
			wp_register_script('uams-tabs', get_template_directory_uri() . '/js/uams.tabs.min.js', array(), '1.0', true);
		}
		add_action( 'init', 'register_uams_tabs' );

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

    function tabs_handler( $atts, $content )
    {

        # Create empty titles & links array
		$this->tab_titles = array();
		$this->tab_links = array();

        $tabs_atts = shortcode_atts( array(
          'name' => '',
        ), $atts);

        if ( empty( $content ) )
            return 'No content inside the tabs element. Make sure your close your tabs element. Required stucture: [tabs][tab title=""]content[/tab][/tabs]';

		// Enqueue accordion script
        wp_enqueue_script('uams-tabs');

        # Get all individual tabs content
		$tab_content = do_shortcode($content);

		#Load the Script, CSS, and Start the Tabs
		$output = sprintf('<div id="uams-tabs uams-tabs-shortcode %s">', str_replace(' ', '', $tabs_atts['name'] ));

		# Start the tab navigation
		$output .= '<div class="js-tabs tabs__uams"><ul class="js-tablist tabs__uams_ul" data-hx="h2">';

		# Loop through tab titles
		foreach ($this->tab_titles as $key => $title) {
			$id = $key + 1;
			$output .= sprintf('<li class="js-tablist__item tabs__uams__li"><a href="#%s" id="label_%s" class="js-tablist__link tabs__uams__a">%s</a></li>',
				($this->tab_links[$key] ? str_replace(' ', '', $this->tab_links[$key]) :'tab-' . $id),
				($this->tab_links[$key] ? str_replace(' ', '', $this->tab_links[$key]) :'tab-' . $id),
				$title
			); //$id == 1 ? ' active' : '',
		}

		# Close the tab navigation container and add tab content
		$output .= '</ul><div class="uams-tab-content">';
		$output .= $tab_content;
		$output .= '</div></div>'; //Close js-tabs
		$output .= '</div>'; //Close uams-tabs-shortcode

		return $output;

    }

    function tab_handler( $atts, $content )
    {

        $tab_atts = shortcode_atts( array(
          'title' => '',
          'link' => '',
        ), $atts);

        if ( empty( $content ) ){
          $content = 'No content for this tab.  Make sure you wrap your content like this: [tab]Content here[/tab]';
        }

        $title = $tab_atts['title'];
        $link = $tab_atts['link'];

        # Add the title to the titles array
		array_push($this->tab_titles, $title);
		array_push($this->tab_links, $link);

		$id = count($this->tab_titles);

		return sprintf('<div id="%s" class="js-tabcontent tabs__uams__tabcontent">%s</div>',
			($link ? $link :'tab-' . $id),
			do_shortcode($content)
		);
    }
}
