<?php
/**
 * Template Name: Blank
 */
?>

<?php get_header();
    $sidebar = get_post_meta($post->ID, "sidebar");
    $breadcrumbs = get_post_meta($post->ID, "breadcrumb");
?>

<div class="uams-hero-image hero-blank no-title">
  <h1 class="container uams-site-title-blank"><?php the_title(); ?></h1>
</div>

<div class="container uams-body blank">

  <div class="row">

    <div class="col-md-<?php echo (($sidebar[0]!="on") ? "8" : "12" ) ?> uams-content" role='main'>

      <?php  // Add mobile sidebar, if necessary ?>
	      	<div id="mobile-sidebar">

				<button id="mobile-sidebar-menu" class="visible-xs" aria-hidden="true" tabindex="1">

			    	<div aria-hidden="true" id="ham">
					    <span></span>
						<span></span>
						<span></span>
						<span></span>
				    </div>
					<div id="mobile-sidebar-title" class="page_item">

						<?php
					        //limitation of the characters
					        echo text_cut();
							function text_cut($text, $length = 27, $dots = true) {
							$text =get_the_title();
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
          // Start the Loop.
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
