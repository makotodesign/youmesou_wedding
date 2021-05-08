/* news */
(function($) {
	// setting - titleReflection
	const acfName = '5b336723277e5';
	var acfTitleField = '#acf-field_' + acfName;

	function eventify() {
		// titleReflection
		$(document).on('change', acfTitleField, function() {
			$('input#title').val($(this).val());
		});
	}

	function setup() {
		// titleReflection
		$('#titlediv').hide();
	}

	$(function() {
		eventify();
		setup();
	});
})(jQuery);
