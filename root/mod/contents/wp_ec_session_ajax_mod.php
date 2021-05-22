<?php
/*--------------------------------------------------------------

	wp_ec_session_ajax_mod

	@version
		18.1.1

	@memo

---------------------------------------------------------------*/

##	ajax

	/* session */
	if( session_status() !== PHP_SESSION_ACTIVE ) session_start();

	/* post to session */
	$_SESSION[ 'ec' ][ 'token' ]                = $_POST[ 'token' ]                     ?? '';
	$_SESSION[ 'ec' ][ 'logged_in' ]            = $_POST[ 'logged_in' ] === 'true'      ? true : false;
	$_SESSION[ 'ec' ][ 'carts_items' ]          = $_POST[ 'carts' ][ 'items' ]          ?? [];
	$_SESSION[ 'ec' ][ 'carts_total_quantity' ] = $_POST[ 'carts' ][ 'total_quantity' ] ?? 0;
	$_SESSION[ 'ec' ][ 'carts_total_price' ]    = $_POST[ 'carts' ][ 'total_price' ]    ?? 0;
	$_SESSION[ 'ec' ][ 'customer_name' ]        = $_POST[ 'customer' ][ 'name' ]        ?? '';
	$_SESSION[ 'ec' ][ 'customer_company' ]     = $_POST[ 'customer' ][ 'company' ]     ?? '';
	$_SESSION[ 'ec' ][ 'favorites' ]            = $_POST[ 'favorites' ]                 ?? [];