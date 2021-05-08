/*==================================================================

	frame.js

	@author		oldoffice.com
	@since		2018-07-20
	@ver		12.4.1
	@package
		[ setting ]
		[ structure ]
		[ fn : hws ]         : header_wrap_scroll
		[ fn : gno ]         : gnav_open
		[ fn : util ]
		----
		[ load ]
	@memo
		2018-07-20           : transitionでの動作に切り替え[ 12.3.1 ]
		2018-08-19           : load処理をbase.jsに移動[ 12.3.2 ]
		2018-09-07           : gno.type.b修正[ 12.3.5 ]
		2018-09-07           : hwの動作をcssに移行 設定項目のシンプル化[ 12.4.1 ]

==================================================================*/

jQuery(function($) {
	/*------------------------------------------------

	[ setting ]

	hws : header_wrap のスクロールイベント
		type
			a：header_wrapを特定のY(adjust)クラス付与(header_wrap_change)
				opt
					hwInitHeight : [必須]初期のheader_wrap.outerHeight(true) * マージン含む
					adjust       : 変化するY header_wrap.height に加算分
			b：header_wrapが通常スクロールの後再表示 & クラス付与(header_wrap_change)
				opt
					hwInitHeight : [必須]初期のheader_wrap.outerHeight(true) * マージン含む
					adjust       : 変化するY header_wrap.height に加算分
			c：下にスクロールでheader_wrap非表示・上にスクロールで表示
				opt -
					hwInitHeight : [必須]初期のheader_wrap.outerHeight(true) * マージン含む
					adjust       : 変化するY header_wrap.height に加算分
			z：アクションなし
				opt -
			(sample)
				pc : { adjust : 100 }

------------------------------------------------*/

	var setting = {
		hws: {
			type: {
				sp: 'a',
				spyoko: 'c', // spモード & 横向き ※ 'c'推奨
				tb: 'a',
				pc: 'a'
			},
			opt: {
				sp: { hwInitHeight: 86, adjust: 200 },
				spyoko: { hwInitHeight: 126, adjust: 200 },
				tb: { hwInitHeight: 126, adjust: 200 },
				pc: { hwInitHeight: 166, adjust: 200 }
			}
		}
	};

	/*------------------------------------------------

	[ structure ]

------------------------------------------------*/

	var // dom base
		$window = $(window),
		$body = $('body'),
		$container = $('.container'),
		$hw = $('.header_wrap'),
		$gnav = $('.gnav', $hw),
		$gnavHandle = $('.gnav_btn', $hw),
		$wpadminbar = $('#wpadminbar'),
		// resize
		status = 'none', // sp( max600 ) / sp_yoko( min600&max960&yoko ) / tb( min600&max960 ) / pc( min960 )
		// hws : header_wrap_scroll
		hwsFlag = true, // hws実行フラグ
		hwsType, // hwsタイプ a / b / c
		hwsOpt = {}, // hwsオプション
		hwh, // .header_wrap.outerHeight()
		st, // scrollTop
		hwsOptHWIH, // hwsOpt header_wrap高さ初期値 * 必須
		hwsOptAdjs, // hwsOpt adjust
		// gno : gnav_open
		gnoFlag = true, // gno実行フラグ
		winlock, // windowLockフラグ
		tmpst; // winlock時のscrollTop

	/* --- main --- */
	function main() {
		// status変更時1回だけ実行
		if (window.matchMedia('(max-width:600px)').matches) {
			statusChange('sp');
		} else if (window.matchMedia('(max-width:960px)').matches && window.innerWidth > window.innerHeight) {
			statusChange('spyoko');
		} else if (window.matchMedia('(max-width:960px)').matches) {
			statusChange('tb');
		} else {
			statusChange('pc');
		}
	}

	/* sc : status_change */
	function statusChange(argStatus) {
		// status
		if (status !== argStatus) {
			status = argStatus;
			//console.log( 'status[ ' + status + ' ], argStatus[ ' + argStatus + ' ], hwsType[ ' + hwsType + ' ]' );
			// init : status変更時1回だけ実行
			settingParse(status);
			hwsInit();
			gnoInit();
		}
	}

	/* settingParse : status変更時1回だけ実行 */
	function settingParse(argStatus) {
		hwsType = setting.hws.type[argStatus];
		hwsOpt = setting.hws.opt[argStatus];
		// body と header_wrap にクラス付与
		wrapClass();
	}

	/* --- setup : readyで以下をscrollにバインド --- */
	function setup() {
		// core
		gnoCore();
		hwsCore();
	}

	/*------------------------------------------------

	[ fn : hws ]
	 header_wrap のスクロールイベント

------------------------------------------------*/

	/* hwsInit : status変更時1回だけ実行 */
	function hwsInit() {
		// hwsOpt
		hwsOptHWIH = 'hwInitHeight' in hwsOpt ? hwsOpt.hwInitHeight : 'error'; // hwh 初期値
		hwsOptAdjs = 'adjust' in hwsOpt ? hwsOpt.adjust : 100; // headerWrap 固定されるY座標
		hwsOptAdjs = hwsOptAdjs < 10 ? 10 : hwsOptAdjs; // 最小値を10px

		// hws_base
		st = $window.scrollTop();

		// ready状態ののheader_wrap.height 取得（* wpadminbar調整 & containerのpadding-top調整）
		if (hwsOptHWIH === 'error') {
			alert('必須hwh初期値が設定されていません！');
		} else {
			$hw.css({ marginTop: wpadminbarheight() });
			hwh = hwsOptHWIH + wpadminbarheight();
			$container.css({ paddingTop: hwsOptHWIH });
		}

		// 各タイプ初期値
		/* hws-a */
		if (hwsFlag && hwsType === 'a') {
			$hw.css({ position: 'fixed' });
			if (st < hwh + hwsOptAdjs) {
				$hw.removeClass('header_wrap_change');
			} else {
				$hw.addClass('header_wrap_change');
			}
			/* hws-b */
		} else if (hwsFlag && hwsType === 'b') {
			if (st < hwh) {
				$hw.removeClass('header_wrap_change').css({ top: 0, position: 'absolute' });
			} else if (st < hwh + hwsOptAdjs / 2) {
				$hw.addClass('header_wrap_change').css({ top: -1 * hwh, position: 'absolute' });
			} else if (st < hwh + hwsOptAdjs) {
				$hw.addClass('header_wrap_change');
				var tempHwh = $hw.outerHeight();
				$hw.css({ top: -1 * tempHwh, position: 'fixed' });
			} else {
				$hw.css({ top: 0, position: 'fixed' });
			}
			/* hws-c */
		} else if (hwsFlag && hwsType === 'c') {
			$hw.css({ position: 'fixed' });
			if (st < hwh + hwsOptAdjs) {
				$hw.removeClass('header_wrap_change');
			} else {
				$hw.addClass('header_wrap_change');
			}
		}
	}

	/* hwsCore : readyで以下をscrollにバインド */
	function hwsCore() {
		var before = $window.scrollTop();

		$window.on('scroll', function() {
			st = $(this).scrollTop();

			/* hws-a */
			if (hwsFlag && hwsType === 'a') {
				if (st < hwh + hwsOptAdjs) {
					$hw.removeClass('header_wrap_change');
				} else {
					$hw.addClass('header_wrap_change');
				}

				/* hws-b */
			} else if (hwsFlag && hwsType === 'b') {
				if (st < hwh) {
					$hw.css({ top: 0 });
				} else if (st < hwh + hwsOptAdjs / 2) {
					$hw.removeClass('header_wrap_change').css({ top: -1 * hwh, position: 'absolute' });
				} else if (st < hwh + hwsOptAdjs) {
					$hw.addClass('header_wrap_change');
					var tempHwh = $hw.outerHeight();
					$hw.css({ top: -1 * tempHwh, position: 'fixed' });
				} else {
					$hw.css({ top: 0 });
				}

				/* hws-c */
			} else if (hwsFlag && hwsType === 'c') {
				// down（ページが上に移動 scrollDown）
				if (st > before && st > hwh) {
					$hw.css({ top: -1 * hwh });
					// up（ページが下に移動 scrollUp）
				} else {
					$hw.css({ top: 0 });
				}
				if (st < hwh + hwsOptAdjs) {
					$hw.removeClass('header_wrap_change');
				} else {
					$hw.addClass('header_wrap_change');
				}
				before = st;
			}
		});
	}

	/*------------------------------------------------

	[ fn : gno ]
	gno : gnav のsp/tbでのオープンイベント

------------------------------------------------*/

	/* gnoInit : status変更時1回だけ実行 */
	function gnoInit() {
		if (status === 'pc') {
			$gnav
				.css({ top: '', paddingTop: '', marginLeft: '', width: '' })
				.show()
				.removeClass('open');
			$gnavHandle
				.removeClass('close')
				.addClass('menu')
				.hide();
			windowLock('off');
		} else {
			// gnav 開いた状態でstatus_change した場合
			var gnavy = $hw.outerHeight(true) + $hw.position().top;
			$gnav.css({ top: gnavy });
			if (winlock === false) {
				$gnav.removeClass('open');
				$gnavHandle
					.removeClass('close')
					.addClass('menu')
					.show();
			}
		}
	}

	/* gnoCore : readyで以下をscrollにバインド */
	function gnoCore() {
		$gnavHandle.on('click', function() {
			// gnav_open
			if ($gnavHandle.hasClass('menu')) {
				// hws再開
				hwsFlag = false;
				// gno
				gnoFlag = 'open';
				// gnav_close
			} else if ($gnavHandle.hasClass('close')) {
				// hws停止
				hwsFlag = true;
				// gno
				gnoFlag = 'close';
			}
			var gnavy = $hw.outerHeight(true) + $hw.position().top;
			if (gnoFlag === 'open') {
				$gnav.css({ top: gnavy }).addClass('open');
				$gnavHandle.removeClass('menu').addClass('close');
			} else {
				$gnav.css({ top: gnavy }).removeClass('open');
				$gnavHandle.removeClass('close').addClass('menu');
			}

			/* windowLock */
			if (gnoFlag === 'open') {
				// window_lock
				windowLock('on');
			} else {
				// window_lock
				windowLock('off');
			}
		});
	}

	/*------------------------------------------------

	[ fn : util ]
	利用関数

------------------------------------------------*/

	// wpadminbarの高さ
	function wpadminbarheight() {
		var h = typeof $wpadminbar.outerHeight() === 'undefined' ? 0 : $wpadminbar.outerHeight();
		return h;
	}

	// gnavオープン時の画面ロック
	function windowLock(arg) {
		if (arg === 'on') {
			tmpst = $window.scrollTop();
			$body.css({ position: 'fixed', width: '100%', top: -1 * tmpst });
			winlock = true;
		} else if (arg === 'off') {
			tmpst = tmpst === undefined ? 0 : tmpst;
			$body.css({ position: '', width: '', top: '' });
			if (winlock) {
				$window.scrollTop(tmpst);
			}
			winlock = false;
		}
	}

	// dom_wrap にクラス付与
	function wrapClass() {
		$body.removeClass('status_sp status_spyoko status_tb status_pc').addClass('status_' + status);
		$hw.removeClass('hws_type_a hws_type_b hws_type_c hws_type_o').addClass('hws_type_' + hwsType);
	}

	/*------------------------------------------------
	--- run ---
------------------------------------------------*/

	$(function() {
		$window.on('resize orientationchange', function() {
			main();
		});
		main();
		setup();
	});
});
