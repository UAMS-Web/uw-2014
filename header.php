<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> <?php wp_title(' | ',TRUE,'right'); echo str_replace('\n', '', get_bloginfo('name')); ?> </title>
        <meta charset="utf-8">
        <meta name="description" content="<?php bloginfo('description', 'display'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <?php wp_head(); ?>

        <!--[if lt IE 9]>
            <script src="<?php bloginfo("template_directory"); ?>/assets/ie/js/html5shiv.js" type="text/javascript"></script>
            <script src="<?php bloginfo("template_directory"); ?>/assets/ie/js/respond.js" type="text/javascript"></script>
            <link rel='stylesheet' href='<?php bloginfo("template_directory"); ?>/assets/ie/css/ie.css' type='text/css' media='all' />
        <![endif]-->

        <?php
        echo get_post_meta( get_the_ID() , 'javascript' , 'true' );
        echo get_post_meta( get_the_ID() , 'css' , 'true' );
        ?>
    </head>
    <!--[if lt IE 9]> <body <?php body_class('lt-ie9'); ?>> <![endif]-->
    <!--[if gt IE 8]><!-->
    <body <?php body_class(); ?> >
    <!--<![endif]-->

    <div id="uamssearcharea" aria-hidden="true" class="uams-search-bar-container"></div>

    <a id="main-content" href="#main_content" class='screen-reader-shortcut'>Skip to main content</a>

    <div id="uams-container">

    <div id="uams-container-inner">


    <?php get_template_part('thinstrip'); ?>

    <?php require( get_template_directory() . '/inc/template-functions.php' );
          uams_dropdowns(); ?>
    <div class="col-md-12 mobile-menu"> <?php get_template_part( 'menu', 'mobile' ); ?> </div>
