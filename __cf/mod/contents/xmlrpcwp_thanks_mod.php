<?php

/*************************************************************************

	xmlrpc thanks module
	// WordPress entry

	@memo

**************************************************************************/

##	base

	/* table_name */
	$table_name = 'table_name';
	// xmlrpc
	include_once '../../../00_stock/mod/contents/XML/RPC.php'; // XML-RPC_SERVER
	$GLOBALS[ 'XML_RPC_defencoding' ] = 'UTF-8';
	include_once ROOTREALPATH . '/mod/lib/xmlrpc_wp.class.php';

	$host        = "domain.com";                       // ドメインのみ
	$blog_id     = 12;
	$user        = "admin";
	$passwd      = "eciffodlo";
	$publish     = 0;                                  // 0=下書き 1=公開
	$xmlrpc_path = PUBLICDIR . '/xmlrpc.php';          // マルチサイトの場合 ディレクトリ名も含める
	$_categories = array( 'slug' );                    // slug
	$XW = new xmlrpc_wp( $host, $blog_id, $user, $passwd, $publish, $xmlrpc_path );

## data

	// post
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? $BASE->sanitize_server_request( $_POST ) : [];

##	process

	/* post */
	$send_title      = $_POST[ 'form_title' ];
	$send_content    = '';
	$customfields_array = array(
		array(
			'key'   => 'comment',
			'value' => $_POST[ 'form_comment' ],
		),
		array(
			'key'   => 'handlename',
			'value' => $_POST[ 'form_name' ],
		),
		array(
			'key'   => 'mail',
			'value' => $_POST[ 'form_email' ],
		),
		array(
			'key'   => 'age',
			'value' => $_POST[ 'form_age' ],
		),
		array(
			'key'   => 'pic_resize01',
			'value' => $_POST[ 'form_image_path2' ],
		),
		array(
			'key'   => 'pic_resize02',
			'value' => $_POST[ 'form_image_path3' ],
		)
	);

	/* entry */
	$set_content = $XW->set_content( $send_title, $categories, $send_content, $customfields_array );