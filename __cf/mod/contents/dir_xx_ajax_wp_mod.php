<?php
/*--------------------------------------------------------------

	ajax_json_wp_mod

	@memo

---------------------------------------------------------------*/

##	setting

	$display_posts_per_page = 20;     // json

	/* db */
	$db_host   = '***';
	$db_user   = '***';
	$db_path   = '***';
	$db_name   = '***';

##	base

	/* includes */
	// class : DB
	$DB = new db( $db_host, $db_user, $db_path, $db_name );
	// master : filter
	include_once ROOTREALPATH . '/mod/master/master_ajax_filter.php'; // $master_filter_field_arr

##	data

	/* get */
	$_GET                 = ( isset( $_GET ) ) ? $BASE->sanitize_server_request( $_GET ) : [];
	// filter ( ajax )
	$GET_filter           = ( isset( $_GET[ 'filter' ] ) )     ? $_GET[ 'filter' ]     : [];
	// search ( ajax )
	$GET_search           = ( isset( $_GET[ 'searchword' ] ) ) ? $_GET[ 'searchword' ] : false;
	$GET_search_arr       = ( $GET_search ) ? preg_split( "/[\s,]+/", $GET_search )    : [];
	// range ( ajax )
	$GET_range_arr        = ( isset( $_GET[ 'range' ] ) )      ? $_GET[ 'range' ]      : [];
	// paged ( ajax )
	$GET_paging           = ( isset( $_GET[ 'paging' ] ) )     ? $_GET[ 'paging' ]     : 1; // WordPressのpagedと競合しない命名「paging」

##	wp : get_posts_data
	// 省略
	$base_data_arr = $arr;
	// get_posts
/********** debug **************************/
/** test_on start **/
if(isset($_GET['test']) && $_GET['test']=='on'){
//$GET_filter           = [];
//$GET_search           = '';
//$GET_search_arr       = [];
//$GET_range_arr        = array( 0, 120 );
//$GET_bool             = true;
//$GET_str              = '';
}
/** test_on end **/
/********** debug end **********************/

	$args = array(
		'posts_per_page' => $display_posts_per_page,
		'paged'          => $GET_paging
	);
	// GET_filter
	if( $GET_filter  ) {
		$args[ 'meta_query' ][ 'relation' ] = 'AND';
		$temp_arr = array(
			'relation'       => 'OR'
		);
		foreach( $GET_filter as $v ) {
			$temp_arr[] = array(
				'key'        => 'xx_filter',
				'value'      => $v,
				'compare'    => 'LIKE'
			);
		}
		$args[ 'meta_query' ][] = $temp_arr;
	}
	// GET_search
	if( $GET_search ) {
		$temp_arr[] = array(
			'key'        => 'xx_set_0_cont',
			'value'      => '',
			'compare'    => '!='
		);
		$args[ 'meta_query' ][] = $temp_arr;
	}
	// GET_bool
	if( $GET_bool ) {
		$temp_arr[] = array(
			'key'        => 'xx_set_0_cont',
			'value'      => '',
			'compare'    => '!='
		);
		$args[ 'meta_query' ][] = $temp_arr;
	}
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$i++;
		}
	}
	// results
	$match_arr = $arr;
	$match_num = $the_query->found_posts; //全件数
	$disp_num  = $the_query->post_count;  //取得した数

##	tag

	/* main_cont */
	$tag = '';
	$tb = ( ! isset( $ajax_check_mode ) || ! $ajax_check_mode ) ? "\t\t\t\t\t\t\t\t" : '';
	$arr = $match_arr;

	$tag .= $tb . "" . '' . "\n";
	$json_arr[ 'tag_main_cont' ] = $tag;

	/* pager */
	$tag = '';
	$tb = ( ! isset( $ajax_check_mode ) || ! $ajax_check_mode ) ? "\t\t\t\t\t\t\t\t" : '';

	$tag .= $tb . "" . '<ul>' . "\n";
	for( $i = 0; $i < ceil( $match_num / $display_posts_per_page ); $i++ ) {
		if( ( $i + 1 ) == $GET_paging ) {
			$tag .= $tb . "\t" . '<li><span class="page-numbers current">' . ( $i + 1 ) . '</span></li>' . "\n";
		} else {
			$tag .= $tb . "\t" . '<li><a class="page-numbers" href="#scroll_selector">' . ( $i + 1 ) . '</a></li>' . "\n"; // scroll_selector : ページ内スクロール先
		}
	}
	$tag .= $tb . "" . '</ul>' . "\n";
	$json_arr[ 'tag_pager' ] = $tag;

	/* status */
	$str = '';
	if( $match_num > 0 ) {
		$str .= '※ 該当商品 ' . $match_num . ' 件中 ' . ( $GET_offset_num + 1 ) . '～' . ( $GET_offset_num + count( $match_arr ) ) . ' 件表示';
	} else {
		$str .= '※ 該当する商品は見つかりませんでした。';
	}

	$json_arr[ 'str_status' ] = $str;

/********** debug **************************/
//print '$json_arr'.'：';var_dump($json_arr);print '<br>'."\n";
/********** debug end **********************/

##	output

	// themeファイルで「$ajax_check_mode」が「false」であれば
	if( ! isset( $ajax_check_mode ) || ! $ajax_check_mode ) {
		header( 'Content-Type: text/javascript; charset=utf-8' );
		echo json_encode( $json_arr );
	}
