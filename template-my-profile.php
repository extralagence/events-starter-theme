<?php
/*
Template name: Gestion de mon profil
*/
the_post();
?>

<div class="content">
	<h1 class="main-title"><?php the_title(); ?></h1>
	<?php echo do_shortcode('[wppb-edit-profile]'); ?>
</div>