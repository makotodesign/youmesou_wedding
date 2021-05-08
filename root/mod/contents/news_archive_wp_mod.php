<?php
/**--------------------------------------------------------------
 *
 * news_archive_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* date */
	$date_format = 'Y/n/j';

##	base

	/* includes */
	include_once ROOTREALPATH . '/mod/contents/wp_news_parts_func.php';

##	wp : get_posts_data

	/* get_posts */
	$res_arr = [];
	$the_query = $wp_query;
	if( $the_query->have_posts() ) {
		while( $the_query->have_posts() ) {
			$the_query->the_post();
			$arr = [];
			// id
			$this_post_id                                      = $the_query->post->ID;
			// base
			$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
			// dete
			$arr[ 'post_date' ]                                = get_the_date( $date_format, $this_post_id );
			$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			// res_link
			$temp_title                                        = wp_oo_acf_textarea( get_field( 'news_title', $this_post_id ) );
			$arr[ 'news_link_type' ]                           = wp_oo_acf_radio( wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'type' ), 'value' );
			$temp_link_to[ 'permalink' ]                       = get_permalink( $this_post_id );
			$temp_link_to[ 'pdf' ]                             = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'pdf' );
			$temp_link_to[ 'url' ]                             = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'url' );
			$arr[ 'title' ]                                    = res_news_parts( 'title', $arr[ 'news_link_type' ], $temp_title, $temp_link_to );
			// add_res
			$res_arr[] = $arr;
		}
	}
	$wp_posts_array = $res_arr;

	/* pager */
	// normal
	$args = array(
		'base'               => str_replace( 99999999, '%#%', esc_url( get_pagenum_link( 99999999) ) ),
		'format'             => 'page/%#%/',
		'total'              => $the_query->max_num_pages,
		'mid_size'           => 2,
		'type'               => 'array',
		'current'            => get_query_var( 'paged', 1 ),
		'prev_text'          => '<span>&lt;</span>',
		'next_text'          => '<span>&gt;</span>',
		'before_page_number' => '<span>',
		'after_page_number'  => '</span>'
	);
	$wp_pager_array = paginate_links( $args );

##	info

	/* archive_title */
	$add_paging_str = ( is_paged() ) ? ' [ ' . get_query_var( 'paged', 1 ) . '/' . $wp_query->max_num_pages . ' ]' : '';

	if( is_year() ){ // wp_year
		$wp_archive_title = get_query_var( 'year' ) . '年のお知らせ一覧' . $add_paging_str;
	} else {
		$wp_archive_title = 'お知らせ一覧' . $add_paging_str;
	}
