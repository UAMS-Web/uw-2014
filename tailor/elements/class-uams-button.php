<?php

/**
 * Tailor custom content element class.
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( class_exists( 'Tailor_Element' ) && ! class_exists( 'Tailor_UAMS_Button_Element' ) ) {

    /**
     * Tailor custom content element class.
     */
    class Tailor_UAMS_Button_Element extends Tailor_Element {

	    /**
	     * Registers element settings, sections and controls.
	     *
	     * @access protected
	     */
	    protected function register_controls() {

		    $this->add_section( 'general', array(
			    'title'                 =>  __( 'General', 'tailor-portfolio' ),
			    'priority'              =>  10,
		    ) );

/*
		    $this->add_section( 'colors', array(
			    'title'                 =>  __( 'Colors', 'tailor-portfolio' ),
			    'priority'              =>  30,
		    ) );
*/

		    $this->add_section( 'attributes', array(
			    'title'                 =>  __( 'Attributes', 'tailor-portfolio' ),
			    'priority'              =>  40,
		    ) );

		    $priority = 0;

		    // Add as many custom settings as you like..
		    $this->add_setting( 'content', array(
			    'sanitize_callback'     =>  'tailor_sanitize_text',
			    'default'               =>  $this->label,
		    ) );
		    $this->add_control( 'content', array(
			    'label'                 =>  __( 'Label', 'tailor' ),
			    'type'                  =>  'text',
			    'priority'              =>  $priority += 10,
			    'section'               =>  'general',
		    ) );
		    $this->add_setting( 'btn_size', array(
            	'sanitize_callback'     =>  'tailor_sanitize_text',
			) );
		    $this->add_control( 'btn_size', array(
			    'label'                 =>  __( 'Size', 'tailor' ),
			    'type'                  =>  'select',
			    'priority'              =>  $priority += 10,
			    'section'               =>  'general',
			    'choices'               =>  array(
				    'md'               		=>  __( 'Default', 'tailor' ),
				    'sm'               		=>  __( 'Small', 'tailor' ),
				    'lg'               		=>  __( 'Large', 'tailor' ),
				),
				'default'               =>  'md',
		    ) );



		    // This allows you to also add one of many standard control types..
		    $general_control_types = array(
		    	'style',
//			    'size',
//			    'size_tablet',
//			    'size_mobile',
		    	'href',
			    'target',
//			    'horizontal_alignment',
//			    'horizontal_alignment_tablet',
//			    'horizontal_alignment_mobile',
			);

		    // This allows you to alter values for standard controls and settings..
		    $general_control_arguments = array(
			    'style'                 =>  array(
				    'setting'               =>  array(
					    'default'               =>  'none',
				    ),
				    'control'               =>  array(
					    'choices'               =>  array(
						    'none'              =>  __( 'Default' ),
						    'grey'				=>  __( 'Grey' ),
						    'red'               =>  __( 'Red' ),
						    'blue'              =>  __( 'Blue' ),
						    'green'             =>  __( 'Green' ),
					    ),
				    ),
			    ),
			    'target'                =>  array(
				    'control'               =>  array(
					    'dependencies'          =>  array(
						    'href'                  =>  array(
							    'condition'             =>  'not',
							    'value'                 =>  '',
						    ),
					    ),
				    ),
			    ),
/*
			    'btn_size'                 =>  array(
				    'setting'               =>  array(
					    'default'               =>  'md',
				    ),
				    'control'               =>  array(
					    'choices'               =>  array(
						    'md'               		=>  __( 'Default', 'tailor' ),
						    'sm'               		=>  __( 'Small', 'tailor' ),
						    'lg'               		=>  __( 'Large', 'tailor' ),
					    ),
				    ),
			    ),
*/
		    );

		    // Note the starting priority is passed to the function
		    tailor_control_presets( $this, $general_control_types, $general_control_arguments, $priority );

		    // Standard color settings..
/*
		    $priority = 0;
		    $color_control_types = array(
			    'color',
			    'link_color',
			    'heading_color',
			    'background_color',
			    'border_color',
		    );
		    $color_control_arguments = array();
		    tailor_control_presets( $this, $color_control_types, $color_control_arguments, $priority );
*/

		    // Standard attribute settings..
		    $priority = 0;
		    $attribute_control_types = array(
			    'class',
			    'padding',
			    'padding_tablet',
			    'padding_mobile',
			    'margin',
			    'margin_tablet',
			    'margin_mobile',
		    );
		    $attribute_control_arguments = array();
		    tailor_control_presets( $this, $attribute_control_types, $attribute_control_arguments, $priority );
	    }

	    /**
	     * Returns custom CSS rules for the element.
	     *
	     * @param $atts
	     * @return array
	     */
		  public function generate_css( $atts ) {
		    $css_rules = array();
		    $excluded_control_types = array();

		    // Just generate the default setting CSS
		    $css_rules = tailor_css_presets( $css_rules, $atts, $excluded_control_types );
		    $selectors = array(
			    'padding'                   =>  array( '.uams-btn' ),
			    'padding_tablet'            =>  array( '.uams-btn' ),
			    'padding_mobile'            =>  array( '.uams-btn' ),
			    'margin'                    =>  array( '.uams-btn' ),
			    'margin_tablet'             =>  array( '.uams-btn' ),
			    'margin_mobile'             =>  array( '.uams-btn' ),
		    );
		    $css_rules = tailor_generate_attribute_css_rules( $css_rules, $atts, $selectors );

		    return $css_rules;
	    }
    }
}