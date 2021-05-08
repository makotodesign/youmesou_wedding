<?php
/*--------------------------------------------------------------

	CSVダウンロード

---------------------------------------------------------------*/

##	base

	/* setting */
	$csv_filename_prefix = 'xx';
	$redirect_page_url = 'http://www.xxx.com/'; // 不正アクセス時のリダイレクト

	/* class */
	// DB
	include_once ROOTREALPATH . '/mod/lib/db.class.php';
	$host   = '';
	$user   = '';
	$path   = '';
	$dbname = '';
	$DB = new db( $host, $user, $path, $dbname );
	// CSVD
	include_once ROOTREALPATH . '/mod/lib/csv_download.class.php';
	$CSVD = new csv_download();

##	data

	/* post */

	/* db */
	$sql = '
		SELECT		table_name.field_name01,table_name.field_name02
		FROM		tableName
		' . $where_query . '
		ORDER BY	aaa ASC
		LIMIT		10
	';
	$db_arr = $DB->query( $sql, $value_arr ); // arg3 : $type = 'array(def)' || 'record' || 'var', arg4 : $key=  'fieldname(def)' || 'num'

##	action

	/* CSVダウンロード実行 */
	if( $complete_flag ){ // id:略可
		$CSVD-＞csv_create( $db_arr, $csv_filename_prefix );
	} else {
		header( 'Location: ' . $redirect_page_url );
	}

