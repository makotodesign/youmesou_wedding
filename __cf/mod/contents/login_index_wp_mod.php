<?php
/*--------------------------------------------------------------

	login_index_wp_mod

	@memo

---------------------------------------------------------------*/

##	setting

	// db : laravel
	$db_host = 'localhost';
	$db_user = '';
	$db_pass = '';
	$db_name = '';

	/* wp_user */
	$wp_user_member_id       = 'members';
	$wp_user_member_password = '45bj5gygazdi';

	/* redirect */
	if( isset( $_SESSION[ 'redirect_url' ] ) ) {
		$redirect_path = $_SESSION[ 'redirect_url' ];
	} else {
		$redirect_path = site_url() . '/members/';
	}

	/* temp_match */
	// テスト用メンバーログイン判定
	$temp_match_member_id      = 'test';
	$temp_match_member_pasword = 'testtest';

##	base

	/* class */
	// db
	// include_once ROOTREALPATH . '/mod/lib/db.class.php';
	// $DB = new db( $db_host, $db_user, $db_pass, $db_name );

##	data

	/* post */
	$_POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? $BASE->sanitize_server_request( $_POST ) : array();
	$POST_member_id                     = $_POST[ 'member_id' ]       ?? '';
	$POST_member_password               = $_POST[ 'member_password' ] ?? '';

##	login

	if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

		$login_match = false;

		/* login 判定 */
		// テスト用メンバーログイン判定
		if( ! $login_match && ( $POST_member_id === $temp_match_member_id && $POST_member_password === $temp_match_member_pasword ) ) {
			$wp_user_id       = $wp_user_member_id;
			$wp_user_password = $wp_user_member_password;
			$login_match      = true;
		}

		// admin || hyogokai
		if( $POST_member_id === 'admin' || $POST_member_id === 'hyogokai' ) {
			$wp_user_id       = $POST_member_id;
			$wp_user_password = $POST_member_password;
			$login_match      = true;
		}

		// laravel ログイン判定
		$sql = '
			SELECT *
			FROM   members
			WHERE  member_id = ?
				   AND
				   member_password = BINARY ?
		';
		$sql_val = array(
			$POST_member_id,
			$POST_member_password
		);
		$laravel_user_record = $DB->query( $sql, $sql_val, 'record' );
		if( ! $login_match && $laravel_user_record ) {
			$login_match                   = true;
			$wp_user_id                    = $wp_user_member_id;
			$wp_user_password              = $wp_user_member_password;
			$_SESSION[ 'member_id' ]       = $laravel_user_record[ 'member_id' ];
		}

		if( $login_match ) {
			// wp へのログイン
			$credentials = array();
			$credentials[ 'user_login' ]    = $wp_user_id;
			$credentials[ 'user_password' ] = $wp_user_password;
			$credentials[ 'remember' ]      = true;
			$results_user = wp_signon( $credentials );
			if( ! is_wp_error( $results_user ) ) {
				header( 'Location: ' . $redirect_path );
			}
		}
	}

##	wp_user_data

	$current_user = wp_get_current_user();

	/* user_info */

	$user_info[ 'id' ]            = $current_user->ID;
	$user_info[ 'user' ]          = $current_user->user_login;
	$user_info[ 'name' ]          = $current_user->last_name . ' ' .$wp_current_user->first_name;
	$user_info[ 'user_email' ]    = $current_user->user_email;

	/* user_meta */
	$user_info[ 'user_status' ]   = $current_user->user_status;
	$user_info[ 'user_nicename' ] = $current_user->user_nicename;
	$user_info[ 'display_name' ]  = $current_user->display_name;
	$user_meta = get_user_meta( $wp_user_info[ 'wp_id' ] );

##	laravel_user_data

	$current_user = $laravel_user_record;

	/* user_info */

	$user_info[ 'id' ]            = $current_user->ID;
	$user_info[ 'user' ]          = $current_user->member_id;
	$user_info[ 'name' ]          = $current_user->last_name . ' ' .$wp_current_user->first_name;
	$user_info[ 'user_email' ]    = $current_user->user_email;

	/* user_meta */
	$user_info[ 'user_status' ]   = $current_user->user_status;
	$wp_user_meta = get_user_meta( $wp_user_info[ 'wp_id' ] );