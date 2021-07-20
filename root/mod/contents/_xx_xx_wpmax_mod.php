<?php
/**--------------------------------------------------------------
 *
 * xx_xx_wpmax_mod
 *
 * @memo
 * 		wp global 変数は使用不可
 * 			* $wpdb, $wp_queryを除く
 *
 * 			$post      = get_queried_object();
 * 			$post_type = get_query_var( 'post_type' );
 * 			$year      = get_query_var( 'year' );
 * 			$monthnum  = get_query_var( 'monthnum' );
 * 			$day       = get_query_var( 'day' );
 * 			$paged     = get_query_var( 'paged' );
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// multisite
	$switch_blog_id          = 99;
	// archive
	$the_posts_per_page      = -1;
	$the_taxonomy            = 'cat_xxx';
	$the_date_format         = 'Y.m.d';
	// single
	$posts_per_page_relation = 5;
	// adminpage
	$admin_page_id           = 99;

	/* xxx */
	// temp_master_arr
	$temp_master_xxx_arr     = [
		'a' => 'A'
	];

##	base

	/* includes */
	include_once ROOTREALPATH . '/mod/contents/common_xxx_func.php';

	/* date */
	$today                   = date_oo( 'Ymd' );
	$date_compare            = date_oo( 'Ymd', strtotime( date_oo( 'Y-m-d' ) . '-1 month' ) );
	$wdayjp_array            = [ '日', '月', '火', '水', '木', '金', '土' ]; // dete_oo default
	$wdayen_array            = [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ];

	/* csv */
	$csv_total_fields        = 6;
	$csv_arr_type            = 'fieldname';
	$csv_title_row_num       = 2; // 対象外行数 1,2,...
	$csv_key_row_num         = 1; // key行 0,1...

	/* the_domain */
	$this_domain             = $_SERVER[ 'HTTP_HOST' ];

	/* pager */
	$pager_link_dir          = '/dir/?'; // 前の｢/｣～後ろの｢?｣まで

	/* pre get */
	// this_post_number_for_offset
	$this_post = get_queried_object();
	$sql = "SELECT
			COUNT(*)
		FROM
			{$wpdb->posts}
		WHERE
			post_date <= %s
			AND post_status = 'publish'
			AND post_type = 'post'
	";
	$sql_val = [
		$this_post->post_date
	];
	$the_post_number = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) );
	$count_posts     = wp_count_posts();
	$total_posts_num = $count_posts->publish;
	$the_offset_num  = $total_posts_num - $this_post_number;

##	data

	/* master */
	// wp_export_master_xxxxx
	include_once ROOTREALPATH . '/mod/master/wp_export_master_xxxxx.php';
	// $wp_export_master_xxxxx_array
	$master_xxx = [
	];

	/* get */
	$_GET = isset( $_GET ) ? OOBASE::sanitize_server_request( $_GET ) : [];
	$GET_paging = $_GET[ 'paging' ] ?? 1;
	$GET_param  = $_GET[ 'param' ]  ?? 'default_value';

	/* post */
	$_POST = $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ? OOBASE::sanitize_server_request( $_POST ) : [];
	$POST_postname = $_POST[ 'postname' ] ?? 'default_value';

	/* wpdb */
	// シリアル化された配列にLIKEするときは%内を""で囲む
	$sql = "SELECT
			COUNT(*)
		FROM
			tablename
		WHERE
			fieldname01 = %d
			AND fieldname02 LIKE %s
			AND fieldname03 IN %s
	";
	$sql_val = [
		$num,
		'%"' . $str . '"%',
		'("' . join( '","', $arr ) . '")'
	];
	$wpdb_arr = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) );

##	wp : get_posts

	/* switch_blog */
	switch_to_blog( $switch_blog_id );
	restore_current_blog();

	/* posts */
	$res_arr = [];
	$args = [
		'posts_per_page' => $the_posts_per_page,
		'post_type'      => 'xxx',
		'paged'          => get_query_var( 'paged', 1 ),
		'orderby'        => 'meta_value', // menu_order : プラグインの並び替え
		'order'          => 'ASC',
		'post__in'       => [ $include_post_id ],
		'post__not_in'   => [ $exclude_post_id ],
		'cat'            => '1,2',
		'meta_key'       => 'hook_key',
		'meta_value'     => 'check_value',
		'meta_query'     => [
			'relation'       => 'AND',
			[
				'key'        => 'hook_date',
				'value'      => $today,
				'compare'    => '>='
			],
			[
				'key'        => 'status',
				'value'      => 'full',
				'compare'    => '!='
			]
		],
		'tax_query' => [
			[
				'taxonomy' => $the_taxonomy,
				'field'    => 'slug',
				'terms'    => get_query_var( $the_taxonomy ) // 現在のカテゴリ取得
			]
		],
		'post_status'      => 'publish',
		'suppress_filters' => false // wpml : current_lang
	];
	if( is_term( $the_taxonomy ) ) {
		$args[ 'tax_query' ] = [
			array(
				'taxonomy' => $the_taxonomy,
				'field'    => 'slug',
				'terms'    => get_query_var( $the_taxonomy ) // 現在のカテゴリ取得
			)
		];
	}
	if( $sort_flag ) {
		$args[ 'meta_query' ] = [
			'relation'    => 'AND',
			'meta_status' => [
				'key'     => 'xxx_acfname'
			],
			'meta_place'  => [
				'key'     => 'xxx_acfname'
			],
			'meta_price'  => [
				'key'     => 'xxx_acfname',
				'type'    => 'numeric'
			]
		];
		if( $GET_sort === 'pricelow' ) {
			$args[ 'orderby' ] = [
				'meta_status'  => 'DESC',
				'meta_price'   => 'ASC',
				'meta_place'   => 'DESC'
			];
		} elseif( $GET_sort === 'pricehigh' ) {
			$args[ 'orderby' ] = [
				'meta_status'  => 'DESC',
				'meta_price'   => 'DESC',
				'meta_place'   => 'DESC'
			];
		} else {
			$args[ 'orderby' ] = [
				'meta_status'  => 'DESC',
				'meta_place'   => 'DESC',
				'date'         => 'DESC'
			];
		}
	}
	// search
	if( $GET_searchword ) {
		$args[ '_meta_or_title' ] = $GET_searchword; // title or meta の or 検索
		$args[ 'meta_query' ] = [
			'relation'       => 'OR',
			[
				'key'     => 'products_code',
				'value'   => $GET_searchword,
				'compare' => 'LIKE'
			],
			[
				'key'     => 'products_class_name',
				'value'   => $GET_searchword,
				'compare' => 'LIKE'
			]
			];
	}
	if( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		if( $current_user->has_cap( 'edit_posts' ) ) {
			$args[ 'post_status' ] = [
				'publish',
				'private'
			];
		} else {
			$args[ 'post_status' ] = [
				'publish'
			];
		}
	}
	$the_query = new WP_Query( $args );
	// $the_query = $wp_query;
	// $the_posts_ids = get_field( 'xxx_posts_ids', $admin_page_id );
	// if( $the_posts_ids ) {
	// 	foreach( $the_posts_ids as  $v ) {
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
			$arr[ 'post_name' ]                                = get_post_field( 'post_name', $this_post_id );
			$arr[ 'post_type' ]                                = get_post_field( 'post_type', $this_post_id );
			$arr[ 'serial_number' ]                            = wp_oo_get_serial_number( $post ); // 公開済post連番
			// author
			$arr[ 'author_id' ]                                = $the_query->post->post_author; // $post->post_author; || $v->post_author
			$arr[ 'author_id' ]                                = get_the_author_meta( 'ID' ); // argにpost_id不要 *上記推奨
			$arr[ 'author_match' ]                             = ( $arr[ 'author_id' ] === $current_user->ID ) ? true : false;
			// dete
			$arr[ 'post_date' ]                                = get_the_date( 'Ymd', $this_post_id );
			$arr[ 'post_date' ]                                = get_the_date( $date_format, $this_post_id );
			$arr[ 'post_date' ]                                = get_the_date( 'Y/n/j H:i:s（D）', $this_post_id );
			$arr[ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			$arr[ 'modified_date' ]                            = get_the_modified_date( 'Y-m-d', $this_post_id );
			$arr[ 'post_date_new' ]                            = get_the_date( 'Ymd', $this_post_id ) > $date_compare ? true : false;
			// content
			$post_content                                      = apply_filters( 'the_content', get_post_field( 'post_content', $this_post_id ) );
			$arr[ 'post_content' ]                             = wp_oo_acf_content( $post_content, "\t\t\t\t\t\t\t\t" );
			$arr[ 'post_excerpt' ]                             = wp_oo_content_trim( $post_content, 60, '...more' );
			// category ( 基本撤廃 )
			$temp_categories                                   = get_the_category( $this_post_id );
			$temp_cat                                          = $temp_categories[ 0 ] ?? '';
			$arr[ 'the_cat_id' ]                               = $temp_cat->cat_ID;
			$arr[ 'the_cat_slug' ]                             = $temp_cat->slug;
			$arr[ 'the_cat_name' ]                             = $temp_cat->name;
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
			// acf : textarea
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_textarea( get_field( 'xxx_acfname', $this_post_id ) );
			// acf : textarea_to_arr
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_textarea_to_arr( get_field( 'xxx_acfname', $this_post_id ) );
			// acf : editor
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_content( get_field( 'xxx_acfname', $this_post_id ), "\t\t\t\t\t\t\t\t" ); // タブは2行目より適用
			$arr[ 'xxx_acfname_excerpt' ]                      = wp_oo_content_trim( get_field( 'xxx_acfname', $this_post_id ), 60, '...more' );
			// acf : radio ( 返り値:配列 )
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_radio( get_field( 'xxx_acfname', $this_post_id ), 'both' ); // both(def) || label || value
			// acf : select ( 返り値:配列 )
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_select( get_field( 'xxx_acfname', $this_post_id ), 'both' ); // both(def) || label || value
			// acf : checkbox ( 返り値:配列 )
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_checkbox( get_field( 'xxx_acfname', $this_post_id ), 'both' ); // both(def) || label || value
			// acf : date
			$arr[ 'xxx_acfname' ]                              = wp_oo_date( 'Y/n/j（D）', get_field( 'xxx_acfname', $this_post_id ) );
			$temp_acf_timestamp                                = wp_oo_timestamp_from_His( get_field( 'xxx_acfname', $this_post_id ) );
			$arr[ 'xxx_acfname' ]                              = date_oo( 'a h:i:s', $temp_acf_timestamp );
			// acf : image ( 返り値:配列 )
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_image( get_field( 'xxx_acfname', $this_post_id ), 'medium', '/images/lib/parts/noimage_icon.svg' ); // url || thumbnail || medium || large
			// acf : relation
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_relation( get_field( 'xxx_acfname', $this_post_id ) );
			// acf : group
			$arr[ 'xxx_acfname' ][ 'yyy' ]                     = wp_oo_acf_group( get_field( 'xxx_acfname', $this_post_id ), 'yyy' );
			// acr : loop
			$arr[ 'xxx_acfname' ]                              = wp_oo_acf_loop( get_field( 'xxx_acfname', $this_post_id ) );
			foreach( $arr[ 'xxx_acfname' ] as $k => $v ) { // loop over write
				$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_textarea( $v[ 'yyy' ] );
				$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_image( $v[ 'yyy' ], 'medium', '/images/lib/parts/noimage_icon.svg' ); // url || thumbnail || medium || large
				$arr[ 'xxx_acfname' ][ $k ][ 'yyy' ]           = wp_oo_acf_radio( $v[ 'yyy' ], 'value' ); // both(def) || label || value
			}
			/*
				aaa
				bbb
				ccc
			*/
			/* add_res */
			$check = true;
			if( $check ) {
				$res_arr[] = $arr;
			}
		}
	}
	// taxonomy_archive
	//$wp_posts_array = wp_oo_adjust_taxonomy_archive( $res_arr, $the_taxonomy );
	$wp_posts_array = $res_arr;
	$wp_posts_json_code = '<script>const postsJson = ' . json_encode( $res_arr ) . '</script>';

##	wpdb

	$sql ="SELECT
			ID as xxx_id,
			pm1.meta_value AS value1 ,
			pm2.meta_value AS value2 ,
			pm3.meta_value AS value3
		FROM
			{$wpdb->posts}
			LEFT JOIN {$wpdb->postmeta} AS pm1 ON (ID = pm1.post_id AND pm1.meta_key = %s)
			LEFT JOIN {$wpdb->postmeta} AS pm2 ON (ID = pm2.post_id AND pm2.meta_key = %s)
			LEFT JOIN {$wpdb->postmeta} AS pm3 ON (ID = pm3.post_id AND pm3.meta_key = %s)
		WHERE
			post_type = 'post_type01'
			AND post_status = 'publish'
			AND pm3.meta_value IS NULL
			AND pm2.meta_value <= CURDATE()
			AND pm1.meta_value IN (
				SELECT
					ID
				FROM
					{$wpdb->posts}
					LEFT JOIN {$wpdb->postmeta} AS pmw1 ON (ID = pmw1.post_id AND pmw1.meta_key = 'meta_key1')
					LEFT JOIN {$wpdb->postmeta} AS pmw2 ON (ID = pmw2.post_id AND pmw2.meta_key = 'meta_key2')
				WHERE
					post_type = 'post_type02'
					AND post_status = 'publish'
					AND pmw1.meta_value = '合致させたい内容'
					AND pmw2.meta_value BETWEEN %d AND %d
			)
	";
	$sql_val = [ 'value1', 'value2', 'value3', $min_price, $max_price ];
	$results = $wpdb->get_results( $wpdb->prepare( $sql, $sql_val ), ARRAY_A );
	if( $results ) {
		foreach ( $results as $v ) {
			$value_ids[] = $v[ 'value1' ];
		}
	}
	$wpdb_arr = $wpdb->get_row( $wpdb->prepare( $sql, $sql_val ), 'ARRAY_A' );
	$wpdb_arr = $wpdb->get_var( $wpdb->prepare( $sql, $sql_val ) );

##	wp : current_info

	/* current_archive */
	$the_found_posts         = $the_query->found_posts;
	$the_paged               = get_query_var( 'paged' ) ? ( int ) get_query_var( 'paged' ) : 1;
	$the_term                = is_tax() ? get_query_var( $the_taxonomy ) : false;
	if( is_tax() ){ // is_tax
		$wp_the_term = get_term_by( 'slug', get_query_var( $the_taxonomy ), $the_taxonomy );
	}

	/* current_user */
	$current_user            = wp_get_current_user();
	$current_user_id         = $current_user->ID;
	$current_user_roles      = $current_user->roles;
	$current_user_allcaps    = $current_user->allcaps;

	// archive
	$archive_name = 'xx一覧';
	$archive_name .= ( is_paged() ) ? ' [ ' . get_query_var( 'paged' ) . '/' . $the_query->max_num_pages . ' ]' : '';
	if( is_post_type_archive() && is_day() ){ // is_day
		$wp_archive_title = get_query_var( 'year' ) . '年' . get_query_var( 'monthnum' ) . '月' . get_query_var( 'day' ) . '日の' . $archive_name;
	} elseif( is_post_type_archive() && is_month() ){ // is_month
		$wp_archive_title = get_query_var( 'year' ) . '年' . get_query_var( 'monthnum' ) . '月の' . $archive_name;
	} elseif( is_post_type_archive() && is_year() ){ // is_year
		$wp_archive_title = get_query_var( 'year' ) . '年の' . $archive_name;
	} elseif( is_tax() ){ // is_tax
		$temp_cat = get_the_category();
		$wp_archive_title = single_cat_title( '', false ) . 'の' . $archive_name;
	} elseif( is_post_type_archive() ){ // wp_home
		$wp_archive_title = '' . $archive_name;
	} else {
		$wp_archive_title = '' . $archive_name;
	}

	// single
	$wp_single_title      = $wp_single_array[ 'post_title' ];
	$wp_single_date       = $wp_single_array[ 'post_date' ];

##	wp : navigation

	/* pager */
	// normal
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

	// original
	$args = [
		'base'               => '/post_type/',
		'format'             => '?paging=%#%',
		'total'              => $the_query->max_num_pages,
		'mid_size'           => 2,
		'type'               => 'array',
		'current'            => $GET_paging,
		'prev_text'          => '<span>&lt;</span>',
		'next_text'          => '<span>&gt;</span>',
		'before_page_number' => '<span>',
		'after_page_number'  => '</span>'
	];
	$add_paging_param = [
		'key01'              => '01',
		'key02'              => '02',
		'key03'              => '03'
	];
	$wp_pager_array = wp_oo_pager( $args, $add_paging_param );

	// autopager
	$next_page_link = next_posts( $wp_query->max_num_pages, false );

	/* next_prev */
	$arr = [];
	// next
	$temp_post                      = get_next_post();
	//$temp_post                      = get_next_post( true, '', 'support_cat' ); // arg01 : 同じterm, arg02 : 除外カテゴリ, arg03 : タクソノミー名称
	$this_post_id                   = ( $temp_post ) ? $temp_post->ID                 : '';
	$arr[ 'next' ][ 'flag' ]        = ( $temp_post ) ? true                           : false;
	$arr[ 'next' ][ 'post_title' ]  = ( $temp_post ) ? $temp_post->post_title         : '';
	$arr[ 'next' ][ 'permalink' ]   = ( $temp_post ) ? get_permalink( $this_post_id ) : '';
	//prev
	$temp_post                      = get_previous_post();
	$this_post_id                   = ( $temp_post ) ? $temp_post->ID                 : '';
	$arr[ 'prev' ][ 'flag' ]        = ( $temp_post ) ? true                           : false;
	$arr[ 'prev' ][ 'post_title' ]  = ( $temp_post ) ? $temp_post->post_title         : '';
	$arr[ 'prev' ][ 'permalink' ]   = ( $temp_post ) ? get_permalink( $this_post_id ) : '';
	$wp_next_prev_array = $arr;

	/* tag_cloud */
	// wp_oo_tag_cloud
	$args = [
		'taxonomy'  => 'yyy',
		'smallest'  => 1,
		'largest'   => 5,
		'unit'      => 'px',
		'number'    => 20,
		'order'     => 'RAND',
		'format'    => 'array',
		'echo'      => false
	];
	$tags_arr = wp_oo_tag_cloud( $args );
	$tag .= $tb . "\t" . '<ul class="sidenav">' . "\n";
	foreach( $tags_arr as $tg ) {
		$tg[ 'href' ];
		$tg[ 'name' ];
		$tg[ 'score' ];
		$tg[ 'count' ];
		$tag .= $tb . "\t" . '<li class="tag-item tag-score-' . $tg[ 'score' ] . '"><a href="' . $tg[ 'href' ] . '"><span>' . $tg[ 'name' ] . '</span></a></li>' . "\n";
	}
	$tag .= $tb . "\t" . '</ul>' . "\n";

##	wp : taxonomy / users

	/* taxonomy */
	$args = [
		'hide_empty' => false,
		'taxonomy'   => $the_taxonomy
	];
	$terms = get_categories( $args );
	foreach( $terms as $term ) {
		$term->term_taxonomy_id;
		$term->parent;
		$term->name;
		$term->slug;
		$term->taxonomy;
		$term->category_count;
		$term->xxx_acfname = get_field( 'xxx_acfname', $term->taxonomy . '_' . $term->term_taxonomy_id );
		$temp_arr[] = $term->term_id;
	}
	// 親子カテゴリが存在する場合 ※ 孫の場合は別途記述
	$temp_arr = [];
	foreach( $terms as $v ) {
		// トップレベルカテゴリの場合
		if( $v->parent == 0 ) {
			$temp_arr[ $v->term_taxonomy_id ] = $v;
		} else {
			$temp_arr[ $v->parent ][ 'child' ][ $v->term_taxonomy_id ] = $v;
		}
	}
	$terms = $temp_arr;

	// acf_tax current_queried
	if( is_tax() ) {
		$current_queried  = get_queried_object();
		$acfname_tax_xxx = get_field( 'xxx', $current_queried );
	}

	/* users */
	$res_arr = [];
	// posts_array
	$args = [
		'role__in'       => 'Administrator',
		'role__not_in'   => 'Subscriber',
		'exclude'        => [ 1, 2, 3 ], // user_id
		'blog_id'        => 99, // for multisite
		'search'         => 'ssss',
		'search_columns' => [ 'ID', 'user_login', 'user_nicename', 'user_email', 'user_url' ],
		'orderby'        => 'meta_value', // ID || display_name || user_name || user_login || user_nicename || post_count || meta_value || meta_value_num
		'order'          => 'ASC',
		'meta_query' => [
		'relation' => 'OR',
			[
				'key'     => 'xxx_user_acfname',
				'value'   => 'aaa',
				'compare' => '='
			],
			[
				'key'     => 'xxx_user_acfname',
				'value'   => [ 20, 30 ],
				'type'    => 'numeric',
				'compare' => 'BETWEEN'
			]
		]
	];
	$users_query = new WP_User_Query( $args );
	$total_users_num = $users_query->total_users;
	if( $users_query->results ) {
		foreach( $users_query->results as $v ) {
			/* wp_user_elements */
			$arr = [];
			// id
			$this_user_id                                      = $users_query->results->ID; // the_post() : $post->ID; || $v->ID
			// base
			$arr[ 'user_id' ]                                  = $this_user_id;
			$arr[ 'user_url' ]                                 =  $users_query->results->user_url ;
			$arr[ 'user_display_name' ]                        =  $users_query->results->display_name;
			$arr[ 'user_email' ]                               =  $users_query->results->user_email;
			$arr[ 'user_login' ]                               =  $users_query->results->user_login;
			// acf
			$arr[ 'xxx_user_acfname' ]                         = get_field( 'xxx_user_acfname', 'user_' . $this_user_id );
			/* add_user */
			$check = true;
			if( $check ) {
				$res_arr[] = $arr;
			}
		}
	}
	$wp_users_array = $res_arr;

##	info

	/* map_script */
	$divice_type = ( is_pc() ) ?'pc' : 'sp';
	$map_id      = $arr[ 'google_map_id' ];
	$map_title   = $arr[ 'google_map_title' ];
	$map_lat     = $arr[ 'google_map_latitude' ];
	$map_lng     = $arr[ 'google_map_longitude' ];
	$map_zip     = $arr[ 'google_map_zip' ];
	$map_address = $arr[ 'google_map_address' ];
	$tag_map_script = map_script( $map_id, $map_title, $map_lat, $map_lng, $map_zip, $map_address, $divice_type );

	// autopager
	$tag = '';
	$tb = "\t\t\t\t\t\t";
	if( $max_page > 1 ){
		$tag .= $tb . "" . '<nav class="box">' . "\n";
		$tag .= $tb . "\t" . '<div class="part pager_cont">' . "\n";
		$tag .= $tb . "\t\t" . '<p class="ajax_more_load"><a href="' . $next_page_link . '" class="button bc_original"><span>さらに読み込む</span></a></p>' . "\n";
		$tag .= $tb . "\t" . '</div>'."\n";
		$tag .= $tb . "" . '</nav>' . "\n";
	}

	/* title */
	// default
	$archive_name = 'xx一覧';
	$archive_name .= ( is_paged() ) ? ' [ ' . get_query_var( 'paged' ) . '/' . $wp_query->max_num_pages . ' ]' : '';
	if( is_post_type_archive() && is_day() ){ // is_day
		$wp_archive_title = get_query_var( 'year' ) . '年' . get_query_var( 'monthnum' ) . '月' . get_query_var( 'day' ) . '日の' . $archive_name;
	} elseif( is_post_type_archive() && is_month() ){ // is_month
		$wp_archive_title = get_query_var( 'year' ) . '年' . get_query_var( 'monthnum' ) . '月の' . $archive_name;
	} elseif( is_post_type_archive() && is_year() ){ // is_year
		$wp_archive_title = get_query_var( 'year' ) . '年の' . $archive_name;
	} elseif( is_tax() ){ // wp_year
		$temp_cat = get_the_category();
		$wp_archive_title = single_cat_title( '', false ) . 'の' . $archive_name;
	} elseif( is_post_type_archive() ){ // wp_home
		$wp_archive_title = '' . $archive_name;
	} else {
		$wp_archive_title = '' . $archive_name;
	}

##	redirect

	if( $arr[ 0 ][ 'type' ] == 'a' ){
		header( 'Location: ' . PUBLICDIR . '/');
	} else if( $arr[ 0 ][ 'type' ] == 'b' ) {
		header( 'Location: ' . $arr[ 0 ][ 'url' ] );
	}