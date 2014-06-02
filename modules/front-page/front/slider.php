<?php
/**********************
 *
 *
 *
 * SLIDER
 * 
 *
 *
 *********************/
global $front_page_metabox;
global $post; 
$slides = $front_page_metabox->get_the_value('slide');
if(!empty($slides)):
?>
<div id="slider" class="bloc">
	<div class="wrapper">
		<ul>
		<?php while($front_page_metabox->have_fields('slide')): ?>
			<li>					
				<?php
					$image_id = $front_page_metabox->get_the_value("slide-image");

					extra_responsive_image(
						$image_id,
						array(
							'desktop' => array(
								'width' => 960,
								'height' => 355,
								'crop' => true
							),
							'tablet' => array(
								'width' => 960,
								'height' => 355,
								'crop' => true
							),
							'mobile' => array(
								'width' => 960,
								'height' => 355,
								'crop' => true
							)
						),
						'image'
					);
				?>
				<?php
				$slide_content = $front_page_metabox->get_the_value("slide-content");
				if(!empty($slide_content)): ?>
					<div class="post-entry">
						<div class="content">
							<?php echo apply_filters('the_content', html_entity_decode( $slide_content, ENT_QUOTES, 'UTF-8' )); ?>
						</div>
					</div>
				<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
	</div>
</div>
<?php endif; ?>