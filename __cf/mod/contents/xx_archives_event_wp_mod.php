<?php
/*--------------------------------------------------------------

	xxevent_archive_wp_mod

	@memo

---------------------------------------------------------------*/

##	setting

	/* wp */
	$switch_blog_id = 10;
	$display_posts_per_page = -1;

##	base

	/* base_info */
	$today  = date_oo( 'Ymd' );

	/* total_posts_num */
	global $wp_query;
	$total_posts_num = $wp_query->found_posts;

##	data

	/* get */
	$get = ( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' ) ? $BASE->sanitize_server_request( $_GET ) : [];
	$page_id = ( isset( $get[ 'page' ] ) && $get[ 'page' ] ) ? $get[ 'page' ] : 1; // (int)

##	wp : get_posts_data

	/* switch_blog ( another_blog ) */
	switch_to_blog( $switch_blog_id );

	/* posts */
	// reset
	$arr = [];
	$i = 0;
	// get_posts
	$args = array(
		'posts_per_page' => $display_posts_per_page,
		'paged'          => get_query_var( 'paged', 1 ),
		'orderby'        => 'event_date',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'            => 'event_date',
				'value'          => $today,
				'compare'        => '>='
			)
		)
	);
	$posts_array = get_posts( $args );
	if( is_array( $posts_array ) && $posts_array ) {
		foreach( $posts_array as $post ) {
			setup_postdata( $post );
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
			// acf
			$arr[ $i ][ 'acfxxxxxxxxx' ]                      = get_field( 'acfxxxxxxxxx', $this_post_id );
			// acf : textarea
			$arr[ $i ][ 'acfxxxxxxxxx' ]                      = wp_acf_textarea( get_field( 'acfxxxxxxxxx', $this_post_id ) );
			// acf : date
			$temp_date                                        = get_field( 'acfxxxxxxxxx', $this_post_id );
			$temp_timestamp                                   = mktime( 0, 0, 0, substr( $temp_date, 4, 2 ), substr( $temp_date, 6, 2 ), substr( $temp_date, 0, 4 ) );
			$arr[ $i ][ 'acfxxxxxxxxx' ]                      = $temp_date;
			$arr[ $i ][ 'acfxxxxxxxxx_fromated' ]             = date_oo( 'Y/n/j（D）', $temp_timestamp );
			/* add_post_num */
			$i++;
		}
	}
	// posts_array
	$wp_posts_array = $arr;

	/* restore_current_blog */
	restore_current_blog();

##	tag

	/* archive_contents */
	$tag = '';
	$tb  = "\t\t\t\t\t\t\t\t";
	$arr = $wp_posts_array;

	$tag .= $tb . "" . '' . "\n";
	for( $i = 0; $i < count( $arr ); $i++ ) {
		$tag .= $tb . "\t" . '' . $arr[ $i ][ 'aaa' ] . '' . "\n";
	}
	$tag .= $tb . "" . '' . "\n";

	$tag_archive_contents = $tag;
?>