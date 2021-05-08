/* csv */

(function($) {
	// var
	const $titleWrap = $('#titlediv'),
		$titleField = $('input#title'),
		csvYearField = '#acf-field-csv_year',
		csvMonthField = '#acf-field-csv_month';
	var selectedYear, selectedMonth;

	function init() {
		create();
		eventify();
		setup();
	}

	function create() {
		selectedYear = $(csvYearField).val() + '年';
		selectedMonth = $(csvMonthField).val() + '月';
	}

	function eventify() {
		$(document).on('change', csvYearField, function() {
			selectedYear = $(this).val() + '年';
			$titleField.val(selectedYear + selectedMonth);
		});
		$(document).on('change', csvMonthField, function() {
			selectedMonth = $(this).val() + '月';
			$titleField.val(selectedYear + selectedMonth);
		});
	}

	function setup() {
		$titleWrap.hide();
	}

	$(function() {
		init();
	});
})(jQuery);
