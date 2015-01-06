<?php
function extra_hotel() {
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
		'name' => __('Hôtel', 'extra-admin'),
		'singular_name' => __('Hôtel', 'extra-admin'),
		'add_new' => __('Ajouter un hôtel', 'extra-admin'),
		'add_new_item' => __('Ajouter un hôtel', 'extra-admin'),
		'edit_item' => __('Modifier l\'hôtel', 'extra-admin'),
		'new_item' => __('Nouvel hôtel', 'extra-admin'),
		'all_items' => __('Tous les hôtels', 'extra-admin'),
		'view_item' => __('Voir l\'hôtel', 'extra-admin'),
		'search_items' => __('Rechercher un hôtel', 'extra-admin'),
		'not_found' =>  __('Aucun hôtel trouvé', 'extra-admin'),
		'not_found_in_trash' => __('Aucun hôtel trouvé dans la corbeille', 'extra-admin'),
		'parent_item_colon' => '',
		'menu_name' => __('Hôtels', 'extra-admin')
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'capability_type' => 'post',
		'rewrite' => array(
			'slug' => __('hotel', 'extra-admin'),
			'with_front' => false,
			'feeds' => false,
			'pages' => false
		),
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => 24,
		'menu_icon' => 'dashicons-admin-home',
		'supports' => array('title', 'editor')
	); 
	register_post_type('hotel', $args);
		
	// GET ALL HOTELS
	global $hotels_query;
	$hotels_query = get_posts(array(
		'post_type' => 'hotel',
		'posts_per_page' => -1
	));
		
}
add_action('init', 'extra_hotel', 1);

/**********************
 *
 *
 *
 * METABOX
 * 
 *
 *
 *********************/
global $hotel_metabox, $hotel_list_metabox;
$hotel_metabox = new ExtraMetaBox(array(
	'id' => '_hotel_meta',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_hotel_',
	'title' => __("Paramètres de l'hotel", "extra-admin"),
	'types' => array('hotel'),
	'hide_ui' => true,
	'fields' => array(
		array(
			'type' => 'bloc',
			'label' => __("Paramètres de l'hôtel", "extra-admin"),
			'subfields' => array(
				array(
					'type' => 'slider',
					'name' => 'room_max',
					'label' => __("Places disponibles", "extra-admin"),
					'max' => '1000'
				),
				array(
					'type' => 'slider',
					'name' => 'price_single',
					'label' => __("Chambres simples", "extra-admin"),
					'max' => '1000'
				),
				array(
					'type' => 'slider',
					'name' => 'price_double',
					'label' => __("Chambres doubles", "extra-admin"),
					'max' => '1000'
				)
			)
		),
		array(
			'type' => 'bloc',
			'label' => __("Photos", "extra-admin"),
			'subfields' => array(
				array(
					'type' => 'gallery',
					'name' => 'gallery',
				)
			)
		),
		array(
			'type' => 'bloc',
			'label' => __("Coordonnées", "extra-admin"),
			'subfields' => array(
				array(
					'type' => 'map',
					'name' => 'map',
				)
			)
		)
	)
));

$hotel_list_metabox = new ExtraMetaBox(array(
	'id' => '_hotel_list_meta',
	'title' => __("Paramètres", "extra"),
	'types' => array('page'),
	'include_template' => array('template-hotel.php'),
	'hide_editor' => true,
	'hide_ui' => true,
	'fields' => array(
		array(
			'type' => 'label',
			'label' => '<strong>'.__("Attention ! Le contenu de la page est remplacé par la liste des hôtels disponibles.", "extra-admin").'</strong>',
			'css_class' => 'bloc'
		),
	)
));

function extra_hotel_list_enqueue_assets() {
	if (is_page_template('template-hotel.php')) {
		wp_enqueue_style( 'extra-hotel', THEME_MODULES_URI.'/hotel/front/css/hotel.less', array(), false, 'all' );
		wp_enqueue_script('extra-hotel', THEME_MODULES_URI.'/hotel/front/js/hotel.js', array('jquery'), null, true);
	}
}
add_action('wp_enqueue_scripts', 'extra_hotel_list_enqueue_assets');


function extra_hotel_add_global_options ($sections) {

	$sections[] = array(
		'icon' => 'el-icon-home',
		'title' => __("Hôtels", 'extra-admin'),
		'fields' => array(
			array(
				'id' => 'extra_hotel_default_image',
				'type' => 'media',
				'title' =>  __('Image hôtel par défaut', 'extra-admin')
			)
		)
	);

	return $sections;
}
add_filter( 'extra_add_global_options_section','extra_hotel_add_global_options');