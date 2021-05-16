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

	/* login check */
	if( ! in_array( get_current_user_id(), WPEC_USER_IDS ) ) {
		return;
	}

##	data

	/* post */
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? OOBASE::sanitize_server_request( $_POST ) : [];
	$POST_csv_name   = $_POST[ 'csv_name' ]   ?? false;
	$POST_date_start = $_POST[ 'date_start' ] ?? '2000-01-01';
	$POST_date_end   = $_POST[ 'date_end' ]   ?? date( 'Y-m-d' );

	/* master */
	$master_csv_field_name = [
		'ec_id'                 => '商品ID',
		'wp_products_code'      => 'WP商品コード',
		'ec_name'               => '商品名',
		'ec_code'               => '商品コード',
		'products_name'         => '商品表示名',
		'calc_type'             => '商品料金算出方法',
		'class01_name'          => '仕様01',
		'class02_name'          => '仕様02',
		'lot'                   => 'ロット',
		'nouki'                 => '短縮納期',
		'price'                 => '販売価格',
		'ec_class_category_id1' => '規格分類1(ID)',      // 空白
		'ec_class_category_id2' => '規格分類2(ID)',      // 空白
		'ec_status'             => '公開ステータス(ID)', // 1
		'ec_valiation'          => '販売種別(ID)',       // 1
		'ec_stock_num'          => '在庫数',             // 空白
		'ec_stock_flag'         => '在庫数無制限フラグ',  // 1
		'tax_rate'              => '税率'                // 1軽減税率：対応の場合
	];

##	wp

	/* csv_filename_prefix */
	$csv_filename_prefix = $POST_csv_name ? $POST_csv_name : $csv_filename_prefix;

	/* posts */
	$to_csv_arr = [];
	$args = [
		'posts_per_page' => -1,
		'post_type'      => WPEC_POST_TYPE,
		'post_status'      => 'publish'
	];
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		while( $the_query->have_posts() ) {
			$the_query->the_post();

			// id
			$this_post_id                                    = $the_query->post->ID;
			$this_products_code                              = get_field( WPEC_ACF_KEY_CODE, $this_post_id );
			$this_products_price                             = get_field( WPEC_POST_TYPE . '_price', $this_post_id );
			if( $this_products_code && $this_products_price ) {
				$to_csv_arr [] = [
					$master_csv_field_name[ 'ec_id' ]                 => ec_oo_get_product_data( 'id', $this_products_code ),
					$master_csv_field_name[ 'wp_products_code' ]      => $this_products_code,
					$master_csv_field_name[ 'ec_name' ]               => get_the_title( $this_post_id ),
					$master_csv_field_name[ 'ec_code' ]               => $this_products_code,
					$master_csv_field_name[ 'price' ]                 => $this_products_price,
					$master_csv_field_name[ 'ec_class_category_id1' ] => '',
					$master_csv_field_name[ 'ec_class_category_id2' ] => '',
					$master_csv_field_name[ 'ec_status' ]             => 1,
					$master_csv_field_name[ 'ec_valiation' ]          => 1,
					$master_csv_field_name[ 'ec_stock_num' ]          => '',
					$master_csv_field_name[ 'ec_stock_flag' ]         => 1
				];
			}
		}
	}

##	csv

	/* csv download */
	$CSVDL->csv_create( $to_csv_arr, true, $csv_filename_prefix );
// print '<pre>'.'$to_csv_arr' . '：';var_dump($to_csv_arr);print '</pre>' . "\n";