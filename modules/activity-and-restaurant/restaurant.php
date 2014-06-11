<?php
function extra_restaurant() {
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
		'name' => __('Restaurant', 'extra-admin'),
		'singular_name' => __('Restaurant', 'extra-admin'),
		'add_new' => __('Nouveau restaurant', 'extra-admin'),
		'add_new_item' => __('Ajouter un restaurant', 'extra-admin'),
		'edit_item' => __('Éditer un restaurant', 'extra-admin'),
		'new_item' => __('Nouveau restaurant', 'extra-admin'),
		'all_items' => __('Tous les restaurants', 'extra-admin'),
		'view_item' => __('Voir le restaurant', 'extra-admin'),
		'search_items' => __('Rechercher un restaurant', 'extra-admin'),
		'not_found' =>  __('Pas de restaurant trouvé', 'extra-admin'),
		'not_found_in_trash' => __('Pas de restaurant dans la corbeille', 'extra-admin'), 
		'parent_item_colon' => '',
		'menu_name' => __('Restaurants', 'extra-admin')
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'capability_type' => 'post',
		'rewrite' => array(
			'slug' => __('restaurant', 'extra-admin'),
			'with_front' => false,
			'feeds' => true,
			'pages' => true
		),
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 22,
		'menu_icon' => 'dashicons-marker',
		'supports' => array('title', 'editor', 'author', 'thumbnail')
	); 
	register_post_type('restaurant', $args);
}
add_action('init', 'extra_restaurant', 1);
/**********************
 *
 *
 *
 * METABOX
 * 
 *
 *
 *********************/

global $restaurant_metabox;
$restaurant_metabox = new ExtraMetaBox(array(
	'id' => '_restaurant_meta',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_restaurant_',
	'title' => __("Paramètres du restaurant", "extra"),
	'types' => array('restaurant'),
	'fields' => array(
		array(
			'type' => 'gallery',
			'name' => 'gallery'
		)
	),
	'hide_editor' => false
));

global $restaurant_list_metabox;
$restaurant_list_metabox = new ExtraMetaBox(array(
	'id' => '_restaurant_list_meta',
	'title' => __("Paramètres", "extra"),
	'types' => array('page'),
	'include_template' => array('template-restaurant.php'),
	'hide_editor' => true,
	'hide_ui' => true,
	'fields' => array(
		array(
			'type' => 'label',
			'label' => '<strong>'.__("Attention ! Le contenu de la page est remplacé par la liste des restaurants disponibles.", "extra-admin").'</strong>',
			'css_class' => 'bloc'
		),
	)
));

function extra_restaurant_list_enqueue_assets() {
	if (is_page_template('template-restaurant.php')) {
		wp_enqueue_style( 'extra-restaurant-list', THEME_MODULES_URI.'/activity-and-restaurant/front/css/multiple.less', array(), false, 'all' );
		//wp_enqueue_script('extra-restaurant-list', THEME_MODULES_URI.'/activity-and-restaurant/front/js/multiple.js', array('jquery'), null, true);
	}

	if (is_singular('restaurant')) {
		wp_enqueue_style( 'extra-restaurant', THEME_MODULES_URI.'/activity-and-restaurant/front/css/single.less', array(), false, 'all' );
		wp_enqueue_script('extra-restaurant', THEME_MODULES_URI.'/activity-and-restaurant/front/js/single.js', array('jquery'), null, true);
	}
}
add_action('wp_enqueue_scripts', 'extra_restaurant_list_enqueue_assets');

function extra_restaurant_add_global_options ($sections) {

	$sections[] = array(
		'icon' => 'el-icon-glass',
		'title' => __("Restaurants", 'extra-admin'),
		'fields' => array(
			array(
				'id' => 'extra_restaurant_default_image',
				'type' => 'media',
				'title' =>  __('Image restaurant par défaut', 'extra-admin')
			),
			array(
				'id' => 'extra_restaurant_list_page',
				'type' => 'select',
				'data' => 'pages',
				'title' =>  __('Page "liste des restaurants"', 'extra-admin')
			)
		)
	);

	return $sections;
}
add_filter( 'extra_add_global_options_section','extra_restaurant_add_global_options');

/**********************
 *
 *
 *
 * GET CLASS FOR HOME
 *
 *
 *
 *********************/
add_filter('nav_menu_css_class' , 'extra_restaurant_nav_menu_css_class' , 10 , 2);
function extra_restaurant_nav_menu_css_class($classes, $item){

	global $extra_options;

	if((is_singular('restaurant')) && $extra_options['extra_restaurant_list_page'] == $item->object_id) {
		$classes[] = "current-menu-item current_page_item";
	}

	return $classes;
}