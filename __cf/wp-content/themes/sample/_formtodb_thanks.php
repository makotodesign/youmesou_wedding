<?php
/*--------------------------------------------------------------------------

	formtodb_thanks
		
---------------------------------------------------------------------------*/

##	page setting
	
	/* contents_module */
	// 一般送信完了モジュール略
	include_once ROOTREALPATH . '/00_stock/mod/contents/formtodb_thanks_mod.php';
	
/*---------------------------------------------------------------------------*/

	$SENDMAIL->disp_message();
	//db保存
	if( isset( $SENDMAIL->send_comp ) && ( $SENDMAIL->send_comp ) ) {
		$DB->query( $sql_insert );
	}

