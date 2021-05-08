<?php
/***********************************************************

	日付変換クラス

	@package    changedate.class
	@author     oldoffice.com
	@since      PHP 5.2
	@ver        2.1.1

	@memo
		2011-05-17 公開用に加筆
		2015-05-27

***********************************************************/

class change_date {

	public $debug_report;

	public  $timestamp;
	public  $changed_date;

	private $enc;
	private $ja_almanac_arr;
	private $change_str_arr;
	private $week_arr;
	private $str;

	### constructor
	function __construct( $format ) {

		// エンコード
		$this->enc = 'UTF-8';

		// 和暦指定 *元号は下に追加
		$this->ja_almanac_arr = [
			[ "明治", "M", '1868' ],
			[ "大正", "T", '1912' ],
			[ "昭和", "S", '1926' ],
			[ "平成", "H", '1989' ]
		];

		// 変換文字
		$this->change_str_arr = [
			"明治" => "M",
			"大正" => "T",
			"昭和" => "S",
			"平成" => "H",
			'年' => "/",
			'月' => "/",
			'日' => "",
			'.' => "/",
			'／' => "/",
			'-' => "/",
			'&#24180;' => "/",
			'&#26376;' => "/",
			'&#26085;' => ""
		];

		// 曜日
		$this->week_arr = [ '日', '月', '火', '水', '木', '金', '土' ];

		// 出力フォーマット
		$this->format = $format;
	}

	### 1バイト変換
	private function change_one_byte() {

		$this->str = mb_convert_kana( $this->str, 'n', $this->enc ); // 全角数字を半角に変換し､指定文字コードを返す
		$this->str = strtr( $this->str, $this->change_str_arr ); // 区切り文字をすべて1バイト文字に変換
		for( $i = 0; $i < count( $this->ja_almanac_arr ); $i++ ) { // 和暦の場合西暦へ整形
			if( substr( $this->str, 0, 1 ) == $this->ja_almanac_arr[$i][1] ) {
				$ja_str = substr( $this->str, 1 );
				$check_num = strspn( $ja_str, '0123456789' );
				$en_str = substr( $ja_str, 0, $check_num )+$this->ja_almanac_arr[$i][2]-1;
				$this->str = $en_str.substr( $this->str, ( $check_num+1 ) );
			}
		}
	}

	### 西暦の省略形を整形
	private function change_en_almanac() {

		$check_num = strspn( $this->str, '0123456789' );
		if( $check_num < 4 ) {
			$this->str = substr( '200', 0, ( 4 - $check_num ) ).$this->str;
		}
	}

	### 全形式を統一日付データ（/区切り）へ変換
	private function change_common_format() {

		$check_str = strtr( $this->str, [ '/'=>'' ] );
		if( strlen( $check_str ) == 4 ) {
			$this->str = $check_str.'/01/01';
		} elseif( strlen( $check_str ) >= 8 ) {
			$this->str = substr( $check_str, 0, 4 ).'/'.substr( $check_str, 4, 2 ).'/'.substr( $check_str, 6, 2 );
		} elseif( substr( $this->str, -1 ) == '/' ) {
			$this->str = $this->str.'01';
		} else {
			return;
		}
	}

	### タイムスタンプへ変換
	private function change_timestamp() {

		$this->timestamp = strtotime( $this->str );
	}

	### 出力日付を作成
	public function res_date( $date_str ) {

		$this->str = $date_str;
		$this->change_one_byte();
		$this->change_en_almanac();
		$this->change_common_format();
		$this->change_timestamp();

		/* タイムスタンプを配列に格納＆ロケール情報に変換 */
		$date_arr = getdate( $this->timestamp );
		setlocale( LC_TIME, 'ja_JP.UTF-8' );

		/* 各フォーマットの値 */
		$yyyy = $date_arr[ 'year' ];
		$yy = substr( $date_arr[ 'year' ], -2 );
		for( $i = 0; $i < count( $this->ja_almanac_arr ); $i++ ) { // 和暦生成
			if( $yyyy > $this->ja_almanac_arr[ $i ][ 2 ] ) {
				$YY = $this->ja_almanac_arr[ $i ][ 0 ].( $yyyy-$this->ja_almanac_arr[ $i ][ 2 ] + 1 );
				$Y = $this->ja_almanac_arr[ $i ][ 1 ].( $yyyy-$this->ja_almanac_arr[ $i ][ 2 ] + 1 );
			}
		}
		$mm       = strftime( '%m', $this->timestamp );
		$m        = $date_arr[ 'mon' ];
		$MM       = $date_arr[ 'month' ];
		$M        = substr( $date_arr[ 'month' ], 0, 3 );
		$dd       = strftime( '%d', $this->timestamp );
		$d        = $date_arr[ 'mday' ];
		$ww       = $date_arr[ 'weekday' ];
		$w        = substr( $date_arr[ 'weekday' ], 0, 3 );
		$week_num = $date_arr[ 'wday' ]; // 曜日生成
		$W        = $this->week_arr[ $week_num ];

		/* フォーマット置換配列 */
		$format_arr = [
			'yyyy' => $yyyy,
			'yy'   => $yy,
			'YY'   => $YY,
			'Y'    => $Y,
			'mm'   => $mm,
			'm'    => $m,
			'MM'   => $MM,
			'M'    => $M,
			'dd'   => $dd,
			'd'    => $d,
			'ww'   => $ww,
			'w'    => $w,
			'W'    => $W
		];

/******* reference *********************************************************************************

	[ $format_arr : sample ]

			yyyy = 2008;
			yy   = 08;
			YY   = 平成20;
			Y    = H20;
			mm   = 07;
			m    = 7;
			MM   = July;
			M    = Jul;
			dd   = 06;
			d    = 6;
			ww   = Friday;
			w    = Fri;
			W    = 金

******************************************************************************************************/

		$this->changed_date = strtr( $this->format, $format_arr );
		return $this->changed_date;
	}
}

