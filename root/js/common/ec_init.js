/*--------------------------------------------------------------

	ec_init

	@version

---------------------------------------------------------------*/

jQuery(function ($) {
	// top_nav
	const $topNavCartBtn = $('#topnav_ec_cart'),
		$topNavCartSet = $('#ecnav_cart_set');
	// cartin
	const $cartInBtn = $('button[data-ec_submit_role=add_cart]'),
		$cartForm = $('form[data-ec_form_role=add_cart]');
	let productsec_EcIdFirst;
	// modal
	const $overlay = $('#modal_overlay'),
		$modal = $('.modal', $overlay);
	let $modalBtn, $modalTarget, winScrollTop;
	// cartset
	const $ecnavCartSet = $('#ecnav_cart_set');

	function eventfy() {
		$cartInBtn.on('click', function (event) {
			event.preventDefault();
			$modalBtn = $(this);
			if ($(this).hasClass('off')) return;
			$(this)
				.siblings('form[data-ec_form_role=add_cart]')
				.each(function () {
					$.post(
						$(this).attr('action'),
						$(this).serialize(),
						function (data) {
							// modal
							winScrollTop = $(window).scrollTop();
							$modalTarget = $('#' + $modalBtn.data('target'));
							$modalTarget.clone().appendTo($modal);
							$overlay.fadeIn();
							$modalBtn.siblings('.to_cart_message_after_cart_in').show();
							cartsUpdate();
							return false;
							// 直接カート
							//location.href = PUBLICDIR + '/ec/';
						},
						'json'
					);
				});
		});
	}

	function setup() {
		// top_nav
		$('#topnav_ec_cart').on('click', function () {
			if ($topNavCartSet.is(':visible')) {
				$topNavCartSet.hide();
			} else {
				$topNavCartSet.slideDown(100);
			}
			return false;
		});
		$('.button.v_close', $topNavCartSet).on('click', function () {
			if ($topNavCartSet.is(':visible')) {
				$topNavCartSet.hide();
			}
			return false;
		});
		// cart button
		$cartInBtn.each(function () {
			$(this).addClass('off');
		});
		//wp→ec ajax setup
		if ($cartInBtn.length > 0) {
			$.ajaxSetup({
				headers: {
					'ECCUBE-CSRF-TOKEN': $('meta[name="eccube-csrf-token"]').attr('content')
				}
			});
		}
	}

	/* get_all_info */
	// token, logged_in, carts_total_quantity, carts_total_price, customer, favorites
	function ecGetAllInfo() {
		$.post(
			PUBLICDIR + '/ec/oo_ec_all_info',
			null,
			function (data) {
				// console.log('oo_ec_all_info');
				// console.log(data);
				if (data.token) {
					$('meta[name=eccube-csrf-token]').attr('content', data.token);
				}
				if (data.logged_in) {
					$('#topnav_ec_login').hide();
					$('#topnav_ec_register').hide();
					$('#topnav_ec_logout').fadeIn();
					$('#topnav_ec_mypage').fadeIn();
				} else {
					$('#topnav_ec_logout').hide();
					$('#topnav_ec_mypage').hide();
					$('#topnav_ec_login').fadeIn();
					$('#topnav_ec_register').fadeIn();
				}
				// console.log($ecnavCartSet.data('status'));
				if (data.carts.total_quantity > 0) {
					$topNavCartBtn.removeClass('off').addClass('on');
					$('#carts_total_quantity').text(data.carts.total_quantity);
					if ($ecnavCartSet.data('status') === 'ready') {
						$('.message_no_cart', $ecnavCartSet).addClass('v_hide');
						$('.button.v_cart', $ecnavCartSet).removeClass('v_hide');
						createCartSet(data.carts.items);
					}
				} else {
					$topNavCartBtn.removeClass('on').addClass('off');
					$('#carts_total_quantity').text(0);
					if ($ecnavCartSet.data('status') === 'ready') {
						$('.message_no_cart', $ecnavCartSet).removeClass('v_hide');
						$('.button.v_cart', $ecnavCartSet).addClass('v_hide');
					}
				}
				ecDataToSession(data);
			},
			'json'
		);
	}

	function ecGgetCartToken() {
		// cart form : _token *一つ目の商品でtoken 取得
		productsec_EcIdFirst = $cartForm.eq(0).find('input[name=product_id]').val();
		if (productsec_EcIdFirst) {
			$.get(
				PUBLICDIR + '/ec/oo_ec_cart_token/' + productsec_EcIdFirst,
				null,
				function (data) {
					// console.log('oo_ec_cart_token');
					// console.log(data);
					$cartForm.find('input[name=_token]').val(data.cart_token);
					// cart button
					$cartInBtn.each(function () {
						$(this).removeClass('off');
					});
				},
				'json'
			);
		}
	}

	function cartsUpdate() {
		let tag;
		$.post(
			PUBLICDIR + '/ec/oo_ec_carts',
			'',
			function (data) {
				// topnav_ec_cart
				$('#topnav_ec_cart').removeClass('off').addClass('on');
				$('#carts_total_quantity').text(data.carts.total_quantity);
				// ecnav_cart_set
				$('.message_no_cart', $ecnavCartSet).addClass('v_hide');
				$('.button.v_cart', $ecnavCartSet).removeClass('v_hide');
				// console.log('carts_update');
				// console.log(data.carts.items);
				createCartSet(data.carts.items);
				ecDataToSession(data);
			},
			'json'
		);
	}

	function createCartSet(cartsItems) {
		let tag = '';
		$.each(cartsItems, function () {
			tag += '<div class="image_texts cart_item">';
			tag += '<div class="image_item">';
			tag += '<p class="object_fit"><img src="' + this.pic + '" alt="' + this.name + '"></p>';
			tag += '</div>';
			tag += '<div class="texts_item">';
			tag += '<p><span class="cart_item_name">' + this.name + '</span></p>';
			if (this.class01 && this.class02) {
				tag += '<span class="cart_item_class">' + this.class01 + '<br>' + this.class02 + '</span>';
			} else if (this.class01 || this.class02) {
				tag += '<span class="cart_item_class">' + this.class01 + this.class02 + '</span>';
			}
			tag += '<p><span class="cart_item_price">￥' + this.price + '</span><span class="cart_item_taxword"> 税込</span></p>';
			tag += '<p><span class="cart_item_quantity">数量：</span> <span class="cart_item_quantity_num">' + this.quantity + '</span></p>';
			tag += '</div>';
			tag += '</div>';
		});
		$('.cart_items', $ecnavCartSet).html(tag);
	}

	function ecDataToSession(inheritJson) {
		$.post(PUBLICDIR + '/mod/wpec/ec_data_to_session_ajax_mod.php', inheritJson);
	}

	$(function () {
		eventfy();
		setup();
		ecGetAllInfo();
		ecGgetCartToken();
	});
});
