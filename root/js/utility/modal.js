/*--------------------------------------------------------------

	top

	@memo

---------------------------------------------------------------*/

jQuery(function($) {
	var breakpoint = [600, 960];
	/* promo */
	var $promoWrap = $('.promo_wrap');
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
		/* ie */
		// object_fit
		//if (typeof objectFitImages == 'function') objectFitImages('.promo_pic img');
		/* modal */
		let winScrollTop;
		const $modal = $('#modal_overlay');
		$('.modal_handle').each(function() {
			$(this).on('click', function() {
				winScrollTop = $(window).scrollTop();
				$(this)
					.parent()
					.parent()
					.clone()
					.appendTo('.modal', $modal);
				$modal.fadeIn();
				return false;
			});
		});
		$('.modal_close', $modal).on('click', function() {
			$('.modal', $modal)
				.children()
				.detach();
			$modal.fadeOut();
			$('body,html')
				.stop()
				.animate({ scrollTop: winScrollTop }, 100);
			return false;
		});
	}

	/***** util *****/

	/***** run *****/

	$(function() {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});
