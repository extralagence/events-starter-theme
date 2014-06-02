<?php 
/*
Template name: Plan du site
*/ 
global $extra_options; 
the_post();
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
	<div id="main">
		
		<?php
		/**********************
		 *
		 * ARIANNE
		 *
		 *********************/
		get_template_part("arianne"); ?>
		
		<div class="wrapper">

			<?php		
			/**********************
			 *
			 * SIDEBAR
			 *
			 *********************/
			get_template_part("sidebar", "page"); ?>
			
			<div id="content">
			
				<h1 class="main-title"><?php the_second_title(); ?></h1>	
					
				<article class="content"> 
					<?php the_content(); ?>
					<ul><?php wp_list_pages(array('title_li' => null)); ?></ul>
				</article>	
				
				<?php extra_share(); ?>
				
				<a class="totop" href="#top"><?php _e("Retour haut de page", "extra"); ?></a>
		
			</div><!-- #content -->
		
		</div>
		
	</div><!-- #main -->			
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