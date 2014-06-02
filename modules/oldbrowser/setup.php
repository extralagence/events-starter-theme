<?php
// CSS & JS
function extra_oldbrowser_enqueue_styles() {
	// CSS
	wp_enqueue_style( 'extra-oldbrowser', THEME_URI . '/modules/oldbrowser/oldbrowser.css', array(), false, 'all' );
	// JS
	wp_enqueue_script('extra-oldbrowser', THEME_URI.'/modules/oldbrowser/oldbrowser.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'extra_oldbrowser_enqueue_styles');
function extra_oldbrowser_enqueue_styles_login() {
	// CSS
	wp_enqueue_style( 'extra-oldbrowser', THEME_URI . '/modules/oldbrowser/oldbrowser.css', array(), false, 'all' );
	// FANCYBOX
	wp_enqueue_style( 'fancybox', THEME_URI . '/assets/css/jquery.fancybox.css', array(), false, 'all' );
	// JS
	wp_enqueue_script('extra-oldbrowser', THEME_URI.'/modules/oldbrowser/oldbrowser.js', array('jquery'), false, true);
	// MOUSEWHEEL
	wp_enqueue_script('mousewheel', THEME_URI.'/assets/js/lib/jquery.mousewheel-3.0.6.pack.js', array('jquery'), false, true);
	// FANCYBOX
	wp_enqueue_script('fancybox', THEME_URI.'/assets/js/lib/jquery.fancybox.pack.js', array('jquery'), false, true);
}
add_action('login_init', 'extra_oldbrowser_enqueue_styles_login');
// HTML
function extra_oldbrowser_head(){ ?>

	<div style="display:none;">
	<div id="oldBrowser" class="oldBrowser-<?php bloginfo("language"); ?>">
		<h3 class="title"><?php _e("Mettez à jour votre navigateur pour consulter ce site", "extra"); ?></h3>
		<ul class="browsers">
			<li class="firefox"><a href="http://www.getfirefox.com" target="_blank"><span>Mozilla Firefox</span></a></li>
			<li class="ie"><a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie" target="_blank"><span>Internet Explorer</span></a></li>
			<li class="chrome"><a href="http://www.google.com/chrome" target="_blank"><span>Google Chrome</span></a></li>
			<li class="safari"><a href="http://support.apple.com/kb/dl1531" target="_blank"><span>Safari</span></a></li>
		</ul>
	</div>
	</div>

<?php }
add_action('login_footer', 'extra_oldbrowser_head');
add_action('wp_footer', 'extra_oldbrowser_head');
?>