<?php
/**--------------------------------------------------------------
 *
 * xx_single_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// single
	$posts_per_page_relation = 6;

##	base

##	data

##	wp

	/* post */
	$arr = [];
//	if( get_post_status( $get_post_id ) ) {
	$the_query = $wp_query;
	if( $the_query->have_posts() ) {
		$the_query->the_post();
		// id
		$this_post_id                                      = $the_query->post->ID;
		// base
		$arr[ 'post_id' ]                                  = $this_post_id;
		$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
		// dete
		$arr[ 'post_date' ]                                = get_the_date( 'Y/n/j', $this_post_id );
		$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
		// content
		$post_content                                      = apply_filters( 'the_content', get_post_field( 'post_content', $this_post_id ) );
		$arr[ 'post_content' ]                             = wp_oo_acf_content( $post_content, "\t\t\t\t\t\t\t\t" );
		$arr[ 'eyecatch' ]                                 = wp_oo_acf_image( get_field( 'eyecatch', $this_post_id ), 'medium' );
	}
	$wp_single_array = $arr;

	/* relation */
	$res_arr = [];
	$args = [
		'post_type'      => 'weblog',
		'posts_per_page' => $posts_per_page_relation,
		'post__not_in'   => [ $wp_single_array[ 'post_id' ] ],
		// 'offset'         => $this_offset_num,
		// 'meta_query' => [
		// 	[
		// 		'key'   => 'xxx_acfname',
		// 		'value' => $wp_single_array[ 'xxx' ][ 'value' ]
		// 	],
		// 	[
		// 		'key'   => 'xxx_acfname',
		// 		'value' => $wp_single_array[ 'xxx' ][ 'value' ]
		// 	]
		// ]
	];
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$arr = [];
			// id
			$this_post_id                                      = $the_query->post->ID; // the_post() : $post->ID;;
			// base
			$arr[ 'post_id' ]                                  = $this_post_id;
			$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
			$arr[ 'post_date' ]                                = get_the_date( 'Y/n/j', $this_post_id );
			$arr[ 'permalink' ]                                = get_permalink( $this_post_id );
			// acf
			$arr[ 'eyecatch' ]                             = wp_oo_acf_image( get_field( 'eyecatch', $this_post_id ), 'medium' );
			/* add_res */
			$res_arr[] = $arr;
		}
	}
	$wp_relation_array = $res_arr;

##	info

	/* single_title */
	$wp_single_title      = $wp_single_array[ 'post_title' ];
