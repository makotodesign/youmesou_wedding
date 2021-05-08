<?php
/**************************************************************************
 *
 * calendar.class
 * 		カレンダー クラス
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		5.6
 * @version
 * 		11.1.1
 *
 * @history
 * 		2012-10-09 新規作成
 * 		2013-12-10 引数[ $w_check_date ] を追加。毎週の定休日設定。date( 'w' ) で入力。
 * 		2014-10-02 引数[ $check_date ]の配列対応。 '付与するclass' => '日' にて複数指定可能。
 * 				   引数[ $start_monday ]を追加。 bool型 trueで月曜始まりのカレンダーに。
 * 		2015-02-04 自動で[ past ][ holiday ]が追加されるように変更 K
 * 		---
 * 		2015-03-13 全体コードの見直し N ※使用法はこれまでと同じ[ver2]
 * 		---
 * 		2015-09-02 全体コードの見直し N ※刷新[ver3]
 * 		2015-10-08 全体コードの見直し N ※刷新[ver3.2.1]
 * 		2016-06-28 addclassの不具合修正 N [3.2.2]
 * 		2016-06-28 varの不具合修正/addclassの不具合修正 N [3.2.3]
 * 		2017-01-31 weeklyでtodayスタート機能追加 N [3.2.4]
 * 		2017-07-27 その他のチェックが反映される機能追加 N [3.2.5]
 * 		2018-06-08 ct11にあわせてバージョンアップ N [ 11.1.1 ]
 * 		           ・tdの中をカスタマイズできる機能を追加 ※ calendar.class_ex.php を使用
 * 		           ・祝日の自動取得
 *
 * *************************************************************************/

class calendar {

	public    $tb              = "\t\t\t\t\t\t\t\t";
	public    $table_class     = 'calendar_table';
	public    $start_wday      = 'sunday';
	public    $holiday_arr;

	public    $close_date      = '';                 // カンマ区切りの日付 例）'1,12,25'
	public    $close_wday      = '';                 // カンマ区切りの曜日 ※数値で示す曜日（0：日 ～ 6：土）
	public    $open_date       = '';                 // カンマ区切りの日付 例）'1,12,25'
	public    $check_date      = '';                 // カンマ区切りの日付 例）'1,12,25'

	public    $the_type        = 'monthly';
	public    $the_year;
	public    $the_month;
	public    $the_start_day_wday_num;
	public    $the_last_day;
	public    $the_last_day_wday_num;

	private   $today_year;
	private   $today_month;
	private   $today_day;
	private   $today_wday_num;
	private   $today_timestump;
	private   $today_date_id;
	private   $this_last_day;

	const     week_class_arr  = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];
	const     week_name_arr   = [ '日', '月', '火', '水', '木', '金', '土' ];

	### constructor

	function __construct() {
		$this->holiday_arr     = $this->japan_holiday();

		// today_data
		$this->today_year      = date( 'Y' );        // 4桁 year
		$this->today_month     = date( 'm' );        // 2桁 month
		$this->today_day       = date( 'd' );        // 2桁 day
		$this->today_wday_num  = date( 'w' );        // 数値で示す曜日（0：日 ～ 6：土）
		$this->today_timestump = date( 'U' );        // タイムスタンプ
		$this->today_date_id   = date( 'Ymd' );      // 8桁 日付
		$this->this_last_day   = date( 't' );        // 今月の最終日(28～31)
	}

	### public function

	/* results_calendar_array */

	public function results_calendar_array( $type = 'monthly', $arg_timestamp = '', $prev_next = 0 ) {

		$res_arr = [];
		$arg_timestamp = empty( $arg_timestamp ) ? time() : $arg_timestamp;

		// monthly, weekly で $start_day_timestamp, $arr_lengthを取得
		if( $type === 'monthly' ) {
			$start_day_timestamp = mktime( 0, 0, 0, date( 'n', $arg_timestamp ) + $prev_next, 1, date( 'Y', $arg_timestamp ) );
			// update : $this->the_year, $this->the_month
			$this->the_year               = date( 'Y', $start_day_timestamp ); // 4桁 year
			$this->the_month              = date( 'n', $start_day_timestamp ); // 1or2桁 month
			$this->the_type               = $type;                             // monthly or weekly
			// update : $this->the_last_day, $this->the_start_day_wday_num, $this->the_last_day_wday_num
			$this->the_last_day           = intval( date( 't', $start_day_timestamp ) );
			$this->the_start_day_wday_num = date( 'w', $start_day_timestamp ); // 数値で示す曜日（0：日 ～ 6：土）
			$this->the_last_day_wday_num  = date( 'w', mktime( 0, 0, 0, $this->the_month, $this->the_last_day, $this->the_year ) );
			// res
			$this->the_type               = $type;                             // monthly or weekly
			$arr_length = $this->the_last_day;
			// disp_calendar( monthly ) に引き継ぐ情報
			$res_arr[ 'base_info' ] = [
				'the_year'               => $this->the_year,
				'the_month'              => $this->the_month,
				'the_last_day'           => $this->the_last_day,
				'the_start_day_wday_num' => $this->the_start_day_wday_num,
				'the_last_day_wday_num'  => $this->the_last_day_wday_num
			];
		} elseif( $type === 'weekly' ) {
			if( $this->start_wday === 'monday' ) {
				$adjust_num_sunday = ( $this->today_wday_num == 0 ) ? 7 : 0 ;
				$start_day_timestamp = mktime( 0, 0, 0, date( 'n' ), date( 'j' ) - $this->today_wday_num + ( $prev_next * 7 ) - $adjust_num_sunday + 1, date( 'Y' ) );
			} elseif( $this->start_wday === 'today' ) {
				$start_day_timestamp = mktime( 0, 0, 0, date( 'n' ), date( 'j' ), date( 'Y' ) );
			} else {
				$start_day_timestamp = mktime( 0, 0, 0, date( 'n' ), date( 'j' ) - $this->today_wday_num + ( $prev_next * 7 ), date( 'Y' ) );
			}
			// res
			$this->the_type               = $type;
			$arr_length = 7;
			// disp_calendar( tate ) に引き継ぐ情報
			$res_arr[ 'base_info' ] = [];
		}
		// create_array
		$arr = [];
		for( $i = 0; $i < $arr_length; $i++ ) {
			$timestamp = strtotime( '+' . $i . ' day', $start_day_timestamp );
			$day_id = date( 'Ymd', $timestamp );
			// timestamp,common_data
			$arr[ $day_id ][ 'timestamp' ]  = $timestamp;
			$arr[ $day_id ][ 'year' ]       = date( 'Y', $timestamp );
			$arr[ $day_id ][ 'month' ]      = date( 'n', $timestamp );
			$arr[ $day_id ][ 'day' ]        = date( 'j', $timestamp );
			$arr[ $day_id ][ 'wday' ]       = date( 'w', $timestamp );
			$arr[ $day_id ][ 'wday_class' ] = self::week_class_arr[ date( 'w', $timestamp ) ];
			$arr[ $day_id ][ 'wday_name' ]  = self::week_name_arr[ date( 'w', $timestamp ) ];
			// timeline
			if( $day_id == $this->today_date_id ) {
				$arr[ $day_id ][ 'timeline' ]     = 'today';
			} elseif( $day_id < $this->today_date_id ) {
				$arr[ $day_id ][ 'timeline' ]     = 'past';
			} else {
				$arr[ $day_id ][ 'timeline' ]     = 'future';
			}
			// wday
			$arr[ $day_id ][ 'wday' ]             = self::week_class_arr[ date( 'w', $timestamp ) ];
			// holiday
			if( isset( $this->holiday_arr[ $day_id ] ) ) {
				$arr[ $day_id ][ 'holiday' ]      = true;
				$arr[ $day_id ][ 'holiday_name' ] = $this->holiday_arr[ $day_id ];
			} else {
				$arr[ $day_id ][ 'holiday' ]      = false;
				$arr[ $day_id ][ 'holiday_name' ] = '';
			}
			// close
			$close_day_arr  = explode( ',', $this->close_date ); // 指定休業日
			$close_wday_arr = explode( ',', $this->close_wday ); // 定休日：曜日
			if( in_array( date( 'j', $timestamp ), $close_day_arr ) ){
				$arr[ $day_id ][ 'close' ]        = true;
			} elseif( in_array( date( 'w', $timestamp ), $close_wday_arr ) ) {
				$arr[ $day_id ][ 'close' ]        = true;
			} else {
				$arr[ $day_id ][ 'close' ]        = false;
			}
			// open *over_write_close
			$open_day_arr  = explode( ',', $this->open_date ); // 臨時営業日 *close消去
			if( in_array( date( 'j', $timestamp ), $open_day_arr ) ){
				$arr[ $day_id ][ 'close' ]        = false;
			}
			// check
			$check_day_arr  = explode( ',', $this->check_date ); // その他のチェック
			if( in_array( date( 'j', $timestamp ), $check_day_arr ) ){
				$arr[ $day_id ][ 'check' ]        = true;
			} else {
				$arr[ $day_id ][ 'check' ]        = false;
			}
			// add_class
			$add_class = '';
			$add_class .= $arr[ $day_id ][ 'wday_class' ];                    // wday_name
			$add_class .= ' ' . $arr[ $day_id ][ 'timeline' ];               // past/today/future
			$add_class .= ( $arr[ $day_id ][ 'holiday' ] ) ? ' holiday' : ''; // holiday
			$add_class .= ( $arr[ $day_id ][ 'close' ] ) ? ' close' : '';     // holiday
			$add_class .= ( $arr[ $day_id ][ 'check' ] ) ? ' check' : '';     // holiday
			$arr[ $day_id ][ 'add_class' ] = $add_class;
		}
		ksort( $arr, SORT_NUMERIC );
		$res_arr['calendar'] = $arr;
		return $res_arr;
	}

	/* disp_calendar */

	public function disp_calendar( $calendar_arr = [] ) {

		switch( $this->the_type ) {
			case 'monthly':
				return $this->disp_monthly_calendar( $calendar_arr );
				break;
			case 'monthly_tate':
			case 'weekly':
			case 'tate':
				return $this->disp_tate_calendar( $calendar_arr );
				break;
			default:
				return 'error';
		}
	}

	### private function

	/* monthly_calendar */

	private function disp_monthly_calendar( $arr ) {

		// table class
		$table_class = self::adjust_class_tag( $this->table_class );

		// tag_00
		$tag = '';
		$tag .= $this->tb . "" . '<table' . $table_class . '>' . "\n";
		$tag .= $this->tb . "\t" . '<tr>' . "\n";
		if( $this->start_wday === 'sunday' ){
			$tag .= $this->tb . "\t\t" . '<th class="' . self::week_class_arr[ 0 ] . '">日</th><th class="' . self::week_class_arr[ 1 ] . '">月</th><th class="' . self::week_class_arr[ 2 ] . '">火</th><th class="' . self::week_class_arr[ 3 ] . '">水</th><th class="' . self::week_class_arr[ 4 ] . '">木</th><th class="' . self::week_class_arr[ 5 ] . '">金</th><th class="' . self::week_class_arr[ 6 ] . '">土</th>' . "\n";
		} else {
			$tag .= $this->tb . "\t\t" . '<th class="' . self::week_class_arr[ 1 ] . '">月</th><th class="' . self::week_class_arr[ 2 ] . '">火</th><th class="' . self::week_class_arr[ 3 ] . '">水</th><th class="' . self::week_class_arr[ 4 ] . '">木</th><th class="' . self::week_class_arr[ 5 ] . '">金</th><th class="' . self::week_class_arr[ 6 ] . '">土</th><th class="' . self::week_class_arr[ 0 ] . '">日</th>' . "\n";
		}
		$tag .= $this->tb . "\t" . '</tr>' . "\n";
		// tag_01
		$tag .= $this->tb . "\t" . '<tr>' . "\n";
		if( $this->start_wday === 'sunday' ){
			$add_null_cell_num = $arr[ 'base_info' ][ 'the_start_day_wday_num' ];
		} else {
			$add_null_cell_num = ( $arr[ 'base_info' ][ 'the_start_day_wday_num' ] == 0 ) ? 6 : $arr[ 'base_info' ][ 'the_start_day_wday_num' ] - 1;
		}
		$tag .= $this->disp_null_cell_monthly( $add_null_cell_num ); // 月先頭の空白セル
		// tag_02
		$calendar_arr = isset(  $arr[ 'calendar' ] ) ?  $arr[ 'calendar' ] : [];
		foreach( $calendar_arr as $k => $v ) {
			// td
			$tag .= $this->disp_td_monthly( $v );
			// tr_glue
			if( $this->start_wday === 'sunday' && $v[ 'wday' ] === 'saturday' && $v[ 'day' ] != $arr[ 'base_info' ][ 'the_last_day' ] ){
				$tag .= "\n";
				$tag .= $this->tb . "\t" . '</tr>' . "\n";
				$tag .= $this->tb . "\t" . '<tr>' . "\n";
			} elseif( $this->start_wday === 'monday' && $v[ 'wday' ] === 'sunday' && $v[ 'day' ] != $arr[ 'base_info' ][ 'the_last_day' ] ) {
				$tag .= "\n";
				$tag .= $this->tb . "\t" . '</tr>' . "\n";
				$tag .= $this->tb . "\t" . '<tr>' . "\n";
			}
		}
		// tag_03
		if( $this->start_wday === 'sunday' ){
			$add_null_cell_num = 6 - $arr[ 'base_info' ][ 'the_last_day_wday_num' ];
		} else { // monday
			$add_null_cell_num = ( $arr[ 'base_info' ][ 'the_last_day_wday_num' ] == 0 ) ? 0 : 7 - $arr[ 'base_info' ][ 'the_last_day_wday_num' ];
		}
		$tag .= $this->disp_null_cell_monthly( $add_null_cell_num ); // 月最後の空白セル
		$tag .=  "\n";
		$tag .=  $this->tb . "\t" . '</tr>' . "\n";
		$tag .= $this->tb . "" . '</table>' . "\n";

		return $tag;
	}

	// disp_null_cell_monthly
	private function disp_null_cell_monthly( $n ) {
		$tag = $this->disp_td_monthly( 'null' ); // サイト毎にカスタマイズ
		return str_repeat( $tag , $n );
	}

	// disp_td_monthly : for_extends
	public function disp_td_monthly( $day_arr = 'null' ) {
		$add_class = ( isset( $day_arr[ 'add_class' ] ) ) ? self::adjust_class_tag( $day_arr[ 'add_class' ] ) :  '';
		$date = $day_arr === 'null' ? '&nbsp;' : $day_arr[ 'day' ];
		$tag = $this->tb . "\t\t" . '<td' . $add_class . '>' . $date . '</td>' . "\n"; // サイト毎にカスタマイズ
		return $tag;
	}

	/* tate_calendar */

	private function disp_tate_calendar( $arr ) {

		$table_class = self::adjust_class_tag( $this->table_class );

		$tag = '';
		$tag .= $this->tb . "" . '<table' . $table_class . '>' . "\n";
		$calendar_arr = isset(  $arr[ 'calendar' ] ) ?  $arr[ 'calendar' ] : [];
		foreach( $calendar_arr as $k => $v ) {
			$add_class    = self::adjust_class_tag( $v[ 'add_class' ] );
			$month        = isset( $v[ 'month' ] )        ? $v[ 'month' ]                                : 0;
			$day          = isset( $v[ 'day' ] )          ? $v[ 'day' ]                                  : 0;
			$wday_name    = isset( $v[ 'wday_name' ] )    ? $v[ 'wday_name' ]                            : '-';
			$event_name   = isset( $v[ 'event_name' ] )   ? $v[ 'event_name' ]                           : '';
			$holiday      = isset( $v[ 'holiday' ] )      ? $v[ 'holiday' ]                              : false;
			$holiday_name = isset( $v[ 'holiday_name' ] ) ? $v[ 'holiday_name' ]                         : '';
			$tag .= $this->disp_tr_tate( $v );
		}
		$tag .= $this->tb . "" . '</table>' . "\n";

		return $tag;
	}

	// disp_tr_tate : for_extends
	public function disp_tr_tate( $day_arr = [] ) {

		$add_class = ( isset( $day_arr[ 'add_class' ] ) ) ? self::adjust_class_tag( $day_arr[ 'add_class' ] ) :  '';
		$tag = '';
		$tag .= $this->tb . "\t" . '<tr' . $add_class . '>' . "\n";
		$tag .= $this->tb . "\t\t" . '<th>' . $day_arr[ 'month' ] . '/' . $day_arr[ 'day' ] . ' (' . $day_arr[ 'wday_name' ] . ')</th>' . "\n";
		$tag .= $this->tb . "\t\t" . '<td>' . "\n";
		if( ( isset( $day_arr[ 'event_name' ] ) && $day_arr[ 'event_name' ] ) || ( isset( $day_arr[ 'holiday' ] ) && $day_arr[ 'holiday' ] ) ) {
			if( $day_arr[ 'event_name' ] ) {
				$tag .= $day_arr[ 'event_name' ] ? $this->tb . "\t\t" . '<p>' . $day_arr[ 'event_name' ] . '</p>' . "\n" : '';
			}
			if( $day_arr[ 'holiday_name' ] ) {
				$tag .= $day_arr[ 'holiday_name' ] ? $this->tb . "\t\t" . '<p>' . $day_arr[ 'holiday_name' ] . '</p>' . "\n" : '';
			}
		} else {
			$tag .= $this->tb . "\t\t" . '<p>&nbsp;</p>' . "\n";
		}
		$tag .= $this->tb . "\t\t" . '</td>' . "\n";
		$tag .= $this->tb . "\t" . '</tr>' . "\n";
		return $tag;
	}

	/* japan_holiday */

	public function japan_holiday() {

		$json = file_get_contents( 'https://holidays-jp.github.io/api/v1/date.json' );
		$temp_holiday_arr = json_decode( $json, true );
		$temp_holiday_arr = ( is_null( $temp_holiday_arr ) ) ? false : $temp_holiday_arr;

		$res_arr = [];
		if( $temp_holiday_arr ) {
			foreach( $temp_holiday_arr as $k => $v ) {
				$k = str_replace( '-', '', $k );
				$res_arr[ $k ] = $v;
			}
		}
		return $res_arr;
	}

	### module

	private function start_day_timestamp_weekly( $prev_next ) {

		if( $this->start_wday === 'monday' ) {
			$adjust_num_sunday = ( $this->today_wday_num == 0 ) ? 7 : 0 ;
			$start_day_timestamp = mktime( 0, 0, 0, date( 'n' ), date( 'j' ) - $this->today_wday_num + ( $prev_next * 7 ) - $adjust_num_sunday + 1, date( 'Y' ) );
		} elseif( $this->start_wday === 'today' ) {
			$start_day_timestamp = mktime( 0, 0, 0, date( 'n' ), date( 'j' ), date( 'Y' ) );
		} else {
			$start_day_timestamp = mktime( 0, 0, 0, date( 'n' ), date( 'j' ) - $this->today_wday_num + ( $prev_next * 7 ), date( 'Y' ) );
		}

		return $start_day_timestamp;
	}

	private static function last_day( $m, $Y ) {
		return date( "j", mktime( 0, 0, 0, $m + 1, 0, $Y ) );
	}

	protected static function adjust_class_tag( $arg = '' ) {
		if( is_array( $arg ) ){
			$tag = $arg ? ' class="' . implode( ' ', $arg ) . '"' : '';
		} else {
			$tag = $arg ? ' class="' . $arg . '"' : '';
		}
		return $tag;
	}
}

