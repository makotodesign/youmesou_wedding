/*--------------------------------------------------------------

	xx

	@memo

---------------------------------------------------------------*/

jQuery(function($) {
	var breakpoint = [600, 960];
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
		var swiper = new Swiper('.swiper-container', {
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev'
			},
			loop: true,
			pagination: {
				el: '.swiper-pagination',
				type: 'bullets',
				clickable: true
			}
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
