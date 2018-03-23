<?php

/**
 *
 * Social Icons widget
 *
 * Social Media Icons are displayed
 */

class UAMS_Social_Icons extends WP_Widget
{

  function __construct()
  {
		parent::__construct( $id = 'uams-widget-social', $name = 'UAMS Social Icons', $options = array( 'description' => 'Display social media icons with links to the appropriate account', 'classname' => 'social-widget' ) );

    if ( is_admin() )
      add_action('admin_enqueue_scripts', array( __CLASS__, 'scripts') );
  }

  public static function scripts()
  {
    //wp_enqueue_script( 'single-card-image',  get_bloginfo('template_directory') . '/assets/admin/js/widgets/uams.card-widget.js' );
   // wp_enqueue_script( 'jquery-ui-autocomplete' );
    //wp_enqueue_media();
  }

  function form( $instance )
  {

    $title = isset($instance['title']) ? esc_attr($instance['title']) : 'Connect with us:';
    $facebook  = isset($instance['facebook'])  ? esc_attr($instance['facebook'])  : '';
    $twitter = isset($instance['twitter']) ? esc_attr($instance['twitter']) : '';
    $instagram   = isset($instance['instagram']) ? esc_attr($instance['instagram']) : '';
    $youtube  = isset($instance['youtube']) ? esc_attr($instance['youtube']) : '';
    $linkedin  = isset($instance['linkedin']) ? esc_attr($instance['linkedin']) : '';
    $pinterest = isset($instance['pinterest']) ? esc_attr($instance['pinterest']) : '';

    ?>

		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?>  <small><b>Appears above the icons</b></small></label>
		<input data-posttype="post" class="widefat wp-get-posts" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
    <p>
    <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URI:'); ?></label>
    <input id="facebook-<?php echo $this->id ?>" class="widefat wp-get-posts-url" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $facebook; ?>" />
    </p>
		<p>
    <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URI:'); ?></label>
    <input id="twitter-<?php echo $this->id ?>" class="widefat wp-get-posts-url" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $twitter; ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URI:'); ?></label>
    <input id="instagram-<?php echo $this->id ?>" class="widefat wp-get-posts-url" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo $instagram; ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('YouTube URI:'); ?></label>
    <input id="youtube-<?php echo $this->id ?>" class="widefat wp-get-posts-url" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo $youtube; ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin URI:'); ?></label>
    <input id="linkedin-<?php echo $this->id ?>" class="widefat wp-get-posts-url" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo $linkedin; ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URI:'); ?></label>
    <input id="pinterest-<?php echo $this->id ?>" class="widefat wp-get-posts-url" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo $pinterest; ?>" />
    </p>

  <?php

  }

  function update($new_instance, $old_instance)
  {
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['facebook']  = strip_tags( $new_instance['facebook'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['instagram']   = strip_tags( $new_instance['instagram'] );
		$instance['youtube']  = strip_tags( $new_instance['youtube'] );
    $instance['linkedin']  = strip_tags( $new_instance['linkedin'] );
		$instance['pinterest']  = strip_tags( $new_instance['pinterest'] );
    return $instance;
  }

  function widget($args, $instance)
  {

	extract( $args );
	  $title = $instance['title'];
    $facebook  = $instance['facebook'];
    $twitter = $instance['twitter'];
    $instagram  = $instance['instagram'];
    $youtube  = $instance['youtube'];
    $linktext  = $instance['linkedin'];
    $pinterest = $instance['pinterest'];
    ?>

    <?php  echo $before_widget; ?>

      <h2 class="widgettitle"><?php  echo $title; ?></h2>

	  <?php if ( ! empty( $title ) ) : ?>
      <span class="udub-slant"><span></span></span>
      <?php endif; ?>

      <nav aria-label="social networks">
        <ul class="widget-social">
          <?php if ( ! empty( $facebook ) ) : ?>
            <li><a class="facebook" title="Facebook" href="<?php  echo $facebook; ?>">Facebook</a></li>
          <?php endif; ?> 
          <?php if ( ! empty( $twitter ) ) : ?>
            <li><a class="twitter" title="Twitter" href="<?php  echo $twitter; ?>">Twitter</a></li>
          <?php endif; ?>  
          <?php if ( ! empty( $instagram ) ) : ?>
            <li><a class="instagram" title="Instagram" href="<?php  echo $instagram; ?>">Instagram</a></li>
          <?php endif; ?>  
          <?php if ( ! empty( $youtube ) ) : ?>
            <li><a class="youtube" title="YouTube" href="<?php  echo $youtube; ?>">YouTube</a></li>
          <?php endif; ?>
          <?php if ( ! empty( $linkedin ) ) : ?>
            <li><a class="linkedin" title="LinkedIn" href="<?php  echo $linkedin; ?>">LinkedIn</a></li>
          <?php endif; ?>
          <?php if ( ! empty( $pinterest ) ) : ?>
            <li><a class="pinterest" title="Pinterest" href="<?php  echo $pinterest; ?>">Pinterest</a></li>
          <?php endif; ?>
        </ul>
      
      </nav>

    <?php echo $after_widget;

  }
}

register_widget( 'UAMS_Social_Icons' );
