<?php
/**
 *
 */
/**********************
 *
 *
 *
 * PREVENT ACCESS TO ADMIN FOR SUBSCRIBERS
 *
 *
 *
 *********************/
if ( is_user_logged_in() && is_admin() && !(defined('DOING_AJAX') && DOING_AJAX) ) {
	global $current_user;
	get_currentuserinfo();
	$user_info = get_userdata($current_user->ID);
	if (in_array('subscriber', $user_info->roles)) {

		// Redirect Home
		$redirect_permalink = esc_url( home_url( '/' ) );
		wp_redirect($redirect_permalink);
		exit();
	}
}

/**********************
 *
 *
 *
 * PREVENT ACCESS TO PROFILE FRONT EDITOR WHEN NOT LOGGED IN
 *
 *
 *
 *********************/
add_action('template_redirect', function () {
	if ( !is_user_logged_in() && is_page_template('template-my-profile.php')) {
		// Redirect Home
		$redirect_permalink = esc_url( home_url( '/' ) );
		wp_redirect($redirect_permalink);
		exit();
	}
});

/**********************
 *
 *
 *
 * REDIRECT AFTER LOGIN / LOGOUT
 *
 *
 *
 *********************/
add_action('wp_logout','go_home');
add_action('wp_login','go_home');
function go_home(){
	// Redirect Home
	$redirect_permalink = esc_url( home_url( '/' ) );
	wp_redirect($redirect_permalink);
	exit();
}

/**********************
 *
 *
 *
 * THEME SETUP
 *
 *
 *
 *********************/
function _blank_setup() {
	// MATCH EDITOR CSS
	add_editor_style('assets/css/editor-style.less');
}

add_action('after_setup_theme', '_blank_setup');
/**********************
 *
 *
 *
 * LESS VARS
 *
 *
 *
 *********************/
function _blank_less_vars($vars, $handle) {
	// GLOBAL VARS
	$vars['font1'] = 'georgia, sans-serif';
	$vars['font2'] = '"Franklin Gothic Compressed", sans-serif';
	$vars['white'] = '#FFFFFF';
	$vars['black'] = '#606060';
	$vars['dark'] = '#202020';
	$vars['grey'] = '#808080';

	// THEME COLOR VARS
	$vars['highlight'] = '#00546d';
	$vars['color_base'] = '#00546d';
	$vars['color_hover'] = '#5d0135';
	$vars['color_grey'] = '#606060';
	$vars['color_background'] = '#f4f2f0';

	$vars['color_border'] = '#aac2c8';
	$vars['color_title'] = $vars['color_hover'];
	$vars['color_link'] = $vars['color_base'];
	return $vars;
}

add_filter('less_vars', '_blank_less_vars', 10, 3);

/**********************
 *
 *
 *
 * EXTRA PAGE BUILDER SIZES
 *
 *
 *
 *********************/
add_filter('extra_page_builder_full_width', function ($width) {
	return 880;
});
add_filter('extra_page_builder_half_width', function ($width) {
	return 420;
});
add_filter('extra_page_builder_one_third_width', function ($width) {
	return 265;
});
add_filter('extra_page_builder_two_third_width', function ($width) {
	return 570;
});
add_filter('extra_page_builder_gap', function ($width) {
	return 40;
});

/**********************
 *
 *
 *
 * ADMIN ONLY STUFF
 *
 *
 *
 *********************/
include_once 'setup/admin/setup.php';
