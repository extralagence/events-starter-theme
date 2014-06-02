$(document).ready(function(){
	/**********************
	 *
	 * GALLERY
	 * 
	 *********************/
	var autoSlider = true;
	var $slider = $("#slider").extraSlider({
			'navigate'				: true,
			'paginate'				: true,
			'speed'					: 1,
			'type'					: 'fade',
			'auto'					: 5
		}),
		$animation = $('<div class="extra-slider-auto-indicator"></div>').appendTo($slider),
		autoAnimation = TweenMax.to($animation, 5, {width: '100%'});

	$slider.on('pause.extra.slider', function() {
		autoAnimation.pause();
		$slider.data('pause', 'pause')
	});
	$slider.on('resume.extra.slider', function() {
		autoAnimation.resume();
		$slider.data('pause', '')
	});
	$slider.on('moveStart.extra.slider', function() {
		autoAnimation.restart();
		if ($slider.data('pause') == 'pause') {
			autoAnimation.pause();
		}
	});

	/**********************
	 *
	 * PUSHS ROLL OVER
	 * 
	 *********************/
	$("#pushs").find(".register, .contact").each(function(){
		var elmt = $(this);
		var link = elmt.find("a").first().clone().appendTo(elmt).removeAttr('class').addClass("biglink");
		elmt.on("mouseenter", function(){
			elmt.addClass("over");
		}).on("mouseleave", function(){
			elmt.removeClass("over");
		});
	});
});
