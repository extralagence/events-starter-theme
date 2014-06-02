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
	wp_enqueue_style( 'extra-admin-login', THEME_URI.'/assets/img/.less' );
}
add_action('admin_print_styles', 'extra_events_css_admin');
add_action('login_head', 'extra_events_css_admin');