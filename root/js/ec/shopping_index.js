/*--------------------------------------------------------------

	shopping_index

---------------------------------------------------------------*/

jQuery(function ($) {
	const $edit = $('.customer_edit'),
		$hidden = $('.customer_in'),
		$form = $('.customer_form');

	function eventify() {
		$('#customer_btn_disp_edit').click(function () {
			$edit.each(function (index) {
				let name = $(this).text();
				let input = $('<input id="edit' + index + '" type="text" />').val(name);
				$form.eq(index).empty().append(input);
			});
			$('#customer_disp').hide();
			$('#customer_edit').show();
		});
		$('#customer_btn_ok').click(function () {
			$form.each(function (index) {
				$hidden.eq(index).val($form.eq(index).children('input').val());
			});

			let $postData = {};
			$($hidden).each(function () {
				$postData[$(this).attr('name')] = $(this).val();
			});

			$.oo.loadingOverlay();

			$.ajax({
				url: PUBLICDIR + '/ec/shopping/customer',
				type: 'POST',
				data: $postData,
				dataType: 'json'
			})
				.done(function (data) {
					if (data.status == 'OK') {
						$form.each(function (index) {
							$edit.eq(index).empty().text($form.eq(index).children('input').val());
							$form.eq(index).empty();
						});

						// kana field
						$edit.eq(2).empty().text(data.kana01);
						$edit.eq(3).empty().text(data.kana02);
						$('#customer_kana01').val(data.kana01);
						$('#customer_kana02').val(data.kana02);
					}
				})
				.fail(function () {
					alert('更新に失敗しました。入力内容を確認してください。');
				})
				.always(function (data) {
					$.ooec.loadingOverlay('hide');
				});

			$('#customer_disp').show();
			$('#customer_edit').hide();
		});
		$('#customer_btn_cancel').click(function () {
			$('#customer_disp').show();
			$('#customer_edit').hide();
		});
	}

	function setup() {
		$('[data-trigger]').each(function () {
			$(this).on($(this).attr('data-trigger'), callback_Redirect);
		});
	}

	function callback_Redirect() {
		$.oo.loadingOverlay();
		$('#shopping_order_redirect_to').val($(this).attr('data-path'));
		$('#ec_shopping_index_form')
			.attr('action', PUBLICDIR + '/ec/shopping/redirect_to')
			.submit();
		setTimeout(function () {
			$.ooec.loadingOverlay('hide');
		}, 2000);
	}

	$(function () {
		eventify();
		setup();
	});
});
