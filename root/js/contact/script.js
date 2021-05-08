/*--------------------------------------------------------------

	contact

	@memo

---------------------------------------------------------------*/

jQuery(function ($) {
	const breakpoint = [600, 960];
	let currentMode = 'none';
	/* form */
	const thisFormName = 'contact_form',
		$thisForm = $('#' + thisFormName),
		// show_hide_input
		handleName = 'handle_user';

	function eventify() {
		/* show_hide_input */
		$('.' + handleName + '_01', $thisForm).on('click', function () {
			$('[data-target="' + handleName + '_02"]', $thisForm).hide();
			$('[data-target="' + handleName + '_01"]', $thisForm).fadeIn(300);
			$('#' + thisFormName + '_' + handleName).val(handleName + '_01');
		});
		$('.' + handleName + '_02', $thisForm).on('click', function () {
			$('[data-target="' + handleName + '_01"]', $thisForm).hide();
			$('[data-target="' + handleName + '_02"]', $thisForm).fadeIn(300);
			$('#' + thisFormName + '_' + handleName).val(handleName + '_02');
		});

		/* ajaxzip3 */
		// $('#' + thisFormName + '_zip').keyup(function () {
		// 	AjaxZip3.zip2addr(this, '', 'form_address', 'form_address');
		// });
	}

	function changed(mode) {
		if (mode === 'sp') {
			currentMode = 'sp';
		} else if (mode === 'sp_tb') {
		} else if (mode === 'tb') {
		} else if (mode === 'tb_pc') {
			currentMode = 'tb_pc';
		} else if (mode === 'pc') {
		} else if (mode === 'every') {
		}
	}

	function setup() {
		/* validate */
		$.validator.setDefaults({ ignore: [] });
		$thisForm.validate({
			rules: {
				form_company: {
					required: function () {
						return $('#contact_form_user01').is(':checked');
					}
				},
				form_name: {
					required: true
				},
				form_email: {
					required: true,
					email: true
				},
				form_selectid: {
					required: true
				},
				// form_zip: {
				// 	required: true
				// },
				// form_address: {
				// 	required: true
				// },
				'form_kiyaku[]': {
					required: true
				}
			},
			messages: {
				form_company: {
					required: '会社名をご入力下さい'
				},
				form_name: {
					required: 'お名前をご入力下さい'
				},
				form_email: {
					required: 'メールアドレスをご入力下さい',
					email: 'Eメール形式が正しくありません'
				},
				form_selectid: {
					required: 'セレクトが選択されていません'
				},
				// form_zip: {
				// 	required: '住所をご入力ください'
				// },
				// form_address: {
				// 	required: '住所をご入力ください'
				// },
				'form_kiyaku[]': {
					required: '規約に同意してください'
				}
			},
			// groups: {
			// 	form_address_gp: 'form_zip form_address'
			// },
			errorPlacement: function (error, element) {
				if (element.attr('name') === 'form_kiyaku[]') {
					if (currentMode === 'sp') {
						error.insertAfter('#' + thisFormName + '_kiyaku_must');
					} else {
						error.insertAfter($('#' + element.attr('id')).parent());
					}
				} else if (currentMode === 'sp') {
					error.insertAfter('#' + element.attr('id') + '_must');
				} else if (element.prop('tagName') === 'SELECT') {
					error.insertAfter($('#' + element.attr('id')).parent());
				} else if (element.attr('name') === 'form_zip' || element.attr('name') === 'form_address') {
					error.insertAfter('#' + thisFormName + '_address');
				} else {
					error.insertAfter('#' + element.attr('id'));
				}
			}
		});

		/* show_hide_input */
		// for session_adjust
		if ($('.' + handleName + '_01 input', $thisForm).prop('checked')) {
			$('[data-target="' + handleName + '_01"]', $thisForm).show();
			$('[data-target="' + handleName + '_02"]', $thisForm).hide();
		} else {
			$('[data-target="' + handleName + '_01"]', $thisForm).hide();
			$('[data-target="' + handleName + '_02"]', $thisForm).show();
		}
	}

	$(function () {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});
