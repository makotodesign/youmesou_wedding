/*--------------------------------------------------------------

	base

	@version 15.3.1

---------------------------------------------------------------*/

jQuery(function ($) {
	const breakpoint = [600, 960],
		$body = $('body'),
		$gnav = $('.gnav'),
		$pagetop = $('.pagetop'),
		frameSetting = {
			hws: {
				type: {
					sp: 'a',
					spyoko: 'c', // spモード & 横向き ※ 'c'推奨
					tb: 'a',
					pc: 'a'
				},
				opt: {
					sp: { adjust: 200 },
					spyoko: { adjust: 200 },
					tb: { adjust: 200 },
					pc: { adjust: 500 }
				}
			}
		};
	/***** func : main *****/

	function eventify() {}

	function changed(mode) {
		if (mode === 'sp') {
		} else if (mode === 'sp_tb') {
		} else if (mode === 'tb') {
		} else if (mode === 'tb_pc') {
		} else if (mode === 'pc') {
		} else if (mode === 'every') {
			// switchimg
			$('img[data-switchimg]').switchImg({ breakPoint: breakpoint });
			// gnav_submenu
			$('.submenu_wrap', $gnav).gnavSubmenu();
			$('.sscroll').sScroll();
		}
	}

	function setup() {
		/* structure ( oo_lib ) */
		$gnav.navCurrent();
		$('.sidenav').navCurrent({ gnav: false });
		$('a', $pagetop).sScroll({ top: true });
		$pagetop.pagetopDisplayAnimation();

		/* utility ( oo_lib ) */
		$body.hashLinkInPage();
		$('a[href$=".pdf"]').gaDownloadTrack();
		$('a[href$=".pdf"]').addTargetBlank();
		$('.tab_handle_set a').switchTab();
		$('.openclose_handle').openclose();
		$('.modal_handle').modal();
		$('.snap_sp').snapDots();
		$('.tooltip').tooltip();
		$('.sidenav_openclose_handle').openclose({
			target: '.sidenav_openclose_target',
			wrap: '.sidenav_openclose_wrap'
		});
		// inherit_teston
		$.oo.inherit_teston();
		// frame
		$.oo.frame(frameSetting);
		/* ie */
		// ie scroll ( oo_lib )
		$('body').removeSmoothScrollIE();
	}

	/***** util *****/

	/***** run *****/

	$(function () {
		eventify();
		$.oo.changed_run(changed, breakpoint);
		setup();
	});
});

/*------------------------------------------------
	load
------------------------------------------------*/

setTimeout(function () {
	$('#loading_wrap').fadeOut();
	$('body').css({ opacity: 100 });
}, 2000);
$(window).on('load', function () {
	/* load page */
	$('#loading_wrap').fadeOut();
	$('body').css({ opacity: 100 });
	$('.contaiiner').css({ paddingTop: $('.header_wrap').outerHeight() });
});
