<?php
function extra_activity() {
	/**********************
	 *
	 *
	 *
	 * POST TYPE CREATION
	 * 
	 *
	 *
	 *********************/
	$labels = array(
		'name' => __('Activité', 'extra-admin'),
		'singular_name' => __('Activité', 'extra-admin'),
		'add_new' => __('Nouvelle activité', 'extra-admin'),
		'add_new_item' => __('Ajouter une activité', 'extra-admin'),
		'edit_item' => __('Éditer une activité', 'extra-admin'),
		'new_item' => __('Nouvelle activité', 'extra-admin'),
		'all_items' => __('Toutes les activités', 'extra-admin'),
		'view_item' => __('Voir l\'activité', 'extra-admin'),
		'search_items' => __('Rechercher une activité', 'extra-admin'),
		'not_found' =>  __('Pas d\'activité trouvée', 'extra-admin'),
		'not_found_in_trash' => __('Pas d\'activité dans la corbeille', 'extra-admin'), 
		'parent_item_colon' => '',
		'menu_name' => __('Activités', 'extra-admin')
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'capability_type' => 'post',
		'rewrite' => array(
			'slug' => __('activite', 'extra-admin'),
			'with_front' => false,
			'feeds' => true,
			'pages' => true
		),
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 23,
		'menu_icon' => 'dashicons-art', //THEME_MODULES_URI."/activity/activity.png",
		'supports' => array('title', 'editor', 'author', 'thumbnail')
	); 
	register_post_type('activity', $args);
}
add_action('init', 'extra_activity', 1);
/**********************
 *
 *
 *
 * METABOX
 *
 *
 *
 *********************/
global $activity_metabox;
$activity_metabox = new ExtraMetaBox(array(
	'id' => '_activity_meta',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_activity_',
	'title' => __("Paramètres de l'activité", "extra"),
	'types' => array('activity'),
	'fields' => array(
		array(
			'type' => 'gallery',
			'name' => 'gallery'
		)
	),
	'hide_editor' => false
));

global $activity_list_metabox;
$activity_list_metabox = new ExtraMetaBox(array(
	'id' => '_activity_list_meta',
	'title' => __("Paramètres", "extra"),
	'types' => array('page'),
	'include_template' => array('template-activity.php'),
	'hide_editor' => true,
	'hide_ui' => true,
	'fields' => array(
		array(
			'type' => 'label',
			'label' => '<strong>'.__("Attention ! Le contenu de la page est remplacé par la liste des activités disponibles.", "extra-admin").'</strong>',
			'css_class' => 'bloc'
		),
	)
));

function extra_activity_list_enqueue_assets() {
	if (is_page_template('template-activity.php')) {
		wp_enqueue_style( 'extra-activity-list', THEME_MODULES_URI.'/activity-and-restaurant/front/css/multiple.less', array(), false, 'all' );
		//wp_enqueue_script('extra-activity-list', THEME_MODULES_URI.'/activity-and-restaurant/front/js/multiple.js', array('jquery'), null, true);
	}

	if (is_singular('activity')) {
		wp_enqueue_style( 'extra-activity', THEME_MODULES_URI.'/activity-and-restaurant/front/css/single.less', array(), false, 'all' );
		wp_enqueue_script('extra-activity', THEME_MODULES_URI.'/activity-and-restaurant/front/js/single.js', array('jquery'), null, true);
	}
}
add_action('wp_enqueue_scripts', 'extra_activity_list_enqueue_assets');

function extra_activity_add_global_options ($sections) {

	$sections[] = array(
		'icon' => 'el-icon-pencil',
		'title' => __("Activités", 'extra-admin'),
		'fields' => array(
			array(
				'id' => 'extra_activity_default_image',
				'type' => 'media',
				'title' =>  __('Image activité par défaut', 'extra-admin')
			),
			array(
				'id' => 'extra_activity_list_page',
				'type' => 'select',
				'data' => 'pages',
				'title' =>  __('Page "liste des activités"', 'extra-admin')
			)
		)
	);

	return $sections;
}
add_filter( 'extra_add_global_options_section','extra_activity_add_global_options');



/**********************
 *
 *
 *
 * GET CLASS FOR HOME
 *
 *
 *
 *********************/
add_filter('nav_menu_css_class' , 'extra_activity_nav_menu_css_class' , 10 , 2);
function extra_activity_nav_menu_css_class($classes, $item){

	global $extra_options;

	if((is_singular('activity')) && $extra_options['extra_activity_list_page'] == $item->object_id) {
		$classes[] = "current-menu-item current_page_item";
	}

	return $classes;
}