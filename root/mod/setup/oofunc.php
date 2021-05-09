<?php
/*--------------------------------------------------------------

	setup

	@package	oofunc
	@author		oldoffice.com
	@since		PHP 7.4
	@ver		18.1.1

	@memo
		2021-05-05	base_mod 関数を oo_func に移動 [18.1.1]

---------------------------------------------------------------*/

##	func

	/**
	 * tax_adjust
	 *
	 * サイト内の税率対応金額を一括管理
	 */
	function tax_adjust( $price, $decimals = 0 ) {
		return number_format( floatval( $price ) * TAXRATE, $decimals );
	}

	/**
	 * user_agent
	 */
	function oo_is_pc() {
		return ( OOBASE::ua_device() === 'pc' ) ? true : false;
	}
	function oo_is_sp() {
		return ( OOBASE::ua_device() === 'sp' ) ? true : false;
	}
	function oo_is_tb() {
		return ( OOBASE::ua_device() === 'tb' ) ? true : false;
	}
	function oo_is_ie() {
		return ( OOBASE::ua_browser() === 'ie' ) ? true : false;
	}
	// switch_pc_sp ( pcのみ表示文字列 || spのみ表示文字列 )
	function oo_switch_pc_sp( $word_pc, $word_sp ){
		if( OOBASE::ua_device() === 'pc' && $word_pc ){
			return $word_pc;
		} elseif( OOBASE::ua_device() === 'sp' && $word_sp ){
			return $word_sp;
		}
	}

	/**
	 * date
	 *
	 * date, date_i18n 自動選定
	 * date_oo から ct18で名称変更
	 */
	function oo_date( $format, $timestamp = true ) {
		if( $timestamp ) {
			if( function_exists( 'date_i18n' ) ) {
				return date_i18n( $format );
			} else {
				return date( $format );
			}
		} else {
			return date( $format, $timestamp );
		}
	}
	// 時限装置
	function oo_jigen( $date, $format = 'Ymd' ) {
		return $date >= oo_date( $format ) ? true : false;
	}

