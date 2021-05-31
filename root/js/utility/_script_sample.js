/*--------------------------------------------------------------

	xx

	@memo

---------------------------------------------------------------*/

jQuery(function ($) {
	const breakpoint = [600, 960];
	let cw = window.innerWidth, // current_window_width
		fromMode = 'none',
		currentMode;

	/***** func : main *****/

	function eventify() {}

	function changed(mode) {
		if (mode === 'sp') {
			// slick_sp
			$('.slick_sp:not( .slick-initialized )').slick({
				arrows: false,
				dots: true
			});
			/* slickxxx */
			$('.slick_xxx').slick({
				autoplay: true,
				autoplaySpeed: 5000,
				arrows: true,
				dots: true,
				slidesToShow: 1,
				centerMode: true,
				centerPadding: '20%',
				focusOnSelect: true,
				adaptiveHeight: true // innerの高さにより調整
			});
			// clm
			$('.clm2_sp').mbCut({ colNum: 2 });
			$('.clm3_sp').mbCut({ colNum: 3 });
			$('.clm4_sp').mbCut({ colNum: 4 });
			$('.clm5_sp').mbCut({ colNum: 5 });
		} else if (mode === 'sp_tb') {
			// sp_tb で切り替えしない場合
			/* dom_move */
			$('.heading_xxx').each(function () {
				$(this).prependTo($(this).parents('.box'));
			});
			// dom移動
			$('.topnav_list').prependTo('.gnav');
			$('.header_topnav_wrap').detach();
		} else if (mode === 'tb') {
			// slick_sp
			$('.slick_sp.slick-initialized').slick('unslick');
			/* slickxxx */
			$('.slick_xxx').slick({
				autoplay: true,
				autoplaySpeed: 5000,
				arrows: true,
				dots: true,
				slidesToShow: 2,
				centerMode: true,
				centerPadding: '20%',
				focusOnSelect: true,
				adaptiveHeight: true // innerの高さにより調整
			});
			// clm
			$('.clm2_tb').mbCut({ colNum: 2 });
			$('.clm3_tb').mbCut({ colNum: 3 });
			$('.clm4_tb').mbCut({ colNum: 4 });
			$('.clm5_tb').mbCut({ colNum: 5 });
		} else if (mode === 'tb_pc') {
			// tb_pc で切り替えしない場合
		} else if (mode === 'pc') {
			/* dom_move */
			$('.heading_xxx').each(function () {
				$(this).prependTo($(this).parents('.box').find('.texts_cont'));
			});
			// dom移動
			$('.topnav_list').prependTo('.header_wrap').wrap($('<div class="header_topnav_wrap"/>')).wrap($('<nav class="header_topnav"/>'));
			/* slickxxx */
			$('.slick_xxx').slick('unslick');
			// clm
			$('.clm2_pc').mbCut({ colNum: 2 });
			$('.clm3_pc').mbCut({ colNum: 3 });
			$('.clm4_pc').mbCut({ colNum: 4 });
			$('.clm5_pc').mbCut({ colNum: 5 });
		} else if (mode === 'every') {
			/* every */
		}
	}

	function setup() {
		/* 個別オープンクローズ */
		$('.xxx_openclose_handle').openClose({
			target: '.xxx_openclose_target',
			wrap: '.xxx_openclose_wrap',
			textChange: false
		});

		/* colorbox */
		$('.classname').colorbox();

		/* bigtarget */
		$('.bt:has( a )').bigTarget({ hoverClass: 'bt_hover' });

		// gallery
		$('#selector a').on('click', function () {
			var imgSrc = $(this).children('img').attr('src');
			$('#selector a.current').removeClass('current');
			$(this).addClass('current');
			$('#target img').attr('src', imgSrc);
			return false;
		});

		/* sclick_yyy */
		$('.sclick_yyy').slick({
			autoplay: true,
			autoplaySpeed: 5000,
			arrows: true,
			dots: true,
			slidesToShow: 1,
			centerMode: true,
			centerPadding: '20%',
			focusOnSelect: true,
			adaptiveHeight: true, // innerの高さにより調整
			mobileFirst: true,
			responsive: [
				{
					breakpoint: 600,
					settings: {
						slidesToShow: 2
					}
				},
				{
					breakpoint: 960,
					settings: {
						slidesToShow: 3
					}
				}
			]
		});
	}

	function resized() {
		// リサイズされる度に実行される
	}

	/***** util *****/

	/***** run *****/

	$(function () {
		eventify();
		$(window).on('resize orientationchange', function () {
			if (cw === window.innerWidth) return;
			resized();
			cw = window.innerWidth;
		});
		$.oo.changed_run(changed, breakpoint); // oo_lib
		resized();
		setup();
	});
});

/*------------------------------------------------
	load
------------------------------------------------*/

$(window).on('load', function () {
	/* aos */
	AOS.init({
		easing: 'ease-in-out-sine'
	});
});
