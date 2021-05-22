<?php
/***********************************************************

	日付変換クラス

	@package    changewareki.class
	@author     oldoffice.com
	@since      PHP 7.4
	@ver        18.1.1

	@memo
		2011-05-17 公開用に加筆
		2015-05-27
		2021-05-22 changedate 撤廃 changewareki に変更[18.1.1]

***********************************************************/

class changewareki {

	const WAREKI = [
		'meiji' => [
			'kanji'    => '明治',
			'alphabet' => 'M',
			'Y'        => '1868',
			'm'        => '10',
			'd'        => '23'
		],
		'taisho' => [
			'kanji'    => '大正',
			'alphabet' => 'T',
			'Y'        => '1912',
			'm'        => '07',
			'd'        => '30'
		],
		'showa' => [
			'kanji'    => '昭和',
			'alphabet' => 'S',
			'Y'        => '1926',
			'm'        => '12',
			'd'        => '25'
		],
		'heisei' => [
			'kanji'    => '平成',
			'alphabet' => 'H',
			'Y'        => '1989',
			'm'        => '01',
			'd'        => '08'
		],
		'reiwa' => [
			'kanji'    => '令和',
			'alphabet' => 'R',
			'Y'        => '2019',
			'm'        => '05',
			'd'        => '01'
		]
	];

	public static function date_to_wareki( string $date, string $add_date_format = '年n月j日', string $wareki_format = 'kanji' ) : string {

		$Ymd     = intval( date( 'Ymd', strtotime( $date ) ) );
		$Y       = intval( date( 'Y', strtotime( $date ) ) );
		$add_nj  = date( $add_date_format, strtotime( $date ) );
		if( ! in_array( $wareki_format, [ 'kanji', 'alphabet' ] ) ){
			return 'format_error';
		}
		$res     = '';
		if( $Ymd > self::gengou_to_Ymd( 'reiwa' ) ) {
			$res = self::WAREKI[ 'reiwa' ][ $wareki_format ];
			$Y   = $Y - intval( self::WAREKI[ 'reiwa' ][ 'Y' ] ) + 1;
		} elseif( $Ymd > self::gengou_to_Ymd( 'heisei' ) ) {
			$res = self::WAREKI[ 'heisei' ][ $wareki_format ];
			$Y   = $Y - intval( self::WAREKI[ 'heisei' ][ 'Y' ] ) + 1;
		} elseif( $Ymd > self::gengou_to_Ymd( 'showa' ) ) {
			$res = self::WAREKI[ 'showa' ][ $wareki_format ];
			$Y   = $Y - intval( self::WAREKI[ 'showa' ][ 'Y' ] ) + 1;
		} elseif( $Ymd > self::gengou_to_Ymd( 'taisho' ) ) {
			$res = self::WAREKI[ 'taisho' ][ $wareki_format ];
			$Y   = $Y - intval( self::WAREKI[ 'taisho' ][ 'Y' ] ) + 1;
		} elseif( $Ymd > self::gengou_to_Ymd( 'meiji' ) ) {
			$res = self::WAREKI[ 'meiji' ][ $wareki_format ];
			$Y   = $Y - intval( self::WAREKI[ 'meiji' ][ 'Y' ] ) + 1;
		} else {
			return 'before_meiji';
		}
		return $res . $Y . $add_nj;
	}

	private static function gengou_to_Ymd( string $gengou ) : int {
		if( in_array( $gengou, array_keys( self::WAREKI ) ) ) {
			return intval( self::WAREKI[ $gengou ][ 'Y' ] . self::WAREKI[ $gengou ][ 'm' ] . self::WAREKI[ $gengou ][ 'd' ] );
		} else {
			return 0;
		}
	}
}

