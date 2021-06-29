/*===============================================

	oo_lib

	@author		oldoffice.com
	@since		12-04-19
	@ver		each plugin
	@package
		[ plugin ]
		* structure
			fn.navCurrent              : navのcurrent
			fn.imgRolloverCurrent      : 画像のhover時のロールオーバー＆カレント処理
			fn.gnavSubmenu             : gnav submenu 表示エフェクト
			fn.containerMinHeight      : container min-height 固定-最下部( コンテンツ量が少ない時 )
			fn.footerFixed             : footer 固定-最下部( コンテンツ量が少ない時 )
			fn.pagetopDisplayAnimation : pagetop 表示エフェクト
		* contents layout
			fn.modal                   : モーダルコンテンツ
			fn.openclose               : 開閉式コンテンツ
			fn.switchTab               : タブコンテンツ
		* utility
			fn.switchImg               : レスポンシブ画像変換
			fn.snapDots                : snap_sp ドット位置
			fn.bigTarget               : ビッグターゲット [ bt ]
			fn.tooltip                 : ツールチップ [ tooltip ]
			fn.sScroll                 : スムーススクロール [ scroll ]
			fn.hashLinkInPage          : ページ遷移時の#（ハッシュ）リンク
			fn.mbCut                   : clm*n 右端最下段マージンカット [ mbcut ]
			fn.containBlock            : ブロック要素の縦横比を親要素にあわせて維持
			fn.gaDownloadTrack         : ファイルダウンロード解析（Google Analytics用）
			fn.addTargetBlank          : target="_blank"の自動付与
			fn.removeSmoothScrollIE    : IEのスムーズスクロール機能解除
		[ global ]
			changed_run                : メディアクエリにchangedを関連付け
			inherit_teston             : test_onの継承
			add_publicdir              : publicdir自動付与(210113停止)
			get_param                  : 引数keyに対応するパラメータ取得
			wpadminbarHeight           : WordPress Adminbarの高さ取得
		[ frame ]
			frame                      : ヘッダーのスクロールによる動作
	@history
		2019-06-08                     : 各pluginに記述
		2019-11-04                     : footerFixed撤廃
		                                 global > changed_run 追加
		2020-04-18                     : ie不具合の解消 function arg default
		2020-04-25                     : modal 追加

===============================================*/

jQuery(function ($) {
	/*==============================================================================================
		plugin
	==============================================================================================*/

	/*------------------------------------
		[ navCurrent ]
		navのカレント処理
		@ver		16.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2020-04-19		: 使用クラス名を削減 [ 16.1.1 ]

		* 相対リンクには無効
		* homeリンクへは data-gnav="home"
		* 適用したくない時は data-navcurrent="false"
		* サブメニューは li li a の形式

		> 使用方法
		$( '.gnav' ).navCurrent( {
			submenuCurrent        : true, // submenuへのcurrent付与
			ganv                  : true  // gnavに使用する場合
			submenuWrapClass      : 'submenu_wrap'
		} );
	------------------------------------*/

	jQuery.fn.navCurrent = function (config) {
		let opt = jQuery.extend(
			{
				ganv: true,
				submenuCurrent: true,
				submenuWrapClass: 'submenu_wrap'
			},
			config
		);

		/* gnav内リンク配列 */
		let $links = [],
			$navWap = $(this);
		// gnav home抽出
		let $navHome = $navWap.find('a[data-gnav="home"]').not('a[data-navcurrent="false"]');
		if ($navHome.length > 0) {
			$links.push({
				dom: $navHome,
				link: removeDomain($navHome.attr('href')),
				home: true,
				sub: []
			});
		}
		// home,false,subnavi以外抽出
		let $tempArr = [];
		$navWap
			.find('a')
			.not('a[data-gnav="home"], a[data-navcurrent="false"], li li a')
			.each(function () {
				let $link = {};
				if ($(this).attr('href') !== undefined) {
					$link.dom = $(this);
					$link.link = removeDomain($(this).attr('href'));
					$link.home = false;
					$link.sub = [];
					if ($(this).parent().hasClass(opt.submenuWrapClass)) {
						$(this)
							.next()
							.find('a')
							.each(function () {
								$link.sub.push($(this));
							});
						// hrefを文字列の長い順にsort *長いものは短いものを含む
						$link.sub.sort(function (a, b) {
							return removeDomain(b.attr('href')).length - removeDomain(a.attr('href')).length;
						});
					}
					$tempArr.push($link);
				}
			});
		// hrefを文字列の長い順にsort *長いものは短いものを含む
		$tempArr.sort(function (a, b) {
			return b.link.length - a.link.length;
		});
		$.merge($links, $tempArr);

		/* match判定 */
		let currentHref = removeDomain(location.href);
		let run = true;
		// gnav home判定
		if (run) {
			labelAll: for (let i = 0; i < $links.length; i++) {
				if ($links[i].home) {
					if (checkFixed(currentHref, $links[i].link)) {
						$links[i].dom.addClass('current');
						run = false;
						break labelAll;
					}
				}
			}
		}
		// submenu完全一致のみ判定
		if (run && opt.ganv) {
			labelAll: for (i = 0; i < $links.length; i++) {
				if (!$links[i].home && $links[i].sub.length > 0) {
					for (let j = 0; j < $links[i].sub.length; j++) {
						if (checkFixed(currentHref, removeDomain($links[i].sub[j].attr('href')))) {
							$links[i].dom.addClass('current');
							if (opt.submenuCurrent) $links[i].sub[j].addClass('current');
							run = false;
							break labelAll;
						}
					}
				}
			}
		}
		// submenu前方一致判定
		if (run && opt.ganv) {
			labelAll: for (i = 0; i < $links.length; i++) {
				if (!$links[i].home && $links[i].sub.length > 0) {
					for (j = 0; j < $links[i].sub.length; j++) {
						if (checkPreFixed(currentHref, removeDomain($links[i].sub[j].attr('href')))) {
							$links[i].dom.addClass('current');
							if (opt.submenuCurrent) $links[i].sub[j].addClass('current');
							run = false;
							break labelAll;
						}
					}
				}
			}
		}
		// nav完全一致判定
		if (run) {
			labelAll: for (i = 0; i < $links.length; i++) {
				if (!$links[i].home && checkFixed(currentHref, removeDomain($links[i].link))) {
					$links[i].dom.addClass('current');
					run = false;
					break labelAll;
				}
			}
		}
		// nav前方一致判定
		if (run && opt.ganv) {
			labelAll: for (i = 0; i < $links.length; i++) {
				if (!$links[i].home && checkPreFixed(currentHref, removeDomain($links[i].link))) {
					$links[i].dom.addClass('current');
					run = false;
					break labelAll;
				}
			}
		}
		/* utility */
		// gnav リンクを正規化した上で配列生成（homeリンク除く）
		function removeDomain(href) {
			if (href === undefined) {
				//console.log( href );
				return;
			}
			let m = href.match(/^(http)*s*:?\/\/[a-zA-Z0-9-.]+(.*)$/);
			if (m) {
				return m[2] === '' ? '/' : m[2];
			} else {
				return href;
			}
		}
		// 前方一致
		function checkPreFixed(string, pattern) {
			if (string.indexOf(pattern) === 0) {
				return true;
			} else {
				return false;
			}
		}
		// 完全一致
		function checkFixed(string, pattern) {
			if (string === pattern) {
				return true;
			} else {
				return false;
			}
		}
		return this;
	};

	/*------------------------------------
		[ imgRolloverCurrent ]
		ロールオーバー＆カレント処理
		@ver		14.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]

		> 使用方法
		$( 'a img' )( {
			current   : false, // current時のimg変更
			postFixRo : '_f2',
			postFixCr : '_f3'
		} );
	------------------------------------*/

	jQuery.fn.imgRolloverCurrent = function (config) {
		let opt = jQuery.extend(
			{
				current: false,
				postFixRo: '_f2',
				postFixCr: '_f3'
			},
			config
		);

		let $img = $(this);
		if ($(this).parent('a').hasClass('current') && $(this).hasClass('ro') && opt.current) {
			$img[0].originalSrc = $img.attr('src');
			$img[0].currentSrc = $img[0].originalSrc.replace(new RegExp('(' + opt.postFixCr + ')?(.gif|.jpg|.png|.svg)$'), opt.postFixCr + '$2');
			$img.attr('src', $img[0].currentSrc);
		} else if ($(this).hasClass('ro')) {
			$img[0].originalSrc = $img.attr('src');
			$img[0].currentSrc = $img[0].originalSrc.replace(new RegExp('(' + opt.postFixRo + ')?(.gif|.jpg|.png|.svg)$'), opt.postFixRo + '$2');
			$(this).hover(
				function () {
					$img.attr('src', $img[0].currentSrc).css({ opacity: 1 });
				},
				function () {
					$img.attr('src', $img[0].originalSrc);
				}
			);
		}
		return this;
	};

	/*------------------------------------
		[ gnavSubmenu ]
		グローバルナビサブメニュー
		@ver		16.2.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-06-08		: pc版で動作しない設定値追加 [ 14.2.1 ]
					2019-06-08		: not:animatedを削除 [ 14.2.1 ]
					2020-04-18		: 再記述 [ 16.1.1 ]
					2020-05-18		: 不審な挙動を解決 [ 16.2.1 ]

		use
		$.oo.frame   : body class を利用

		> 設定詳細
		run          :( 略可 ) on off 切り替え 'on'(def) || 'off'
		responsive   :( 略可 ) 使用状態 'all'(def) || '_sp' || '_tb' || 'tb' || 'tb_' || 'pc_'
		handle       :( 略可 ) handle (def : 最初の a)
		target       :( 略可 ) target (def : a の次の要素)
		pcHandleLink :( 略可 ) pcの場合trueでリンク機能付与 true || false(def)

		> 設定方法
		$( '.submenu_wrap' ).gnavSubmenu();
	------------------------------------*/

	jQuery.fn.gnavSubmenu = function (config) {
		let opt = jQuery.extend(
			{
				run: 'on',
				responsive: 'all',
				handle: '> a:first-of-type',
				target: '> a:first-of-type + *',
				pcHandleLink: false
			},
			config
		);

		const $body = $('body');

		$(this).each(function () {
			let $wrapper = $(this),
				$handle = $(this).find(opt.handle),
				$target = $(this).find(opt.target);
			$handle.removeClass('minus').addClass('plus');
			$target.hide();
			$wrapper.off('mouseenter.gnavSubmenu mouseleave.gnavSubmenu');
			if (opt.run === 'on') {
				$wrapper
					.on('mouseenter.gnavSubmenu', function (e) {
						if ($body.hasClass('status_pc') && $target.is(':hidden')) {
							$handle.removeClass('plus').addClass('minus');
							$target.slideDown(200);
						}
					})
					.on('mouseleave.gnavSubmenu', function (e) {
						if ($body.hasClass('status_pc') && $target.is(':visible')) {
							$handle.removeClass('minus').addClass('plus');
							$target.slideUp(200);
						}
					});
				$handle.off('click.gnavSubmenu').on('click.gnavSubmenu', function (e) {
					if ($target.is(':hidden')) {
						$handle.removeClass('plus').addClass('minus');
						$target.slideDown(200);
					} else {
						$handle.removeClass('minus').addClass('plus');
						$target.slideUp(200);
					}
					if (!opt.pcHandleLink || !$body.hasClass('status_pc')) {
						return false;
					}
				});
			}
		});
		return this;
	};

	/*------------------------------------
		[ pagetopDisplayAnimation ]
		pagetopの表示エフェクト
		@ver		14.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2017-04-26 N 位置バグ修正
					2017-05-10 N Firefox非同期パンに対応

		> 設定詳細
		****

		> 設定方法
		$( '.pagetop' ).pagetopDisplayAnimation();
	------------------------------------*/

	jQuery.fn.pagetopDisplayAnimation = function () {
		let showFlag = false;
		let $self = $(this);
		$self.css('opacity', '0.0');
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				if (showFlag == false) {
					showFlag = true;
					$self.stop().animate({ opacity: '1.0' }, 200);
				}
			} else {
				if (showFlag) {
					showFlag = false;
					$self.stop().animate({ opacity: '0.0' }, 200);
				}
			}
		});
		return this;
	};

	/*------------------------------------
		[ modal ]
		モーダル
		@ver		18.1.1
		@history	2020-04-25		: 新規作成 [ 16.1.1 ]
		@history	2021-05-16		: 特設モーダルのdetachをパラメータ化 [ 18.1.1 ]

		> 設定詳細
		target        : クローンしてオーバーレイに入れるdom（data('target')）上書き
		overlay       : modalオーバーレイid
		closeBtn      : オーバーレイ内のcloseボタンclass,
		detach        : モーダルの中をCloseで消去

		> 設定方法
		<a data-target="xxx" class="modal_handole">モダールオープン</a>
		$( '.modal_handole' ).modal( { overlay: '.modal_overlay', closeBtnClass: '.modal_close', } );
------------------------------------*/

	jQuery.fn.modal = function (config) {
		let opt = jQuery.extend(
			{
				overlay: '#modal_overlay',
				modal: '.modal',
				closeBtn: '.modal_close, .modal_bg,[data-role=modal_close]',
				detach: true
			},
			config
		);
		const $overlay = $(opt.overlay),
			$modal = $(opt.modal, $overlay);
		let $target, winScrollTop;

		$(this).each(function () {
			$(this).on('click', function () {
				winScrollTop = $(window).scrollTop();
				if (opt.detach) {
					$target = $('#' + $(this).data('target'));
					$target.clone().appendTo($modal);
				}
				$overlay.fadeIn();
				return false;
			});
		});
		$(document).on('click', opt.closeBtn, function () {
			if (opt.detach) {
				$modal.children().detach();
			}
			$overlay.fadeOut();
			$('body,html').stop().animate({ scrollTop: winScrollTop }, 100);
			return false;
		});
		return this;
	};

	/*------------------------------------
		[ openclose ]
		開閉リスト
		@ver		16.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-06-13		: off機能の追加 [ 14.2.1 ]
					2019-06-13		: data-taget の開閉に切り替え [ 16.1.1 ]

		> 設定詳細
		textChange : 開閉時テキスト変更
		textClose  : textChange=true ：閉じる文字
		textOpen   : textChange=true ：開く文字
		speed      : 開閉するスピード（ミリ秒）
		def        : 標準の開閉 ※ handleにplus minus を記述するとそちらが優先されます。
		off        : 全機能解除（レスポンシブ用）

		> 設定方法
		$( '.openclose_handle' ).openclose( { textChange: true, textClose: '.閉じる', textOpen: '.さらに表示' } );
------------------------------------*/

	jQuery.fn.openclose = function (config) {
		let opt = jQuery.extend(
			{
				textChange: false,
				textClose: 'CLOSE',
				textOpen: 'MORE',
				speed: 300,
				def: 'hide',
				off: false
			},
			config
		);

		let $self, $target;

		$(this).each(function () {
			$self = $(this);
			if ($(this).data('target')) {
				$target = $('#' + $(this).data('target'));
			} else {
				$target = $(this).next();
			}
			if (opt.off) {
				$target.show();
			} else if ($self.hasClass('plus')) {
				if (opt.textChange) {
					$self.text(opt.textOpen);
				}
				$target.hide();
			} else if ($self.hasClass('minus')) {
				if (opt.textChange) {
					$self.text(opt.textClose);
				}
				$target.show();
			} else if (opt.def == 'hide') {
				$self.addClass('plus').removeClass('minus');
				if (opt.textChange) {
					$self.text(opt.textOpen);
				}
				$target.hide();
			} else if (opt.def == 'show') {
				$self.addClass('minus').removeClass('plus');
				if (opt.textChange) {
					$self.text(opt.textClose);
				}
				$target.show();
			} else {
				$target.show();
			}
		});
		if (opt.off) {
			$(this).off('click.openclose');
		} else {
			$(this).on('click.openclose', function () {
				$self = $(this);
				if ($(this).data('target')) {
					$target = $('#' + $(this).data('target'));
				} else {
					$target = $(this).next();
				}
				//console.log('$target.attr(id)' + ' = ' + $target.attr('id'));

				if ($target.is(':hidden')) {
					$target.slideDown(opt.speed);
					$self.addClass('minus').removeClass('plus');
					if (opt.textChange) {
						$(this).text(opt.textClose);
					}
				} else {
					$target.slideUp(opt.speed);
					$self.addClass('plus').removeClass('minus');
					if (opt.textChange) {
						$(this).text(opt.textOpen);
					}
				}
			});
		}
		return this;
	};

	/*------------------------------------
		[ switchTab ]
		開閉リスト
		@ver		14.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-07-05		: タブの機能を再記述 [ 14.2.1 ]

		> 設定詳細
		target : クリックで開閉する要素のwrap
		wrap   : クリック対象となる要素
		speed  : 開閉するスピード（ミリ秒）

		> 設定方法
		$( '.tab_handle_set a' ).switchTab( { target: '.tab_target_set', wrap: '.tab_wrap' } );
	------------------------------------*/

	jQuery.fn.switchTab = function (config) {
		let opt = jQuery.extend(
			{
				target: '.tab_target',
				wrap: '.tab_wrap',
				speed: 300
			},
			config
		);

		let $target = $(this).closest(opt.wrap).find(opt.target);
		$target.hide().first().show();
		$(this).click(function () {
			if ($(this).hasClass('current')) return false;
			$target.hide().eq($(this).index()).fadeIn(opt.speed);
			$(this).addClass('current').siblings().removeClass('current');
			return false;
		});
		return this;
	};

	/*------------------------------------
		[ switchImg ]
		レスポンシブ画像変換
		@ver		16.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-09-27		: svg切り替えに対応 [ 14.1.2 ]
					2020-06-13		: spyoko 指定がない場合はPC画像に変更 [ 16.1.1 ]

		> 設定詳細
		classes : 付ける属性名

		> 設定方法
		$( 'img[data-switchimg]' ).switchImg();
	------------------------------------*/

	jQuery.fn.switchImg = function (config) {
		let opt = jQuery.extend(
			{
				breakPoint: [600, 960]
			},
			config
		);

		$(this).each(function () {
			let fnames = $(this).data('switchimg').split(',');
			let fnameSp, fnameTb, fnamePc, fnameSpyoko, fnameFrom, srcTo;
			fnameSp = fnames[0] ? fnames[0] : '';
			fnameTb = fnames[1] ? fnames[1] : '';
			fnamePc = fnames[2] ? fnames[2] : fnameTb;
			fnameSpyoko = fnames[3] ? fnames[3] : fnameTb;
			fnameFrom = $(this).attr('src');
			fnameFrom = fnameFrom.match(/[_0-9a-zA-Z-]+\.(jpg|png|gif|jpeg|JPG|svg)$/);
			if (fnameSp === '' || fnameTb === '') return;
			if (window.innerWidth <= opt.breakPoint[0]) {
				srcTo = $(this).attr('src').replace(fnameFrom[0], fnameSp);
			} else if (window.innerWidth <= opt.breakPoint[1]) {
				if (window.innerWidth > window.innerHeight) {
					srcTo = $(this).attr('src').replace(fnameFrom[0], fnameSpyoko);
				} else {
					srcTo = $(this).attr('src').replace(fnameFrom[0], fnameTb);
				}
			} else {
				srcTo = $(this).attr('src').replace(fnameFrom[0], fnamePc);
			}
			$(this).attr('src', srcTo);
		});
		return this;
	};

	/*------------------------------------
		[ snapDots ]
		snap_sp ドット位置
		@ver		18.1.1
		@history	2021-06-29		: 新規作成 [ 18.1.1 ]

		> 設定詳細

		> 設定方法
		$( '.snap_sp' ).snapDots();
	------------------------------------*/

	jQuery.fn.snapDots = function (config) {
		let opt = jQuery.extend(
			{
				snapChildren: '.clm_item',
				dotsWrap: '.snap_dots'
			},
			config
		);
		let snapLength, x, i, index, totalWidth;
		function dotChange($eachSnap) {
			x = $eachSnap.scrollLeft();
			totalWidth = 0;
			index = 0;
			for (i = 0; i < snapLength; i++) {
				x = $eachSnap.scrollLeft();
				totalWidth += $eachSnap.children(opt.snapChildren).eq(i).width();
				if (x < totalWidth) {
					index = i;
					break;
				}
			}
			$eachSnap.next(opt.dotsWrap).children('span').removeClass('current').eq(index).addClass('current');
		}
		$(this).each(function () {
			snapLength = $(this).children(opt.snapChildren).length;
			$(this).next(opt.dotsWrap).append('<span></span>'.repeat(snapLength));
			dotChange($(this));
			$(this).scroll(function () {
				dotChange($(this));
			});
		});
		return this;
	};

	/*------------------------------------
		[ bigTarget ]
		ビッグターゲット
		@ver		14.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]

		> 設定詳細
		hoverClass : ホバー時のクラス名

		> 設定方法
		$( '.bt' ).bigTarget();
	------------------------------------*/

	jQuery.fn.bigTarget = function (config) {
		let opt = jQuery.extend(
			{
				hoverClass: 'hover'
			},
			config
		);

		$(this).click(function () {
			let target = $(this).find('a').attr('target'),
				url = $(this).find('a').attr('href');
			if (target == '_blank') {
				window.open(url);
			} else {
				window.location = url;
			}
			return false;
		});
		$(this).hover(
			function () {
				$(this).addClass(opt.hoverClass);
			},
			function () {
				$(this).removeClass(opt.hoverClass);
			}
		);
		return this;
	};

	/*------------------------------------
		[ tooltip ]
		ツールチップ
		@ver		18.1.1
		@history	2021-02-22		: 新規追加 [ 17.1.1 ]

		> 設定詳細
		fadeSpeed: 200

		> 設定方法
		$( '.tooltip' ).tooltip();
			*html
			<a class="tooltip" data-tooltip="注釈">ハンドル</a>
	------------------------------------*/

	jQuery.fn.tooltip = function (config) {
		let opt = jQuery.extend(
			{
				fadeSpeed: 200
			},
			config
		);
		let $tooltipTarget, cont, offset, handleSize, targetSize;

		$(this).each(function () {
			$(this)
				.on('mouseenter', function () {
					cont = $(this).data('tooltip');
					$tooltipTarget = $(["<span class='tooltip_target'>", '<span>', cont, '</span>', '</span>'].join(''));
					$(this).append($tooltipTarget);
					offset = $(this).offset();
					handleSize = {
						width: $(this).outerWidth(),
						height: $(this).outerHeight()
					};
					targetSize = {
						width: $tooltipTarget.outerWidth(),
						height: $tooltipTarget.outerHeight()
					};
					$tooltipTarget
						.css({
							top: 0,
							left: handleSize.width + 10
							// left: offset.left + handleSize.width / 2 - targetSize.width / 2
						})
						.stop(true, false)
						.fadeIn(opt.fadeSpeed);
				})
				.on('mouseleave', function () {
					$tooltipTarget.stop(true, false).fadeOut(opt.fadeSpeed, function () {
						$tooltipTarget.remove();
					});
				});
		});
		return this;
	};

	/*------------------------------------
		[ sScroll ]
		スムーススクロール
		@ver		16.2.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-06-11		: offsetをレスポンシブで切り替えられるように修正 [ 14.2.1 ]
					2019-10-15		: 条件分岐不具合修正 [ 14.3.1 ]
					2019-10-19		: ハッシュリンク先がない場合の対応 [ 14.3.2 ]
					2020-05-09		: 各種設定値を自動算出 [ 16.1.1 ]
					2020-05-25		: wp admin bar も含めて自動算出 [ 16.2.1 ]

		> 設定詳細
		speed : 'slow' or 'normal' or 'fast' or ミリ秒（ex. 1500）
		easing : 'linear' or 'swing'
		offset : num
		top : true

		> 設定方法
		$( '.pagetop a' ).sScroll();
	------------------------------------*/

	jQuery.fn.sScroll = function (config) {
		let opt = jQuery.extend(
			{
				offset: 0, // default offset
				adjust: false, // offset +=
				top: false,
				offsetPc: false,
				offsetTb: false,
				offsetSp: false,
				breakPoint: [600, 960],
				speed: 'slow',
				easing: 'swing'
			},
			config
		);

		const $hw = $('.header_wrap');
		let currentOffset, $self, $target, offset, adjust;

		$(this).click(function () {
			$self = $(this);
			if (opt.top) {
				currentOffset = 0;
				$('html,body').animate({ scrollTop: currentOffset }, opt.speed, opt.easing);
			} else {
				$target = $self.attr('href').length ? $($self.attr('href')) : $('body');
				if (opt.adjust) {
					adjust = opt.adjust;
				} else if ($target.hasClass('area')) {
					adjust = 0;
				} else {
					adjust = 20;
				}
				if (window.matchMedia('screen and (max-width: ' + (opt.breakPoint[0] - 1) + 'px)').matches) {
					offset = opt.offsetSp ? opt.offsetSp : $hw.outerHeight();
					currentOffset = offset + adjust + $.oo.wpadminbarHeight();
				} else if (window.matchMedia('screen and (min-width: ' + opt.breakPoint[0] + 'px) and (max-width: ' + (opt.breakPoint[1] - 1) + 'px)').matches) {
					offset = opt.offsetTb ? opt.offsetTb : $hw.outerHeight();
					currentOffset = offset + adjust + $.oo.wpadminbarHeight();
				} else {
					offset = opt.offsetPc ? opt.offsetPc : $hw.outerHeight();
					currentOffset = offset + adjust + $.oo.wpadminbarHeight();
				}
				$('html,body').animate({ scrollTop: $target.offset().top - currentOffset }, opt.speed, opt.easing);
			}
			return false;
		});
		return this;
	};

	/*------------------------------------
		[ hashLinkInPage ]
		ページ遷移時の#（ハッシュ）リンク
		@ver		16.1.1
		@history	2019-02-25 N 新規追加
					2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-10-15		: 条件分岐不具合修正 [ 14.2.1 ]
					2019-07-25 N 各breakpoint で 調整値変更
					2019-10-19		: ハッシュリンク先がない場合の対応 [ 14.2.2 ]
					2020-05-09		: 各種設定値を自動算出 [ 16.1.1 ]

		> 設定詳細
		****

		> 設定方法
		$( '.body,html' ).hashLinkInPage( {
			adjust   : 50
			offsetPc : 100,
			offsetTb : 150,
			offsetSp : 200
		} );
	------------------------------------*/

	jQuery.fn.hashLinkInPage = function (config) {
		let opt = jQuery.extend(
			{
				flag: true,
				offset: 0, // default offset
				adjust: false,
				offsetPc: false,
				offsetTb: false,
				offsetSp: false,
				breakPoint: [600, 960],
				speed: 'slow',
				easing: 'swing'
			},
			config
		);

		let urlHash = location.hash,
			$target,
			position,
			offset,
			adjust;

		if ($(urlHash).length) {
			if (window.matchMedia('screen and (max-width: ' + (opt.breakPoint[0] - 1) + 'px)').matches) {
				offset = opt.offsetSp ? opt.offsetSp : $('.header_wrap').outerHeight();
			} else if (window.matchMedia('screen and (min-width: ' + opt.breakPoint[0] + 'px) and (max-width: ' + (opt.breakPoint[1] - 1) + 'px)').matches) {
				offset = opt.offsetSp ? opt.offsetSp : $('.header_wrap').outerHeight();
			} else {
				offset = opt.offsetSp ? opt.offsetSp : $('.header_wrap').outerHeight();
			}
			if (urlHash && opt.flag) {
				$(this).stop().scrollTop(0);
				setTimeout(function () {
					$target = $($(urlHash));
					if (opt.adjust) {
						adjust = opt.adjust;
					} else if ($target.hasClass('area')) {
						adjust = 0;
					} else {
						adjust = 20;
					}
					position = $target.offset().top - offset - adjust;
					$('body,html').stop().animate({ scrollTop: position }, 800);
				}, 1200);
			}
		}
		return this;
	};

	/*------------------------------------
		[ mbCut ]
		最下段カラムのマージンカット（display:flex）
		@ver		15.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
					2019-06-08		: 復活 [ 15.1.1 ]

		> 設定詳細
		items : 子要素の指定
		colNum : カラム数の指定
		mbClass : 最下段要素に振るクラス名

		> 設定方法
		$( '.clm2' ).mbCut( {
			items: '.clm_item',
			colNum: 2
		} );
	------------------------------------*/

	jQuery.fn.mbCut = function (config) {
		let opt = jQuery.extend(
			{
				items: '.clm_item',
				colNum: 2,
				mbClass: 'mbcut'
			},
			config
		);

		$(this).each(function () {
			let $self = $(this),
				$item = $self.find(opt.items),
				total = $item.length,
				num = opt.colNum,
				start;
			if ($self.css('display') === 'flex') {
				if (total % num == 0) {
					start = total - num;
				} else {
					start = total - (total % num);
				}
				for (let i = 0; i < total; i++) {
					if (i >= start) {
						$item.eq(i).addClass(opt.mbClass);
					} else {
						$item.eq(i).removeClass(opt.mbClass);
					}
				}
			} else {
				$item.removeClass(opt.mbClass);
			}
		});
		return this;
	};

	/*------------------------------------
		[ containBlock ]
		ブロック要素の縦横比を親要素にあわせて維持
		@ver		14.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]

		> 設定詳細 * 4:3 にしたい場合
		wRate : 横比率
		hRate : 縦比率

		> 設定方法
		$( '.contain_cont' ).containBlock( { wRate: 4, hRate: 3 } );
	------------------------------------*/

	jQuery.fn.containBlock = function (config) {
		let opt = jQuery.extend(
			{
				wRate: 4,
				hRate: 3
			},
			config
		);

		let wParent, hParent;

		$(this).each(function () {
			wParent = $(this).parent().width();
			hParent = $(this).parent().height();
			if (hParent / wParent > opt.hRate / opt.wRate) {
				$(this).width(wParent);
				$(this).height((wParent * opt.hRate) / opt.wRate);
			} else {
				$(this).width((hParent * opt.wRate) / opt.hRate);
				$(this).height(hParent);
			}
		});
		return this;
	};

	/*------------------------------------

	[ gaDownloadTrack ]
	ファイルダウンロード解析（Google Analytics）
	@ver		16.1.1
	@history	2019-06-08		: historyの再管理 [ 14.1.1 ]
				2019-10-10		: ga() > gtag()への移行 [ 14.2.1 ]
				2020-04-10		: event_category,event_label を オプションに追加 [ 16.1.1 ]

	> 設定詳細
	category : トラッキングするオブジェクトのグループに付ける名前
	action : トラッキングするオブジェクトへのアクション名
	label : 任意の値 デフォルトのは ファイルURL

	> 設定方法
	$('a[href$=.pdf]').gaDownloadTrack(
		{
			action: 'xxx',
			event_category: 'yyy', // タグには data-yyy="値" を記述
			event_label: 'zzz' // タグには data-zzz="値" を記述
		}
	);

------------------------------------*/

	jQuery.fn.gaDownloadTrack = function (config) {
		var opt = jQuery.extend(
			{
				action: 'download',
				event_category: 'default',
				event_label: 'default'
			},
			config
		);

		$(this).on('click', function () {
			let href = $(this).attr('href'),
				title = $(this).text(),
				$matches,
				fname,
				category,
				label;
			$matches = href.match(/[^\/]*\.([a-zA-z0-9]*)$/);
			if ($matches[0] === null) return;
			fname = $matches[0]; // fname
			if (opt.event_category !== 'default') {
				category = opt.event_category;
			} else {
				category = $matches[1]; // ext
			}
			if (opt.event_label !== 'default') {
				label = $(this).data(opt.event_label);
			} else {
				label = href; // href
			}
			gtag('event', opt.action, {
				event_category: category,
				event_label: label
			});
		});
		return this;
	};

	/*------------------------------------

	[ addTargetBlank ]
	target="_blank"の自動付与
	@ver		18.1.1
	@history	2021-03-17		: 新規作成 [ 17.1.1 ]

	> 設定方法
	$('a[href$=.pdf]').addTargetBlank();

------------------------------------*/

	jQuery.fn.addTargetBlank = function (config) {
		let opt = jQuery.extend({}, config);

		$(this).each(function () {
			$(this).attr('target', 'blank');
		});
		return this;
	};

	/*------------------------------------
		[ removeSmoothScrollIE ]
		IEのスムーズスクロールバグ解除機能
		@ver		14.1.1
		@history	2019-06-08		: historyの再管理 [ 14.1.1 ]

		> 設定方法
		$( '.body' ).removeSmoothScrollIE();
	------------------------------------*/

	jQuery.fn.removeSmoothScrollIE = function (config) {
		let opt = jQuery.extend(
			{
				// eslint-disable-line no-unused-vars
			},
			config
		);

		if (navigator.userAgent.match(/MSIE 10/i) || navigator.userAgent.match(/Trident\/7\./) || navigator.userAgent.match(/Edge\/12\./)) {
			$(this).on('mousewheel', function () {
				event.preventDefault();
				let wd = event.wheelDelta;
				let csp = window.pageYOffset;
				window.scrollTo(0, csp - wd);
			});
		}
		return this;
	};

	/*==============================================================================================
		global
	==============================================================================================*/

	$.oo = {};

	/*------------------------------------
		[ changed_run ]

		@ver		16.1.1
		@history	2019-11-04		: 新規作成 [ 14.1.1 ]
					2019-12-06		: sp_yokoの追加 [ 15.1.1 ]
					2019-12-06		: spyokoのバグ修正 [ 15.1.2 ]
	------------------------------------*/

	$.oo.changed_run = function (callback, breakpoint, flgSpyoko) {
		flgSpyoko = flgSpyoko ? flgSpyoko : false;
		let windowMatchMedia = {},
			fromMode = 'none';
		if (breakpoint.length > 1) {
			windowMatchMedia['sp'] = window.matchMedia('screen and (max-width: ' + (breakpoint[0] - 1) + 'px)');
			windowMatchMedia['tb'] = window.matchMedia('screen and (min-width: ' + breakpoint[0] + 'px) and (max-width: ' + (breakpoint[1] - 1) + 'px)');
			windowMatchMedia['pc'] = window.matchMedia('screen and (min-width: ' + breakpoint[1] + 'px)');
		} else if (breakpoint.length === 1) {
			windowMatchMedia['sp'] = window.matchMedia('screen and (max-width: ' + (breakpoint[0] - 1) + 'px)');
			windowMatchMedia['pc'] = window.matchMedia('screen and (min-width: ' + breakpoint[1] + 'px)');
		}
		function changed_core() {
			callback('every');
			if (breakpoint.length > 1) {
				if (windowMatchMedia['sp'].matches) {
					callback('sp');
					if (fromMode !== 'tb') callback('sp_tb');
					fromMode = 'sp';
				} else if (windowMatchMedia['tb'].matches) {
					// spyoko 判定 200130 N
					if (window.innerHeight < window.innerWidth && flgSpyoko) {
						callback('spyoko');
					} else {
						callback('tb');
					}
					if (fromMode !== 'sp') callback('sp_tb');
					if (fromMode !== 'pc') callback('tb_pc');
					fromMode = 'tb';
				} else if (windowMatchMedia['pc'].matches) {
					if (fromMode !== 'tb') callback('tb_pc');
					callback('pc');
					fromMode = 'pc';
				}
			} else if (breakpoint.length === 1) {
				if (windowMatchMedia['sp'].matches) {
					callback('sp');
					fromMode = 'sp';
				} else if (windowMatchMedia['pc'].matches) {
					callback('pc');
					fromMode = 'pc';
				}
			}
		}
		if (breakpoint.length > 1) {
			windowMatchMedia['sp'].addListener(changed_core);
			windowMatchMedia['pc'].addListener(changed_core);
		} else if (breakpoint.length === 1) {
			windowMatchMedia['sp'].addListener(changed_core);
		}
		changed_core();
	};

	/*------------------------------------
		[ loadingOverlay ]

		@ver		18.1.1
		@memo	2021-05-03		: 新規作成西 [ 17.1.1 ]
	------------------------------------*/

	$.oo.loadingOverlay = function (action) {
		if (action == 'hide') {
			$('#loading_wrap').hide().css({ opacity: 1 });
		} else {
			$('#loading_wrap').css({ opacity: 0.7 }).show();
		}
	};

	/*------------------------------------
		[ inherit_teston ]

		@ver		14.1.1
		@history	2019-12-05		: 新規作成 [ 15.1.1 ]
	------------------------------------*/

	$.oo.inherit_teston = function () {
		let href, action, str;
		if ($.oo.get_param('test') === 'on') {
			$('a').each(function () {
				href = $(this).attr('href');
				if (href !== undefined) $(this).attr('href', addTestOn(href));
			});
			$('form').each(function () {
				action = $(this).attr('action');
				if (action !== undefined) $(this).attr('action', addTestOn(action));
			});
		}
		// func
		function addTestOn(href) {
			str = href.split('?').length > 1 ? '&' : '?';
			str += 'test=on';
			return href.replace(/(https?:\/\/[^\/]+)?(\/[^\?]*\??)([^#]*)(.*)$/, '$1$2$3' + str + '$4');
		}
	};

	/*------------------------------------
		[ add_publicdir ]

		@ver		14.1.1
		@history	2019-12-05		: 新規作成 [ 15.1.1 ]
					2021-01-13		: wordpressテンプレートで停止 [ 17.1.1 ]
	------------------------------------*/

	$.oo.add_publicdir = function (publicdir) {
		let path,
			pattern = /^\//;
		if (publicdir) {
			$('a').each(function () {
				path = $(this).attr('href');
				if (flagAbs(path)) $(this).attr('href', publicdir + path);
			});
			$('form').each(function () {
				path = $(this).attr('action');
				if (flagAbs(path)) $(this).attr('action', publicdir + path);
			});
			$('img').each(function () {
				path = $(this).attr('src');
				if (flagAbs(path)) $(this).attr('src', publicdir + path);
			});
		}
		// func
		function flagAbs(argPath) {
			if (argPath === undefined) {
				return false;
			} else if (argPath.match(pattern)) {
				return true;
			} else {
				return false;
			}
		}
	};

	/*------------------------------------
		[ get_param ]
		@ver		15.1.1
		@history	2019-12-05		: 新規作成 [ 15.1.1 ]
	------------------------------------*/

	$.oo.get_param = function (key, url) {
		url = !url ? window.location.href : url;
		key = key.replace(/[\[\]]/g, '\\$&');
		let regex = new RegExp('[?&]' + key + '(=([^&#]*)|&|#|$)'),
			results = regex.exec(url);
		if (!results) {
			return null;
		} else if (!results[2]) {
			return '';
		} else {
			return decodeURIComponent(results[2].replace(/\+/g, ' '));
		}
	};

	/*------------------------------------
		[ wpadminbarHeight ]
		@ver		15.1.1
		@history	2019-12-05		: 新規作成 [ 15.1.1 ]
	------------------------------------*/

	$.oo.wpadminbarHeight = function () {
		let $wpadminbar = $('#wpadminbar'),
			h;
		h = typeof $wpadminbar.outerHeight() === 'undefined' ? 0 : $wpadminbar.outerHeight();
		return h;
	};

	/*==============================================================================================
		frame
	==============================================================================================*/

	/*------------------------------------
		[ frame ]
		header スクロール変化
		@ver		16.1.1
		@history	2019-12-06		: oo_lib 移設 [ 15.1.1 ]
					2020-05-09		: 各種設置の自動算出 [ 16.1.1 ]
	------------------------------------*/

	$.oo.frame = function (setting, breakpoint) {
		const // dom base
			$window = $(window),
			$body = $('body'),
			$container = $('.container'),
			$hw = $('.header_wrap:not(.header_wrap_clone)'),
			$gnav = $('.gnav', $hw),
			$gnavHandle = $('.gnav_btn', $hw);
		let // resize
			status = 'none', // sp( max600 ) / sp_yoko( min600&max960&yoko ) / tb( min600&max960 ) / pc( min960 )
			// hws : header_wrap_scroll
			$hwClone,
			hwsFlag = true, // hws実行フラグ
			hwsType, // hwsタイプ a / b / c
			hwsOpt = {}, // hwsオプション
			hwh, // .header_wrap.outerHeight()
			hwhTransitonEnd,
			st, // scrollTop
			// gno : gnav_open
			gnoFlag = true, // gno実行フラグ
			winlock, // windowLockフラグ
			tmpst; // winlock時のscrollTop

		/*------------------------------------------------
				setting
			------------------------------------------------*/

		/* setting */
		if (!setting)
			setting = {
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
						pc: { adjust: 200 }
					}
				}
			};
		if (!breakpoint) breakpoint = [600, 960];

		/*------------------------------------------------
				structure
			------------------------------------------------*/

		/* --- main --- */
		function frameMain(mode) {
			// status変更時1回だけ実行
			if (mode === 'sp') {
				statusChange('sp');
			} else if (mode === 'spyoko') {
				statusChange('spyoko');
			} else if (mode === 'tb') {
				statusChange('tb');
			} else if (mode === 'pc') {
				statusChange('pc');
			}
		}
		/* sc : status_change */
		function statusChange(argStatus) {
			// status
			if (status !== argStatus) {
				status = argStatus;
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

		/*------------------------------------------------
				fn : hws
			------------------------------------------------*/

		/* hwsInit : status変更時1回だけ実行 */
		function hwsInit() {
			// hwsOpt
			hwh = $hw.outerHeight();
			$hw.on('transitionend', function () {
				// transition が発生した場合はhwh再調整
				hwhTransitonEnd = $hw.outerHeight();
				//console.log('hwh:transitionend(' + status + ') = ' + hwh);
				$container.css({ paddingTop: hwhTransitonEnd }); // hws:init 終了後も再調整させる
			});
			//console.log('hwh:init(' + status + ') = ' + hwh);
			st = $window.scrollTop();
			// ready状態ののheader_wrap.height 取得（* wpadminbar調整 & containerのpadding-top調整）
			if (hwsType === 'b') {
				$hw.has('.header_wrap_change').css({ marginTop: $.oo.wpadminbarHeight() });
				// wpadminbarHeight を足さないと動作ログイン時動作不良のケースがある 200402 西
				// hwh = hwh + $.oo.wpadminbarHeight();
				$container.css({ paddingTop: hwh });
			} else {
				$hw.css({ marginTop: $.oo.wpadminbarHeight() });
				// wpadminbarHeight を足さないと動作ログイン時動作不良のケースがある 200402 西
				// hwh = hwh + $.oo.wpadminbarHeight();
				$container.css({ paddingTop: hwh });
			}
			// 各タイプ初期値
			/* hws-a */
			if (hwsFlag && hwsType === 'a') {
				if ($hwClone !== undefined) {
					$hwClone.detach();
				}
				$hw.css({ position: 'fixed' });
				if (st < hwh + hwsOpt.adjust) {
					$hw.removeClass('header_wrap_change');
				} else {
					$hw.addClass('header_wrap_change');
				}
				/* hws-b */
			} else if (hwsFlag && hwsType === 'b') {
				$hwClone = $hw.clone(true).insertAfter($hw).addClass('header_wrap_clone').css({ position: 'fixed' });
				$hwClone.find('.submenu_wrap').gnavSubmenu();
				$hw.removeClass('header_wrap_change').css({ top: 0, position: 'absolute', marginTop: 0 });
				if (st < hwh) {
					$hwClone.css({ top: '-100px' });
				} else {
					$hwClone.css({ top: 0 });
				}
				/* hws-c */
			} else if (hwsFlag && hwsType === 'c') {
				if ($hwClone !== undefined) {
					$hwClone.detach();
				}
				$hw.css({ position: 'fixed' });
				if (st < hwh + hwsOpt.adjust) {
					$hw.removeClass('header_wrap_change');
				} else {
					$hw.addClass('header_wrap_change');
				}
			}
		}
		/* hwsCore : readyで以下をscrollにバインド */
		function hwsCore() {
			let before = $window.scrollTop();
			$window.on('scroll', function () {
				st = $(this).scrollTop();
				/* hws-a */
				if (hwsFlag && hwsType === 'a') {
					if (st < hwh + hwsOpt.adjust) {
						$hw.removeClass('header_wrap_change').on('transitionend', function () {
							$container.css({ paddingTop: $hw.outerHeight() });
						});
					} else {
						$hw.addClass('header_wrap_change');
					}
					/* hws-b */
				} else if (hwsFlag && hwsType === 'b') {
					if (st < hwh + hwsOpt.adjust) {
						$hwClone.css({ top: '-130px' });
					} else {
						$hwClone.css({ top: $.oo.wpadminbarHeight() });
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
					if (st < hwh + hwsOpt.adjust) {
						$hw.removeClass('header_wrap_change');
					} else {
						$hw.addClass('header_wrap_change');
					}
					before = st;
				}
			});
		}

		/*------------------------------------------------
			fn : gno
		------------------------------------------------*/

		/* gnoInit : status変更時1回だけ実行 */
		function gnoInit() {
			if (status === 'pc') {
				$gnav.css({ top: '', paddingTop: '', marginLeft: '', width: '' }).show().removeClass('open');
				$gnavHandle.removeClass('close').addClass('menu');
				$gnav.css({ top: '' });
				windowLock('off');
			} else {
				// gnav 開いた状態でstatus_change した場合
				let gnavy = $hw.outerHeight(true) + $hw.position().top;
				$gnav.css({ top: gnavy });
				if (winlock === false) {
					$gnav.removeClass('open');
					$gnavHandle.removeClass('close').addClass('menu');
				}
			}
		}
		/* gnoCore : readyで以下をscrollにバインド */
		function gnoCore() {
			$gnavHandle.on('click', function () {
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
				let gnavy = $hw.outerHeight(true) + $hw.position().top;
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
			fn : util
		------------------------------------------------*/
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
		$(function () {
			$.oo.changed_run(frameMain, breakpoint, true);
			frameMain();
			gnoCore();
			hwsCore();
		});
	};

	/*-- end oo_lib ----------------------------------*/
});
