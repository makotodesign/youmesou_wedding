
<?php
/*--------------------------------------------------------------

	xxx_yyy__csvdownloadwp_mod

	@memo

---------------------------------------------------------------*/

##　setting

	/* setting */
	$csv_filename_prefix = 'prefix_name';
	$complete_flag = true;

##　base

	/* includes */
	include_once ROOTREALPATH . '/mod/lib/csv_download.class.php';
	$CSVD = new csv_download();

##　data

	/* post */
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? $BASE->sanitize_server_request( $_POST ) : [];
	$POST_postname01 = $_POST[ 'postname01' ] ?? 'default_value';
	$POST_postname02 = $_POST[ 'postname03' ] ?? 'default_value';

	/* db */
	$sql = '
		SELECT
			aaa,
			bbb,
			ccc,
			ddd
		FROM
			table_name
		WHERE
			w01 LIKE %s
			AND
			w02 = %d
			AND
			date >= $s
			AND
			date <= $s
	';
	$sql = $wpdb->prepare(
		$sql,
		'%"' . $POST_postname01 . '"%',
		intval( $POST_postname02 ),
		'2020-10-10',
		'2020-10-20'
	);
	$db_arr = $wpdb->get_results( $sql, 'ARRAY_A' );

##　action

	/* CSVダウンロード実行 */
	if( $complete_flag ){ // id:略可
		$CSVD->csv_create( $db_arr, $csv_filename_prefix );
	} else {
		echo 'error';
	}