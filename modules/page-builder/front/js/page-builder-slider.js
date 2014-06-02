jQuery(document).ready(function ($) {
	$(".extra-slider").each(function () {
		var $this = $(this),
			properties = $this.data('properties');

		properties = $.parseJSON(properties.replace(/'/g, '"'));

		$this.extraSlider({
			'auto': properties.extra_page_builder_slider_auto,
			'draggable': properties.extra_page_builder_slider_draggable,
			'navigate': properties.extra_page_builder_slider_navigate,
			'paginate': properties.extra_page_builder_slider_paginate,
			'keyboard': properties.extra_page_builder_slider_keyboard,
			'speed': properties.extra_page_builder_slider_speed,
			'type': properties.extra_page_builder_slider_type
		});

		if (properties.extra_page_builder_slider_auto != false) {
			var $animation = $('<div class="extra-slider-auto-indicator"></div>').appendTo($this),
				autoAnimation = TweenMax.to($animation, properties.extra_page_builder_slider_auto, {width: '100%'});

			$this.on('pause.extra.slider', function() {
				autoAnimation.pause();
				$this.data('pause', 'pause')
			});
			$this.on('resume.extra.slider', function() {
				autoAnimation.resume();
				$this.data('pause', '')
			});
			$this.on('moveStart.extra.slider', function() {
				autoAnimation.restart();
				if ($this.data('pause') == 'pause') {
					autoAnimation.pause();
				}
			});
		}
	})
});