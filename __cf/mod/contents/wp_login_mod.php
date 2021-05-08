<?php
/*--------------------------------------------------------------

	wp_login_mod

	@memo

---------------------------------------------------------------*/

##	setting

##	redirect

	if( ! is_user_logged_in() ){
		header( 'Location: ' . PUBLICDIR . '/members/login/');
	}

##	master

##	wp_user_data

	$wp_current_user = wp_get_current_user();

	/* user_info */

	$wp_user_info[ 'wp_id' ]             = $wp_current_user->ID;
	$wp_user_info[ 'user_login' ]        = $wp_current_user->user_login;
	$wp_user_info[ 'user_nicename' ]     = $wp_current_user->user_nicename; //サニタイズ後のログインIDを取得
	$wp_user_info[ 'display_name' ]      = $wp_current_user->display_name; //サニタイズ後のログインIDを取得
	$wp_user_info[ 'user_email' ]        = $wp_current_user->user_email;
	$wp_user_info[ 'user_status' ]       = $wp_current_user->user_status;
	$wp_user_info[ 'name' ]              = $wp_current_user->last_name . ' ' .$wp_current_user->first_name;

	/* user_meta */
	$wp_user_meta = get_user_meta( $wp_user_info[ 'wp_id' ] );