<?php
/*
Template name: Liste des activités
*/
global $extra_options, $activity_metabox;
the_post();
$activity_query = new WP_Query(array(
	'posts_per_page' => -1,
	'post_type' => 'activity'
));

$default_image = $extra_options['extra_activity_default_image'];
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

<div class="wrapper">

	<?php if($activity_query->have_posts()): ?>

		<?php while($activity_query->have_posts()): $activity_query->the_post(); ?>

			<div class="activity item">

				<h3 class="activity-title chapo"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<div class="gallery">
					<a href="<?php the_permalink(); ?>">
						<?php
						extra_responsive_image(
							(has_post_thumbnail()) ? get_post_thumbnail_id() : $default_image['url'],
							array(
								'desktop' => array(
									'width' => 420,
									'height' => 235
								),
								'tablet' => array(
									'width' => 420,
									'height' => 235
								),
								'mobile' => array(
									'width' => 420,
									'height' => 235
								),
							)
						)
						?>
						<span class="details">
							<span><?php _e("Voir les détails"); ?></span>
						</span>
					</a>
				</div><!-- .gallery -->

			</div><!-- .hotel -->

		<?php endwhile; endif; ?>

</div>