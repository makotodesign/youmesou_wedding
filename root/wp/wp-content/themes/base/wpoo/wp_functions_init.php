<?php
/**--------------------------------------------------------------
 *
 * wp_functions_init
 *
 * @version
 * 		18.2.1
 *
 * @history
 * 		2021-01-13	PUBLICDIRの自動付与をJSから移行 [ 18.1.1 ]
 * 		2020-03-26	WordPressの基本設定を抽出 [ 16.1.1 ]
 * 		2021-05-05	名称を wp_functions_base から wp_functions_init に変更 [ 18.1.1 ]
 * 					注釈の記述を変更
 * 		2021-07-20	title meta のor検索機能追加 [ 18.2.1 ]
 *
 --------------------------------------------------------------*/

	/**------------------------------------------------------
	 *
	 * wp_head
	 *
	------------------------------------------------------ */

	## remove

	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'rel_canonical' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	remove_action( 'wp_head', 'wp_resource_hints', 2 );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );

	## add

	function wp_init_oo_head_filter( $buffer ) {
		//$buffer = preg_replace( '/^.*<!--.*all in one seo pack.*-->.*\r?\n/im', '', $buffer );
		$buffer = str_replace( '<', "\t<", $buffer );
		return $buffer;
	}
	function wp_init_oo_head_buffer_start() {
		ob_start( 'wp_init_oo_head_filter' );
	}
	function wp_init_oo_head_buffer_end() {
		ob_end_flush();
	}
	add_action( 'wp_head', 'wp_init_oo_head_buffer_start', 0 );
	add_action( 'wp_head', 'wp_init_oo_head_buffer_end', 100 );
	add_action( 'wp_enqueue_scripts', function() {
		wp_deregister_style( 'wp-block-library' );
	} );

	## prevnext_canonical_link

	function wp_init_oo_add_prevnext_canonical_link() {
		global $wp_query;
		$this_post_type = get_query_var( 'post_type' );
		// canonical : by template_type
		$canonical_url = false;
		if( is_home() || is_front_page() ){
			//$canonical_url = home_url() . '/';
		} else if ( is_category() ){
			//$canonical_url = get_category_link( get_query_var( 'cat' ) );
		} else if ( is_post_type_archive() ){
			//$canonical_url = home_url() . '/' . $this_post_type . '/';
		} else if ( is_page() || is_single() ) {
			//$canonical_url = get_permalink();
		} else if ( is_search() ){
			//$encode_s_word = urlencode( get_search_query() );
			//$canonical_url = home_url() . '?s=' . $encode_s_word;
		} else if( is_tag() ){
			//$encode_tag = urlencode( single_tag_title( '', false ) );
			//$canonical_url = home_url() . '/archives/tag/' . $encode_tag;
		} elseif( is_404() ) {
			//$canonical_url = home_url();
		} else {
			//$canonical_url = false;
		}
		// paged
		if ( get_query_var( 'paged' ) >= 2 ) {
			//$canonical_url .= 'page/' . get_query_var( 'paged' ) . '/';
		}
		if ($canonical_url == !null) {
			//echo '<link rel="canonical" href="' . $canonical_url . '">' . "\n";
		}
		// prev next
		if( is_home() || is_archive() ) {
			$max_page = $wp_query->max_num_pages;
			if( $max_page > 1) {
				if( get_query_var( 'paged' ) ) {
					echo '<link rel="prev" href="' . previous_posts( false ) . '">' . "\n";
				}
				if( get_query_var( 'paged' ) < $max_page ) {
					echo '<link rel="next" href="' . next_posts( $max_page, false ) . '">' . "\n";
				}
			}
		}
	}
	add_action( 'wp_head', 'wp_init_oo_add_prevnext_canonical_link' );

	## script

	// delete : 絵文字機能除去
	function wp_init_oo_disable_emoji() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}
	add_action( 'init', 'wp_init_oo_disable_emoji' );

	##	favicon 管理画面用

	function wp_init_oo_admin_favicon() {
		echo '<link rel="shortcut icon" type="image/x-icon" href="' . home_url() . '/favicon.ico">';
	}
	add_action( 'admin_head', 'wp_init_oo_admin_favicon' );

	/**------------------------------------------------------
	 *
	 * 管理画面
	 *
	------------------------------------------------------ */

	## dashboard

	// remove widget
	function wp_init_oo_remove_dashboard_widgets() {
		remove_action( 'welcome_panel', 'wp_welcome_panel' );                                        // ようこそ非表示
		global $wp_meta_boxes;
		unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_right_now' ] );       // 現在の状況
		unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_recent_comments' ] ); // 最近のコメント
		unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_incoming_links' ] );  // 被リンク
		unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_plugins' ] );         // プラグイン
		unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_activity' ] );        // アクティビティ
		unset( $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ][ 'dashboard_site_health' ] );     // サイトヘルス
		unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_quick_press' ] );       // クイック投稿
		unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_recent_drafts' ] );     // 最近の下書き
		unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_primary' ] );           // WordPressブログ
		unset( $wp_meta_boxes[ 'dashboard' ][ 'side' ][ 'core' ][ 'dashboard_secondary' ] );         // WordPressフォーラム
	}
	add_action( 'wp_dashboard_setup', 'wp_init_oo_remove_dashboard_widgets' );

	## layout widget : スクリーンレイアウト表示
	function wp_init_oo_add_select_dashboard_columns() {
		add_screen_option( 'layout_columns', [ 'max' => 3, 'default' => 1 ] );
	}
	add_action( 'admin_head-index.php', 'wp_init_oo_add_select_dashboard_columns' );

	/**------------------------------------------------------
	 *
	 * 投稿表示
	 *
	------------------------------------------------------ */

	##	private post 下書きの表示

	function wp_init_oo_remove_private_posts() {
		global $wp_query;
		if( $wp_query->is_admin || ( defined( 'REMOVE_PRIVATE_POSTS' ) && ! REMOVE_PRIVATE_POSTS ) ) return;
		if( is_post_type_archive() ){
			$wp_query->query_vars[ 'post_status' ] = 'publish'; // 投稿ステータス「公開済」
		}
	}
	add_filter( 'pre_get_posts', 'wp_init_oo_remove_private_posts' );

	##	content内 画像

	// srcset解除
	add_filter( 'wp_calculate_image_srcset', '__return_false' );
	// content内 画像 不要属性削除
	// 現在acfエディタ内の画像には無効
	function wp_init_oo_remove_image_attribute( $html ){
		$html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
		$html = preg_replace( '/class=[\'"]([^\'"]+)[\'"]/i', '', $html );
		$html = preg_replace( '/title=[\'"]([^\'"]+)[\'"]/i', '', $html );
		$html = preg_replace( '/<a href=".+">/', '', $html );
		$html = preg_replace( '/<\/a>/', '', $html );
		return $html;
	}
	add_filter( 'image_send_to_editor', 'wp_init_oo_remove_image_attribute', 10 );
	add_filter( 'post_thumbnail_html', 'wp_init_oo_remove_image_attribute', 10 );

	##	get_archives_link の返り値変更

	function wp_init_oo_get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
		global $before_text, $after_text;
		$before_text = $before_text ?? '';
		$after_text  = $after_text  ?? '';
		$link_html = preg_replace( '@(<a.+>)(.+?)</a>(.+?)</li>@','\1\2\3</a></li>', $link_html );
		if ( $format === 'oldoffice_custom' ) {
			$link_html = $before . '<a href="' .$url . '"><span>' . $before_text . $text . $after_text . '</span></a>' . $after . "\n";
		}
		return $link_html;
	}
	add_filter( 'get_archives_link', 'wp_init_oo_get_archives_link', 10, 6 );

	##	PUBLICDIR 自動付与

	function wp_init_oo_output_callback( $buffer ) {
		if( defined( 'PUBLICDIR' ) && ! empty( PUBLICDIR ) ) {
			$buffer = preg_replace( '/(<img .*src=")(' . "\\" . PUBLICDIR . ')*\//', '$1' . PUBLICDIR . '/', $buffer );
			$buffer = preg_replace( '/(<form .*action=")(' . "\\" . PUBLICDIR . ')*\//', '$1' . PUBLICDIR . '/', $buffer );
			$buffer = preg_replace( '/(<a .*href=")(' . "\\" . PUBLICDIR . ')*\//', '$1' . PUBLICDIR . '/', $buffer );
		}
		return $buffer;
	}
	function wp_init_oo_buf_start() {
		ob_start( 'wp_init_oo_output_callback' );
	}
	function wp_init_oo_buf_end() {
		if( ob_get_length() ) ob_end_flush();
	}
	add_action( 'after_setup_theme', 'wp_init_oo_buf_start' );
	add_action( 'shutdown', 'wp_init_oo_buf_end' );

	/**------------------------------------------------------
	 *
	 * テンプレート
	 *
	------------------------------------------------------ */

	##	独自検索テンプレート( custom_search )

	function wp_init_oo_custom_search_template( $template ){
		if ( is_search() ){
			$post_types = get_query_var( 'post_type' );
			foreach ( (array) $post_types as $v ) {
				$templates[] = 'search-' . $v . '.php';
			}
			$templates[] = 'search.php';
			$template = get_query_template( 'search', $templates );
		}
		return $template;
	}
	add_filter( 'template_include','wp_init_oo_custom_search_template' );

	/**------------------------------------------------------
	 *
	 * ACF
	 *
	------------------------------------------------------ */

	##	acf 自動選択肢

	// 年 auto_year
	function wp_init_oo_acf_load_field_choices_auto_year( $field ) {
		$field[ 'choices' ] = [];
		$auto_year_last  = intval( date_i18n( 'Y' ) ) + 1;
		$auto_year_start = 2000;
		for( $auto_year = $auto_year_last; $auto_year > $auto_year_start; $auto_year-- ) {
			$field[ 'choices' ][ $auto_year ] = $auto_year . '年';
		}
		$field[ 'default_value' ] = intval( date_i18n( 'Y' ) );
 		return $field;
	}
	add_filter( 'acf/load_field/name=auto_year', 'wp_init_oo_acf_load_field_choices_auto_year' );
	// 月 auto_month
	function wp_init_oo_acf_load_field_choices_auto_month( $field ) {
		$field[ 'choices' ] = [];
		for( $auto_month = 1; $auto_month <= 12; $auto_month++ ) {
			$field[ 'choices' ][ sprintf( '%02d', $auto_month ) ] = $auto_month . '月';
		}
		$field[ 'default_value' ] = strval( date_i18n( 'm' ) );
 		return $field;
	}
	add_filter( 'acf/load_field/name=auto_month', 'wp_init_oo_acf_load_field_choices_auto_month' );
	// 年度 auto_nendo
	function wp_init_oo_acf_load_field_choices__auto_nendo( $field ) {
		// reset choices
		$field[ 'choices' ] = [];
		$auto_nendo_last  = intval( date_i18n( 'Y' ) );
		$auto_nendo_start = 2000;
		for( $auto_nendo = $auto_nendo_last; $auto_nendo > $auto_nendo_start; $auto_nendo-- ) {
			$field[ 'choices' ][ $auto_nendo ] = $auto_nendo . '年度';
		}
		$field[ 'default_value' ] = intval( date_i18n( 'n' ) ) < 4 ? $auto_nendo_last - 1 : $auto_nendo_last;
		// return the field
		return $field;
	}
	add_filter( 'acf/load_field/name=auto_nendo', 'wp_init_oo_acf_load_field_choices__auto_nendo' );

	/**------------------------------------------------------
	 *
	 * title と meta を or 検索
	 *
	------------------------------------------------------ */

	add_action( 'pre_get_posts', function( $q ) {
		if( $title = $q->get( '_meta_or_title' ) ) {
			add_filter( 'get_meta_sql', function( $sql ) use ( $title ) {
				global $wpdb;
				static $nr = 0;
				if( 0 != $nr++ ) return $sql;
				$sql[ 'where' ] = sprintf(
					" AND ( %s OR %s ) ",
					$wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title ),
					mb_substr( $sql[ 'where' ], 5, mb_strlen( $sql[ 'where' ] ) )
				);
				return $sql;
			} );
		}
	} );

	/**------------------------------------------------------
	 *
	 * その他
	 *
	------------------------------------------------------ */

	##	公開ページからのログイン

	/* サイト上でのログインエラー時 */
	function wp_init_oo_frontend_login_fail( $username ) {
		$referrer = $_SERVER[ 'HTTP_REFERER' ];
		if( !empty( $referrer ) && ! strstr( $referrer, 'wp-login' ) && ! strstr( $referrer, 'wp-admin' ) ) {
			$referrer = ( strpos( $referrer, '?login=failed' ) ) ? $referrer : $referrer . '?login=failed';
			wp_redirect( $referrer );
			exit;
		}
	}
	add_action( 'wp_login_failed', 'wp_init_oo_frontend_login_fail' );