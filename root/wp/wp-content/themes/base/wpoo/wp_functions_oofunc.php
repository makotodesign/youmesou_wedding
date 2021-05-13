<?php
/**--------------------------------------------------------------
 *
 * wp_functions_oofunc
 *
 * @version
 * 		18.1.1
 *
 * @history
 * 		2021-01-03	wp_oo_get_term link追加
 * 					wp_oo_adjust_taxonomy_archive 修正 [ 17.1.1 ]
 * 		2020-03-26	oo 関数を抽出 [ 16.1.1 ]
 * 		2021-05-05	グローバル変数変換（$post_type など） [ 17.1.1 ]
 * 					注釈の記述を変更
 *
 --------------------------------------------------------------*/

	/**------------------------------------------------------
	 *
	 * ACF
	 *
	------------------------------------------------------ */

	##	textarea

	function wp_oo_acf_textarea( $texts ){
		$texts = nl2br( $texts, false );                                      // <br>追加
		$texts = str_replace( '<br />', '<br>', $texts );                     // html5タグ
		$texts = str_replace( [ "\r\n", "\n", "\r" ], '', $texts );      // 改行除去
		return $texts;
	}
	// wp_oo_acf_textarea_to_arr
	function wp_oo_acf_textarea_to_arr( $texts ){
		$texts = wp_oo_acf_textarea( $texts );                                // <br>追加
		$temp_arr = ( $texts ) ? explode( '<br>', $texts ) : [];
		return $temp_arr;
	}

	##	editor

	function wp_oo_acf_content( $content, $tb = "\t\t\t\t\t\t\t", $prefix = '', $suffix = '' ) {
		wp_oo_adjust_content( $content, $tb, $prefix, $suffix );
		return $content;
	}
	//  エディタタグの整形
	function wp_oo_adjust_content( $content, $tb = "\t\t\t\t\t\t\t", $prefix = '', $suffix = '' ) {
		$content = str_replace( [ "\r\n", "\n", "\r" ], '', $content );  // 改行除去
		$content = str_replace( '<br />', '<br>', $content );                 // html5タグ
		$content = str_replace( '<p', "\n" . $tb . '<p', $content );          // <p>改行
		$content = str_replace( '<h', "\n" . $tb . '<h', $content );          // <h>改行
		$content = str_replace( '<ul', "\n" . $tb . '<ul', $content );        // <ul>改行
		$content = str_replace( '<ol', "\n" . $tb . '<ol', $content );        // <ol>改行
		$content = str_replace( '</ul', "\n" . $tb . '</ul', $content );      // </ul>改行
		$content = str_replace( '</ol', "\n" . $tb . '</ol', $content );      // </ol>改行
		$content = str_replace( '<li', "\n" . $tb . "\t" . '<li', $content ); // <li>改行
		$content = trim( $content );                                          // 先頭/末尾の空白文字(" \t\n\r\0\x0B")除去
		$content = $prefix . $content . $suffix;                              // prefix & suffix
		return $content;
	}
	// エディタ内最初の画像
	function wp_oo_first_image_in_content( $content = false ) {
		$first_img = '';
		if( ! $content ) {
			$this_post = get_queried_object();
			if( is_object( $this_post ) ) {
				$content = $this_post->post_content;
			}
		}
		if( $content ) {
			preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches );
			$first_img = $matches[ 1 ][ 0 ] ?? '';
		}
		return $first_img;
	}

	##	image

	// wp_oo_acf_image : 画像がない場合は「noimage_path」
	function wp_oo_acf_image( $acf, $res_type = 'medium', $noimage = '/images/lib/parts/noimage_icon.svg' ){
		if( ! is_array( $acf ) ) {
			// acf返り値がboth出ない時の判定
			$res = ( $acf ) ? $acf : $noimage;
		} elseif( ! in_array( $res_type, array( 'url', 'thumbnail', 'medium', 'medium_large', 'large', 'filename' ) ) ) {
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
			} elseif( $res_type === 'filename' ) {
				$res = ( $acf[ 'filename' ] )                ? $acf[ 'filename' ]                : false;
			} else {
				$res = $noimage;
			}
		}
		return $res;
	}
	function wp_oo_acf_image_fileinfo( $url_img = '', $type = 'fname' ){
		if( $url_img ) {
			preg_match( '/[^\/]+\.(\w+)$/u', $url_img, $matches );
			if( $type === 'ext' ) {
				return $matches[ 1 ];
			} else {
				return $matches[ 0 ];
			}
		}
	}

	##	radio

	function wp_oo_acf_radio( $acf, $res_type = 'both' ){
		if( $res_type === 'both' ) {
			if( is_array( $acf ) ) {
				$res[ 'value' ] = ( isset( $acf[ 'value' ] ) ) ? $acf[ 'value' ] : 'error_value';
				$res[ 'label' ] = ( isset( $acf[ 'label' ] ) ) ? $acf[ 'label' ] : 'error_label';
			} else {
				$res[ 'value' ] = $acf;
				$res[ 'label' ] = $acf;
			}
		} elseif( $res_type === 'value' ) {
			if( is_array( $acf ) ) {
				$res = ( isset( $acf[ 'value' ] ) ) ? $acf[ 'value' ] : 'error_value';
			} else {
				$res = $acf;
			}
		} elseif( $res_type === 'label' ) {
			if( is_array( $acf ) ) {
				$res = ( isset( $acf[ 'label' ] ) ) ? $acf[ 'label' ] : 'error_value';
			} else {
				$res = $acf;
			}
		}
		return $res;
	}

	##	select

	function wp_oo_acf_select( $acf, $res_type = 'both' ){
		return wp_oo_acf_radio( $acf, $res_type );
	}

	##	checkbox

	function wp_oo_acf_checkbox( $acf_res, $res_type = 'both' ) {
		$arr = oo_adjust_array( $acf_res );
		$res_arr = [];
		if( $res_type === 'value' ) {
			foreach( $arr as $v ) {
				if( isset( $v[ 'value' ] ) ) {
					$res_arr[] = $v[ 'value' ];
				} else {
					$res_arr[] = $v;
				}
			}
		} elseif( $res_type === 'label' ) {
			foreach( $arr as $v ) {
				if( isset( $v[ 'label' ] ) ) {
					$res_arr[] = $v[ 'label' ];
				} else {
					$res_arr[] = $v;
				}
			}
		} else {
			$res_arr = $arr;
		}
		return $res_arr;
	}

	##	relation

	function wp_oo_acf_relation( $acf_res ) {
		$acf_res = oo_adjust_array( $acf_res );
		$res_arr = [];
		foreach( $acf_res as  $v ) {
			if( get_post_status( $v ) === 'publish' || is_user_logged_in() ) {
				$res_arr[] = $v;
			}
		}
		return $res_arr;
	}

	##	loop

	function wp_oo_acf_loop( $acf_arr, $acf_child_name = false ) {
		$acf_res = oo_adjust_array( $acf_arr );
		if( $acf_child_name &&  isset( $acf_res[ 0 ][ $acf_child_name ] )  ) {
			$acf_res = $acf_res[ 0 ][ $acf_child_name ];
		}
		return $acf_res;
	}

	##	group

	function wp_oo_acf_group( $acf_arr, $acf_child_name = false ) {
		$acf_res = oo_adjust_array( $acf_arr );
		if( $acf_child_name && isset( $acf_res[ $acf_child_name ] ) ) {
			$acf_res = $acf_res[ $acf_child_name ];
		}
		return $acf_res;
	}

	/**------------------------------------------------------
	 *
	 * 独自値取得
	 *
	------------------------------------------------------ */

	##	投稿順序

	function wp_oo_get_serial_number( $this_post_type = 'post', $op = '<=' ) {
		global $wpdb;
		$this_post = get_queried_object();
		$this_post_type = is_array( $this_post_type ) ? '(' . implode( ',', $this_post_type ) . ')' : $this_post_type;
		$sql = "SELECT
				COUNT( * )
			FROM
				{$wpdb->posts}
			WHERE  post_date {$op} %s
				   AND post_status = 'publish'
				   AND post_type = %s
		";
		$sql_val = [
			$this_post->post_date,
			$this_post_type
		];
		$number = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) );
		return $number;
	}

	##	Ymdからタイムスタンプ

	function wp_oo_timestamp_from_Ymd( $Ymd ){
		$ymd_separet_array = [];
		$ymd_separet_array[ 'Y' ] = substr( $Ymd, 0, 4 );
		$ymd_separet_array[ 'm' ] = substr( $Ymd, 4, 2 );
		$ymd_separet_array[ 'd' ] = substr( $Ymd,-2 );
		return  mktime( 0, 0, 0, $ymd_separet_array[ 'm' ], $ymd_separet_array[ 'd' ], $ymd_separet_array[ 'Y' ] );
	}

	##	Ymdから日付

	function wp_oo_date_from_Ymd( $format, $acf, $acf_format = 'U' ){
		if( $acf_format === 'Ymd' ) {
			$timestamp = wp_oo_timestamp_from_Ymd( $acf );
		} else {
			$timestamp = $acf;
		}
		return  date_i18n( $format, $timestamp );
	}

	##	Hisからタイムスタンプ

	function wp_oo_timestamp_from_His( $His ){
		$his_separet_array = [];
		$his_separet_array[ 'H' ] = substr( $His, 0, 2 );
		$his_separet_array[ 'i' ] = substr( $His, 2, 2 );
		$his_separet_array[ 's' ] = substr( $His, -2 );
		return mktime( $his_separet_array[ 'H' ], $his_separet_array[ 'i' ], $his_separet_array[ 's' ] );
	}
	//  wp_oo_content_trim
	function wp_oo_content_trim( $content, $length = 70, $add_text = '...' ) {
		$content = preg_replace( '/<!--more-->.+/is', '', $content );         // moreタグ以降削除
		$content = strip_shortcodes( $content );                              // ショートコード削除
		$content = strip_tags( $content );                                    // タグ除去
		$content = str_replace( '&nbsp;', '', $content );                     // 特殊文字の削除（現在スペースのみ）
		$content = str_replace( [ "\r\n", "\n", "\r" ], '', $content );  // 改行除去
		if( mb_strlen( $content ) > $length ) {
			$content = mb_substr( $content, 0, $length );
			$content .= $add_text;
		}
		return $content;
	}

	/**------------------------------------------------------
	 *
	 * ページャー
	 *
	------------------------------------------------------ */

	/* wp_oo_pager */
	function wp_oo_pager( $args = [], $add_param_array = [] ) {

		$arr = [];
		$max_pages = ( int ) $args[ 'total' ];
		// param
		$add_param = '';
		foreach( $add_param_array as $k => $v ) {
			$add_param .= '&' . $k . '=' . $v;
		}
		// error
		if( ! isset( $args[ 'base' ] ) || ! isset( $args[ 'total' ] ) ) {
			$error_arr = [];
			if( ! isset( $args[ 'base' ] ) )  $error_arr[] = 'wp_oo_pager_error : no_base_link';
			if( ! isset( $args[ 'total' ] ) ) $error_arr[] = 'wp_oo_pager_error : no_max_pages';
			return implode( ' / ', $error_arr );
		}
		// default
		if( ! isset( $args[ 'mid_size' ] ) )            $args[ 'mid_size' ]           = 2;
		if( ! isset( $args[ 'current' ] ) )             $args[ 'current' ]            = 1;
		if( ! isset( $args[ 'prev_text' ] ) )           $args[ 'prev_text' ]          = '';
		if( ! isset( $args[ 'next_text' ] ) )           $args[ 'next_text' ]          = '';
		if( ! isset( $args[ 'before_page_number' ] ) )  $args[ 'before_page_number' ] = '<span>';
		if( ! isset( $args[ 'after_page_number' ] ) )   $args[ 'after_page_number' ]  = '</span>';
		// res
		if( $args[ 'total' ] === 1 ) {
			return;
		} elseif ( $args[ 'total' ] > 1 ) {
			if( $args[ 'current' ] > 1 && $args[ 'prev_text' ] ) {
				// prev
				$arr[] = '<a href="' . $args[ 'base' ] . '?paging=' . ( $args[ 'current' ] - 1 ) . $add_param . '" class="prev">' . $args[ 'prev_text' ] . '</a>';
			}
			// 1
			if( $args[ 'current' ] > 1 ) {
				$arr[] = '<a href="' . $args[ 'base' ] . '?paging=' . 1 . $add_param . '">' . $args[ 'before_page_number' ] . '1' . $args[ 'after_page_number' ] . '</a>';
			} else {
				$arr[] = '<a class="current">' . $args[ 'before_page_number' ] . '1' . $args[ 'after_page_number' ] . '</a>';
			}
			if( 2 < $args[ 'current' ] - $args[ 'mid_size' ] ) {
				$arr[] = '<span class="dots">&hellip;</span>';
			}
			for( $i = 2; $i < $args[ 'total' ]; $i++ ) {
				if( $i >= $args[ 'current' ] - $args[ 'mid_size' ] && $i <= $args[ 'current' ] + $args[ 'mid_size' ] ) {
					if( $i == $args[ 'current' ] ) {
						$arr[] = '<a class="current">' . $args[ 'before_page_number' ] . '' . $i . '' . $args[ 'after_page_number' ] . '</a>';
					} else {
						$arr[] = '<a href="' . $args[ 'base' ] . '?paging=' . $i . $add_param . '">' . $args[ 'before_page_number' ] . '' . $i . '' . $args[ 'after_page_number' ] . '</a>';
					}
				}
			}
			if( $args[ 'total' ] - 1 > $args[ 'current' ] + $args[ 'mid_size' ] ) {
				$arr[] = '<span class="dots">&hellip;</span>';
			}
			// max_pages
			if( $args[ 'current' ] === $args[ 'total' ] ) {
				$arr[] = '<a class="current">' . $args[ 'before_page_number' ] . '' . $args[ 'total' ] . '' . $args[ 'after_page_number' ] . '</a>';
			} else {
				$arr[] = '<a href="' . $args[ 'base' ] . '?paging=' . $args[ 'total' ] . $add_param . '">' . $args[ 'before_page_number' ] . '' . $args[ 'total' ] . '' . $args[ 'after_page_number' ] . '</a>';
			}
			if( $args[ 'current' ] < $args[ 'total' ] && $args[ 'next_text' ] ) {
				// next
				$arr[] = '<a href="' . $args[ 'base' ] . '?paging=' . ( $args[ 'current' ] + 1 ) . $add_param . '" class="next">' . $args[ 'next_text' ] . '</a>';
			}
		}
		return $arr;
	}

	/**------------------------------------------------------
	 *
	 * taxonomy
	 *
	------------------------------------------------------ */

	##	posts から taxonomy_archive を生成 posts内に'the_term_id'必須

	function wp_oo_adjust_taxonomy_archive( $arr, $taxonomy, $depth = 2 ) {
		$res_arr = [];
		$temp_arr = [];
		foreach( $arr as  $v ) {
			if( $v[ 'the_term_id' ] ) {
				$temp_arr[ $v[ 'the_term_id' ] ][] = $v;
			}
		}
		$args = [
			'hide_empty' => false,
			'taxonomy'   => $taxonomy
		];
		foreach( get_categories( $args ) as $v ) {
			if( $v->parent === 0 ) {
				$res_arr[ $v->term_taxonomy_id ][ 'slug' ]  = $v->slug;
				$res_arr[ $v->term_taxonomy_id ][ 'name' ]  = $v->name;
				$res_arr[ $v->term_taxonomy_id ][ 'posts' ] = $temp_arr[ $v->term_taxonomy_id ] ?? [];
			} else {
				$res_arr[ $v->parent ][ 'child' ][ $v->term_taxonomy_id ][ 'slug' ]  = $v->slug;
				$res_arr[ $v->parent ][ 'child' ][ $v->term_taxonomy_id ][ 'name' ]  = $v->name;
				$res_arr[ $v->parent ][ 'child' ][ $v->term_taxonomy_id ][ 'posts' ] = $temp_arr[ $v->term_taxonomy_id ] ?? [];
			}
		}
		return $res_arr;
	}

	##	term 階層取得 * 4階層まで

	function wp_oo_get_term( $taxonomy, $depth = 4, $base_parent = 0, $args = false ) {
		$res_arr = [];
		if( ! $args ) {
			$args = [
				'hide_empty'    => false,
				'fields'        => 'all',
				'parent'        => $base_parent
			];
		}
		$terms = get_terms( $taxonomy, $args );
		$res_arr = [];
		foreach( $terms as $v ) {
			$res_arr[ $v->term_id ] = [
				'name'  => $v->name,
				'slug'  => $v->slug,
				'count' => $v->count,
				'link'  => get_category_link( $v->term_id )
			];
			if( $depth > 1 ) {
				$args[ 'parent' ] = $v->term_id;
				$c = get_terms( $taxonomy, $args );
				if( $c ) {
					foreach( $c as $vv ) {
						$res_arr[ $v->term_id ][ 'children' ][ $vv->term_id ] = [
							'name'  => $vv->name,
							'slug'  => $vv->slug,
							'count' => $vv->count,
							'link'  => get_category_link( $vv->term_id )
						];
						if( $depth > 2 ) {
							$args[ 'parent' ] = $vv->term_id;
							$cc = get_terms( $taxonomy, $args );
							if( $cc ) {
								foreach( $cc as $vvv ) {
									$res_arr[ $v->term_id ][ 'children' ][ $vv->term_id ][ 'children' ][ $vvv->term_id ] = [
										'name'  => $vvv->name,
										'slug'  => $vvv->slug,
										'count' => $vvv->count,
										'link'  => get_category_link( $vvv->term_id )
									];
									if( $depth >3 ) {
										$args[ 'parent' ] = $vvv->term_id;
										$ccc = get_terms( $taxonomy, $args );
										if( $ccc ) {
											foreach( $ccc as $vvvv ) {
												$res_arr[ $v->term_id ][ 'children' ][ $vv->term_id ][ 'children' ][ $vvv->term_id ][ 'children' ][ $vvvv->term_id ] = [
													'name'  => $vvvv->name,
													'slug'  => $vvvv->slug,
													'count' => $vvvv->count,
													'link'  => get_category_link( $vvvv->term_id )
												];
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
		return $res_arr;
	}

	##	タグクラウド

	function wp_oo_tag_cloud( $args ){
		/*
		$args = [
			'smallest'                  => 1,
			'largest'                   => 5,
			'number'                    => 20,
			'format'                    => 'array',
			'order'                     => 'RAND',
			'taxonomy'                  => 'xxxxx',
			'echo'                      => false
		);
		*/

		$args = array_merge();

		$tag_cloud_arr = wp_tag_cloud( $args );
		$res_arr = [];
		foreach( $tag_cloud_arr as $v ){
			$arr = [];
			// href
			preg_match( '/href=\"(http[s]*:\/\/.+?)\"/', $v, $matche );
			$arr[ 'href' ] = ( isset( $matche[ 1 ] ) ) ? $matche[ 1 ] : '';
			// score
			preg_match( '/style=\"font-size:\s(.+?)px;\"/', $v, $matche );
			$arr[ 'score' ] = ( isset( $matche[ 1 ] ) ) ? intval( round( $matche[ 1 ] ) ) : 0;
			// count
			preg_match( '/aria-label=\".+?\(([0-9]+).+?\).*\"/', $v, $matche );
			$arr[ 'count' ] = ( isset( $matche[ 1 ] ) ) ? intval( $matche[ 1 ] ) : 0;
			// name
			$arr[ 'name' ] = strip_tags( $v );
			// add
			$res_arr[] = $arr;
		}
		return $res_arr;
	}

	/**------------------------------------------------------
	 *
	 * 画像の検索
	 *
	 * 		特定のファイル文字列からwpメディアアップロードの画像を返す
	 * 			$file_search_str = '%' . '/' . '3t施工' . '.' . '%'; // 画像ファイル名に 「/」 と拡張子前の「.」を付与 * 後方一致の場合最後の「%」削除、前方一致の場合 最初の「%」削除
	 * 			$res = oo_wp_res_image_by_file_search_str( $file_search_str, 'medium' ); // thumbnail || medium || large *debug のときは第3引数に「true」
	 * 			2020-05-01 N
	 *
	 *
	------------------------------------------------------ */

	function oo_wp_res_image_by_file_search_str( $file_search_str, $res_size = 'medium', $debug = false ) {
		global $wpdb;
		$res_size_check_array = [
			'url',
			'thumbnail',
			'medium',
			'large',
			'medium_large'
		];
		// wpdb : wp_posts
		$sql = "SELECT
				ID,
				guid
			FROM
				{$wpdb->posts}
			WHERE
				guid LIKE %s
		";
		$sql_val = [
			$file_search_str
		];
		$attachment_post_arr = $wpdb->get_row( $wpdb->prepare( $sql, $sql_val ) );
		if( ! $attachment_post_arr ) {
			return $debug ? 'no_exist_image' : '';
		}
		// wpdb : wp_postmeta
		$sql = "SELECT
				meta_value
			FROM
				{$wpdb->postmeta}
			WHERE
				meta_key = '_wp_attachment_metadata'
				AND post_id = %d
		";
		$sql_val = [
			$attachment_post_arr->ID
		];
		$attachment_meta = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) );
		if( ! $attachment_meta ) {
			return $debug ? 'no_wp_media_upload' : '';
		}
		$attachment_meta_array = unserialize( $attachment_meta );
		if( !$attachment_post_arr ) return '';
		$res_size = ( $res_size === 'large' ) ? 'medium_large' : $res_size;
		if( ! in_array( $res_size, $res_size_check_array ) ) {
			return $debug ? 'error_select_size' : '';
		}
		$res_attachment_url = str_replace( $attachment_meta_array[ 'file' ], $attachment_meta_array[ 'sizes' ][ $res_size  ][ 'file' ], $attachment_post_arr->guid );
		return $res_attachment_url;
	}

	/**------------------------------------------------------
	 *
	 * sidebar
	 *
	------------------------------------------------------ */

	##	backnumber

	function wp_oo_sidebar_backnumber( $this_post_type, $type = 'yearly', $multisite_blog_id = 1, $href_prefix = false ) {
		if( $multisite_blog_id !== 1 ) switch_to_blog( $multisite_blog_id );
		global $wpdb;
		$href_prefix = $href_prefix ? $href_prefix : '/' . $this_post_type;
		$sql ="SELECT
				DATE_FORMAT( post_date, '%Y' ) as Y,
				DATE_FORMAT( post_date, '%m' ) as m
			FROM
				{$wpdb->posts}
			WHERE
				post_type = %s
				AND post_status = 'publish'
			ORDER BY
				post_date DESC
		";
		$sql_val = [ $this_post_type ];
		$wpdb_posts_Y_m = $wpdb->get_results( $wpdb->prepare( $sql, $sql_val ), ARRAY_A );
		$res_arr = [];
		if( $type === 'yearly' ) {
			foreach( $wpdb_posts_Y_m as  $v ) {
				if( isset( $res_arr[ $v[ 'Y' ] ] ) ) {
					$res_arr[ $v[ 'Y' ] ][ 'count' ]++;
				} else {
					$res_arr[ $v[ 'Y' ] ][ 'name' ] = $v[ 'Y' ] . '年';
					$res_arr[ $v[ 'Y' ] ][ 'Y' ] = $v[ 'Y' ];
					$res_arr[ $v[ 'Y' ] ][ 'count' ] = 1;
					$res_arr[ $v[ 'Y' ] ][ 'link' ]  = $href_prefix . '/' . $v[ 'Y' ] . '/';
				}
			}
		} elseif( $type === 'monthly' ) {
			foreach( $wpdb_posts_Y_m as  $v ) {
				if( isset( $res_arr[ $v[ 'Y' ] . $v[ 'm' ] ] ) ) {
					$res_arr[ $v[ 'Y' ] . $v[ 'm' ]  ][ 'count' ]++;
				} else {
					$res_arr[ $v[ 'Y' ] . $v[ 'm' ] ] = [
						'name'  => $v[ 'Y' ] . '年' . intval( $v[ 'm' ] ) . '月',
						'Y'     => $v[ 'Y' ],
						'm'     => $v[ 'm' ],
						'count' => 1,
						'link'  => $href_prefix . '/' . $v[ 'Y' ] . '/' . $v[ 'm' ] . '/'
					];
				}
			}
		} elseif( $type === 'yearly_monthly' ) {
			foreach( $wpdb_posts_Y_m as  $v ) {
				if( isset( $res_arr[ $v[ 'Y' ] ] ) ) {
					$res_arr[ $v[ 'Y' ] ][ 'count' ]++;
				} else {
					$res_arr[ $v[ 'Y' ] ][ 'name' ]  = $v[ 'Y' ] . '年';
					$res_arr[ $v[ 'Y' ] ][ 'Y' ]     = $v[ 'Y' ];
					$res_arr[ $v[ 'Y' ] ][ 'count' ] = 1;
					$res_arr[ $v[ 'Y' ] ][ 'link' ]  = $href_prefix . '/' . $v[ 'Y' ] . '/';
				}
				if( isset( $res_arr[ $v[ 'Y' ] ][ 'child' ][ $v[ 'm' ] ] ) ) {
					$res_arr[ $v[ 'Y' ] ][ 'child' ][ $v[ 'm' ] ][ 'count' ]++;
				} else {
					$res_arr[ $v[ 'Y' ] ][ 'child' ][ $v[ 'm' ] ] = [
						'name'  => intval( $v[ 'm' ] ) . '月',
						'Y'     => $v[ 'Y' ],
						'm'     => $v[ 'm' ],
						'count' => 1,
						'link'  => $href_prefix . '/' . $v[ 'Y' ] . '/' . $v[ 'm' ] . '/'
					];
				}
			}
		} else {
			$res_arr = 'error_type_name';
		}
		if( $multisite_blog_id !== 1 ) restore_current_blog();
		return $res_arr;
	}

	##	taxonomy

	function wp_oo_sidebar_taxonomy( $taxonomy, $depth = 1, $exclude_term = [], $multisite_blog_id = 1 ) {
		if( $multisite_blog_id !== 1 ) switch_to_blog( $multisite_blog_id );
		$tax_arr = wp_oo_get_term( $taxonomy, $depth );
		if( $multisite_blog_id !== 1 ) restore_current_blog();
		return $tax_arr;
	}

	##	recent

	function wp_oo_sidebar_recent( $this_post_type, $posts_per_page = 5, $multisite_blog_id = 1 ) {
		if( $multisite_blog_id !== 1 ) switch_to_blog( $multisite_blog_id );
		$res_arr = [];
		$args = [
			'post_type'      => $this_post_type,
			'posts_per_page' => $posts_per_page
		];
		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ) {
			while( $the_query->have_posts() ) {
				$the_query->the_post();
				$arr = [];
				$this_post_id  = $the_query->post->ID;
				$arr[ 'name' ] = get_the_title( $this_post_id );
				$arr[ 'href' ] = get_permalink( $this_post_id );
				// add_res
				$res_arr[] = $arr;
			}
		}
		if( $multisite_blog_id !== 1 ) restore_current_blog();
		return $res_arr;
	}

	##	*現在使用停止

	function wp_oo_sidenav_array_to_tag ( $sidenav_array, $add_tb = "\t\t\t" ) {
		global $tb;
		$tag = '';
		foreach( $sidenav_array as  $v ) {
			$tag .= $tb . $add_tb . '<li><a href="' . $v[ 'href' ] . '"><span>' . $v[ 'name' ] . '</span></a></li>' . "\n";
		}
		return $tag;
	}

	/**------------------------------------------------------
	 *
	 * Util
	 *
	------------------------------------------------------ */

	##	タグ内class 整形

	function wp_oo_adjust_class_name( $class_name, $type = 'inner' ){ // innner || class_tag
		if( $type === 'inner' ) {
			$class_name = ( $class_name ) ? ' ' . $class_name : '';
		} else {
			$class_name = ( $class_name ) ? ' class="' . $class_name . '"' : '';
		}
		return $class_name;
	}

	##	配列の挿入 : for manage_custom_post_types_columns

	function wp_oo_array_insert( &$array, $position, $insert_array ) {
		$first_array = array_splice( $array, 0, $position );
		$array = array_merge( $first_array, $insert_array, $array );
	}

	##	配列型変換（値がない場合）

	function oo_adjust_array( $var ) {
		if( is_null( $var ) || ! is_array( $var ) || ! $var ) {
			$var = [];
		}
		return $var;
	}

	##	CSVから独自データベース書換ツール用

	function wp_oo_prepare_update_by_csv_func( $arr_csv, $csv_total_fields ){
		$arr_sql = [];
		// csv
		foreach( $arr_csv as $v ) {
			if( is_array( $v ) && implode( '', $v ) !== '' ) {
				$arr_sql[] = '("' . implode( '"",""', $v ) . '")';
			}
		}
		return implode( ',', $arr_sql );
	}
