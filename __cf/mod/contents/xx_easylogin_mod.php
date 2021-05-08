<?php
/*--------------------------------------------------------------

	会員ページ簡易ログイン

	@memo

---------------------------------------------------------------*/

##	setting

	/* cookie */
	$cookie_int = 60 * 60 * 24 * 30;

##	base

##	data

	/* post */
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? $BASE->sanitize_server_request( $_POST ) : [];
	$POST_password = ( isset( $_POST[ 'password' ] ) && $_POST[ 'password' ] ) ? $_POST[ 'password' ] : '';

	/* cookie */
	$COOKIE_password = ( isset( $_COOKIE[ 'password' ] ) && $_COOKIE[ 'password' ] ) ? $BASE->sanitize_server_request( $_COOKIE[ 'password' ] ) : [];

	/* master */
	include_once ROOTREALPATH . '/mod/master/password.php'; // $password_array

##	process

	/* password_check */
	$easy_login = false;
	$easy_login_error = false;

	if( $POST_password ) {
		if( in_array( $POST_password, $password_array ) ) {
			$easy_login = true;
		} else {
			$easy_login_error = true;
		}
	} elseif( $COOKIE_password ) {
		if( in_array( $COOKIE_password, $password_array ) ) {
			$easy_login = true;
		}
	} else {
			$easy_login = false;
	}

	/* set_cookie */
	if( $easy_login && $POST_password ) {
		setcookie( 'password_members', $POST_password, time() + $cookie_int );
	} elseif( $easy_login && $COOKIE_password ) {
		setcookie( 'password_members', $COOKIE_password );
	}

##	tag

	/* tag : パスワードエラー */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t";
	$tag .= $tb . "" . '<p class="caution caption text">パスワードが異なります</p>' . "\n";
	$tag_password_error_message = ( $easy_login_error ) ? $tag : '';