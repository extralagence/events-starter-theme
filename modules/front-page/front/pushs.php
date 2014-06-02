<?php
global $front_page_metabox;;
$front_page_metabox->the_meta();
$events = get_posts("post_type=event&numberposts=1");
$postID = $events[0]->ID;
$event_date = get_post_meta($postID, "_event_start_date", true);
?><div id="pushs">
	<div class="push start">
		<h3><?php _e("Date et lieu", "extra"); ?></h3>
		<p><?php $front_page_metabox->the_value("date_location"); ?></p>
	</div>
	<div class="push register">
		<h3><?php _e("S'inscrire à l'évènement", "extra"); ?></h3>
		<p><a class="button" href="<?php echo get_permalink($front_page_metabox->get_the_value("event-page")); ?>"><?php _e("Inscription", "extra"); ?></a></p>
	</div>
	<div class="push contact">
		<h3><?php _e("Une question ?", "extra"); ?></h3>
		<p><a class="button" href="<?php echo get_permalink($front_page_metabox->get_the_value("contact-page")); ?>"><?php _e("Contactez-nous", "extra"); ?></a></p>
	</div>
</div>
