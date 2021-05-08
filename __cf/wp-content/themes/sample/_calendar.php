<?php
/*--------------------------------------------------------------------------

	Template Name: php_calendar

	@memo

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME = 'カレンダークラス';
	$DIRNAME = 'PHPデモ';
	define( 'DIRCODE', 'phpdemo' );
	define( 'PAGECODE', 'calendar' );

	/* realpath & includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
//	include_once ROOTREALPATH . '/00_stock/mod/contents/sample_php_callendar_mod.php';

	/* css */
	$HEAD->css = '';
	$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . PUBLICDIR . '/css/utility/calendar.css" media="all">' . "\n";

	/* js */
	$HEAD->js .= "\t" . '<script>' . "\n";
	$HEAD->js .= "\t\t" . 'jQuery( function($) {' . "\n";
	$HEAD->js .= "\t\t\t" . '$("a").click(function(){return false;});' . "\n";
	$HEAD->js .= "\t\t" . '});' . "\n";
	$HEAD->js .= "\t" . '</script>' . "\n";

	/* page_option ( over write ) : title / meta / h1 / og_cullent_img */
	$HEAD->title = '';
	$HEAD->meta_description = '';
	$HEAD->back_navi_url = '/';

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/data/includes/header_mod.php';

/*---------------------------------------------------------------------------*/
?>
<?php

/*--------------------------------------------------------------

	name

	@memo

---------------------------------------------------------------*/

##	base

	/* class */
	// calendar
	include_once ROOTREALPATH . '/mod/lib/calendar.class_ex.php';
	$CAL = new calendar();
	$CALEX = new calendar_ex();

##	tag

	/* holidays */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t\t";
	$arr = $CAL->japan_holiday();

	foreach( $arr as $k => $v ) {
		$tag .= $tb . "" . '<dt>' . $k . '</dt>' . "\n";
		$tag .= $tb . "" . '<dd>' . $v . '</dd>' . "\n";
	}
	$tag_holidays = $tag;

	/* disp table */
	/* 01 今月・前月・来月のカレンダー */
	$timestamp = time();
	$calendar_arr = $CAL->results_calendar_array( 'monthly', $timestamp, 0 ); // arg01:type(monthly/weekly), arg02:timestamp, arg03:prev_next(-1,0,1,2,...) 関数実行でthe_year,the_month設定
//print '$calendar_arr'.'：';var_dump($calendar_arr);print '<br>'."\n";
	$CAL->the_type = 'monthly';
	$CAL->table_class = 'calendar_table calendar_column7';
	$tag_table_01 = $CAL->disp_calendar( $calendar_arr );
	$yyyy_01 = $CAL->the_year;
	$mm_01 = $CAL->the_month;
	// prev
	$calendar_arr = $CAL->results_calendar_array( 'monthly', $timestamp, -1 );
//print '$calendar_arr'.'：';var_dump($calendar_arr);print '<br>'."\n";
	$tag_table_01_prev = $CAL->disp_calendar( $calendar_arr);
	$yyyy_01_prev = $CAL->the_year;
	$mm_01_prev = $CAL->the_month;
	// next
	$calendar_arr = $CAL->results_calendar_array( 'monthly', $timestamp, 1 );
//print '$calendar_arr'.'：';var_dump($calendar_arr);print '<br>'."\n";
	$tag_table_01_next = $CAL->disp_calendar( $calendar_arr);
	$yyyy_01_next = $CAL->the_year;
	$mm_01_next = $CAL->the_month;

	/* 02 指定月のカレンダー */
	//tag
	$temp_year  = 2018;
	$temp_month = 9;
	$timestamp = mktime( 0, 0, 0, $temp_month, 1, $temp_year );
	$calendar_arr = $CAL->results_calendar_array( 'monthly', $timestamp, 0 );
	$tag_table_02 = $CAL->disp_calendar( $calendar_arr);
	$yyyy_02 = $CAL->the_year;
	$mm_02 = $CAL->the_month;

	/* 03 カレンダーの設定 */
	// tdカスタマイズ
	//tag
	$CALEX->start_wday = 'monday';          // 月曜スタート ※一度設定したら以降継承される
	$CALEX->table_class = 'calendar_table calendar_column7'; // table クラス付与 ※一度設定したら以降継承される
	$CALEX->close_date = '21,23';           // close:日付 ※一度設定したら以降継承される
	$CALEX->close_wday = '4';               // close:数値で示す曜日（0：日 ～ 6：土） ※一度設定したら以降継承される
	$CALEX->open_date = '1,2,3,4,5,6,21';   // open ※一度設定したら以降継承される
	$calendar_arr = $CALEX->results_calendar_array( 'monthly', time(), 0 );
	$tag_table_03 = $CALEX->disp_calendar( $calendar_arr);
	$yyyy_03 = $CALEX->the_year;
	$mm_03 = $CALEX->the_month;

	/* 04 */
	$calendar_arr = $CAL->results_calendar_array( 'monthly', time(), 0 );
//print '$calendar_arr'.'：';var_dump($calendar_arr);print '<br>'."\n";
	if( array_key_exists( '20180608', $calendar_arr[ 'calendar' ] ) ) {
		$calendar_arr[ 'calendar' ][ '20180608' ][ 'event_name' ] = 'EVENT NAME_01';
	}
	if( array_key_exists( '20180625', $calendar_arr[ 'calendar' ] ) ) {
		$calendar_arr[ 'calendar' ][ '20180625' ][ 'event_name' ] = 'EVENT NAME_03';
	}
	//tag
	$CAL->the_type = 'monthly_tate';
	$CAL->table_class = 'calendar_table calendar_vertical';
	$tag_table_04 = $CAL->disp_calendar( $calendar_arr );
	$yyyy_04 = $CAL->the_year;
	$mm_04 = $CAL->the_month;

	/* 05 */
	$CAL->start_wday = 'sunday';
	// 05-01
	$calendar_arr01 = $CAL->results_calendar_array( 'weekly', time(), 0 );
	if( array_key_exists( '20180608', $calendar_arr01[ 'calendar' ] ) ) {
		$calendar_arr01[ 'calendar' ][ '20180608' ][ 'event_name' ] = 'EVENT NAME_01';
	}
	if( array_key_exists( '20180610', $calendar_arr01[ 'calendar' ] ) ) {
		$calendar_arr01[ 'calendar' ][ '20180610' ][ 'event_name' ] = 'EVENT NAME_02';
	}
//print '$calendar_arr'.'：';var_dump($calendar_arr01);print '<br>'."\n";
	// 05-02
	$calendar_arr02 = $CAL->results_calendar_array( 'weekly', time(), 1 );
	if( array_key_exists( '20180613', $calendar_arr02[ 'calendar' ] ) ) {
		$calendar_arr02[ 'calendar' ][ '20180613' ][ 'event_name' ] = 'EVENT NAME_03';
	}
	if( array_key_exists( '20180615', $calendar_arr02[ 'calendar' ] ) ) {
		$calendar_arr02[ 'calendar' ][ '20180615' ][ 'event_name' ] = 'EVENT NAME_04';
	}
	// 05-03
	$calendar_arr03 = $CAL->results_calendar_array( 'weekly', time(), -1 );
	if( array_key_exists( '20180619', $calendar_arr03[ 'calendar' ] ) ) {
		$calendar_arr03[ 'calendar' ][ '20180619' ][ 'event_name' ] = 'EVENT NAME_05';
	}
	if( array_key_exists( '20180610', $calendar_arr03[ 'calendar' ] ) ) {
		$calendar_arr03[ 'calendar' ][ '20180610' ][ 'event_name' ] = 'EVENT NAME_06';
	}
	//tag
	$CAL->the_type = 'weekly';
	$CAL->table_class = 'calendar_table calendar_vertical';
	$tag_table_05_01 = $CAL->disp_calendar( $calendar_arr01 ); // 05_01
	$tag_table_05_02 = $CAL->disp_calendar( $calendar_arr02 ); // 05_02
	$tag_table_05_03 = $CAL->disp_calendar( $calendar_arr03 ); // 05_03
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<div class="mono_area">
					<section>
						<div class="hgroup">
							<h2 class="heading02"><?= $PAGENAME ?></h2>
						</div>
						<div class="box">
							<h3 class="heading03">祝日</h3>
							<div class="part openclose_wrap">
								<h5 class="openclose_handle plus">OPEN</h5>
								<dl class="openclose_target text">
<?= $tag_holidays ?>
								</dl>
							</div>
						</div>
						<div class="box">
							<h3 class="heading03">CALENDAR01</h3>
							<div class="part">
								<h4 class="heading04">今月（<?= $yyyy_01 ?>年<?= $mm_01 ?>月）のカレンダー</h4>
<?= $tag_table_01 ?>
							</div>
							<div class="part">
								<h4 class="heading04">前月（<?= $yyyy_01_prev ?>年<?= $mm_01_prev ?>月）のカレンダー</h4>
<?= $tag_table_01_prev ?>
							</div>
							<div class="part">
								<h4 class="heading04">来月（<?= $yyyy_01_next ?>年<?= $mm_01_next ?>月）のカレンダー</h4>
<?= $tag_table_01_next ?>
							</div>
						</div>
						<div class="box">
							<h3 class="heading03">CALENDAR02</h3>
								<h4 class="heading04">指定月（<?= $yyyy_02 ?>年<?= $mm_02 ?>月）のカレンダー</h4>
							<div class="part">
<?= $tag_table_02 ?>
							</div>
						</div>
						<div class="box">
							<h3 class="heading03">CALENDAR03</h3>
							<div class="part texts">
								<h4 class="heading04"><?= $yyyy_03 ?>年<?= $mm_03 ?>月のカレンダー</h4>
								<p>月曜スタート</p>
								<p>tableクラス付与:calendar_table</p>
								<p>close_date:21,23</p>
								<p>close_wday:4(木曜日)</p>
								<p>open_date:1,2,3,4,5,6,7</p>
<?= $tag_table_03 ?>
							</div>
						</div>
						<div class="box">
							<h3 class="heading03">CALENDAR04</h3>
							<div class="part">
								<h4 class="heading04"><?= $yyyy_04 ?>年<?= $mm_04 ?>月のカレンダー</h4>
<?= $tag_table_04 ?>
							</div>
						</div>
						<div class="box">
							<h3 class="heading03">CALENDAR05</h3>
							<div class="part">
								<h4 class="heading04">今週のカレンダー</h4>
<?= $tag_table_05_01 ?>
								<h4 class="heading04">次週のカレンダー</h4>
<?= $tag_table_05_02 ?>
								<h4 class="heading04">先週のカレンダー</h4>
<?= $tag_table_05_03 ?>
							</div>
						</div>
						<div class="box">
							<div class="part texts">
<?php
//	$holiday_arr = $CAL->japan_holiday( time(), 'weekly' );
//	print '$holiday_arr'.'：';var_dump($holiday_arr);print '<br>';
?>
								<p><?= $CAL->debug_report ?></p>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
<?php	include_once ROOTREALPATH . '/data/includes/footer_mod.php';?>