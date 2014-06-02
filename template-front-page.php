<?php 
/*
Template name: Page d'accueil
*/
global $extra_options;
global $front_page_metabox;
the_post();
$front_page_metabox->the_meta();
?>

<?php
/**********************
 *
 * SLIDER
 *
 *********************/
get_template_part("modules/front-page/front/slider");
?>

<div class="wrapper">
	<?php
	/**********************
	 *
	 * ABOUT
	 *
	 *********************/
	get_template_part("/modules/front-page/front/pushs");
	?>

</div><!-- .wrapper -->