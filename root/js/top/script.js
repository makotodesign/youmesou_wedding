/*--------------------------------------------------------------

	top

	@memo

---------------------------------------------------------------*/

jQuery(function($) {
	const breakpoint = [600, 960];
	/* promo */
	const $promoWrap = $('.promo_wrap');
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
	}

	/***** util *****/

	/***** run *****/

	$(function() {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});
