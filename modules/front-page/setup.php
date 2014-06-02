<?php
global $front_page_metabox;
$front_page_metabox = new ExtraMetaBox(array(
	'id' => '_front_page_meta',
	'title' => __("Paramètres de la page d'accueil", "extra"),
	'types' => array('page'),
	'include_template' => 'template-front-page.php',
	'hide_editor' => TRUE,
	'fields' => array(
		array(
			'type' => 'tabs',
			'name' => 'slide',
			'bloc_label' => __("Slide", 'extra-admin'),
			'subfields' => array(
				array(
					'type' => 'image',
					'name' => 'slide-image'
				),
				array(
					'type' => 'custom_editor',
					'name' => 'slide-content'
				),
			)
		),
		array(
			'type' => 'bloc',
			'subfields' => array(
				array(
					'type' => 'page_selector',
					'name' => 'event-page',
					'post_type' => 'event',
					'label' => __("Page d'inscription", "extra-admin")
				),
				array(
					'type' => 'page_selector',
					'name' => 'contact-page',
					'label' => __("Page de contact", "extra-admin")
				),
				array(
					'type' => 'text',
					'name' => 'date_location',
					'label' => __("Date et lieu", "extra-admin")
				)
			)
		)
	)
));

function extra_front_page_enqueue_assets() {
	if (is_page_template('template-front-page.php')) {
		wp_enqueue_style( 'extra-front-page', THEME_MODULES_URI.'/front-page/front/css/front-page.less', array(), false, 'all' );
		wp_enqueue_script('extra-front-page', THEME_MODULES_URI.'/front-page/front/js/front-page.js', array('jquery'), null, true);
	}
}
add_action('wp_enqueue_scripts', 'extra_front_page_enqueue_assets');