jQuery(document).ready(function ($) {
	$(".extra-slider").each(function () {
		var $this = $(this);


		$this.extraSlider({
			'auto': 5,
			'draggable': true,
			'navigate': false,
			'paginate': true,
			'keyboard': true,
			'speed': 1,
			'type': 'fade'
		});

		var $animation = $('<div class="extra-slider-auto-indicator"></div>').appendTo($this),
			autoAnimation = TweenMax.to($animation, 5, {width: '100%'});

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
	})
});