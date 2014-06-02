<?php
global $extra_options, $extra_event_metabox;
the_post();

$meta = $extra_event_metabox->the_meta();
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

	<?php
	// CUSTOM METAS
	$extra_arrival_date_max = $meta['extra_arrival_date_max'];
	$extra_arrival_date_min = $meta['extra_arrival_date_min'];
	$extra_arrival_time_max = $meta['extra_arrival_time_max'];
	$extra_arrival_time_min = $meta['extra_arrival_time_min'];
	$extra_departure_date_max = $meta['extra_departure_date_max'];
	$extra_departure_date_min = $meta['extra_departure_date_min'];
	$extra_departure_time_max = $meta['extra_departure_time_max'];
	$extra_departure_time_min = $meta['extra_departure_time_min'];

	$user_meta = get_user_meta(get_current_user_id());
	$extra_first_name = '';
	$extra_last_name = '';
	if ($user_meta != false) {
		$extra_first_name = $user_meta['first_name'][0];
		$extra_last_name = $user_meta['last_name'][0];
	}

	?>
	<script type="text/javascript">
		var extra_booking_datas = {
			'template_url': "<?php echo THEME_URI; ?>",
			'extra_arrival_date_max': "<?php echo $extra_arrival_date_max; ?>",
			'extra_arrival_date_min': "<?php echo $extra_arrival_date_min; ?>",
			'extra_arrival_time_max': "<?php echo $extra_arrival_time_max; ?>",
			'extra_arrival_time_min': "<?php echo $extra_arrival_time_min; ?>",
			'extra_departure_date_max': "<?php echo $extra_departure_date_max; ?>",
			'extra_departure_date_min': "<?php echo $extra_departure_date_min; ?>",
			'extra_departure_time_max': "<?php echo $extra_departure_time_max; ?>",
			'extra_departure_time_min': "<?php echo $extra_departure_time_min; ?>",
			'extra_first_name': "<?php echo $extra_first_name; ?>",
			'extra_last_name': "<?php echo $extra_last_name; ?>"
		};
	</script>
	<?php the_content(); ?>
</article>