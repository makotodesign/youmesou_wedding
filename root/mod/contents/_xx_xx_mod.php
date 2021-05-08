<?php
/**--------------------------------------------------------------
 *
 * xx_xx mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	// db
	$db_host = '';
	$db_user = '';
	$db_pass = '';
	$db_name = '';

	// csv
	$fpath_csv = '';
	$csv_total_fields = 10;

##	base

	/* class */
	// base
	//include_once ROOTREALPATH . '/mod/lib/oobase.class.php';
	//$BASE = new base();
	// db
	include_once ROOTREALPATH . '/mod/lib/db.class.php';
	$DB = new db( $db_host, $db_user, $db_pass, $db_name );
	// csv_parse
	include_once ROOTREALPATH . '/mod/lib/csvparse.class.php';
	$CP = new csv_parse();
	// change_date
	include_once ROOTREALPATH . '/mod/lib/changedate.class.php';
	$CD = new change_date();

##	data

	/* post */
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? OOBASE::sanitize_server_request( $_POST ) : [];
	$POST_foo = $_POST[ 'foo' ] ?? '';

	/* get */
	$_GET = ( isset( $_GET ) ) ? OOBASE::sanitize_server_request( $_GET ) : [];
	$GET_foo = $_GET[ 'foo' ] ?? '';

	/* master */
	include_once ROOTREALPATH . '/mod/master/master_fpath.php'; // $foo[$i]['**'/'**'/'**'/'**'],['**'],$bar

	/* db */
	$query_arr = [];
	$value_arr = [];
	// filter01
	$query_arr[] = 'ppp = ?';
	$value_arr[] = $val01;
	// filter02
	$query_arr[] = 'FIND_IN_SET(?, カンマ区切りのDBセル値のフィールド名)';
	$value_arr[] = $val02;
	// filter search
	if( $GET_searchword ){
		$query_arr[] = '(
			( aaa LIKE ? ) OR
			( bbb LIKE ? ) OR
			( ccc LIKE ? )
		)';
		$value_arr[] = '%' . $GET_searchword . '%';
		$value_arr[] = '%' . $GET_searchword . '%';
		$value_arr[] = '%' . $GET_searchword . '%';
	}
	// where
	$where_query = ( $query_arr ) ? 'WHERE ' . join( ' AND ', $query_arr ) : '';
	$sql = '
		SELECT		table_name.field_name01,table_name.field_name02
		FROM		tableName
		' . $where_query . '
			AND WHERE xx = ?
		ORDER BY	aaa ASC
		LIMIT		10
	';
	$sql_val = [
		'compare_value'
	];
	$db_arr = $DB->query( $sql, $sql_val );
	$db_arr = $DB->get_results( $sql, $sql_val );
	$db_arr = $DB->get_row( $sql, $sql_val );
	$db_arr = $DB->get_var( $sql, $sql_val );

	/* csv */
	include_once ROOTREALPATH . $master_csv_data;
	$csv_arr = $CP->result_array( $fpath, $csv_total_fields );

##	process

##	tag

	/* tag : 名称 */
	$tag = '';
	$tb = "\t\t\t\t\t";
	$arr = $xx_arr;
	$tag .= $tb . "\t" . '' . "\n";
	for( $i = 0; $i < count( $arr ); $i++ ) {
		$tag .= $tb . "\t" . '' . "\n";
	}
	$tag .= $tb . "\t" . '' . "\n";
	$tag_xxxxx = $tag;

	/* func : 名称 */
	function bar() {
	}

