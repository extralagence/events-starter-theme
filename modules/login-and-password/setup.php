<?php

/**********************
 *
 *
 *
 * LOGIN LOGO LINK
 *
 *
 *
 *********************/
function extra_events_url_login(){
	return home_url('/');
}
add_filter('login_headerurl', 'extra_events_url_login');
/**********************
 *
 *
 *
 * ADMIN STYLESHEET
 *
 *
 *
 *********************/
function extra_events_css_admin() {
	wp_enqueue_style( 'extra-admin-login', THEME_MODULES_URI.'/login-and-password/front/css/login.less' );
}
add_action('admin_print_styles', 'extra_events_css_admin');
add_action('login_head', 'extra_events_css_admin');


/**********************
 *
 *
 *
 * REMOVE STYLESHEET
 *
 *
 *
 *********************/
function extra_password_protected_login_head() {
	// CSS
	// REMOVE ADMIN
	add_filter('wp_admin_css', 'extra_no_admin_css');

	// EXTRA LOGIN
	wp_register_style( 'extra-password', THEME_MODULES_URI . '/login-and-password/front/css/login.less', array(), false, 'all' );
	wp_enqueue_style( 'extra-password' );
	// JS
	// JQUERY
	wp_enqueue_script('jquery');
	// EXTRA LOGIN
	wp_register_script('extra-password', THEME_MODULES_URI . '/login-and-password/front/js/password.js', array('jquery'), false, true);
	wp_enqueue_script('extra-password');
}
add_action( 'password_protected_login_head', 'extra_password_protected_login_head' );
function extra_no_admin_css(){
	return null;
}