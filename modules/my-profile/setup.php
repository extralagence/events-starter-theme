<?php

global $my_profile_metabox;
$my_profile_metabox = new ExtraMetaBox(array(
	'id' => '_my_profile_meta',
	'title' => __("Paramètres", "extra"),
	'types' => array('page'),
	'include_template' => array('template-my-profile.php'),
	'hide_editor' => true,
	'hide_ui' => true,
	'fields' => array(
		array(
			'type' => 'label',
			'label' => '<strong>'.__("Attention ! Le contenu de la page est remplacé par un formulaire", "extra-admin").'</strong>',
			'css_class' => 'bloc'
		)
	)
));

function extra_my_profile_enqueue_assets() {
	if (is_page_template('template-my-profile.php')) {
		wp_enqueue_style( 'extra-my-profile', THEME_MODULES_URI.'/my-profile/front/css/my-profile.less', array(), false, 'all' );
	}
}
add_action('wp_enqueue_scripts', 'extra_my_profile_enqueue_assets');