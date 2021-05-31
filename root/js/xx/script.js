/*--------------------------------------------------------------

	xx

---------------------------------------------------------------*/

jQuery(function ($) {
	const breakpoint = [600, 960];

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

	function setup() {}

	$(function () {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});
