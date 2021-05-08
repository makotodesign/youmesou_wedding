#!/usr/local/bin/php54
<?php

/*--------------------------------------------------------------
	
	update_shopdb
	
	@memo
	
	@reference
	
	# heteml
	1行目記述 #!/usr/local/bin/php54
	ファイル権限 700
	cron はサーバー管理画面で設定
	
---------------------------------------------------------------*/

##	setting

	$update_interval = 2; // ( hour )

##	base

	/* setting */
	define( 'ROOTREALPATH', '/home/sites/heteml/users/a/s/a/asahigolf/web/shopdb01' );

	/* path */
	$fname_sql_fpath  = '/uploads/fname.php';       // fname
	$BASE_class_fpath = '/mod/lib/base.class.php';  // base
	$DB_class_fpath   = '/mod/lib/db.class.php';    // db_connect
	
	/* class */
	// BASE
	include_once ROOTREALPATH . $BASE_class_fpath;
	$BASE = new base();
	// DB
	include_once ROOTREALPATH . $DB_class_fpath;
	$host   = 'mysql512.heteml.jp';
	$user   = '_shop_master_01';
	$path   = '101pikidogs';
	$dbname = '_shop_master_01';
	$DB = new db( $host, $user, $path, $dbname );
	// get_file_name
	include_once ROOTREALPATH . $fname_sql_fpath;
	
##	update
	
	/* db */
	// delete
	$sql_delete = '
		DELETE
		FROM
			shop_master
	';
	
	// insert
	$sql_update = file_get_contents( ROOTREALPATH . '/uploads/' . $fname_sql );
	$sql_update = mb_convert_encoding( $sql_update, 'UTF-8', 'SJIS' );
	
	// update_record
	$current_timestump = time();
	$sql_update_record = '
		INSERT
			INTO
				shop_master_update(
					timestump,
					date,
					file_name,
					check_code
				) 
			VALUES
				(
					"' . $current_timestump . '",
					"' . date_oo( 'Y-m-d H:i:s' ) . '",
					"' . $fname_sql . '",
					"cron"
				)
	';
	
	/* cron */
	if( isset( $_SERVER[ 'SHELL' ] ) ) {
		$DB->query( $sql_delete );
		$DB->query( $sql_update );
		$DB->query( $sql_update_record );
	} else {
		echo 'no_update';
	}
	
	/* cron_test */
//	$debug_code = var_export( $_SERVER,true );
//	$sql_update_record_test = '
//		INSERT
//			INTO
//				shop_master_update(
//					timestump,
//					date,
//					file_name,
//					check_code
//				) 
//			VALUES
//				(
//					"' . $current_timestump . '",
//					"' . date_oo( 'Y-m-d H:i:s' ) . '",
//					"' . $fname_sql . '",
//					"' . $debug_code . '"
//				)
//	';
//	$DB->query( $sql_update_record_test );
	
?>