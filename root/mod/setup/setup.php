<?php
/*--------------------------------------------------------------

	setup

	@package	setup ( < base_mod )
	@author		oldoffice.com
	@since		PHP 7.4
	@ver		18.1.1

	@memo
		2015-06-16  coding_template ver6 にあわせて整理 N [6.1.1]
		2015-08-25  $sp_site(setting)=false 時の不具合修正 N [6.1.2]
		2016-01-19  smarty対応 関数内globalの除去 KN [6.1.3]
		2016-06-07  wp投稿情報を補正する関数追記 [6.1.4]
		2016-06-29  wp投稿情報を補正する関数移動/debug_report追記 [6.1.5]
		2016-08-09  JavaScript global変数 sitePublicDirの調整 [6.1.6]
		2016-10-03  スマートフォン版ajaxzipをgithubに移行
				    google api key の定数 [6.1.7]
		2017-09-16  プレオープンサイト用に未設定変数を変換 [6.1.8]
		2018-02-15  wpログイン後のadminbar表示をspに適用
		2018-05-22  ct11にあわせて再構成
		2018-07-10  wp_admin_bar の補正値を削除 [12.2.1]
		2018-07-17  jquery-migrate3.0.1 標準 [12.2.2]
		2018-08-02  累積不要コードを一括削除
		            多言語サイト仕様に対応 N [12.3.1]
		2019-03-01  wp-donfigのinclude標準化
					ct13にあわせて見直し N [13.1.1]
		2019-10-18	ENV BASE 統合
					cssを統合 N [14.1.1]
		2019-10-18	test_on の継承 N [14.1.2]
		2021-05-05	名称を base_mod から setup に変更 N [18.1.1]
					ディレクトリを setupに 移動
					機能を oofunc に分割

---------------------------------------------------------------*/

##	base

	/* session */
	if( session_status() !== PHP_SESSION_ACTIVE ) session_start();

	/* debug_report */
	$debug_report        = '';

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setting.php';
	include_once ROOTREALPATH . '/mod/base/oobase.class.php';
	include_once ROOTREALPATH . '/mod/base/head.class.php';
	$HEAD = new OOHEAD();
	include_once ROOTREALPATH . '/mod/setup/oofunc.php';

##	setting

	// page_setting
	$HEAD->pagename               = $PAGENAME ?? '';
	/* jquery */
	$HEAD->jquery                .= "\t" . '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>' . "\n";
	/* preset_js */
	$HEAD->preset_js             .= ( OOBASE::ua_browser() == 'ie' ) ? "\t" . '<script src="' . PUBLICDIR . '/js/lib/fitie.js"></script>' . "\n" : '';
	$HEAD->preset_js             .= "\t" . '<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>' . "\n";

##	ec

	if( defined( 'ECCUBE_INSTALLED' ) && ECCUBE_INSTALLED ) {
		include_once ROOTREALPATH . '/mod/wpec/wpec_functions.php';
	}

##	language

	/* language */
	// none_wpml
	/**
	 * 言語定数
	 *
	 * ICL_LANGUAGE_CODE
	 * 		WPML定数
	 * 		WPMLがない場合も使用
	 * LDIR
	 * 		言語定数の設定 * 多言語サイトの場合リンク先頭に追記
	 */
	if( ! defined( 'ICL_LANGUAGE_CODE' ) ) define( 'ICL_LANGUAGE_CODE', 'ja' );
	if( ICL_LANGUAGE_CODE != 'ja' ) {
		define( 'LDIR', '/' . ICL_LANGUAGE_CODE );
	} else {
		define( 'LDIR', '' );
	}

	/**
	 * switch_lang
	 *
	 * 多言語サイト文字列切替
	 * arg1: 日本語, arg2: 配列 [ 'en' => '英訳', 'zh-hans' => '中国語訳' ]
	 */
	function oo_switch_lang( $def, $word_arr = [] ){
		if( isset( $word_arr[ ICL_LANGUAGE_CODE ] ) ) {
			return $word_arr[ ICL_LANGUAGE_CODE ];
		} elseif( ICL_LANGUAGE_CODE === 'zh-hans' && isset( $word_arr[ 'zh' ] ) ) {
			return $word_arr[ 'zh' ];
		} else {
			return $def;
		}
	}

	/**
	 * is_lang
	 *
	 * 多言語サイトの言語判定
	 * arg: lang
	 */
	function oo_is_lang( $lang_code ){
		$lang_code = ( $lang_code === 'zh' || $lang_code === 'cn' ) ? 'zh-hans' : $lang_code;
		if( ICL_LANGUAGE_CODE === $lang_code ) {
			return true;
		} else {
			return false;
		}
	}

