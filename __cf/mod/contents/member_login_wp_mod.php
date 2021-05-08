<?php
/*--------------------------------------------------------------

	members_login_wp_mod
	ログイン画面のモジュール

	@memo

---------------------------------------------------------------*/

##	redirect

	if( is_user_logged_in() ){
		header( 'Location: ' . PUBLICDIR . '/members/');
	}

##	error_message

	if( isset( $_GET[ 'login' ] ) && $_GET[ 'login' ] === 'failed' ) {
		$members_login_failed = true;
		$failed_message = 'ログインIDまたはパスワードが間違っています。';
	} else {
		$members_login_failed = false;
		$failed_message = '';
	}