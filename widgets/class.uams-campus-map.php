<?php

/**
 * UAMS Campus Map Widget
 */

class UAMS_Campus_Map extends WP_Widget
{

  const URL = '//maps.uams.edu/full-screen/?markerid=';

  function __construct()
  {
		parent::__construct( 'uams-campus-map', __('UAMS Campus Map'), array(
      'description' => __('Show your building on the UAMS campus map.'),
      'classname'   => 'uams-widget-campus-map'
    ) );
  }

  function widget( $args, $instance )
  {
    extract( $args );
    extract( $instance );

		$title = apply_filters( 'widget_title', $instance['title'] );
    $buildingCode = apply_filters( 'uams_campus_map_buildingcode', $instance['buildingCode'] );

    if ( !empty( $title ) )
       $content .= "<h3 class=\"widget-title\"> $before_title $title $after_title </h3>";

    $content .= '<div class="uams-campus-map-widget">
                  <iframe width="100%" height="365" src="'.self::URL.$buildingCode.'" frameborder="0" allow="geolocation"></iframe>
                  <a href="https://maps.uams.edu/map-mashup/?markerid='.$buildingCode.'" target="_blank">View larger</a>
                </div>';

    echo $before_widget . $content . $after_widget;
	}

  function update( $new_instance, $old_instance )
  {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['buildingCode'] = strip_tags( $new_instance['buildingCode'] );
		return $instance;
	}

  function form($instance)
  {

		$title        = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$buildingCode = isset($instance['buildingCode']) ? esc_attr($instance['buildingCode']) : '';
?>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('buildingCode'); ?>"><?php _e('Building Code:'); ?></label>
<!-- 		<input class="widefat" id="<?php echo $this->get_field_id('buildingCode'); ?>" name="<?php echo $this->get_field_name('buildingCode'); ?>" type="text" value="<?php echo $buildingCode; ?>" /> -->
			<select class='widefat' id="<?php echo $this->get_field_id('buildingCode'); ?>"
                name="<?php echo $this->get_field_name('buildingCode'); ?>" type="text">
          <option value=''>
            Select ...
          </option>
          <option value='127'<?php echo ($buildingCode=='127')?'selected':''; ?>>
            12th St. Clinic
          </option>
          <option value='116'<?php echo ($buildingCode=='116')?'selected':''; ?>>
            Administration West (ADMINW)
          </option>
          <option value='117'<?php echo ($buildingCode=='117')?'selected':''; ?>>
            Barton Research (BART)
          </option>
          <option value='118'<?php echo ($buildingCode=='118')?'selected':''; ?>>
            Biomedical Research Center I (BMR1)
          </option>
          <option value='119'<?php echo ($buildingCode=='119')?'selected':''; ?>>
            Biomedical Research Center II (BMR2)
          </option>
          <option value='120'<?php echo ($buildingCode=='120')?'selected':''; ?>>
            Bioventures (BVENT)
          </option>
          <option value='121'<?php echo ($buildingCode=='121')?'selected':''; ?>>
            Boiler House (BH)
          </option>
          <option value='122'<?php echo ($buildingCode=='122')?'selected':''; ?>>
            Central Building (CENT)
          </option>
          <option value='123'<?php echo ($buildingCode=='123')?'selected':''; ?>>
            College of Public Health (COPH)
          </option>
          <option value='124'<?php echo ($buildingCode=='124')?'selected':''; ?>>
            Computer Building (COMP)
          </option>
          <option value='125'<?php echo ($buildingCode=='125')?'selected':''; ?>>
            Cottage 3 (C3)
          </option>
          <option value='128'<?php echo ($buildingCode=='128')?'selected':''; ?>>
            Distribution Center (DIST)
          </option>
          <option value='129'<?php echo ($buildingCode=='129')?'selected':''; ?>>
            Donald W. Reynolds Institute on Aging (RIOA)
          </option>
          <option value='126'<?php echo ($buildingCode=='126')?'selected':''; ?>>
            Ear Nose Throat (ENT)
          </option>
          <option value='131'<?php echo ($buildingCode=='131')?'selected':''; ?>>
            Education Building South (EDS)
          </option>
          <option value='130'<?php echo ($buildingCode=='130')?'selected':''; ?>>
            Education II (EDII)
          </option>
          <option value='132'<?php echo ($buildingCode=='132')?'selected':''; ?>>
            Family Medical Center (FMC)
          </option>
          <option value='133'<?php echo ($buildingCode=='133')?'selected':''; ?>>
            Freeway Medical Tower (FWAY)
          </option>
          <option value='134'<?php echo ($buildingCode=='134')?'selected':''; ?>>
            Harvey and Bernice Jones Eye Institute (JEI)
          </option>
          <option value='135'<?php echo ($buildingCode=='135')?'selected':''; ?>>
            Hospital (HOSP)
          </option>
          <option value='136'<?php echo ($buildingCode=='136')?'selected':''; ?>>
            I. Dodd Wilson Education Building (IDW)
          </option>
          <option value='137'<?php echo ($buildingCode=='137')?'selected':''; ?>>
            Jackson T. Stephens Spine Institute (JTSSI)
          </option>
          <option value='138'<?php echo ($buildingCode=='138')?'selected':''; ?>>
            Magnetic Resonance Imaging (MRI)
          </option>
          <option value='139'<?php echo ($buildingCode=='139')?'selected':''; ?>>
            Mediplex Apartments (1 unit) (MEDPX)
          </option>
          <option value='141'<?php echo ($buildingCode=='141')?'selected':''; ?>>
            Outpatient Center (OPC)
          </option>
          <option value='142'<?php echo ($buildingCode=='142')?'selected':''; ?>>
            Outpatient Diagnostic Center (OPDC)
          </option>
          <option value='143'<?php echo ($buildingCode=='143')?'selected':''; ?>>
            Paint Shop & Flammable Storage (PAINT)
          </option>
          <option value='144'<?php echo ($buildingCode=='144')?'selected':''; ?>>
            PET (PET)
          </option>
          <option value='145'<?php echo ($buildingCode=='145')?'selected':''; ?>>
            Physical Plant (PP)
          </option>
          <option value='146'<?php echo ($buildingCode=='146')?'selected':''; ?>>
            Psychiatric Research Institute (PRI)
          </option>
          <option value='147'<?php echo ($buildingCode=='147')?'selected':''; ?>>
            Radiation Oncology [ROC] (RADONC)
          </option>
          <option value='148'<?php echo ($buildingCode=='148')?'selected':''; ?>>
            Residence Hall Complex (RHC)
          </option>
          <option value='149'<?php echo ($buildingCode=='149')?'selected':''; ?>>
            Ricks Armory
          </option>
          <option value='150'<?php echo ($buildingCode=='150')?'selected':''; ?>>
            Walker Annex (ANNEX)
          </option>
          <option value='151'<?php echo ($buildingCode=='151')?'selected':''; ?>>
            Ward Tower (WARD)
          </option>
          <option value='152'<?php echo ($buildingCode=='152')?'selected':''; ?>>
            West Central Energy Plant (WCEP)
          </option>
          <option value='153'<?php echo ($buildingCode=='153')?'selected':''; ?>>
            Westmark (WESTM)
          </option>
          <option value='154'<?php echo ($buildingCode=='154')?'selected':''; ?>>
            Winston K. Shorey Building (SHOR)
          </option>
          <option value='115'<?php echo ($buildingCode=='155')?'selected':''; ?>>
            Winthrop P. Rockefeller Cancer Institute (WPRCI)
          </option>
          <option value='2'<?php echo ($buildingCode=='2')?'selected':''; ?>>
            Parking Deck 1 Entrance
          </option>
          <option value='3'<?php echo ($buildingCode=='3')?'selected':''; ?>>
            Parking Deck 2 Entrance
          </option>
          <option value='4'<?php echo ($buildingCode=='4')?'selected':''; ?>>
            Parking Deck 3 Entrance
          </option>
          <option value='7'<?php echo ($buildingCode=='7')?'selected':''; ?>>
            Outpatient Valet Parking
          </option>
          <option value='6'<?php echo ($buildingCode=='6')?'selected':''; ?>>
            Stephens Institute Valet Parking
          </option>
        </select></p>

<?php
	}
}


register_widget( 'UAMS_Campus_Map' );
