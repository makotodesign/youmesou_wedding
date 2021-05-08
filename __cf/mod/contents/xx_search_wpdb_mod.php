<?php
/*--------------------------------------------------------------

	xx_search_wpdb_mod

	@memo

---------------------------------------------------------------*/

##	setting

	/* wp */
	$display_posts_per_page = 20; // -1:all

##	base

	/* wp : wpdb */
	global $wpdb;

##	data

	/* wp : keyword */
	$keyword = get_search_query();
	$adjust_keyword = '%' . like_escape( $keyword ) . '%';

	/* wp : search_sql */
	// wp_meta
	$sql = '
		SELECT
			DISTINCT post_id
		FROM
			' . $wpdb->postmeta . '
		WHERE
			meta_value LIKE "%s"
	';
	$post_ids_meta = $wpdb->get_col( $wpdb->prepare( $sql, $adjust_keyword ) );
	// wp_post
	$sql = '
		SELECT
			DISTINCT post_id
		FROM
			' . $wpdb->posts . '
		WHERE
			post_title LIKE "%s"
	';
	$post_ids_post = $wpdb->get_col( $wpdb->prepare( $sql, $adjust_keyword ) );
	// wp_meta & wp_post
	$post_ids = array_values( array_unique( array_merge( $post_ids_meta, $post_ids_post ) ) );

##	wp : get_posts_data

	/* posts */
	// arg
	$args = array(
		'posts_per_page' => $display_posts_per_page,
		'category__not_in' => array( 1 ),
		'post__in'         => $post_ids,
		'post_type'        => 'post',
		'post_status'      => 'publish'
	);
	$the_query = new WP_Query( $args );
	// reset
	$arr = [];
	$i = 0;
	// get_posts
	if( $the_query->have_posts() && $post_ids ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			/* wp_elements */
			// id
			$this_post_id                                     = $post->ID;
			// base
			$arr[ $i ][ 'post_id' ]                           = $this_post_id;
			$arr[ $i ][ 'post_title' ]                        = get_the_title( $this_post_id );
			$arr[ $i ][ 'permalink' ]                         = get_permalink( $this_post_id );
			// dete
			$arr[ $i ][ 'post_date' ]                         = get_the_date( 'Ymd', $this_post_id );
			$arr[ $i ][ 'post_date_code' ]                    = get_the_date( 'Y-m-d', $this_post_id );
			// content
			$temp_content                                     = apply_filters( 'the_content', get_the_content() );
			$arr[ $i ][ 'post_excerpt' ]                      = wp_content_trim( get_the_content(), 60, '...more' );
			// acf
			$arr[ $i ][ 'acfxxxxxxxxx' ]                      = get_field( 'acfxxxxxxxxx', $this_post_id );
			// add_post_num
			$i++;
		}
	}
	// posts_array
	$wp_posts_array_archive = $arr;

##	tag

	/* search_contents */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t";

	$tag .= $tb . "" . '<form method="get" action="' . home_url( '/' ) . '" class="search">' . "\n";
	$tag .= $tb . "\t" . '<input type="text" name="s" class="searchbox">' . "\n";
	$tag .= $tb . "\t" . '<input type="submit" value="検索" class="btn">' . "\n";
	$tag .= $tb . "" . '</form>' . "\n";

	$tag_search_contents = $tag;

	/* archive_contents */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t";
	$arr = $wp_posts_array_archive;

	$tag .= $tb . "\t" . '<p>' . $the_query->found_posts . '件中1-' . $the_query->found_posts . '件を表示</p>' . "\n";
	for( $i = 0; $i < count( $arr ); $i++ ) {
		$tag .= $tb . "\t" . '' . $arr[ $i ][ 'acfxxxxxxxxx' ] . '' . "\n";
	}

	$tag_archive_contents = $tag;
?>