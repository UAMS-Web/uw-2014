<?php
/**
 * Template Name: Small Hero
 */
?>

<?php get_header();
      $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
      if(!$url){
        $url = get_site_url() . "/wp-content/themes/uams-2016/assets/headers/uams-pattern-grey.png";
      }
      $mobileimage = get_field('home_image_mobile');
      $hasmobileimage = '';
      if( !empty($mobileimage) && $mobileimage[0] !== "") {
        //$mobileimage = $mobileimage[0];
        $hasmobileimage = 'hero-mobile-image';
      }
      $sidebar = get_post_meta($post->ID, "sidebar");
      $breadcrumbs = get_post_meta($post->ID, "breadcrumb");
	  $button = get_field( 'home_image_add_button' );
      $buttontext = get_field('home_image_button_text');
      $external = get_field( 'home_image_external' );
      $externalurl = get_field( 'home_image_external_url' );
      $internalurl = get_field( 'home_image_internal_url' );
      $darktext = get_post_meta($post->ID, "home_image_dark_text");
      $hasdarktext =( in_array('1',$darktext) ? ' hero-text-dark' : '');
	  ?>

<div class="uams-hero-image hero-height2 <?php echo $hasmobileimage ?>" style="background-image: url(<?php echo $url ?>);">
     <?php if( !empty($mobileimage) ) { ?>
    <div class="mobile-image" style="background-image: url(<?php echo $mobileimage['url'] ?>);"></div>
    <?php } ?>
      <div class="container">
        <h1 class="uams-site-title2<?php echo $hasdarktext; ?>"><?php the_title(); ?></h1>
        <span class="udub-slant<?php echo $hasdarktext; ?>"><span></span></span>
        <?php if(!empty($buttontext) && $button ){ ?>
        <a class="uams-btn btn-sm btn-none" href="<?php echo $external ? $externalurl : $internalurl; ?>"><?php echo $buttontext ? $buttontext : ''; ?></a>
        <?php } ?>
      </div>
</div>
<div class="container uams-body">
  <div class="row">
    <div class="hero-content col-md-<?php echo (($sidebar[0]!="on") ? "8" : "12" ) ?> uams-content" role='main'>

      <?php //uams_page_title(); ?>
      <?php //get_template_part( 'menu', 'mobile' ); ?>
      <?php
	      if((!isset($breadcrumbs[0]) || $breadcrumbs[0]!="on")) {
	      	get_template_part( 'breadcrumbs' );
	      }
	  ?>

	  <?php  // Add mobile sidebar, if necessary ?>

	      <div id="mobile-sidebar">

				<button id="mobile-sidebar-menu" aria-hidden="true" tabindex="1">

			    	<div aria-hidden="true" id="ham">
					    <span></span>
						<span></span>
						<span></span>
						<span></span>
				    </div>
					<div id="mobile-sidebar-title" class="page_item">

						<?php
					        //limitation of the characters
					        $text = get_the_title();
					        echo text_cut($text, 27, true);
							function text_cut($text, $length, $dots) {
							//$text =get_the_title();
							$text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
							$text_temp = $text;
							   while (substr($text, $length, 1) != " ") {
									$length--;
								  	if ($length > strlen($text)) {
									  	break;
									}
								}
							    $text = substr($text, 0, $length);
							    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : '');
							}
						?>

				  	</div>
				</button>
				<div id="mobile-sidebar-links" aria-hidden="true">  <?php uams_sidebar_menu(); ?></div>
			</div>

      <div id='main_content' class="uams-body-copy" tabindex="-1">

        <?php
          while ( have_posts() ) : the_post();

              the_content();

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
              comments_template();
            }

          endwhile;

        ?>

      </div>

    </div>

    <div id="sidebar"><?php
      if($sidebar[0]!="on"){
        get_sidebar();
      }
    ?></div>

  </div>

</div>

<?php get_footer(); ?>
