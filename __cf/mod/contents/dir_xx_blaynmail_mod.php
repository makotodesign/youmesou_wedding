<?php

/*--------------------------------------------------------------

	dir_xx_blaynmail_mod

	@memo

---------------------------------------------------------------*/

##	setting

	/* blaynmail */
	$blaynmail_connect_array = array(
		'username' => 'hyogokai',
		'password' => '15460',
		'api_key'  => '0952e07dab1eccbbe165dd2348ddbe3d'
	);

##	base

	/* includes */
	// class : blaynmail
	include_once ROOTREALPATH . '/mod/lib/blaynmail.class.php';
	$BLAYNMAIL = new blaynmail();
	$bool_login = $BLAYNMAIL->login( $blaynmail_connect_array );

##	data

	/* logined_user_data */
	// from wp_logiin_mod.php
	$wp_user_field[ 'blaynmail_id_arr' ];

##	tag

	/* show */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t";
	$arr = $wp_user_field[ 'blaynmail_id_arr' ];

	for( $i = 0; $i < count( $arr ); $i++ ) {
		$tag .= $tb . "\t\t\t" . '<p data-bmeid="' . $arr[ $i ] . '">' . $BLAYNMAIL->search( $arr[ $i ] ) . '</p>' . "\n";
	}
	$tag_blaynmail_list = $tag;

	/* http_request */
	// add
	if( $post_submit_action === 'add' ) {
		$blaynmail_add_array = array(
			'c15' => $post_delivery_change_mail,    // user_email - def
			'c0'  => $wp_user_info[ 'name' ],       // name       - def
			'c21' => $wp_user_info[ 'wp_id' ]       // wp_id
		);
		$BLAYNMAIL->add( $blaynmail_add_array );
		$blaynmail_message    = $BLAYNMAIL->results_message;
		$bool_blaynmail       = $BLAYNMAIL->results_bool;
		$results_blaynmail_id = $BLAYNMAIL->results_blaynmail_id;
	// delete
	} elseif( $post_submit_action === 'delete' ) {
		$blaynmail_id = intval( $post_blaynmail_id );
		$BLAYNMAIL->delete( $blaynmail_id );
		$blaynmail_message    = $BLAYNMAIL->results_message;
		$bool_blaynmail       = $BLAYNMAIL->results_bool;
		$results_blaynmail_id = $BLAYNMAIL->results_blaynmail_id;
	// update
	} elseif( $post_submit_action === 'update' ) {
		$blaynmail_id = $post_blaynmail_id;
		$blaynmail_update_array = array(
			'c15' => $post_delivery_change_mail,    // user_email - def
			'c0'  => $wp_user_info[ 'name' ],       // name       - def
			'c21' => $wp_user_info[ 'wp_id' ]       // wp_id
		);
		$BLAYNMAIL->update( $blaynmail_id, $blaynmail_update_array );
		$blaynmail_message    = $BLAYNMAIL->results_message;
		$bool_blaynmail       = $BLAYNMAIL->results_bool;
		$results_blaynmail_id = $BLAYNMAIL->results_blaynmail_id;
	}
?>