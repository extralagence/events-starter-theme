<?php
/**********************
 *
 *
 *
 * TINY MCE
 *
 *
 *
 *********************/
function _blank_tinymce($init) {
	$style_formats = (isset($init['style_formats'])) ? json_decode($init['style_formats']) : null;
	if(empty($style_formats) || !is_array($style_formats)) {
		$style_formats = array();
	}
	$style_formats = array_merge($style_formats, array(
	   array(
			'title'   => 'Lien bouton',
			'selector'   => 'a',
			'classes' => 'link-button'
		), array(
			'title'   => 'Lien important',
			'selector'   => 'a',
			'classes' => 'link-important'
		), array(
			'title'   => 'Chapô',
			'block'   => 'div',
			'classes' => 'chapo',
			'wrapper' => true
		), array(
			'title'   => 'Titre avec bordure',
			'selector'   => 'h1, h2, h3, h4',
			'classes' => 'border-title'
		)
	));
	$init['style_formats'] = json_encode($style_formats);
	return $init;
}

add_filter('tiny_mce_before_init', '_blank_tinymce');

add_filter('extra_add_global_options_section', function ($sections) {
	$sections[] = array(
		'icon' => 'el-icon-list-alt',
		'title' => __('Pages', 'extra-admin'),
		'desc' => null,
		'fields' => array(
			array(
				'id' => 'contact_page',
				'type' => 'select',
				'data' => 'pages',
				'title' => __('Page de contact', 'extra-admin'),
				'subtitle' => null,
				'desc' => null
			)
		)
	);

	return $sections;
});
?>