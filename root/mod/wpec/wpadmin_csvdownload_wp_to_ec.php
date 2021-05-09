<?php
/*--------------------------------------------------------------

	wpadmin_csvdownload_wp_to_ec

	@memo

		wp管理画面からのCSVダウンロード設定
		wp_fuctions_ec と連動

---------------------------------------------------------------*/

##	error_reporting

	// ini_set( 'display_errors', 1 );
	// error_reporting(E_ALL);

##	setting

	/* setting */
	if( ! defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', '/home/oldoffice/www/org01/ct18' );
	$csv_filename_prefix = 'productsec_to_ec';

##	base

	/* init */
	$complete_flag = true;
	$to_csv_arr    = [];

	/* includes */
	include_once ROOTREALPATH . '/wp/wp-load.php';
	include_once ROOTREALPATH . '/mod/setup/setup.php';
	include_once ROOTREALPATH . '/mod/lib/csv_download.class.php';
	$CSVDL = new csv_download();

##	data

	/* post */
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? OOBASE::sanitize_server_request( $_POST ) : [];
	$POST_csv_name   = $_POST[ 'csv_name' ]   ?? false;
	$POST_date_start = $_POST[ 'date_start' ] ?? '2000-01-01';
	$POST_date_end   = $_POST[ 'date_end' ]   ?? date( 'Y-m-d' );

	/* adjust */
	// if( strtotime( $POST_date_start ) || strtotime( $POST_date_start ) ) {
	// 	$complete_flag = false;
	// }

##	wp

	/* csv_filename_prefix */
	$csv_filename_prefix = $POST_csv_name ? $POST_csv_name : $csv_filename_prefix;

	/* posts */
	$res_arr = [];
	$args = [
		'posts_per_page' => -1,
		'post_type'      => 'productsec',
		'post_status'      => 'publish'
	];
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		while( $the_query->have_posts() ) {
			$the_query->the_post();
			$arr = [];
			// id
			$this_post_id                                    = $the_query->post->ID;
			$arr[ '商品コード' ]                             = get_field( 'productsec_code', $this_post_id );
			$arr[ 'WP商品コード' ]                           = get_field( 'productsec_code', $this_post_id ); // eccube favorit用 商品コードと同じ
			$arr[ '商品名' ]                                 = get_the_title( $this_post_id );
			$arr[ '販売価格' ]                               = get_field( 'productsec_price', $this_post_id );
			$temp_productsec_code                            = get_field( 'productsec_code', $this_post_id );
			$arr[ '商品ID' ]                                 = ec_oo_get_product_data( 'id', $temp_productsec_code ); // eccube 上書き用 新規の場合は空白
			if( $arr[ '商品ID' ] === 'error' ) {
				$arr[ '商品ID' ]                             = '';
			}
			$arr[ '入力経緯' ]                                = 'WordPress CSV' . date_i18n( 'Y-m-d H:i:s' ); // eccube 上書き用 新規の場合は空白
			$arr[ '公開ステータス(ID)' ]                      = 1;  // eccube 必須
			$arr[ '販売種別(ID)' ]                           = 1;  // eccube 必須
			$arr[ '在庫数' ]                                 = ""; // eccube 上書き
			$arr[ '在庫数無制限フラグ' ]                      = 1;  // eccube 上書き
			$arr[ '規格分類1(ID)' ]                          = '';  // eccube 上書き
			$arr[ '規格分類2(ID)' ]                          = '';  // eccube 上書き
			/* add_res */
			if( $arr[ '商品コード' ] && $arr[ '販売価格' ] ) {
				$res_arr[] = $arr;
			}
		}
	}
	$to_csv_arr = $res_arr;

##	csv

	/* csv download */
// print '<pre>'.'$to_csv_arr' . '：';var_dump($to_csv_arr);print '</pre>' . "\n";
	if( $complete_flag ){ // id:略可
		$CSVDL->csv_create( $to_csv_arr, true, $csv_filename_prefix );
	}