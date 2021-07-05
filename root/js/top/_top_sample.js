/*--------------------------------------------------------------

	top

	@memo

---------------------------------------------------------------*/

jQuery(function ($) {
	var breakpoint = [600, 960];
	var /* promo */ $promoWrap = $('#promo_wrap');
	/***** func : main *****/

	function eventify() {}

	function changed(mode) {
		if (mode === 'sp') {
		} else if (mode === 'sp_tb') {
		} else if (mode === 'tb') {
		} else if (mode === 'tb_pc') {
		} else if (mode === 'pc') {
		} else if (mode === 'every') {
		}
	}

	function setup() {
		/* promo */
		$promoWrap.cycle({
			fx: 'tileBlind', // fade, scrollHorz, tileSlide, tileBlind, flipHorz, flipVert
			slides: '> div.promo',
			wpeed: 1200,
			timeout: 6000
		});

		/* aos */
		AOS.init({
			easing: 'ease-in-out-sine'
		});
	}

	/***** func : promo cycle2 *****/

	$promoWrap.on('cycle-before cycle-initialized', function (e, opts) {
		$('.promo_cont:visible').find('.promo_catch').animate({ top: '50px', opacity: 0 }, 600);
		$('.promo_progress').stop(true).css('width', 0);
		setTimeout(function () {
			$('.promo_cont:visible').find('.promo_text').animate({ top: '50px', opacity: 0 }, 600);
		}, 300);
	});

	$promoWrap.on('cycle-after cycle-initialized', function (e, opts) {
		$('.promo_cont:visible').find('.promo_catch').animate({ top: '0', opacity: 1 }, 600);
		$('.promo_progress').animate({ width: '100%' }, opts.timeout, 'linear');
		setTimeout(function () {
			$('.promo_cont:visible').find('.promo_text').animate({ top: '0', opacity: 1 }, 600);
		}, 300);
	});

	/***** run *****/

	$(function () {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});
