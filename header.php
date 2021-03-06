<?php

// GLOBAL OPTIONS
global $extra_options;

?><!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9 recent"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="recent noie no-js"><!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />        
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
         
        <!-- TITLE -->       
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        
        <!-- REMOVE NO-JS -->
        <!--noptimize--><script>document.documentElement.className = document.documentElement.className.replace(/\bno-js\b/,'') + ' js';</script><!--/noptimize-->
        
        <!-- ANALYTICS TRACKER -->
        <?php get_template_part("google-analytics"); ?>
        
        <!-- MOBILE FRIENDLY -->        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- IE9.js -->
        <!--[if (gte IE 6)&(lte IE 8)]>
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/ie.css" />
        <script src="<?php echo get_template_directory_uri(); ?>/assets/js/lib/selectivizr-min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/assets/js/lib/html5shiv.js"></script>
        <![endif]-->

        <!-- WORDPRESS HOOK -->
        <?php wp_head(); ?>  
        
    </head>
    <body <?php body_class(); ?>>
        
        <?php
        /**********************
         *
         * MENU MOBILE
         *
         *********************/
        //get_template_part(apply_filters("extra_template_header_menu_mobile", "setup/front/menu-mobile"));
        ?>
        
        <div id="wrapper">
			<div id="header-nav">
				<div class="wrapper">
					<?php if(!is_user_logged_in()): ?>
						<a href="<?php echo wp_login_url(site_url('/')); ?>"><?php _e("Se connecter", "extra"); ?></a>
					<?php else: ?>
						<a href="<?php echo site_url().'/mon-profil' ?>"><?php _e("Mon profil", "extra"); ?></a> |
						<a href="<?php echo get_permalink(get_option("dbem_my_bookings_page")); ?>"><?php _e("Gérer ma réservation", "extra"); ?></a> |
						<a href="<?php echo wp_logout_url(); ?>"><?php _e("Se déconnecter", "extra"); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<header id="header">
                <div class="wrapper">
                    <!-- SITE TITLE (LOGO) -->
                    <?php if(is_front_page()): ?>   <h1 class="site-title"><span><?php bloginfo("name"); ?></span></h1>
                    <?php else: ?>                  <h2 class="site-title"><a href="<?php echo site_url('/'); ?>"><?php bloginfo("name"); ?></a></h2> <?php endif; ?>
                    <?php
                    /**********************
                     *
                     * HEADER
                     *
                     *********************/
                    get_template_part(apply_filters("extra_template_header_content", "setup/front/content-header"));
                    ?>
                </div>
            </header>