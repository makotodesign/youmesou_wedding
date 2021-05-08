<?php
/**************************************************************************
 *
 * calendar.class
 * 		カレンダー クラス（拡張用 編集可）
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.1
 *
 * @history
 * 		2018-06-08	ct11にあわせて新規作成 N [ 11.1.1 ]
 * 					・tdの中をカスタマイズできる機能を追加 ※ calendar.class_ex.php を使用
 *
 * @readme
 * 		使用する場合はcontentsに移動
 *
 * *************************************************************************/

if( ! class_exists ( 'calendar' ) ) {
	include_once ROOTREALPATH . '/mod/lib/calendar.class.php';
}

class calendar_ex extends calendar {

	// disp_td_monthly : for_extends
	public function disp_td_monthly( $day_arr = 'null' ) {

		/*
			memo（カスタマイズ個所）
			・class追記
			・attr追記
		*/
		$add_class = ( isset( $day_arr[ 'add_class' ] ) ) ? parent::adjust_class_tag( $day_arr[ 'add_class' ] ) :  '';
		$add_class .= ''; // サイト毎にカスタマイズ
		$date = $day_arr === 'null' ? '&nbsp;' : $day_arr[ 'day' ];
		$add_attr = ''; // サイト毎にカスタマイズ
		$tag = $this->tb . "\t\t" . '<td' . $add_class . $add_attr . '>' . $date . '</td>' . "\n"; // サイト毎にカスタマイズ
		return $tag;
	}

	// disp_tr_tate : for_extends
	public function disp_tr_tate( $day_arr = [] ) {

		/*
			memo（カスタマイズ個所）
			・event,holidayがあるときだけ表示
		*/
		$tag = '';
		if( ( isset( $day_arr[ 'event_name' ] ) && $day_arr[ 'event_name' ] ) || ( isset( $day_arr[ 'holiday' ] ) && $day_arr[ 'holiday' ] ) ) {
			$add_class = ( isset( $day_arr[ 'add_class' ] ) ) ? parent::adjust_class_tag( $day_arr[ 'add_class' ] ) :  '';
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
		}
		return $tag;
	}
}