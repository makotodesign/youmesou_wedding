<?php
/*************************************************************************

	基本モジュールクラス

	@package	oobase.class（ < base.class ）
		base
			sanitize_server_request
			results_ua_mode
			results_ua_browser
	@author		oldoffice.com
	@since		PHP 7.3
	@ver		18.1.1

	@memo
		2015-03-05	新規制作N[1.1.1]
		2019-10-18	ENV 統合[14.1.1]
		2021-05-05	全て制的メソッドに変更
					名称を oobase.class に変更

**************************************************************************/

class OOBASE {

	/**
	 * sanitize_server_request(ヌルバイトの除去・タグの除去)
	 */
	public static function sanitize_server_request( $sanitized ) {
		if( is_array( $sanitized) ) {
			return array_map( [ 'oobase', 'sanitize_server_request' ], $sanitized );
		}
		// nullバイト除去
		$sanitized = str_replace( "\0", '', $sanitized );
		// [magic_quotes_gpc = On] => エスケープ解除
		$sanitized = stripslashes( $sanitized );
		// タグ除去
		$sanitized = htmlspecialchars( $sanitized, ENT_QUOTES );
		$sanitized = mb_convert_kana( $sanitized, 'KV', 'UTF-8' );
		return $sanitized;
	}

	/**
	 * $_SERVER[ 'HTTP_USER_AGENT' ] より device判定
	 */
	public static function ua_device() {

		$ua_device = '';
		// sp
		if(
			self::ua_check( 'iPhone' )
			||
			self::ua_check( 'iPod' )
			||
			( self::ua_check( 'Android' ) && self::ua_check( 'Mobile' ) )
			||
			( self::ua_check( 'Windows' ) && self::ua_check( 'Phone' ) )
			||
			( self::ua_check( 'Firefox' ) && self::ua_check( 'Mobile' ) )
			||
			self::ua_check( 'BlackBerry' )
		 ) {
			$ua_device = 'sp';
		// tb
		} elseif (
			self::ua_check( 'iPad' )
			||
			( self::ua_check( 'Windows' ) && self::ua_check( 'Touch' ) && self::ua_check( 'Tablet PC', false ) )
			||
			( self::ua_check( 'android' ) && self::ua_check( 'Mobile', false ) )
			||
			( self::ua_check( 'Firefox' ) && self::ua_check( 'Tablet' ) )
			||
			( self::ua_check( 'Kindle' ) || self::ua_check( 'Silk' ) )
			||
			self::ua_check( 'Playbook' )
		) {
			$ua_device = 'tb';
		// pc
		} else {
			$ua_device = 'pc';
		}
		return $ua_device;
	}

	/**
	 * $_SERVER[ 'HTTP_USER_AGENT' ] より ie edge判定
	 */
	public static function ua_browser() {

		$ua_browser = '';
		// ie
		if(  self::ua_check( 'MSIE' ) || self::ua_check( 'Trident' ) ) {
			$ua_browser = 'ie';
		}
		// edge
		if(  self::ua_check( 'Edge' ) ) {
			$ua_browser = 'edge';
		}
	}

	/**
	 * $_SERVER[ 'HTTP_USER_AGENT' ] より ieバージョン判定
	 */
	public static function ua_ie_version() {

		$ua_ie_version = '';

		/* ie6 - 9 */
		if( self::ua_check( 'MSIE' ) && self::ua_check( '6' ) ) {
			$ua_ie_version = '6';
		} else if( self::ua_check( 'MSIE' ) && self::ua_check( '7' ) ) {
			$ua_ie_version = '7';
		} else if( self::ua_check( 'MSIE' ) && self::ua_check( '8' ) ) {
			$ua_ie_version = '8';
		} else if( self::ua_check( 'MSIE' ) && self::ua_check( '9' ) ) {
			$ua_ie_version = '9';
		}
	}

	private static function res_pattern( $arr ) {
		return '/' . implode( '|', $arr ) . '/i';
	}

	private static function ua_check( $str, $bool = true ) {
		$user_agent = $_SERVER[ 'HTTP_USER_AGENT' ];
		if( $bool ) {
			if( strpos( $user_agent, $str ) !== false ) {
				return true;
			} else {
				return false;
			}
		} else {
			if( strpos( $user_agent, $str ) === false ) {
				return true;
			} else {
				return false;
			}
		}
	}
}

