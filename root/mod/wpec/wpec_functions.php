<?php
/*--------------------------------------------------------------

	wpec_functions

	@version
		18.1.1

	@memo

---------------------------------------------------------------*/

##	func

	function ec_oo_get_token() {
		if( ! isset( $_SESSION[ 'ec' ][ 'token' ] ) ) {
			$_SESSION[ 'ec' ][ 'token' ] = '';
		}
		return $_SESSION[ 'ec' ][ 'token' ];
	}

	function ec_oo_is_loggedin() {
		if( ! isset( $_SESSION[ 'ec' ][ 'logged_in' ] ) ) {
			$_SESSION[ 'ec' ][ 'logged_in' ] = false;
		}
		return $_SESSION[ 'ec' ][ 'logged_in' ];
	}

	function ec_oo_get_carts_total_quantity() {
		if( ! isset( $_SESSION[ 'ec' ][ 'carts_total_quantity' ] ) ) {
			$_SESSION[ 'ec' ][ 'carts_total_quantity' ] = 0 ;
		}
		return $_SESSION[ 'ec' ][ 'carts_total_quantity' ];
	}

	function ec_oo_get_carts_total_price() {
		if( ! isset( $_SESSION[ 'ec' ][ 'carts_total_price' ] ) ) {
			$_SESSION[ 'ec' ][ 'carts_total_price' ] = 0 ;
		}
		return $_SESSION[ 'ec' ][ 'carts_total_price' ] ;
	}

	function ec_oo_carts_items() {
		if( ! isset( $_SESSION[ 'ec' ][ 'carts_items' ] )) {
			$_SESSION[ 'ec' ][ 'carts_items' ] = [];
		}
		return $_SESSION[ 'ec' ][ 'carts_items' ];
	}

	function ec_oo_get_customer_name() {
		if( ! isset( $_SESSION[ 'ec' ][ 'customer_name' ] ) ) {
			$_SESSION[ 'ec' ][ 'customer_name' ] = '';
		}
		return $_SESSION[ 'ec' ][ 'customer_name' ];
	}

	function ec_oo_get_customer_company() {
		if( ! isset( $_SESSION[ 'ec' ][ 'customer_company' ] ) ) {
			$_SESSION[ 'ec' ][ 'customer_company' ] = '';
		}
		return $_SESSION[ 'ec' ][ 'customer_company' ];
	}

	function ec_oo_get_favorites() {
		if( isset( $_SESSION[ 'ec' ][ 'favorites' ] ) && is_array( $_SESSION[ 'ec' ][ 'favorites' ] ) ) {
			$_SESSION[ 'ec' ][ 'favorites' ] = [];
		}
		return $_SESSION[ 'ec' ][ 'favorites' ];
	}

	function ec_oo_is_favorite( $products_code ) {
		$favorites_code_arr =[];
		if( isset( $_SESSION[ 'ec' ][ 'favorites' ] ) && is_array( $_SESSION[ 'ec' ][ 'favorites' ] ) ) {
			$favorites_code_arr = $_SESSION[ 'ec' ][ 'favorites' ];
		}
		return in_array( $products_code, $favorites_code_arr ) ? true : false;
	}

	function ec_oo_bundlekey() {
		return mt_rand();
	}

	function ec_oo_code_to_wp_post_id( $ec_product_code ) {
		global $wpdb;
		$res = [];
		if( defined( 'WPEC_ACF_KEY_CODE' ) ) {
			$sql ="SELECT
					post_id
				FROM
					{$wpdb->postmeta}
				WHERE
					meta_key = %s
					AND meta_value = %s
			";
			$sql_val = [
				WPEC_ACF_KEY_CODE,
				$ec_product_code
			];
			$res = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) );
		}
		return $res;
	}

	function ec_oo_get_product_data( $res_ec_key_name, $wp_posttype_for_ec_code ) {
		global $wpdb;
		$ec_db_field = false;
		$res         = '';
		if( $res_ec_key_name === 'id' ) {
			$ec_db_field = 'product_id';
		} elseif( $res_ec_key_name === 'class_id' ) {
			$ec_db_field = 'id';
		} elseif( $res_ec_key_name === 'price' ) {
			$ec_db_field = 'price02';
		}
		if( $ec_db_field ) {
			$sql = "SELECT
					{$ec_db_field}
				FROM
					dtb_product_class
				WHERE
					product_code = %s
			";
			$sql_val = [
				$wp_posttype_for_ec_code
			];
			$res = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) ) ?? 'error';
		}
		return $res;
	}