<?php
global $extra_options;
global $restaurant_metabox;
$events = get_posts("post_type=event&numberposts=1");
$eventID = $events[0]->ID;
the_post();
$restaurant_metabox->the_meta();
?>

<div class="wrapper">
	<aside>
		<?php
		$gallery = $restaurant_metabox->get_the_value('gallery');
		if (empty($gallery)) :
			$default_image = $extra_options['extra_restaurant_default_image'];
			extra_responsive_image(
				$default_image['url'],
				array(
					'desktop' => array(
						'width' => 280,
						'height' => 210,
						'crop' => true
					),
					'tablet' => array(
						'width' => 280,
						'height' => 210,
						'crop' => true
					),
					'mobile' => array(
						'width' => 280,
						'height' => 210,
						'crop' => true
					),
				),
				'image'
			);
		else :
			$ids = explode(',', $gallery);
			$images = array();
			foreach($ids as $id) {
				$attachment = get_post($id);
				$src =  wp_get_attachment_image_src($id, 'large');
				$alt = get_post_meta($id, '_wp_attachment_image_alt', true);
				if(empty($alt)) {
					$alt = $attachment->post_title;
				}
				$image = array();
				$image['id'] = $id;
				$image['alt'] = $alt;
				$image['src'] = $src;
				$image['post_excerpt'] = $attachment->post_excerpt;
				$images[] = $image;
			}
			?>
			<div class="extra-slider">
				<div class="wrapper">
					<ul>
						<?php foreach($images as $image) : ?>
							<li>
								<a href="<?php echo $image['src'][0]; ?>">
									<?php
									extra_responsive_image($image['src'][0], array(
										'desktop' => array(
											'width' => 280,
											'height' => 210,
											'crop' => true
										),
										'tablet' => array(
											'width' => 280,
											'height' => 210,
											'crop' => true
										),
										'mobile' => array(
											'width' => 280,
											'height' => 210,
											'crop' => true
										)
									));
									?>
								</a>
								<?php echo !empty($image['post_excerpt']) ? '<div class="legend">'.$image['post_excerpt'].'</div>' : ''; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
	</aside>

	<article class="content">
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		<p><a class="button" href="<?php echo get_permalink($eventID); ?>#/restaurant/<?php echo $post->post_name; ?>"><?php _e("Sélectionner ce restaurant", "extra"); ?></a></p>
	</article>
</div><!-- .wrapper -->

<div class="extra-page-builder-separator"></div>

<div class="wrapper associations">

	<?php
	$connected = new WP_Query( array(
		'connected_type' => 'restaurant_to_activity',
		'connected_items' => get_queried_object(),
		'nopaging' => true
	));

	// Display connected pages
	if ( $connected->have_posts() ) : ?>

		<h2><?php _e("Activités associées", "extra"); ?></h2>

		<ul>
			<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
				<li>
					<div class="legend"><span><?php the_title(); ?></span></div>
					<a href="<?php the_permalink(); ?>">
						<?php
						extra_responsive_image(
							(has_post_thumbnail()) ? get_post_thumbnail_id() : $default_image['url'],
							array(
								'desktop' => array(
									'width' => 285,
									'height' => 235
								),
								'tablet' => array(
									'width' => 285,
									'height' => 235
								),
								'mobile' => array(
									'width' => 285,
									'height' => 235
								),
							)
						)
						?>
						<span class="details">
						<span><?php _e("Voir les détails"); ?></span>
					</span>
					</a>
				</li>

			<?php endwhile; ?>
		</ul>

		<?php wp_reset_postdata(); endif; ?>

</div>