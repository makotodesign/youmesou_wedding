<?php
/***************************************************************************

	HEADクラス

	@package	head
	@author		oldoffice.com
	@since		PHP 7.4
	@ver		18.1.1

	@memo
		2015-06-16	coding_template ver6 にあわせてclass化 N [6.1.1]
		2015-08-25	$sp_site(setting)=false 時の不具合修正 N [6.1.2]
		2015-11-17	viewport androidブラウザでのPC版表児不具合の修正 K [6.1.3]
		2016-06-04	google analiticsトラッキングコードを最新に変更
		2018-02-26	ct10にあわせて再記述 N [7.1.1]
		2018-03-20	$viewport_width機能追加 N [7.2.1]
		2018-03-30  facebookいいねボタン設置の機能再設定 N [7.3.1]
					透過PNGの設定撤廃 * 後方互換 N [7.3.1]
		2018-05-11	pc/spを可能な限り統合 N [7.4.1]
		2018-07-10	frame.js を標準で読み込み
		            wp_head()削除 N[12.2.1]
		2018-08-02	累積不要コードの削除
		            多言語サイト仕様に対応 N[12.3.1]
		2019-07-23	body_attrを追加
					css_off,js_offを追加 N[14.1.1]
		2020-04-02	multisite 対応 N[16.1.1]
		2020-04-02	modal 表示非表示機能 N[16.1.2]
		2020-05-15	canonical 表示非表示機能 N[16.1.3]
		2020-05-21	modal 表示非表示機能 N[16.1.4]
		2020-11-04	javascript OFF時にloadingのopacity:0とメッセージ表示 I []
		2021-04-22	ec対応
					PUBLICDIR 調整
					js 自動読み込み
		2021-05-05	setup（旧base_mod）縮小により定数などを基本読み込み
					pc_sp 切り替え型撤廃
***************************************************************************/

class OOHEAD {

	public $debug_report;

	// site_setting
	public $sitename                  = '';
	public $google_analytics_ID       = '';
	public $viewport_width            = false; // レスポンシブの場合は使用しない
	public $google_fonts_text         = [];

	// sns_setting
	public $facebook_app_id           = '';
	public $disp_ogp                  = false;
	public $og_image_url              = '';
	public $disp_facebook_script      = false; // def : hide like btn
	public $disp_twitter_script       = false; // def : hide tweet btn
	public $disp_line_script          = false; // def : hide line btn
	public $disp_youtube_script       = false; // def : hide youtube btn
	public $disp_pinterest_script     = false; // def : hide pinterest save btn

	// page_setting
	public $pagename;
	public $css;
	public $js;
	public $css_default_off           = false;

	public $title;
	public $h1_text;
	public $meta_description;
	public $meta_keywords;
	public $meta_robots               = '';
	public $canonical                 = '';
	public $css_media                 = 'all';
	public $body_attr                 = '';

	public $modal_flag                = false;

	// preset_js_css
	public $jquery                    = '';
	public $preset_js                 = '';

	// head_parts
	const tb                          = "\t";

	### constructor

	function __construct() {

		/* setup/setting */
		if( defined( 'SITENAME' ) ) $this->sitename = SITENAME;
	}

	### public function

	public function res_tag_head() {

		// head
		$tag = '';
		$tag .= '<!DOCTYPE HTML>' . "\n";
		$lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : 'ja';
		$tag .= '<html lang="' . $lang . '">' . "\n";
		$tag .= '<head>' . "\n";
		$tag .= $this->res_tag_meta01();
		$tag .= $this->res_tag_title();
		$tag .= $this->res_tag_meta02();
		$tag .= $this->res_tag_canonical();
		$tag .= $this->res_tag_favicons();
		$tag .= $this->res_tag_css();
		// wp_head
		if( function_exists( 'wp_head' ) ){
			ob_start(); // echo される内容を変数に格納
			wp_head();
			$wp_head = ob_get_clean();
			$wp_head = preg_replace( "/\\t/", '', $wp_head );
			$wp_head = preg_replace( "/\\n/", '', $wp_head );
			$wp_head = ( $wp_head ) ? "\t" . trim( preg_replace( "/(<\/[a-z]+>)/", "$1\n\t", $wp_head ), "\t" ) : '';
			$wp_head = ( $wp_head ) ? "\t" . trim( preg_replace( "/\/>/", "/>\n\t", $wp_head ), "\t" ) : '';
			$tag .= ( $wp_head ) ? $wp_head : '';
		}
		$tag .= '</head>' . "\n";
		$tag .= '<body class="device_' . OOBASE::ua_device() . '"' . $this->body_attr . '>' . "\n";
		$tag .= $this->res_tag_container();
		return $tag;
	}

	public function disp_tag_head() {
		echo $this->res_tag_head();
	}

	public function res_tag_foot() {

		// foot
		$tag = '';
		$tag .= $this->res_tag_js();
		$tag .= $this->res_tag_facebook_script();
		$tag .= $this->res_tag_twetter_script();
		$tag .= $this->res_tag_line_script();
		$tag .= $this->res_tag_youtube_script();
		$tag .= $this->res_tag_pinterest_script();
		/* wp_footer */
		if( function_exists( 'wp_footer' ) ){
			ob_start(); // echo される内容を変数に格納
			wp_footer();
			$wp_footer = ob_get_clean();
			$wp_footer = preg_replace( "/\\t/", '', $wp_footer );
			$wp_footer = preg_replace( "/\\n\\n/", '', $wp_footer );
			$wp_footer = ( $wp_footer ) ? "\t" . preg_replace( "/\\n/", "\n\t", $wp_footer ) . "\n" : '';
			$tag .= $wp_footer;
		}
		return $tag;
	}

	public function disp_tag_foot() {
		echo $this->res_tag_foot();
	}

	public function res_tag_modal() {

		if( defined( 'DIRCODE' ) && DIRCODE == 'top' ){
			$class = DIRCODE . '_modal';
		} elseif( defined( 'DIRCODE' ) && defined( 'PAGECODE' ) ) {
			$class = DIRCODE . '_' . PAGECODE . '_modal';
		} else {
			$class = 'no_page';
		}
		if( isset( $_GET[ 'test' ] ) ) {
			$class .= ' test_' . $_GET[ 'test' ];
		}
		$add_class_modal = ( defined( 'MULTISITEBLOGNAME' ) ) ? ' ' . MULTISITEBLOGNAME : '';

		$tag = '';
		if( $this->modal_flag ) {
			$tag .= self::tb . "" . '<div id="modal_overlay" class="modal_overlay ' . $class .  $add_class_modal . '">' . "\n";
			$tag .= self::tb . "\t" . '<div class="modal_bg"></div>' . "\n";
			$tag .= self::tb . "\t" . '<div class="modal_wrap">' . "\n";
			$tag .= self::tb . "\t\t" . '<div class="modal">' . "\n";
			$tag .= self::tb . "\t\t" . '</div>' . "\n";
			$tag .= self::tb . "\t\t" . '<p class="modal_close"></p>' . "\n";
			$tag .= self::tb . "\t" . '</div>' . "\n";
			$tag .= self::tb . "" . '</div>' . "\n";
		}
		return $tag;
	}

	public function disp_tag_modal() {
		echo $this->res_tag_modal();
	}

	public static function fpath_add_date_query( $fpath_no_prefix ){
		$output = false;
		if( defined( 'ROOTREALPATH' ) && file_exists( ROOTREALPATH . $fpath_no_prefix ) ) {
			$temp_prefix = '';
			if( defined( 'PUBLICDIR' ) ) {
				$temp_prefix = PUBLICDIR;
			} elseif( function_exists( 'home_url' ) ) {
				$temp_prefix = home_url();
			}
			$output = $temp_prefix . $fpath_no_prefix;
			if( function_exists( 'date_i18n' ) ) {
				$date_query = date_i18n( 'ymds', filemtime( ROOTREALPATH . $fpath_no_prefix ) );
			} else {
				$date_query = date( 'ymds', filemtime( ROOTREALPATH . $fpath_no_prefix ) );
			}
			$output .= '?' . $date_query;
		}
		return $output;
	}

	### private function

	/* tag */

	// tag_meta01
	private function res_tag_meta01() {

		$tag = '';
		$tag .= self::tb . '<meta charset="utf-8">' . "\n";
		// viewport
		if( $this->viewport_width ) {
			$tag .= self::tb . '<meta name="viewport" content="width=' . $this->viewport_width . '">' . "\n";
		} else {
			$tag .= self::tb . '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
		}
		// ec
		if( defined( 'ECCUBE_INSTALLED' ) && ECCUBE_INSTALLED && function_exists( 'ec_oo_get_token' ) ) {
			$tag .= self::tb . '<meta name="eccube-csrf-token" content="' . ec_oo_get_token() .'">' . "\n";
		}
		// telephone
		$tag .= self::tb . '<meta name="format-detection" content="telephone=no">' . "\n";
		return $tag;
	}

	// tag_title
	private function res_tag_title() {

		$tag = self::tb . '<title>' . $this->res_parts_title() . '</title>' . "\n";
		return $tag;
	}

	// tag_meta02
	private function res_tag_meta02() {

		$tag = '';
		// def_meta_description
		$def_meta_description = '';
		if( defined( 'META_DESCRIPTION' ) ) $def_meta_description = META_DESCRIPTION;
		if( $this->meta_description === 'auto' || ! $this->meta_description ) $this->meta_description = $def_meta_description;
		if( $this->pagename ) $this->pagename . '。' . $this->meta_description;
		$tag .= self::tb . '<meta name="description" content="' . $this->meta_description . '">' . "\n";
		// meta_keywords
		$def_meta_keywords = '';
		if( defined( 'META_KEYWORDS' ) ) $def_meta_keywords = META_KEYWORDS;
		if( $this->meta_keywords === 'auto' || ! $this->meta_keywords ) $this->meta_keywords = $def_meta_keywords;
		$tag .= self::tb . '<meta name="keywords" content="' . $this->meta_keywords . '">' . "\n";
		// meta_robots
		$tag .= ( $this->meta_robots ) ? self::tb . '<meta name="robots" content="' . $this->meta_robots . '">' . "\n" : '';
		// facebook
		if( $this->disp_ogp ) {
			// sns : site_infomation
			$tag .= self::tb . '<meta property="og:locale" content="ja_JP">' . "\n";
			$tag .= self::tb . '<meta property="og:sitename" content="' . $this->sitename . '">' . "\n";
			// sns : site_infomation
			$tag .= self::tb . '<meta property="og:title" content="' . $this->res_parts_title() . '">' . "\n";
			$og_type = ( defined( 'DIRCODE' ) && DIRCODE != 'top' ) ? 'article' :'website';
			$tag .= self::tb . '<meta property="og:type" content="' . $og_type . '">' . "\n";
			$tag .= self::tb . '<meta property="og:url" content="' . $this->res_parts_url_for_wp() . '">' . "\n";
			$tag = $this->og_current_image_url ? self::tb . '<meta property="og:image" content="' . $this->og_image_url . '">' . "\n" : '';
			$tag .= self::tb . '<meta property="og:description" content="' . $this->meta_description . '">' . "\n";
		}
		return $tag;
	}

	// tag_canonical
	private function res_tag_canonical() {

		$tag = '';
		if( $this->canonical ) {
			$tag .= self::tb . '<link rel="canonical" href="' . $this->canonical . '">' . "\n";
		}
		return $tag;
	}

	// tag_favicons
	private function res_tag_favicons() {

		$tag = '';
		if( $this->fpath_add_date_query( '/apple-touch-icon.png' ) ) {
			$tag .= self::tb . '<link rel="apple-touch-icon" href="' . $this->fpath_add_date_query( '/apple-touch-icon.png' ) . '">' . "\n";
		}
		if( $this->fpath_add_date_query( '/favicon.ico' ) ) {
			$tag .= self::tb . '<link rel="icon" href="' . $this->fpath_add_date_query( '/favicon.ico' ) . '">' . "\n";
		}
		return $tag;
	}

	// tag_css
	private function res_tag_css() {

		$tag = '';
		$preconect = self::tb . '<link rel="preconnect" href="https://fonts.gstatic.com"> ' . "\n";
		if( ! $this->css_default_off ) {
			if( defined( 'FONTS_PRELOAD' ) ) {
				if( OOBASE::ua_device() === 'pc' && isset( FONTS_PRELOAD[ 'googlefonts_pc' ] ) ) {
					$tag .= $preconect;
					foreach( FONTS_PRELOAD[ 'googlefonts_pc' ] as $k => $v ) {
						if( isset( $this->google_fonts_text[ $k ] ) && $this->google_fonts_text[ $k ] ) {
							$v .= '&text=' . $this->google_fonts_text[ $k ];
						}
						$tag .= self::tb . '<link rel="stylesheet" href="' . $v . '"> ' . "\n";
					}
				} elseif( isset( FONTS_PRELOAD[ 'googlefonts_def' ] ) ) {
					$tag .= $preconect;
					foreach( FONTS_PRELOAD[ 'googlefonts_def' ] as $k => $v ) {
						if( isset( $this->google_fonts_text[ $k ] ) && $this->google_fonts_text[ $k ] ) {
							$v .= '&text=' . $this->google_fonts_text[ $k ];
						}
						$tag .= self::tb . '<link rel="stylesheet" href="' . $v . '"> ' . "\n";
					}
				}
				if( isset( FONTS_PRELOAD[ 'otherfonts' ] ) ) {
					if( ! FONTS_PRELOAD[ 'googlefonts_sp' ] && ! FONTS_PRELOAD[ 'googlefonts_pc' ] && ! FONTS_PRELOAD[ 'googlefonts_def' ] ) {
						$tag .= $preconect;
					}
					foreach( FONTS_PRELOAD[ 'otherfonts' ] as $k => $v ) {
						$tag .= self::tb . '<link rel="preload" as="style" href="' . $v . '" onload="this.rel=' . "'" . 'stylesheet' . "'" . '">' . "\n";
					}
				}
			}
			// multisite
			$add_fname_css = '';
			if( defined( 'MULTISITEBLOGNAME' ) && defined( 'MULTISITE_BLOG_TYPE' ) && MULTISITEBLOGNAME != 'base' && MULTISITE_BLOG_TYPE === 'each' ) $add_fname_css = '_' . MULTISITEBLOGNAME;
			// styles
			$tag .= self::tb . '<link rel="stylesheet" type="text/css" href="' . $this->fpath_add_date_query( '/css/styles' . $add_fname_css . '.css' ) . '" media="' . $this->css_media . '">' . "\n";
		}
		// page css
		$tag .= $this->css;
		return $tag;
	}

	// tag_js
	private function res_tag_js() {

		$tag = '';
		// google analitics
		if( defined( 'GOOGLE_ANALYTICS_ID' ) ) $def_google_analytics_ID = GOOGLE_ANALYTICS_ID;
		if( $this->google_analytics_ID ) $this->google_analytics_ID = $def_google_analytics_ID;
		if( $this->google_analytics_ID ) {
			$tag .= self::tb . "" . '<script async src="https://www.googletagmanager.com/gtag/js?id=' . $this->google_analytics_ID . '"></script>' . "\n";
			$tag .= self::tb . "" . '<script>' . "\n";
			$tag .= self::tb . "\t" . 'window.dataLayer = window.dataLayer || [];' . "\n";
			$tag .= self::tb . "\t" . 'function gtag(){dataLayer.push(arguments);}' . "\n";
			$tag .= self::tb . "\t" . 'gtag("js", new Date());' . "\n";
			$tag .= self::tb . "\t" . 'gtag("config", "' . $this->google_analytics_ID . '");' . "\n";
			$tag .= self::tb . "" . '</script>' . "\n";
		}
		// jquery
		$tag .= $this->jquery;
		// const
		$tag .= self::tb . "" . '<script>const PUBLICDIR = "' . PUBLICDIR . '",TAXRATE="' . TAXRATE . '";</script>' . "\n";
		// oo_lib
		$tag .= self::tb . "" . '<script src="' . $this->fpath_add_date_query( '/js/common/oo_lib.js' ) . '"></script>' . "\n";
		// preset_js < setup
		$tag .= $this->preset_js;
		// ec
		if( defined( 'ECCUBE_INSTALLED' ) && ECCUBE_INSTALLED ) {
			$tag .= self::tb . "" . '<script src="' . $this->fpath_add_date_query( '/js/common/baseec.js' ) . '"></script>' . "\n";
		}
		// base
		$tag .= self::tb . "" . '<script src="' . $this->fpath_add_date_query( '/js/common/base.js' ) . '"></script>' . "\n";
		// page js
		$tag .= $this->js;
		return $tag;
	}

	// tag_container
	private function res_tag_container() {

		if( defined( 'DIRCODE' ) && DIRCODE == 'top' ){
			$class = DIRCODE . '_container';
		} elseif( defined( 'DIRCODE' ) && defined( 'PAGECODE' ) ) {
			$class = DIRCODE . '_' . PAGECODE . '_container';
		} else {
			$class = 'no_page';
		}
		if( isset( $_GET[ 'test' ] ) ) {
			$class .= ' test_' . $_GET[ 'test' ];
		}
		$add_class_container = ( defined( 'MULTISITEBLOGNAME' ) ) ? ' ' . MULTISITEBLOGNAME : '';
		return "\t" . '<div class="' . $class . ' container' . $add_class_container . '">' . "\n";
	}

	// tag_facebook(fb-root)
	private function res_tag_facebook_script() {

		$tag = '';
		if( $this->disp_facebook_script && $this->facebook_app_id ){
			$tag .= self::tb . "" . '	<div id="fb-root"></div>' . "\n";
			$tag .= self::tb . "" . '<script async defer src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v3.2&appId=' . $this->facebook_app_id . '&autoLogAppEvents=1"></script>' . "\n";
		}
		return $tag;
	}

	// tag_twetter(script)
	private function res_tag_twetter_script() {

		$tag = '';
		if( $this->disp_twitter_script ){
			$tag .= self::tb . "" . '<script async src="https://platform.twitter.com/widgets.js"></script>' . "\n";
		}
		return $tag;
	}

	// tag_line(script)
	private function res_tag_line_script() {

		$tag = '';
		if( $this->disp_line_script ){
			$tag .= self::tb . "" . '<script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>' . "\n";
		}
		return $tag;
	}

	// tag_youtube(script)
	private function res_tag_youtube_script() {

		$tag = '';
		if( $this->disp_youtube_script ){
			$tag .= self::tb . "" . '<script src="https://apis.google.com/js/platform.js"></script>' . "\n";
		}
		return $tag;
	}

	// tag_pinterest(script)
	private function res_tag_pinterest_script() {

		$tag = '';
		if( $this->disp_pinterest_script ){
			$tag .= self::tb . "" . '<script async defer data-pin-hover="true" data-pin-lang="en" src="//assets.pinterest.com/js/pinit.js"></script>' . "\n";
		}
		return $tag;
	}

	/* parts */

	// parts : title
	private function res_parts_title( $delimiter = '｜' ) {

		$title = '';
		if( $this->title && $this->title !== 'auto' ) {
			return $this->title . $delimiter . $this->sitename;
		} elseif( defined( DIRCODE ) && DIRCODE === top ) {
			$title = $this->title ? $this->title : $this->sitename;
		} elseif( $this->pagename ) {
			return $this->pagename . $delimiter . $this->sitename;
		} else {
			return $this->sitename;
		}
	}

	// parts : url_for_wp (URL for WordPress)
	private function res_parts_url_for_wp() {

		$query = ( isset( $_SERVER[ 'QUERY_STRING' ] ) && $_SERVER[ 'QUERY_STRING' ] ) ? '?' . $_SERVER[ 'QUERY_STRING' ] : '';
		$protocol = ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] == "on" ) ? 'https://' : 'http://';
		$url_for_wp = $protocol . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'PHP_SELF' ] . $query;
		if( function_exists( 'is_home' ) && is_home() ) {
			$url_for_wp = home_url();
		} else if( function_exists( 'is_date' ) && is_date() ) {
			$url_for_wp = get_year_link( get_query_var( 'year' ) );
		} elseif( function_exists( 'get_permalink' ) ) {
			$url_for_wp = get_permalink();
		}
		return $url_for_wp;
	}
}
