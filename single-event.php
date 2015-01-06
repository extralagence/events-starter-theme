<?php
global $extra_options, $extra_event_metabox, $post;
the_post();

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

<h1 class="main-title"><?php the_title(); ?></h1>

<article class="content">

	<?php the_extra_booking_datas($post->ID); ?>
	<?php the_content(); ?>
</article>