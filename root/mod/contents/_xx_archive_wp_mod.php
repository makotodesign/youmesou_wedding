<?php
/**--------------------------------------------------------------
 *
 * xxx_archive_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// archive
	$the_posts_per_page      = -1;
	$the_taxonomy            = 'cat_xxx';

##	base

##	data

##	wp

	/* posts */
	$res_arr = [];
//	$args = [
//		'post_type'      => 'xxx',
//		'posts_per_page' => $the_posts_per_page
//	];
//	$the_query = new WP_Query( $args );
	$the_query = $wp_query;
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
			// dete
			$arr[ 'post_date' ]                                = get_the_date( 'Y/n/j（D） H:i:s', $this_post_id );
			$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			// taxonomy
			$temp_terms                                        = get_the_terms( $this_post_id, $the_taxonomy );
			$temp_terms                                        = $temp_terms ?? [];
			$temp_term                                         = $temp_terms[ 0 ] ?? '';
			$arr[ 'the_term_id' ]                              = $temp_term ? $temp_term->term_taxonomy_id : '';
			// acf
			$arr[ 'xxx_acfname' ]                              = get_field( 'xxx_acfname', $this_post_id );
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_textarea( get_field( 'xxx_acfname', $this_post_id ) );
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_radio( get_field( 'xxx_acfname', $this_post_id ), 'both' );
			$arr[ 'xxx_acfname' ]                              = wp_oo_date( 'Y/n/j（D）', get_field( 'xxx_acfname', $this_post_id ) );
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_image( get_field( 'xxx_acfname', $this_post_id ), 'medium' );
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_loop( get_field( 'xxx_acfname', $this_post_id ) );
			foreach( $arr[ 'xxx_acfname' ] as $k => $v ) {
				$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_image( $v[ 'yyy' ], 'medium', '/images/lib/parts/noimage_icon.svg' );
			}
			// add_res
			$res_arr[] = $arr;
		}
	}
	// taxonomy_archive
	//$wp_posts_array = wp_oo_adjust_taxonomy_archive( $res_arr, $the_taxonomy );
	$wp_posts_array = $res_arr;

	/* pager */
	$args = array(
		'base'               => str_replace( 99999999, '%#%', esc_url( get_pagenum_link( 99999999) ) ),
		'format'             => 'page/%#%/',
		'total'              => $the_query->max_num_pages, // wp_query : $the_query->max_num_pages
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
	$archive_name = 'xx一覧';
	if( is_post_type_archive() && is_month() ){ // is_month
		$wp_archive_title = get_query_var( 'year' ) . '年' . get_query_var( 'monthnum' ) . '月の' . $archive_name . $add_paging_str;
	} elseif( is_post_type_archive() && is_year() ){ // is_year
		$wp_archive_title = get_query_var( 'year' ) . '年の' . $archive_name . $add_paging_str;
	} elseif( is_tax() ){ // is_tax
		$temp_cat = get_the_category();
		$wp_archive_title = single_cat_title( '', false ) . 'の' . $archive_name . $add_paging_str;
	} elseif( is_post_type_archive() ){ // wp_home
		$wp_archive_title = '' . $archive_name . $add_paging_str;
	} else {
		$wp_archive_title = '' . $archive_name . $add_paging_str;
	}