<?php
/**--------------------------------------------------------------
 *
 * news_single_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* date */
	$date_format = 'Y/n/j';

##	base

##	wp : get_posts_data

	/* get_posts */
	if( have_posts() ) {
		the_post();
		$arr = [];
		// id
		$this_post_id                                      = $post->ID;
		// base
		$arr[ 'post_id' ]                                  = $this_post_id;
		$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
		// dete
		$arr[ 'post_date' ]                                = get_the_date( $date_format, $this_post_id );
		$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
		// acf : editor
		$arr[ 'detail' ]                                   = wp_oo_adjust_content( wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'detail' ), "\t\t\t\t\t\t\t\t" );
		// res_link
		$link_type                                         = wp_oo_acf_radio( wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'type' ), 'value' );
		$link_to_pdf                                       = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'pdf' );
		$link_to_url                                       = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'url' );
	}
	$wp_single_array = $arr;

##	info

	/* single_title */
	$wp_single_title = $arr[ 'post_title' ];

##	redirect

	if( $link_type == 'type_nolink' ){
		header( 'Location: ' . PUBLICDIR . '/news/');
	} else if( $link_type == 'type_link' ) {
		header( 'Location: ' . $link_to_url );
	} else if( $link_type == 'type_pdf' ){
		header( 'Location: ' . $link_to_pdf );
	}
