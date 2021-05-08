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
	$posts_per_page_relation = 5;
	$the_taxonomy            = 'cat_xxx';

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
		$arr[ 'post_date' ]                                = get_the_date( 'Y/n/j H:i:s（D）', $this_post_id );
		$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
		// content
		$post_content                                      = apply_filters( 'the_content', get_post_field( 'post_content', $this_post_id ) );
		$arr[ 'post_content' ]                             = wp_oo_acf_content( $post_content, "\t\t\t\t\t\t\t\t" );
		// taxonomy
		$temp_terms                                        = get_the_terms( $this_post_id, $the_taxonomy );
		$temp_terms                                        = $temp_terms ?? [];
		$temp_term                                         = $temp_terms[ 0 ] ?? '';
		$arr[ 'the_term_id' ]                              = $temp_term ? $temp_term->term_taxonomy_id : '';
		$arr[ 'the_term_slug' ]                            = $temp_term ? $temp_term->slug : '';
		$arr[ 'the_term_name' ]                            = $temp_term ? $temp_term->name : '';
		$arr[ 'the_term_parent' ]                          = $temp_term ? $temp_term->parent : '';
		$arr[ 'the_term_taxonomy' ]                        = $temp_term ? $temp_term->taxonomy : '';
		$arr[ 'the_term_link_tag' ]                        = '<a href="/xxxxx/' . $temp_term->taxonomy . '/' . $temp_term->slug . '/">' . $temp_term->name . '</a>';
		$arr[ 'the_term_xxx_acfname' ]                     = get_field( 'xxx_acfname', $temp_term->taxonomy . '_' . $temp_term->term_taxonomy_id );
		$arr[ 'the_terms' ]                                = [];
		foreach( $temp_terms as $k => $v ) {
			$arr[ 'the_terms' ][ $k ]                      = $v->term_taxonomy_id;
		}
		// acf
		$arr[ 'xxx_acfname' ]                              = get_field( 'xxx_acfname', $this_post_id );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_textarea( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_textarea_to_arr( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_content( get_field( 'xxx_acfname', $this_post_id ), "\t\t\t\t\t\t\t\t" );
		$arr[ 'xxx_acfname_excerpt' ]                      = wp_oo_content_trim( get_field( 'xxx_acfname', $this_post_id ), 60, '...more' );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_radio( get_field( 'xxx_acfname', $this_post_id ), 'both' );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_select( get_field( 'xxx_acfname', $this_post_id ), 'both' );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_checkbox( get_field( 'xxx_acfname', $this_post_id ), 'both' );
		$arr[ 'xxx_acfname' ]                              = wp_oo_date( 'Y/n/j（D）', get_field( 'xxx_acfname', $this_post_id ) );
		$temp_acf_timestamp                                = wp_oo_timestamp_from_His( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = date_oo( 'a h:i:s', $temp_acf_timestamp );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_image( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_relation( get_field( 'xxx_acfname', $this_post_id ) );
		$arr[ 'xxx_acfname' ]                              = wp_oo_acf_loop( get_field( 'xxx_acfname', $this_post_id ) );
		foreach( $arr[ 'xxx_acfname' ] as $k => $v ) {
			$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_textarea( $v[ 'yyy' ] );
			$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_image( $v[ 'yyy' ], 'medium' );
			$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_radio( $v[ 'yyy' ], 'value' );
		}
		/*
			aaa
			bbb
			ccc
		*/
		// acf : group
		$arr[ 'xxx_acfname' ][ 'yyy' ]                     = wp_oo_acf_group( get_field( 'xxx_acfname', $this_post_id ), 'yyy' ); // arg2 があれば 特定の値
		$arr[ 'googlemap' ]                                = wp_oo_acf_group( get_field( 'googlemap', $this_post_id ) );
		/*
			lat
			lng
			url
		*/
	}
	$wp_single_array = $arr;

	/* relation */
	$res_arr = [];
	$args = [
		'posts_per_page' => $posts_per_page_relation,
		'post__not_in'   => [ $wp_single_array[ 'post_id' ] ],
		'offset'         => $this_offset_num,
		'meta_query' => [
			[
				'key'   => 'xxx_acfname',
				'value' => $wp_single_array[ 'xxx' ][ 'value' ]
			],
			[
				'key'   => 'xxx_acfname',
				'value' => $wp_single_array[ 'xxx' ][ 'value' ]
			]
		]
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
			$arr[ 'permalink' ]                                = get_permalink( $this_post_id );
			// acf
			$arr[ 'xxx_acfname' ]                              = get_field( 'xxx_acfname', $this_post_id );
			/* add_res */
			$res_arr[] = $arr;
		}
	}
	$wp_relation_array = $res_arr;

##	info

	/* single_title */
	$wp_single_title      = $wp_single_array[ 'post_title' ];
