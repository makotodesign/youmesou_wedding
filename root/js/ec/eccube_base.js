/*--------------------------------------------------------------

	eccube_base

---------------------------------------------------------------*/

jQuery(function ($) {
	function eventify() {
		/*
			.load_overlay クリックでオーバーレイ
		*/
		$('.load_overlay').on({
			click: function () {
				$.oo.loadingOverlay();
			},
			change: function () {
				$.oo.loadingOverlay();
			}
		});

		/*
			submit クリックでバリデート・オーバーレイ
		*/
		$(document).on('click', 'input[type="submit"], button[type="submit"]', function () {
			let valid = true,
				form = callback_getAncestorOfTagType(this, 'FORM');
			if (typeof form !== 'undefined' && !form.hasAttribute('novalidate')) {
				if (typeof form.checkValidity === 'function') {
					valid = form.checkValidity();
				}
			}
			if (valid) {
				$.oo.loadingOverlay();
			}
		});

		/*
			お気に入りの削除ボタンで使用
		*/
		$('a[token-for-anchor]').click(function (e) {
			let $this = $(this),
				data = $this.data();
			e.preventDefault();
			if (data.confirm != false) {
				if (!confirm(data.message ? data.message : '削除してよろしいですか？')) {
					return false;
				}
			}
			// 削除時
			$.oo.loadingOverlay();
			var $form = callback_createForm($this.attr('href'), {
				_token: $this.attr('token-for-anchor'),
				_method: data.method
			}).hide();
			$('body').append($form); // Firefox requires form to be on the page to allow submission
			$form.submit();
		});
	}

	function setup() {}

	function callback_getAncestorOfTagType(elem, type) {
		while (elem.parentNode && elem.tagName !== type) {
			elem = elem.parentNode;
		}
		return type === elem.tagName ? elem : undefined;
	}

	function callback_createForm(action, data) {
		var $form = $('<form class="del_form" action="' + action + '" method="post"></form>');
		for (input in data) {
			if (data.hasOwnProperty(input)) {
				$form.append('<input name="' + input + '" value="' + data[input] + '">');
			}
		}
		return $form;
	}

	$(function () {
		eventify();
		setup();
	});
});
