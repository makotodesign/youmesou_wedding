<?php
/*--------------------------------------------------------------------------

	/_export/csvexport-xxx.php

---------------------------------------------------------------------------*/

##	error_reporting

	ini_set( 'display_errors', 1 );
	error_reporting(E_ALL);

##	setting

	// name
	$export_name    = 'xxx';
	$past_post_type = 'ppp';
	// replace
	$search = [
		'ttp://www.xxxxx/wp/wp-content/uploads/'
	];
	$replace = [
		'ttps://www.xxxxxx/official01/wp/wp-content/uploads/past/'
	];

##	base

	define( 'ROOTREALPATH', '/home/oldoffice/www/org01/ct18' );
	include_once ROOTREALPATH . '/wp/wp-blog-header.php';
	//include_once ROOTREALPATH . '/php/contents/wp_functions_mod.php';

##	data

	/* posts */
	// reset
	$res_arr = [];
	// posts_array
	$args = [
		'posts_per_page' => -1,
		'post_status'    => 'any',
		'post_type'      => $past_post_type
	];
	$the_query = new WP_Query( $args );
//print '$the_query'.'：';var_dump($the_query);print '<br>'."\n";
	if( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			/* wp_elements */
			$arr = [];
			// id
			$this_post_id                                      = $the_query->post->ID; // the_post() : $post->ID; || $v->ID
			// dete
			// base
			$arr[ 'post_title' ]                               = get_the_title( $this_post_id );
			$arr[ 'post_name' ]                                = $the_query->post->post_name;
			$arr[ 'post_date' ]                                = get_the_date( 'Y-m-d H:i:s', $this_post_id );
			$arr[ 'status' ]                                   = $the_query->post->post_status;
			// content
//			$arr[ 'post_content' ]                             = str_replace( "\n", '', apply_filters( 'the_content', get_post_field( 'post_content', $this_post_id ) ) );
//			$arr[ 'post_content' ]                             = str_replace( $search, $replace, $arr[ 'post_content' ] );
			// taxonomy:tag
//			$the_terms                                         = get_the_terms( $this_post_id, 'post_tag' );
//			$the_terms                                         = ( $the_terms ) ? $the_terms : [];
//			$temp_arr                                          = [];
//			foreach( $the_terms as $v ) {
//				$temp_arr[]                                    = $v->name;
//			}
//			$arr[ 'post_tag' ]                                 = implode( ',', $temp_arr );
			// taxonomy:category
//			$the_terms                                         = get_the_terms( $this_post_id, 'category' );
//			$the_terms                                         = ( $the_terms ) ? $the_terms : [];
//			$temp_arr                                          = [];
//			foreach( $the_terms as $v ) {
//				$temp_arr[]                                    = $v->name;
//			}
//			$arr[ 'category' ]                                 = implode( ',', $temp_arr );
			// acf
			$arr[ 'acf_xxx' ]                                  = str_replace( $search, $replace, $arr[ 'acf_xxx' ]  );

			$res_arr[] = $arr;
		}
	}
	$res_arr;

	print '$res_arr'.'：';var_dump($res_arr);print '<br>'."\n";

//	$file_handler = fopen( DIRNAME( __FILE__ ) . '/csv/export_' . $export_name . '.csv', "w" );
//	fputcsv( $file_handler, array_keys( $res_arr[ 0 ] ) );
//	foreach( $res_arr as $v ){
//		fputcsv( $file_handler, $v );
//	}
//	fclose( $file_handler );
