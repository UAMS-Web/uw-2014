<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header();
   $sidebar = get_post_meta($post->ID, "sidebar");
   $breadcrumbs = get_post_meta($post->ID, "breadcrumb");
 ?>

<?php get_template_part( 'header', 'image' ); ?>

<!--<div class="col-md-12 mobile-menu"> <?php get_template_part( 'menu', 'mobile' ); ?> </div>-->
<div class="container uams-body">

  <div class="row">

    <div class="col-md-<?php echo ((!isset($sidebar[0]) || $sidebar[0]!="on") ? "8" : "12" ) ?> uams-content" role='main'>

      <?php //uams_page_title(); ?>

      <?php //get_template_part( 'menu', 'mobile' ); ?>

      <?php
	      if((!isset($breadcrumbs[0]) || $breadcrumbs[0]!="on")) {
	      	get_template_part( 'breadcrumbs' );
	      }
	  ?>

      <div id='main_content' class="uams-body-copy" tabindex="-1">

        <h2 id="pages">Pages</h2>
		<ul>
		<?php
		// Add pages you'd like to exclude in the exclude here
		wp_list_pages(
		  array(
		    'exclude' => '',
		    'title_li' => '',
		  )
		);
		?>
		</ul>

		<h2 id="posts">Posts</h2>
		<ul>
		<?php
		// Add categories you'd like to exclude in the exclude here
		$cats = get_categories('exclude=');
		foreach ($cats as $cat) {
		  echo "<li><h3>".$cat->cat_name."</h3>";
		  echo "<ul>";
		  query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
		  while(have_posts()) {
		    the_post();
		    $category = get_the_category();
		    // Only display a post link once, even if it's in multiple categories
		    if ($category[0]->cat_ID == $cat->cat_ID) {
		      echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
		    }
		  }
		  echo "</ul>";
		  echo "</li>";
		}
		?>
		</ul>

      </div>

    </div>

    <div id="sidebar"><?php
      if(!isset($sidebar[0]) || $sidebar[0]!="on"){
        get_sidebar();
      }
    ?></div>

  </div>

</div>

<?php get_footer(); ?>
