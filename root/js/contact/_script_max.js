/*--------------------------------------------------------------

	contact ( max )

	@memo

---------------------------------------------------------------*/

jQuery(function ($) {
	var breakpoint = [600, 960],
		fromMode = 'none';
	/* form */
	var // form common
		thisFormName = 'sample_form',
		$thisForm = $('#' + thisFormName),
		// show_hide_input
		handleName = 'handle_xxx',
		// validate
		currentMode;

	/***** func : main *****/

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
		$('#' + thisFormName + '_zip').keyup(function () {
			AjaxZip3.zip2addr(this, '', 'form_address', 'form_address');
		});

		$('#' + thisFormName + '_zip02').keyup(function () {
			AjaxZip3.zip2addr('form_zip01', 'form_zip02', 'form_pref', 'form_address01');
		});
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
		// 非表示要素対応
		$.validator.setDefaults({ ignore: [] });
		$thisForm.validate({
			rules: {
				form_company: {
					required: '#contact_form_radio_user02:checked'
				},
				form_name: 'required',
				form_email: {
					required: true,
					email: true
				},
				form_email_confirm: {
					required: true,
					email: true,
					equalTo: 'input[name=email]'
				},
				form_message: 'required',
				form_zip: 'required',
				form_address: 'required',
				/*
					select は直接コードにrequired属性を記述しているのでここには記述不要
				*/
				form_aaa: {
					required: '#contact_form_aaa:visible',
					// バリデーション結果をサーバに問い合わせる【オブジェクト】
					remote: 'check-email.php',
					// メールアドレスの形式かどうか（xx@xx.xx）【Boolean】
					email: true,
					// URLの形式かどうか【Boolean】
					url: true,
					// 日付かどうか【Boolean】
					date: true,
					// ISO形式の日付かどうか【Boolean】
					dateISO: true,
					// 10進数かどうか【Boolean】
					number: true,
					// 整数の数値のみかどうか【Boolean】
					digits: true,
					// クレジットカード番号の形式かどうか【Boolean】
					creditcard: true,
					// 指定した値と一致しているか【セレクター】
					equalTo: 'input[name=mail]', // '.email'、'#email'などセレクター
					// 入力文字数・チェックボックスの選択数が設定値以下か【数値】
					maxlength: 4,
					// 入力文字数・チェックボックスの選択数が設定値以上か【数値】
					minlength: 4,
					// 入力文字数・チェックボックスの選択数が設定値の範囲内か【配列】
					rengelength: [2, 6],
					// 入力数値の値が設定値の範囲内か【配列】
					renge: [13, 23],
					// 入力数値の値が設定値の倍数か【数値】
					step: [13, 23],
					// 数値が設定値以下か【数値】
					max: 10,
					// 数値が設定値以上か【数値】
					min: 10
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
				form_email: {
					required: 'メールアドレスをご入力下さい',
					email: 'Eメール形式が正しくありません',
					equalTo: '上記メールアドレスと異なります'
				},
				form_message: {
					required: 'メッセージをご入力下さい（アドレスはご入力いただけません）'
				},
				form_zip: {
					required: '住所をご入力ください'
				},
				form_address: {
					required: '住所をご入力ください'
				},
				'form_kiyaku[]': {
					required: '規約に同意してください'
				}
			},
			/*
			// wpml で翻訳が必要な場合 inputラッパーにメッセージ記述
			//<p data-validatemessage="お名前をご入力下さい">
			//<p data-validatemessage="メールアドレスをご入力下さい" data-validatemessage="Eメール形式が正しくありません。">
			,messages : {
				'form_company'      : $( '#contact_form_company'  ).parent().data( 'validatemessage'  ),
				'form_name'         : $( '#contact_form_name'  ).parent().data( 'validatemessage'  ),
				'form_email'        : {
					'required'      : $( '#contact_form_email'  ).parent().data( 'validatemessage'  ),
					'email'         : $( '#contact_form_email'  ).parent().data( 'validateemail'  )
				}
			}
*/
			// validate_group
			groups: {
				form_address_gp: 'form_zip form_address'
			},
			errorPlacement: function (error, element) {
				if (currentMode === 'sp') {
					if (element.attr('name') == 'form_kiyaku[]') {
						error.insertAfter('#' + thisFormName + '_kiyaku_must');
					} else {
						error.insertAfter('#' + element.attr('id') + 'must');
					}
				} else {
					if (element.attr('name') === 'form_kiyaku[]') {
						error.insertAfter($('#' + element.attr('id')).parent());
					} else if (element.attr('name') === 'form_zip' || element.attr('name') === 'form_address') {
						error.insertAfter('#' + thisFormName + '_address');
					} else if (element.attr('name') === 'form_selectid') {
						error.insertAfter($('#' + element.attr('id')).parent());
					} else {
						error.insertAfter('#' + element.attr('id'));
					}
				}
			}
		});

		/* validate_kiyaku */
		$('button[type="submit"]', $thisForm).on('click', function () {
			if ($('#contact_form_kiyaku').prop('checked') === false) {
				$('#contact_form_kiyaku').parent().parent().after('<p id="kiyaku_error" class="error">規約に同意してください</p>').fadeIn();
				return false;
			}
		});
		$('#contact_form_kiyaku').on('change', function () {
			if ($('#contact_form_kiyaku').prop('checked') === true) {
				$('#kiyaku_error').detach();
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

	/***** util *****/

	/***** run *****/

	$(function () {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});
