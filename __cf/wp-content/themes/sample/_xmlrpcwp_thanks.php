<?php
/*--------------------------------------------------------------------------

	Template Name: xmlrpc_thanks
	
	@memo
		
---------------------------------------------------------------------------*/

##	page setting
	
	/* contents_module */
	// 一般送信完了モジュール略
	include_once ROOTREALPATH . '/00_stock/mod/contents/xmlrpcwp_thanks_mod.php';
	
/*---------------------------------------------------------------------------*/

	$SENDMAIL->disp_message();
	//xmlrpc_wp_entry
	if( isset( $SENDMAIL->send_comp ) && ( $SENDMAIL->send_comp ) ) {
		$XW->post_entry();
	}