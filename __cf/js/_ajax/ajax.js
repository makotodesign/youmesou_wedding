/* ajax */

(function($) {
	/* ajax */
	var // ajax : request
		requestJson,
		// ajax : get
		jsonDataPath,
		// ajax : dom
		$ctrlFilterSet,
		$ctrlFilter,
		$targetStatus,
		$targetAjaxSet,
		$loader,
		$targetMainContWrap,
		$targetPagerWrap,
		ctrlPagerSelector;

	function init() {
		create();
		eventify();
		setup();
	}

	function create() {
		/* ajax */
		// ajax : request
		requestJson = {
			xx: 'xxx',
			filter_zz: [],
			paging: 1
		};
		// ajax : get
		jsonDataPath = sitePublicDir + '/xx/master_json/'; // sitePublicDir : globalVar
		// ajax : dom
		$ctrlFilterSet = $('#xx_index_filter_part');
		$ctrlFilter = $('input:checkbox', $ctrlFilterSet);

		ctrlPagerSelector = '#xx_index_pager a'; //appendされたタグにbind
		$targetAjaxSet = $('#xx_index_ajax_target_set');
		$targetStatus = $('#xx_lineup_status_part p');
		$targetMainContWrap = $('#xx_index_ajax_maincont');
		$targetPagerWrap = $('#xx_index_pager');
		$loader = $('#xx_index_ajax_loader');
	}

	function eventify() {
		/* ajax */
		// ajax : filter
		$ctrlFilter.click(function() {
			// this_data
			updateFilter();
			resetPaging();
			// ajax_event
			runDefAjaxEvent();
		});

		// ajax : pager ( live_event )
		$(document).on('click', ctrlPagerSelector, function() {
			var $self = $(this);
			// this_data
			updatePaging($self);
			// ajax_event
			runDefAjaxEvent();
			// scroll_event
			//	scrollEvent( $self ); // pagerのリンク必須
			//	return false; // スクロールイベントの場合はreturn
		});
	}

	function setup() {
		/* ajax */
		// this_data
		resetFilter();
		// ajax_event
		runDefAjaxEvent();
		// disable_enter_key（Enterキーで実行されないように）
		disableEnterKey();
	}

	$(function() {
		init();
	});

	/* func - global : request_json */
	// update : request_data
	function updateFilter() {
		var tempArr = [];
		$ctrlFilter.each(function() {
			if ($(this).prop('checked')) {
				tempArr.push($(this).val());
			}
		});
		requestJson.filter = tempArr;
	}

	function updatePaging($clicked) {
		requestJson.paging = $clicked.text();
	}

	// reset : request_data
	function resetFilter() {
		$ctrlFilter.prop('checked', false);
		requestJson.filter = [];
		var urlParamFilter = '';
		// パラメーターで初期チェック取得
		var getPram = location.search.match(/addfilter=(.*?)(&|$)/);
		if (getPram) {
			var getPramArr = getPram[1].split(',');
			//console.log(getPramArr);
			for (var i = 0; i < getPramArr.length; i++) {
				urlParamFilter = decodeURIComponent(getPramArr[i]);
				requestJson['filter'].push(urlParamFilter);
				$('#' + urlParamFilter).prop('checked', true);
			}
		}
	}

	function resetPaging() {
		requestJson.paging = 1;
	}

	// event : scroll
	function scrollEvent($clicked) {
		var selector = $clicked.attr('href');
		$('html,body').animate({ scrollTop: $(selector).offset().top - 40 }, 'slow'); // リンク先に指定されたセレクタの「40px」上へ
	}

	// event : disable_enter_key_for_form
	function disableEnterKey() {
		$('input').on('keydown', function(e) {
			if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
				// Enterキーのコード=「13」
				return false;
			} else {
				return true;
			}
		});
	}

	/* func - global : run_ajax */
	// run_ajax
	function runDefAjaxEvent() {
		$loader
			.css('height', '50px')
			.find('img')
			.show();
		$targetMainContWrap.css({ opacity: 0 });
		createPage();
	}

	// target_set
	function showTarget($target) {
		$loader.find('img').hide();
		$loader.animate({ height: '0px' }, 'normal');
		$target.css({ opacity: 1.0 });
	}

	// create_page
	function createPage() {
		$.getJSON(
			// ajax_url
			jsonDataPath,
			// ajax_request : phpに送るデータ
			requestJson,
			// ajax_callback : 通信が成功した時のcallback
			function(data, status) {
				// loader > tatget
				showTarget($targetMainContWrap);
				// tag : product_status
				var tags;
				// tag : miancont
				tags = data['tag_main_cont'];
				$targetMainContWrap
					.empty()
					.append(tags)
					.hide()
					.fadeIn(500);
				// tag : pager
				tags = data['tag_pager'];
				$targetPagerWrap.empty().append(tags);
				var str;
				// str : status
				str = data['str_status'];
				$targetStatus.text(str);
			}
		);
	}
})(jQuery);
