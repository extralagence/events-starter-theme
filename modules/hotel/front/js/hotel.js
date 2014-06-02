$(document).ready(function(){
	/**********************
	 *
	 * GALLERY
	 * 
	 *********************/
	var $gallery = $(".gallery"),
		$animation = $('<div class="extra-slider-auto-indicator"></div>').appendTo($gallery),
		autoAnimation = TweenMax.to($animation, 5, {width: '100%'});

	$gallery.extraSlider({
		'navigate'				: false,
		'paginate'				: true,
		'speed'					: 1,
		'type'					: 'fade',
		'auto'					: 5
	});


	$gallery.on('pause.extra.slider', function() {
		autoAnimation.pause();
		$gallery.data('pause', 'pause')
	});
	$gallery.on('resume.extra.slider', function() {
		autoAnimation.resume();
		$gallery.data('pause', '')
	});
	$gallery.on('moveStart.extra.slider', function() {
		autoAnimation.restart();
		if ($gallery.data('pause') == 'pause') {
			autoAnimation.pause();
		}
	});
});
