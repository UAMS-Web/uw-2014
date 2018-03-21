<h1><?php the_title() ?></h1>

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
	<div id="mobile-sidebar-links" aria-hidden="true">  <?php uams_sidebar_menu_mobile(); ?></div>
</div>

<?php the_content(); ?>
