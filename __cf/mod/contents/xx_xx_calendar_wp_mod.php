<?php

/*--------------------------------------------------------------

	xx_csv_to_calendar_wp_mod

	@memo

---------------------------------------------------------------*/

##	setting

	/* wp */
	$switch_blog_id = 9;
	$display_posts_per_page = 1;

	/* csv */
	$csv_total_fields  = 2;
	$csv_arr_type      = 'fieldname';
	$csv_title_row_num = 3;
	$csv_key_row_num   = 1;

##	base

	/* includes */
	// csv_parse_class
	include_once ROOTREALPATH . '/mod/lib/csvparse.class.php';
	$CP = new csv_parse();
	// calendar_class
	include_once ROOTREALPATH . '/mod/lib/calendar.class.php';
	$CAL = new calendar();

##	data

	/* get */
	$get = ( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' ) ? $BASE->sanitize_server_request( $_GET ) : [];
	$get_month_id = ( isset( $get[ 'month' ] ) && $get[ 'month' ] ) ? $get[ 'month' ] : 0; // this = 0, 1, 2

	/* date */
	$this_year                = date_oo( 'Y', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id, 1 ) );
	$this_month               = date_oo( 'm', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id, 1 ) );
	// csv
	$next_month_year          = date_oo( 'Y', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id + 1, 1 ) );
	$next_month               = date_oo( 'm', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id + 1, 1 ) );
	$prev_month_year          = date_oo( 'Y', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id - 1, 1 ) );
	$prev_month               = date_oo( 'm', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id - 1, 1 ) );
	// event
	$firstdate_this_month     = date_oo( 'Ymd', mktime ( 0, 0, 0, date_oo( 'n' ) + $get_month_id, 1 ) );
	$firstdate_this_nextmonth = date_oo( 'Ymd', mktime ( 0, 0, 0, date_oo( 'n' ) + 1 + $get_month_id, 1 ) );

##	wp : get_posts_data

	/* switch_blog */
	switch_to_blog( $switch_blog_id );

	/* posts */
	// reset
	$arr = [];
	$i = 0;
	// get_posts : csv
	$args = array(
		'posts_per_page' => 1,
		'order'          => 'DESC',
		'orderby'        => 'date', // date_oo(def) / modified /
		// csv
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'   => 'csv_year',
				'value' => $this_year
			),
			array(
				'key'   => 'csv_month',
				'value' => $this_month
			)
		)
	);
	$posts_array = get_posts( $args );
	if( is_array( $posts_array ) && $posts_array ) {
		foreach( $posts_array as $post ) :
			setup_postdata( $post );
			/* wp_elements */
			// id
			$this_post_id                                     = $post->ID;
			// base
			$arr[ $i ][ 'post_id' ]                           = $this_post_id;
			$arr[ $i ][ 'post_title' ]                        = get_the_title( $this_post_id );
			// acf
			$arr[ $i ][ 'csv_year' ]                          = get_field( 'csv_year', $this_post_id );
			$arr[ $i ][ 'csv_month' ]                         = get_field( 'csv_month', $this_post_id );
			$arr[ $i ][ 'csv_file_01' ]                       = get_field( 'csv_file_01', $this_post_id );
		endforeach;
	}
	$wp_csv_year         = $arr[ 0 ][ 'csv_year' ];
	$wp_csv_month        = $arr[ 0 ][ 'csv_month' ];
	$wp_csv_file_01      = $arr[ 0 ][ 'csv_file_01' ];
	// get_posts : csv_next
	$args = array(
		'posts_per_page' => 1,
		'order'          => 'DESC', // DESC(def) / ASC
		'orderby'        => 'date', // date_oo(def) / title / modified / meta_value * / meta_value_num * / * meta_key指定
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'   => 'csv_year',
				'value' => $next_month_year
			),
			array(
				'key'   => 'csv_month',
				'value' => $next_month
			)
		)
	);
	$wp_next_posts_array = get_posts( $args );
	// calendar_arr
	$calendar_num = $get_month_id;
	$calendar_arr = $CAL->results_calendar_array( 'monthly', time(), $calendar_num );
	$csv_fpath = $csv_file_01;
	$arr_csv = $CP->result_array( $csv_fpath, $csv_total_fields, $csv_arr_type, $csv_title_row_num, $csv_key_row_num );
	// calendar : add_events
	for( $i = 0; $i < count( $arr_csv ); $i++ ) {
		$dete_id = $this_year . $this_month . sprintf( '%02d', $arr_csv[ $i ][ 'date' ] );
		$calendar_arr[ $dete_id ][ 'xxxxx' ] = $arr_csv[ $i ][ 'xxxxx' ];
	}

	/* posts */
	// reset
	$arr = [];
	$i = 0;
	// get_posts
	$args = array(
		'posts_per_page' => $display_posts_per_page,
		'orderby'        => 'membersevent_date',
		'order'          => 'ASC',
		'meta_query'     => array(
			'relation'           => 'AND',
			array(
				'key'            => 'event_date',
				'value'          => $firstdate_this_month,
				'compare'        => '>='
			),
			array(
				'key'            => 'event_date',
				'value'          => $firstdate_this_nextmonth,
				'compare'        => '<'
			)
		)
	);
	$posts_array = get_posts( $args );
	if( is_array( $posts_array ) && $posts_array ) {
		foreach( $posts_array as $post ) {
			setup_postdata( $post );
			/* wp_elements */
			// id
			$this_post_id                                     = $post->ID;
			// base
			$arr[ $i ][ 'post_id' ]                           = $this_post_id;
			$arr[ $i ][ 'post_title' ]                        = get_the_title( $this_post_id );
			// acf : date
			$temp_date                                        = get_field( 'event_date', $this_post_id );
			$temp_timestamp                                   = mktime( 0, 0, 0, substr( $temp_date, 4, 2 ), substr( $temp_date, 6, 2 ), substr( $temp_date, 0, 4 ) );
			$arr[ $i ][ 'event_date' ]                        = $temp_date;
			$arr[ $i ][ 'event_date_fromated' ]               = date_oo( 'Y/n/j（D）', $temp_timestamp );
			// add_post_num
			$i++;
		}
	}
	// calendar_arr
	$calendar_num = $get_month_id;
	$calendar_arr = $CAL->results_calendar_array( 'monthly', time(), $calendar_num );
	// calendar : add_events
	for( $i = 0; $i < count( $arr ); $i++ ) {
		$dete_id = $arr[ $i ][ 'event_date' ];
		$calendar_arr[ $dete_id ][ 'post_id' ]                    = $arr[ $i ][ 'post_id' ];
		$calendar_arr[ $dete_id ][ 'post_title' ]                 = $arr[ $i ][ 'post_title' ];
	}
	$arr = $calendar_arr;

	/* restore_current_blog */
	restore_current_blog();

##	func

	/* func : no_data */
	function adjust_no_data ( $data = '' ) {
		if( isset( $data ) && $data ) {
			return $data;
		} else {
			return '&nbsp;';
		}
	}

##	tag

	/* bool */
	// next_month_calendar
	$bool_next_month_calendar = ( $next_posts_array ) ? true : false;

	/* tag */
	// calendar_csv
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t\t";

	$tag .= $tb . "" . '<p class="calendar_title">' . $month . '月</p>' . "\n";
	$tag .= $tb . "" . '<table class="table01 calendar_table">' . "\n";
	foreach( $calendar_arr as $k => $v ) {
		$tag .= $tb . "\t" . '<tr' . $v[ 'add_class_tag' ] . '>' . "\n";
		$tag .= $tb . "\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t" . '<p class="day">' . $v[ 'day' ] . ' 日 (' . $v[ 'wday_name' ] . ')</p>' . "\n";
		$tag .= $tb . "\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t" . '<p>' . adjust_no_data ( $v[ 'post_id' ] ) . '</p>' . "\n";
		$tag .= $tb . "\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t" . '</tr>' . "\n";
	}
	$tag .= $tb . "" . '</table>' . "\n";

	$tag_csv_table = $tag;

	// add_wp_event
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t";
	$arr = $calendar_arr;

	$tag .= $tb . "" . '<table class="table01 calendar_vertical">' . "\n";

	foreach( $arr as $k => $v ) {
		$tag .= $tb . "\t" . '<tr' . $v[ 'add_class_tag' ] . '>' . "\n";
		$tag .= $tb . "\t\t" . '<th scope="row" class="event_date">' . $v[ 'day' ] . ' 日 (' . $v[ 'wday_name' ] . ')</th>' . "\n";
		$tag .= $tb . "\t\t" . '<td>' . "\n";
		if( isset( $v[ 'post_id' ] ) && isset( $v[ 'post_title' ] ) && $v[ 'post_id' ] ) {
			$tag .= $tb . "\t\t\t" . '<p class="event_title"><a href="/?postid=' . $v[ 'post_id' ] . '">' . $v[ 'post_title' ] . '</a></p>' . "\n";
		} else {
			$tag .= $tb . "\t\t\t" . '<p class="event_title">&nbsp;</p>' . "\n";
		}
		$tag .= $tb . "\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t" . '</tr>' . "\n";
	}
	$tag .= $tb . "" . '</table>' . "\n";

	$tag_schedule_contents = $tag;

	// next back btn
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t\t\t";

	$tag .= $tb . "" . '<li class="prev_button"><a class="prev" href="/members/event_schedule/?month=' . ( $get_month_id - 1 ) . '">&laquo; ' . $prev_month . '月</a></li>' . "\n";
	$tag .= $tb . "" . '<li class="next_button"><a class="next" href="/members/event_schedule/?month=' . ( $get_month_id + 1 ) . '">' . $next_month . '月 &raquo;</a></li>' . "\n";

	$tag_next_back_btn = $tag;

	// str
	$str_this_month = $this_month . '月';
?>