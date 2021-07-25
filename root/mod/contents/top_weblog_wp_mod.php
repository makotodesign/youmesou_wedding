<?php
/**--------------------------------------------------------------
 *
 * top_weblog_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// archive
	$the_posts_per_page      = 6;

##	base

##	data

##	wp

	/* posts */
	$res_arr = [];
	$args = [
		'post_type'      => 'weblog',
		'posts_per_page' => $the_posts_per_page
	];
	$the_query = new WP_Query( $args );
	// $the_query = $wp_query;
	if( $the_query->have_posts() ) {
		while( $the_query->have_posts() ) {
			$the_query->the_post();
			$arr = [];
			// id
			$this_post_id                                      = $the_query->post->ID; // $v->ID
			// base
			$arr[ 'post_id' ]                                  = $this_post_id;
			$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
			$arr[ 'permalink' ]                                = get_permalink( $this_post_id );
			// content
			$post_content                                      = apply_filters( 'the_content', get_post_field( 'post_content', $this_post_id ) );
			// $arr[ 'post_content' ]                             = wp_oo_acf_content( $post_content, "\t\t\t\t\t\t\t\t" );
			$arr[ 'post_excerpt' ]                             = wp_oo_content_trim( $post_content, 60, '...' );
			// dete
			$arr[ 'post_date' ]                                = get_the_date( 'Y/n/j', $this_post_id );
			$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			$arr[ 'eyecatch' ]                                 = wp_oo_acf_image( get_field( 'eyecatch', $this_post_id ), 'medium' );
			// add_res
			$res_arr[] = $arr;
		}
	}
	$wp_top_weblog_array = $res_arr;