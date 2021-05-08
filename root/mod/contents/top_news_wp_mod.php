<?php
/**--------------------------------------------------------------
 *
 * top_news_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// admin_page
	$admin_page_id                 = 24;
	// headnews
	$headnews_flag                 = true;
	$headnews_detail_disp          = 'modal'; // modal || openclose || permalink
	// normalnews
	$the_posts_per_page_normalnews = 5;
	/* date */
	$date_format                   = 'Y/n/j';

##	base

	/* includes */
	include_once ROOTREALPATH . '/mod/contents/wp_news_parts_func.php';

##	wp

	/* headnews */
	$res_arr = [];
	$posts_array = [];
	if( $headnews_flag ) {
		$top_headnews_disp_type = wp_oo_acf_radio( get_field( 'top_headnews_disp_type', $admin_page_id ), 'value' );
		switch( $top_headnews_disp_type ) {
			// 常に最新の1件を表示
			case 'new':
				$args = array(
					'posts_per_page' => get_field( 'top_headnews_disp_num', $admin_page_id ),
					'post_type'      => 'news'
				);
				$posts_array = get_posts( $args );
				break;
			case 'hide':
				$posts_array = [];
				break;
			case 'select':
				// get_posts
				$posts_array = wp_oo_acf_relation( get_field( 'top_headnews', $admin_page_id ) );
				break;
			default:
				$posts_array = [];
		}
	}
	 $headnews_ids = [];
	if( is_array( $posts_array ) && $posts_array ) {
		foreach( $posts_array as $v ) {
			setup_postdata( $v );
			$arr = [];
			// id
			$this_post_id                                      = $v->ID;
			$headnews_ids[]                                    = $this_post_id;
			// base
			$arr[ 'post_id' ]                                  = $this_post_id;
			$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
			// dete
			$arr[ 'post_date' ]                                = get_the_date( $date_format, $this_post_id );
			$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			// res_link
			$temp_title                                        = wp_oo_acf_textarea( get_field( 'news_title', $this_post_id ) );
			$temp_link_type                                    = wp_oo_acf_radio( wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'type' ), 'value' );
			$temp_link_to                                      = [];
			if( $temp_link_type === 'type_detail' && $headnews_detail_disp === 'modal' ) {
				$arr[ 'news_link_type' ]                       = 'type_detail_modal';
				$temp_link_to[ 'modal_target' ]                = 'headnews_' . $this_post_id;
			} elseif( $temp_link_type === 'type_detail' && $headnews_detail_disp === 'openclose' ) {
				$arr[ 'news_link_type' ]                       = 'type_detail_openclose';
				$temp_link_to[ 'openclose_target' ]            = 'headnews_' . $this_post_id;
			} else {
				$arr[ 'news_link_type' ]                       = $temp_link_type;
			}
			$temp_link_to[ 'permalink' ]                       = get_permalink( $this_post_id );
			$temp_link_to[ 'pdf' ]                             = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'pdf' );
			$temp_link_to[ 'url' ]                             = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'url' );
			$arr[ 'detail' ]                                   = wp_oo_adjust_content( wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'detail' ), "\t\t\t\t\t\t\t" );
			$arr[ 'title' ]                                    = res_news_parts( 'title', $arr[ 'news_link_type' ], $temp_title, $temp_link_to );
			// add_res
			$res_arr[] = $arr;
		}
	}
	$wp_top_headnews_array = $res_arr;

	/* normalnews */
	$res_arr = [];
	$args = [
		'posts_per_page' => $the_posts_per_page_normalnews,
		'post__not_in'   => $headnews_ids,
		'post_type'      => 'news'
	];
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$arr = [];
			// id
			$this_post_id                                      = $the_query->post->ID;
			// base
			$arr[ 'post_id' ]                                  = $this_post_id;
			$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
			// dete
			$arr[ 'post_date' ]                                = get_the_date( $date_format, $this_post_id );
			$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			// res_link
			$temp_title                                        = wp_oo_acf_textarea( get_field( 'news_title', $this_post_id ) );
			$temp_link_type                                    = wp_oo_acf_radio( wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'type' ), 'value' );
			$temp_link_to[ 'permalink' ]                       = get_permalink( $this_post_id );
			$temp_link_to[ 'pdf' ]                             = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'pdf' );
			$temp_link_to[ 'url' ]                             = wp_oo_acf_group( get_field( 'news_link', $this_post_id ), 'url' );
			$arr[ 'title' ]                                    = res_news_parts( 'title', $temp_link_type, $temp_title, $temp_link_to );
			// add_res
			$res_arr[] = $arr;
		}
	}
	$wp_top_normalnews_array = $res_arr;
