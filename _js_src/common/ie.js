/*--------------------------------------------------------------

	base

	@version 14.3.1

---------------------------------------------------------------*/

jQuery(function($) {
	var breakpoint = [600, 960];
	/***** func : main *****/

	function eventify() {}

	function setup() {
		/* ie */
		// ie scroll ( oo_lib )
		$('body').removeSmoothScrollIE();
	}

	/***** util *****/

	/***** run *****/

	$(function() {
		eventify();
		setup();
	});
});
