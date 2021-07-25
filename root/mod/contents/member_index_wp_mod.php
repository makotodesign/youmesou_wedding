<?php
/**--------------------------------------------------------------
 *
 * member_index_wp_mod
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
		$arr[ 'title_sub' ]                                = get_field( 'title_sub', $this_post_id );
		$arr[ 'members' ]                                  = get_field( 'members', $this_post_id );
		foreach( $arr[ 'members' ] as $k => $v ) {
			$arr[ 'members' ][ $k ][ 'comment' ]       =  wp_oo_adjust_content(  $v[ 'comment' ], "\t\t\t\t\t\t\t\t" );
			$arr[ 'members' ][ $k ][ 'logo' ]          = wp_oo_acf_image( $v[ 'logo' ], 'medium', '/images/lib/parts/noimage_icon.svg' );
		}
	}
	$wp_page_array = $arr;