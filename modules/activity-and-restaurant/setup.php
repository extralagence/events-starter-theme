<?php

require_once THEME_MODULES_PATH . '/activity-and-restaurant/activity.php';
require_once THEME_MODULES_PATH . '/activity-and-restaurant/restaurant.php';

function extra_combined() {
	/* ACTIVITES / RESTAURANTS */
	p2p_register_connection_type(array(
		'name' => 'restaurant_to_activity',
		'from' => 'activity',
		'to' => 'restaurant',
		'reciprocal' => true,
		'title' => 'Associations'
	));
}
add_action('init', 'extra_combined');