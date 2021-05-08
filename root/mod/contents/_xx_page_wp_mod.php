<?php
/**--------------------------------------------------------------
 *
 * xxx_page_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// admin_page
	// $admin_page_id           = 99;

##	base

##	data

##	wp

	/* post */
	$arr = [];
	if( have_posts() ) {
		the_post();
		// id
		$this_post_id                                      = $post->ID; // $admin_page_id;
		// dete
		$arr[ 'modified_date' ]                            = get_the_modified_date( 'Y-m-d', $this_post_id );
		// acf
		$arr[ 'xxx_acfname' ]                              = get_field( 'xxx_acfname', $this_post_id );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_textarea( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_content( get_field( 'xxx_acfname', $this_post_id ), "\t\t\t\t\t\t\t\t" );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_radio( get_field( 'xxx_acfname', $this_post_id ), 'both' );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_image( get_field( 'xxx_acfname', $this_post_id ), 'medium' );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_relation( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_loop( get_field( 'xxx_acfname', $this_post_id ) );
		foreach( $arr[ 'xxx_acfname' ] as $k => $v ) {
			$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_textarea( $v[ 'yyy' ] );
			$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_image( $v[ 'yyy' ], 'medium', '/images/lib/parts/noimage_icon.svg' );
			$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_radio( $v[ 'yyy' ], 'value' ); // both(def) || label || value
		}
		$arr[ 'xxx_acfname' ][ 'yyy' ]                     = wp_oo_acf_group( get_field( 'xxx_acfname', $this_post_id ), 'yyy' ); // arg2 があれば 特定の値
		$arr[ 'googlemap' ]                                = wp_oo_acf_group( get_field( 'googlemap', $this_post_id ) );
	}
	$wp_page_array = $arr;