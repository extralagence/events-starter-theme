<?php
global $extra_options;
/**********************
 *
 *
 *
 * HEADER
 * 
 *
 *
 *********************/
get_header();
/**********************
 *
 *
 *
 * START THE LOOP
 * 
 *
 *
 *********************/
?>
<a href="<?php echo home_url('/'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/visu/404.jpg" alt="404" width="960" height="500" id="img404" /></a>
<?php 
/**********************
 *
 *
 *
 * THE FOOTER
 * 
 *
 *
 *********************/
 get_footer();
 ?>