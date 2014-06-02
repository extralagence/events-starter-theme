<?php
/*
Template name: Liste des hotels
*/
global $extra_options, $hotel_metabox;
the_post();
$hotel_query = new WP_Query(array(
	'posts_per_page' => -1,
	'post_type' => 'hotel'
));
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
<h1 class="main-title"><?php the_second_title(); ?></h1>
<?php if($hotel_query->have_posts()): ?>
	<div class="wrapper">
		<?php while($hotel_query->have_posts()): $hotel_query->the_post(); $hotel_metabox->the_meta(); ?>
			<div class="hotel">
				<h3 class="hotel-title chapo"><?php the_title(); ?></h3>
				<?php
				$gallery = $hotel_metabox->get_the_value('gallery');
				if (empty($gallery)) :
					$default_image = $extra_options['extra_hotel_default_image'];
					extra_responsive_image(
						$default_image['url'],
						array(
							'desktop' => array(
								'width' => 420,
								'height' => 215,
								'crop' => true
							),
							'tablet' => array(
								'width' => 420,
								'height' => 215,
								'crop' => true
							),
							'mobile' => array(
								'width' => 420,
								'height' => 215,
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
					<div class="gallery">
						<div class="wrapper">
							<ul>
								<?php foreach($images as $image) : ?>
									<li>
										<a href="<?php echo $image['src'][0]; ?>">
											<?php
											extra_responsive_image($image['src'][0], array(
												'desktop' => array(
													'width' => 420,
													'height' => 215,
													'crop' => true
												),
												'tablet' => array(
													'width' => 420,
													'height' => 215,
													'crop' => true
												),
												'mobile' => array(
													'width' => 420,
													'height' => 215,
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

				<div class="content">
					<?php the_content(); ?>
				</div>
			</div><!-- .hotel -->
		<?php endwhile; ?>
	</div>
<?php endif; ?>