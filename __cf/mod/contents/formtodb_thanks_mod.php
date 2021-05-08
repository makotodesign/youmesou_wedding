<?php

/*************************************************************************

	formtodb thanks module
	// db 保存

	@memo

**************************************************************************/

##	base

	/* table_name */
	$table_name = 'table_name';

	/* class */
	// db
	$host   = '';
	$user   = '';
	$path   = '';
	$dbname = '_official01_oo';
	$DB = new db( $host, $user, $path, $dbname );

## data

	// post
	$post = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? $_POST : [];
	// sanitize
	$post = $BASE->sanitize_server_request( $post );

## db_setting ( *def: comment out)

	//	/* DB CREATE */
	//	$sql_create = '
	//		CREATE TABLE
	//			' . $table_name . '
	//			(
	//				db_id    int auto_increment primary key,
	//				id         varchar(30),
	//				name       varchar(50),
	//				email      varchar(100),
	//				zip        varchar(20),
	//				address    varchar(200),
	//				q01        varchar(100),
	//				q02        varchar(100),
	//				q03        varchar(100),
	//				q04        varchar(100),
	//				q05        varchar(100),
	//				message    text
	//			)
	//	';
	//	$DB->query( $sql_create );

##	process

	/* DB */
	$sql_insert = '
		INSERT INTO
			' . $table_name . '
			(
				id,
				name,
				email,
				tel,
				zip,
				address,
				q01,
				q02,
				q03,
				q04,
				q01_other_text,
				q04_other_text,
				message
			)
		VALUES
			(
				"' . $post[ 'form_id' ] . '",
				"' . $post[ 'form_name' ] . '",
				"' . $post[ 'form_email' ] . '",
				"' . $post[ 'form_tel' ] . '",
				"' . $post[ 'form_zip' ] . '",
				"' . $post[ 'form_address' ] . '",
				"' . $post[ 'form_q01' ] . '",
				"' . $post[ 'form_q02' ] . '",
				"' . $post[ 'form_q03' ] . '",
				"' . $post[ 'form_q04' ] . '",
				"' . $post[ 'form_q01_other_text' ] . '",
				"' . $post[ 'form_q04_other_text' ] . '",
				"' . $post[ 'form_message' ] . '"
			)
	';


?>
