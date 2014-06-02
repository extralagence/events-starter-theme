<?php

global $my_bookings_metabox;
$my_bookings_metabox = new ExtraMetaBox(array(
	'id' => '_my_bookings_meta',
	'title' => __("Paramètres", "extra"),
	'types' => array('page'),
	'include_template' => array('template-my-bookings.php'),
	'hide_editor' => true,
	'hide_ui' => true,
	'fields' => array(
		array(
			'type' => 'label',
			'label' => '<strong>'.__("Attention ! Le contenu de la page est remplacé par les reservations de l'utilisateur loggé.", "extra-admin").'</strong>',
			'css_class' => 'bloc'
		),
	)
));