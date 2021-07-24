<?php
/**--------------------------------------------------------------
 *
 * top_introduction_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// admin_page
	$admin_page_id           = 77;

##	base

##	data

##	wp

	/* post */
	$arr = [];
	if( have_posts() ) {
		the_post();
		// id
		$this_post_id                                      = $admin_page_id;
		// dete
		$arr[ 'modified_date' ]                            = get_the_modified_date( 'Y-m-d', $this_post_id );
		// acf
		$arr[ 'introduction' ]                              = wp_oo_acf_loop( get_field( 'introduction', $this_post_id ) );
		foreach( $arr[ 'introduction' ] as $k => $v ) { // loop over write
			$arr[ 'introduction' ][ $k ][ 'title' ]           = wp_oo_acf_textarea( $v[ 'title' ] );
			$arr[ 'introduction' ][ $k ][ 'contents' ]         = wp_oo_acf_textarea( $v[ 'contents' ] );
			$arr[ 'introduction' ][ $k ][ 'pic' ]             = wp_oo_acf_image( $v[ 'pic' ], 'medium', '/images/lib/parts/noimage_icon.svg' ); // url || thumbnail || medium || large
		}

	}
	$temp_arr = $arr[ 'introduction' ];
	$wp_top_introduction_array = [];
	for( $i = 0 ; $i < count( $temp_arr ) ; $i++){
		$wp_top_introduction_array[ $i ][ 'content'] = $temp_arr[ $i ];
		$wp_top_introduction_array[ $i ][ 'pic_position'] = $i % 2 ? 'right' : 'left' ;
		$wp_top_introduction_array[ $i ][ 'text_position'] = $i % 2 ? 'left' : 'right' ;
	}