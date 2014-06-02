<?php
/*
 * @var $page_builder_metabox ExtraPageBuilder
 */
global $page_builder_metabox;
the_post();
?>

<div class="content">
	<?php the_content(); ?>
	<?php echo $page_builder_metabox->get_front(); ?>
</div>