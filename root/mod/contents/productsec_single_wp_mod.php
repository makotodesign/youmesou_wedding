<?php
/**--------------------------------------------------------------
 *
 * productsec_single_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

##	base

##	data

##	wp

	/* post */
	$arr = [];
	$the_query = $wp_query;
	if( $the_query->have_posts() ) {
		$the_query->the_post();
		// id
		$this_post_id                                      = $the_query->post->ID;
		// base
		$arr[ 'post_id' ]                                  = $this_post_id;
		$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
		// acf
		$arr[ 'productsec_code' ]                            = get_field( 'productsec_code', $this_post_id );
		$arr[ 'productsec_pic_main' ]                        = wp_oo_acf_image( get_field( 'productsec_pic_main', $this_post_id ), 'medium' );
		$arr[ 'productsec_price' ]                           = get_field( 'productsec_price', $this_post_id );
		// ec
		$temp_productsec_code                                = get_field( 'productsec_code', $this_post_id );
		$arr[ 'productsec_ec_id' ]                           = ec_oo_get_product_data( 'id', $temp_productsec_code );
		$arr[ 'productsec_ec_class_id' ]                     = ec_oo_get_product_data( 'class_id', $temp_productsec_code );
		$arr[ 'productsec_ec_flag' ]                         = $arr[ 'productsec_ec_id' ] === 'ec_error' || $arr[ 'productsec_ec_class_id' ] === 'ec_error' ? false : true;
	}
	$wp_single_array = $arr;

##	info

	/* single_title */
	$wp_single_title      = $wp_single_array[ 'post_title' ];

	/* bundlekey */
	$bundlekey = ec_oo_bundlekey();

