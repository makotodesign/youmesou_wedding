<?php
/**--------------------------------------------------------------
 *
 * wp_csv_for_export_xx
 *
 * @reference
 * 		acf
 * 			textarea : そのまま
 * 			image    : oo_export_replace & wp_oo_acf_imageurl
 * 			content  : oo_export_replace
 *
 * @memo
 * 			旧サイトに使用するため 配列や三項演算子など古い記述で維持
 *
 --------------------------------------------------------------*/

##	error_reporting

	ini_set( 'display_errors', 1 );
	error_reporting(E_ALL);

##	setting

	$this_post_type = 'post';
	$switch_blog_id = 99;
	$mod_dir        = 'php';
	if( ! defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', '/home/hyogokai/www/official01' );

	// filename
	$prefix    =  'wp_csv_for_export_' . 'xxx';

	// replace
	$replace = array(
		array(
			'from' => 'https://www.xxx/',
			'to'   => 'https://xxx.sakura.ne.jp/official02/'
		),
		array(
			'from' => 'wp/wp-content/uploads/',
			'to'   => 'uploads/wpallimport/files/'
		),
		array(
			'from' => 'wp-content/uploads/',
			'to'   => 'uploads/wpallimport/files/'
		),
	);

##	base

	/* no_wp */
	if( ! defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', '/home/xxx/www/official01' );
	include_once ROOTREALPATH . '/wp/wp-load.php';
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* includes */
	//include_once ROOTREALPATH . '/php/lib/csv_download.class_ct18.php';
	include_once ROOTREALPATH . '/mod/lib/csv_download.class.php';
	$CSVD = new csv_download();
	$CSVD->convert_encoding_to = 'UTF-8';

##	func

	function oo_export_replace( $subject ) {
		global $replace;
		return str_replace( array_column( $replace, 'from' ), array_column( $replace, 'to' ), $subject );
	}

	function oo_export_checkbox( $acf_checkbox_arr ) {
		$res_arr           = array();
		if( is_array( $acf_checkbox_arr ) ) {
			foreach( $acf_checkbox_arr as  $v ) {
				$res_arr[] = isset( $v[ 'value' ] ) ? $v[ 'value' ] : $v;
			}
		}
		return join( ',', $res_arr );
	}

	function oo_export_image( $acf_image ) {
		$res_arr  = array();
		$image    = wp_oo_acf_image( $acf_image, 'url', '' ) ? wp_oo_acf_image( $acf_image, 'url', '' ) : '';
		return oo_export_replace( $image );
	}

	if( ! function_exists( 'wp_oo_acf_image' ) ) {
		function wp_oo_acf_image( $acf, $res_type = 'medium', $noimage = '/images/lib/parts/noimage_icon.svg' ){
			if( ! is_array( $acf ) ) {
				// acf返り値がboth出ない時の判定
				$res = ( $acf ) ? $acf : $noimage;
			} elseif( ! in_array( $res_type, [ 'url', 'thumbnail', 'medium', 'medium_large', 'large' ] ) ) {
				$res = 'error_oo_arg_res_type_text';
			} else {
				if( $res_type === 'url' ) {
					$res = ( $acf[ 'url' ] )                     ? $acf[ 'url' ]                     : $noimage;
				} elseif( $res_type === 'thumbnail' ) {
					$res = ( $acf[ 'sizes' ][ 'thumbnail' ] )    ? $acf[ 'sizes' ][ 'thumbnail' ]    : $noimage;
				} elseif( $res_type === 'medium' ) {
					$res = ( $acf[ 'sizes' ][ 'medium' ] )       ? $acf[ 'sizes' ][ 'medium' ]       : $noimage;
				} elseif( $res_type === 'medium_large' ) {
					$res = ( $acf[ 'sizes' ][ 'medium_large' ] ) ? $acf[ 'sizes' ][ 'medium_large' ] : $noimage;
				} elseif( $res_type === 'large' ) {
					$res = ( $acf[ 'sizes' ][ 'large' ] )        ? $acf[ 'sizes' ][ 'large' ]        : $noimage;
				} else {
					$res = $noimage;
				}
			}
			return $res;
		}
	}
	if( ! function_exists( 'wp_oo_acf_loop' ) ) {
		function wp_oo_acf_loop( $acf_arr, $acf_child_name = false ) {
			$acf_res = oo_adjust_array( $acf_arr );
			if( $acf_child_name &&  isset( $acf_res[ 0 ][ $acf_child_name ] )  ) {
				$acf_res = $acf_res[ 0 ][ $acf_child_name ];
			}
			return $acf_res;
		}
	}
	if( ! function_exists( 'oo_adjust_array' ) ) {
		function oo_adjust_array( $var ) {
			if( is_null( $var ) || ! is_array( $var ) || ! $var ) {
				$var = array();
			}
			return $var;
		}
	}


##	wp : get_posts_data

	/* switch_blog */
	if( $switch_blog_id !== 1 ) switch_to_blog( $switch_blog_id );

	/* get_posts */
	$res_arr = array();
	$args = array(
		'post_type'      => $this_post_type,
		'posts_per_page' => -1
	);
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$arr = array();
			// id
			$this_post_id                                      = $the_query->post->ID;
			// base
			$arr[ 'post_id' ]                                  = $this_post_id;
			$arr[ 'post_title' ]                               = $the_query->post->post_title;
			$arr[ 'post_name' ]                                = $the_query->post->post_name;
			$arr[ 'post_status' ]                              = $the_query->post->post_status;
			$arr[ 'post_date' ]                                = $the_query->post->post_date;
			// acf
			$arr[ 'acf_text_etc' ]                             = get_field( 'acf_text_etc', $this_post_id );
			$arr[ 'acf_textarea' ]                             = get_field( 'acf_textarea', $this_post_id );
			$arr[ 'acf_image' ]                                = oo_export_image( get_field( 'acf_image', $this_post_id ) );
			$arr[ 'acf_content' ]                              = oo_export_replace( get_field( 'acf_content', $this_post_id ) );
			$arr[ 'acf_checkbox' ]                             = oo_export_checkbox( get_field( 'acf_checkbox', $this_post_id ) );
			$temp_loop                                         = wp_oo_acf_loop( get_field( 'acf_loop', $this_post_id ));
			$arr[ 'acf_loop' ]                               = [];
			for( $i = 0; $i < 5; $i++ ) {
				$arr[ 'acf_loop' . $i . '_text' ]              = isset( $temp_loop[ $i ][ 'text' ] ) ? $temp_loop[ $i ][ 'text' ] : '';
				$arr[ 'acf_loop' . $i . '_pic' ]               = oo_export_image( $temp_loop[ $i ][ 'pic' ] );
			}
			// add_post
			$res_arr[] = $arr;
		}
	}
	$wp_export_array = $res_arr;

	/* switch_blog */
	if( $switch_blog_id !== 1 ) restore_current_blog();

##	action

	/* CSVダウンロード実行 */
	print '<pre>'.'$wp_export_array' . '：';var_dump($wp_export_array);print '</pre>' . "\n";
	// $CSVD->csv_create( $wp_export_array, $prefix );