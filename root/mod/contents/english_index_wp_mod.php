<?php
/**--------------------------------------------------------------
 *
 * english_index_wp_mod
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
		$arr[ 'page_title' ]                               = get_field( 'page_title', $this_post_id );
		$arr[ 'page_title_sub' ]                           = get_field( 'page_title_sub', $this_post_id );
		$arr[ 'contents' ]                                 = wp_oo_acf_loop( get_field( 'contents', $this_post_id ) );
		foreach( $arr[ 'contents' ] as $k => $v ) {
			$arr[ 'contents' ][ $k ][ 'content' ]      = wp_oo_adjust_content(  $v[ 'content' ], "\t\t\t\t\t\t\t\t" );
		}
	}
	$wp_page_array = $arr;
	$wp_page_title = $arr[ 'page_title' ];
	$wp_page_title_sub = $arr[ 'page_title_sub' ];