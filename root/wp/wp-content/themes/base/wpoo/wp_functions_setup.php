<?php
/**--------------------------------------------------------------
 *
 * wp_functions_setup
 *
 * @version
 * 		18.1.3
 *
 * @history
 * 		2020-03-26	WordPressの個別設定関数 [ 16.1.1 ]
 * 		2021-12-25	管理画面ダッシュボード・サイドメニュー マルチサイト対応[ 17.1.1 ]
 * 		2021-05-05	名称を wp_functions_setting から wp_functions_setup に変更 [ 18.1.1 ]
 * 					グローバル変数変換（$post, $post_type など）
 * 					functions にあわせて順序並び替え
 * 					注釈の記述を変更
 * 		2021-06-04	サイトマップXML機能をcronに移行 [ 18.1.2 ]
 * 		2021-06-30	エディタアイコンの設定が反映されないバグ修正  [ 18.1.3 ]
 * 					post_type newsのリンクタイプが
 * 					管理画面投稿一覧メニューに反映されないバグ修正
 *
 --------------------------------------------------------------*/

	/**------------------------------------------------------
	 *
	 * ダッシュボード, 管理画面サイドメニュー
	 *
	------------------------------------------------------ */

	##	ダッシュボード, 管理画面サイドメニュー

	function nav_dashboard_widget_function() {
		$arr = ( defined( 'WPADMIN_NAV_CHILD' ) ) ? WPADMIN_NAV_CHILD : WPADMIN_NAV;
		$current_user_id = get_current_user_id();
		$tag = '';
		$tb = '';
		$tag .= $tb . "" . '<div>' . "\n";
		$tag .= $tb . "\t" . '<ul class="oo_dashboard_navi">' . "\n";
		foreach( $arr as $k => $v ){
			if(
				( isset( $v[ 'user' ] ) && in_array( $current_user_id, $v[ 'user' ] ) )
				||
				! isset( $v[ 'user' ] )
			) {
				switch( $v[ 'type' ] ) {
					case 'heading_dashboard':
						$tag .= $tb . "\t\t" . '<li class="separate">' . $k . '</li>' . "\n";
						break;
					case 'posttype':
					case 'page':
					case 'other':
						if( isset( $v[ 'option_disp_submenu_dashbord' ] ) && isset( $v[ 'add_submenu' ] ) && $v[ 'option_disp_submenu_dashbord' ] ) {
							foreach( $v[ 'add_submenu' ] as  $kk => $vv ) {
								$blog_slug = $vv[ 'multisite' ] ?? false;
								$href = adjust_menu_path( $vv[ 'path' ], $blog_slug );
								$tag .= $tb . "\t\t" . '<li><a href="' . $href . '" class="wp-ui-highlight">' . $kk . '</a></li>' . "\n";
							}
						} else {
							$blog_slug = $v[ 'multisite' ] ?? false;
							$href = adjust_menu_path( $v[ 'path' ], $blog_slug );
							$tag .= $tb . "\t\t" . '<li><a href="' . $href . '" class="wp-ui-highlight">' . $k . '</a></li>' . "\n";
						}
						break;
				}
			}
		}
		$tag .= $tb . "\t" . '</ul>' . "\n";
		$tag .= $tb . "" . '</div>' . "\n";
		echo $tag;
	}
	function add_dashboard_widgets() {
		global $wp_meta_boxes;
		$metabox_title  = '更新管理メニュー';
		wp_add_dashboard_widget( 'nav_dashboard_widget', $metabox_title , 'nav_dashboard_widget_function' );
		$normal_dashboard = $wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ];
		$nav_widget_backup = [ 'nav_dashboard_widget' => $normal_dashboard[ 'nav_dashboard_widget' ] ];
		unset( $normal_dashboard[ 'nav_dashboard_widget' ] );
		$sorted_dashboard = array_merge( $nav_widget_backup, $normal_dashboard );
		$wp_meta_boxes[ 'dashboard' ][ 'normal' ][ 'core' ] = $sorted_dashboard;
	}
	add_action( 'wp_dashboard_setup', 'add_dashboard_widgets' );

	##	sidemenu（管理画面 : サイドメニュー）

	function sidemenu_function() {
		global $menu, $submenu;
		$arr = ( defined( 'WPADMIN_NAV_CHILD' ) ) ? WPADMIN_NAV_CHILD : WPADMIN_NAV;
		$current_user_id = get_current_user_id();
		$temp_arr = [];
		$ok_user_ids = []; // 管理画面の設定に含まれている user_ids
		foreach( $arr as  $k => $v ) {
			if( $v[ 'type' ] === 'heading_dashboard' ) continue;
			if( in_array( $current_user_id, $v[ 'user' ] ) ) {
				$ok_user_ids = array_unique( array_merge( $v[ 'user' ], $ok_user_ids ) );
				$blog_slug = $v[ 'multisite' ] ?? false;
				$dashicon = $v[ 'option_dashicon' ] ?? 'dashicons-arrow-right';
				switch( $v[ 'type' ] ) {
					case 'posttype':
						if( isset( $blog_slug[ 'slug' ] ) ) $blog_slug = $blog_slug[ 'slug' ];
						if( ! $blog_slug || $blog_slug === MULTISITEBLOGNAME ) {
							remove_menu_page( $v[ 'path' ] );
						}
						$v[ 'path' ] = adjust_menu_path( $v[ 'path' ], $blog_slug );
						add_menu_page( $k, $k, 'edit_posts', $v[ 'path' ], '', $dashicon );
						break;
					case 'page':
						$v[ 'path' ] = adjust_menu_path( $v[ 'path' ], $blog_slug );
						add_menu_page( $k, $k, 'edit_posts', $v[ 'path' ], '', $dashicon );
						break;
					case 'other':
						$v[ 'path' ] = adjust_menu_path( $v[ 'path' ] );
						add_menu_page( $k, $k, 'edit_posts', adjust_menu_path( $v[ 'path' ] ), '', $dashicon );
						break;
				}
				// submenu : add
				if( isset( $v[ 'add_submenu' ] ) ) {
					foreach( $v[ 'add_submenu' ] as  $kk => $vv ) {
						if( in_array( $current_user_id, $vv[ 'user' ] ) ) {
							$blog_slug_for_sub = $vv[ 'multisite' ] ?? false;
							$vv[ 'path' ] = adjust_menu_path( $vv[ 'path' ], $blog_slug_for_sub );
							// サブメニュー投稿タイプの時、ユーザーのトップメニューから削除
							if( isset( $blog_slug_for_sub[ 'slug' ] ) ) $blog_slug_for_sub = $blog_slug_for_sub[ 'slug' ];
							if( ! $blog_slug_for_sub || $blog_slug_for_sub === MULTISITEBLOGNAME && $current_user_id !== 1 ) {
								remove_menu_page( $vv[ 'path' ] );
							}
							remove_submenu_page( $v[ 'path' ], htmlspecialchars( $vv[ 'path' ] ) );
							add_submenu_page( $v[ 'path' ], $kk, $kk, 'edit_posts', $vv[ 'path' ] );
						}
					}
				}
				// submenu : remove
				if( isset( $v[ 'remove_submenu' ] ) ) {
					foreach( $v[ 'remove_submenu' ] as  $vv ) {
						if( ! isset( $vv[ 'user' ] ) && in_array( $current_user_id, $vv[ 'user' ] ) ) {
							remove_submenu_page( $v[ 'path' ], htmlspecialchars( $vv[ 'path' ] ) );
						}
					}
				}
			} else {
				switch( $v[ 'type' ] ) {
					case 'media':
						remove_menu_page( 'upload.php' );
						break;
					case 'user':
						if( in_array( $current_user_id, $v[ 'user' ] ) ) {
							remove_menu_page( 'users.php' );
						}
						break;
				}
			}
		}
		if( $current_user_id !== 1 ) {
			remove_menu_page( 'edit.php?post_type=page' );            // 固定ページ
			remove_menu_page( 'edit-comments.php' );                  // コメント
			remove_menu_page( 'themes.php' );                         // 外観
			remove_menu_page( 'plugins.php' );                        // プラグイン
			remove_menu_page( 'tools.php' );                          // ツール
			remove_menu_page( 'options-general.php' );                // 設定
		} elseif( ! in_array( $current_user_id, $ok_user_ids ) ) {
			remove_menu_page( 'index.php' );                          // ダッシュボード
			remove_menu_page( 'edit.php' );                           // 投稿
		}
	}
	if( ! defined( 'ADMIN_MENU_EDITOR_PRO' ) || ! ADMIN_MENU_EDITOR_PRO ) {
		add_action( 'admin_menu', 'sidemenu_function' );
	}

	##	sidemenu（管理画面 : サイドメニュー）並べ替え

	function sidemenu_order( $menu_order ) {
		global $menu;
		$arr = ( defined( 'WPADMIN_NAV_CHILD' ) ) ? WPADMIN_NAV_CHILD : WPADMIN_NAV;
		$res_arr = [];
		$res_arr[] = 'index.php'; //ダッシュボード
		$res_arr[] = 'separator1';
		$count = 1;
		foreach( $arr as  $v ) {
			if( in_array( $v[ 'type' ], [ 'posttype', 'page', 'other' ] ) ) {
				$blog_slug = $v[ 'multisite' ] ?? false;
				$v[ 'path' ] = adjust_menu_path( $v[ 'path' ], $blog_slug );
				$res_arr[] = $v[ 'path' ];
			// セパレーターの追加は次回
			// } elseif( $v[ 'type' ] === 'heading_dashboard' ) {
			// 	// $res_arr[] = 'separator' . $count; //セパレータ
			// 	// $count++;
			}
		}
		$res_arr[] = 'separator2';
		$res_arr[] = 'separator3';
		$res_arr[] = 'separator4';
		$res_arr[] = 'separator5';
		$res_arr[] = 'edit.php'; //投稿
		$res_arr[] = 'edit.php?post_type=page'; //固定ページ
		$res_arr[] = 'upload.php'; //メディア
		$res_arr[] = 'edit-comments.php'; //コメント
		$res_arr[] = 'separator-last'; //最後のセパレータ
		$res_arr[] = 'themes.php'; //外観
		$res_arr[] = 'users.php'; //ユーザー
		$res_arr[] = 'plugins.php'; //プラグイン
		$res_arr[] = 'tools.php'; //ツール
		$res_arr[] = 'options-general.php'; //設定
		return $res_arr;
	}
	if( ! defined( 'ADMIN_MENU_EDITOR_PRO' ) || ! ADMIN_MENU_EDITOR_PRO ) {
		add_filter('custom_menu_order', 'sidemenu_order');
		add_filter('menu_order', 'sidemenu_order');
	}

	##	adminツールバー

	function adminbar_function( $wpadminbar ) {
		$current_user_id = get_current_user_id();
		if( $current_user_id !== 1 ) {
			$wpadminbar->remove_menu( 'wp-logo' );
			$wpadminbar->remove_menu( 'wporg' );
			$wpadminbar->remove_menu( 'documentation' );
			$wpadminbar->remove_menu( 'support-forums' );
			$wpadminbar->remove_menu( 'feedback' );
			$wpadminbar->remove_menu( 'search' );
			$wpadminbar->remove_menu( 'edit-profile' );
			$wpadminbar->remove_menu( 'new-content' );
			$wpadminbar->remove_menu( 'updates' );
			$wpadminbar->remove_menu( 'comments' );
			$wpadminbar->remove_menu( 'new-user' );
			$wpadminbar->remove_menu( 'user-info' );
		}
	}
	add_action( 'admin_bar_menu', 'adminbar_function', 90 );

	##	管理画面用 共通 パス変換関数

	function adjust_menu_path( $path, $blog_slug = false ) {
		$path = htmlspecialchars( $path );
		$scheme = is_ssl() ? 'https' : 'http';
		if( is_multisite() && $blog_slug && defined( 'MULTISITEBLOGNAME' ) ) {
			// 設定値 multisite の 型 により調整
			if( isset( $blog_slug[ 'slug' ] ) ) $blog_slug = $blog_slug[ 'slug' ];
			if( $blog_slug != MULTISITEBLOGNAME ) {
				if( $blog_slug === 'base' ) {
					$temp_blog_id = 1;
				} else {
					$temp_arr = array_flip( MULTISITE_BLOG );
					$temp_blog_id = $temp_arr[ $blog_slug ];
				}
				$multisite_blog_url = get_site_url( $temp_blog_id, '/', $scheme );
				$path = $multisite_blog_url . 'wp-admin/' . $path;
			}
		} elseif( substr( $path, 0, 1 ) === '/' ) {
			$global_home_url = network_home_url( '', $scheme );
			$global_home_url = substr( $global_home_url, -1 ) === '/' ? substr( $global_home_url, 0, -1 ) : $global_home_url; // 念のため「/」を削除
			$path = $global_home_url . $path;
		}
		return $path;
	}

	/* サンプル：ダッシュボード, 管理画面サイドメニュー

		'追加投稿タイプ名' => [
			'type'        => 'posttype',
			'path'        => 'edit.php?post_type=xxx',
			//	・「http」「//」 で始まるのものはそのまま
			//	・「/」で始まるものは「URL/PUBLICDIR」付与
			//	・上記以外は「URL」と「/wp/wp-admin/」を付与
			'user'        => [ 1, 2 ],
			'multisite'   => 'base',
			'add_submenu' => [
				'追加サブメニュー' => [
					'path'        => 'post.php?post=8&action=edit',
					'user'        => [ 1, 2 ],
					'multisite'   => 'base'
				]
			],
			'remove_submenu' => [
				'タクソノミー01' => [
					'path'        => 'edit-tags.php?taxonomy=cat_add01&post_type=xxx',
					'user'        => [ 2 ]
				]
			]
		],
		'追加固定ページ名' => [
			'type'        => 'page',
			'path'        => 'post.php?post=999&action=edit',
			'user'        => [ 1, 2 ],
			'multisite'   => 'base',
			'add_submenu' => [
				'追加サブメニュー' => [
					'path'        => 'post.php?post=45&action=edit',
					'user'        => [ 1, 2 ],
					'multisite'   => 'base'
				]
			],
			'remove_submenu' => [
				'タクソノミー01' => [
					'path'    => 'edit-tags.php?taxonomy=cat_add01&post_type=xxx',
					'user'    => [ 2 ],
					'multisite'   => 'base'
				]
			]
		],
		'※オプション' => [
			他は上記と同じ記述で末尾に記述
			// ※マルチサイト投稿タイプ・固定ページ間共通
			'multisite'   => 'base', // 「c_」は付けない
			または posttype で タクソノミーを含む場合
			'multisite'    => [
				'slug'     => 'base',
				'taxonomy' => [
					'カテゴリー01' => [
						'slug' => 'cat_test01',
						'user' => [ 1, 2 ]
					]
				]
			]
			// *サブメニューーの情報をダッシュボードではボタンとして表示
			'option_disp_submenu_dashbord' => true,
			// dashicon の変更 cf https://developer.wordpress.org/resource/dashicons/
			'option_dashicon' => 'dashicons-admin-post',
		],
		'その他' => [
			'type'        => 'other',
			'path'        => 'https://www.oldoffice.com/',
			'user'        => [ 1, 2 ],
			'add_submenu' => [
				'追加サブメニュー' => [
					'path'    => 'post.php?post=45&action=edit',
					'user'     => [ 1, 2 ]
				]
			]
		],
		'区切り見出し' => [
			'type'        => 'heading_dashboard', // ダッシュボード用区切り見出し
			'user'        => [ 1, 2 ]
		],
		*/

	/**------------------------------------------------------
	 *
	 * カスタム投稿タイプ
	 *
	------------------------------------------------------ */

	##	カスタム投稿タイプ追加

	function create_post_type() {
		$arr            = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
		$arr_taxonomy   = ( defined( 'CUSTOM_TAXONOMY_CHILD' ) ) ? CUSTOM_TAXONOMY_CHILD : CUSTOM_TAXONOMY; // multisite_adjust
		$check_taxonomy = [];
		$check_eycatch  = [];
		foreach( $arr_taxonomy as  $k => $v ) {
			$check_taxonomy[ $v[ 'post_type' ] ][] = $k;
		}
		foreach( $arr as $k => $v ){
			$labels = [
				'name'                => $v[ 'name' ],
				'singular_name'       => $v[ 'name' ],
				'all_items'           => '投稿一覧',
				'menu_name'           => $v[ 'name' ]
			];
			$args = [
				'labels'              => $labels,
				'public'              => true,
				'exclude_from_search' => false,
				'has_archive'         => true,
				'rewrite'             => ( isset( $v[ 'slug' ][ 'rewrite' ] ) && is_array( $v[ 'slug' ][ 'rewrite' ] ) ) ? $v[ 'slug' ][ 'rewrite' ] : true,
				'show_in_rest'        => $v[ 'gutenberg' ]
			];
			if( isset( $check_taxonomy[ $k ] ) ) {
				$args[ 'taxonomies' ] = $check_taxonomy[ $k ];
			}
			if( isset( $v[ 'eyecatch' ] ) && $v[ 'eyecatch' ] ) {
				$args[ 'supports' ] = [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'page-attributes' ];
				$check_eycatch[] = $k;
			}
			if( $k !== 'post' ) register_post_type( $k, $args );
		}
		if( $check_eycatch > 0 ) {
			add_theme_support( 'post-thumbnails' );
		}
	}
	add_action( 'init', 'create_post_type' );

	## アーカイブ表示投稿数 posts_per_page

	function change_loop_setting( $query ) {
		if( is_admin() || ! $query->is_main_query() ) {
			return;
		}
		$arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
		$bool_category_archive = true;
		foreach( $arr as  $k => $v ) {
			if( is_post_type_archive( $k ) ) {
				$query->set( 'posts_per_page', $v[ 'posts_per_page' ] );
				$bool_category_archive = false;
				break;
			}
		}
		if( $bool_category_archive ) {
			$arr = ( defined( 'CUSTOM_TAXONOMY_CHILD' ) ) ? CUSTOM_TAXONOMY_CHILD : CUSTOM_TAXONOMY; // multisite_adjust
			foreach( $arr as  $k => $v ) {
				if( is_tax( $k ) ) {
					$query->set( 'posts_per_page', $v[ 'posts_per_page' ] );
					break;
				}
			}
		}
	}
	add_action( 'pre_get_posts', 'change_loop_setting' );

	## 日本語スラッグの自動変換

	function auto_post_slug( $slug, $this_post_id, $this_post_status, $this_post_type ) {
		$arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
		foreach( $arr as $k => $v ) {
			if( $k === $this_post_type && $v[ 'slug' ][ 'auto_slug' ] ) {
				if( $this_post_id && preg_match( '/(%[0-9a-f]{2})+/', $slug ) ) {
					$slug = 'post' . $this_post_id;
				}
			}
		}
		return $slug;
	}
	add_filter( 'wp_unique_post_slug', 'auto_post_slug', 10, 4  );

	## エディタの設定 editor
	/*
	 * 	旧 old_editor_setting
	 * 	カスタム投稿タイプ・固定ページ 共通
	 */

	//ビジュアルリッチテキストエディタ ボタン1行目
	function oes_button( $buttons ) {
		global $post, $post_type;
		// page
		if( $post_type === 'page' ) {
			$arr = ( defined( 'PAGES_SETTING_CHILD' ) ) ? PAGES_SETTING_CHILD : PAGES_SETTING; // multisite_adjust
			if( in_array( $post->ID, array_keys( $arr ) ) && isset( $arr[ $post->ID ][ 'editor' ] ) ) {
				$buttons = $arr[ $post->ID ][ 'editor' ];
			}
		// post_type
		} else {
			$arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
			foreach( $arr as $k => $v ) {
				if( $post_type === $k ) {
					$buttons = $v[ 'editor' ];
					break;
				}
			}
		}
		return $buttons;
	}
	add_filter( 'mce_buttons', 'oes_button', 1 );
	//ビジュアルリッチテキストエディタ ボタン2行目（共通）
	function oes_button_2( $buttons ) {
		return [];
	}
	add_filter( 'mce_buttons_2', 'oes_button_2', 1 );

	//ブロック要素の設定（共通）
	function oes_select_element( $init_array ) {
		$blockformats = EDITOR_BLOCK_FORMAT;
		$init_array[ 'block_formats' ] = $blockformats;
		return $init_array;
	}
	add_filter( 'tiny_mce_before_init', 'oes_select_element' );
	//ビジュアルエディタ 表(テーブル)
	function mce_external_plugins_table( $plugins ) {
		//$plugins[ 'table' ] = '//cdn.tinymce.com/4/plugins/table/plugin.min.js';
		return $plugins;
	}
	add_filter( 'mce_external_plugins', 'mce_external_plugins_table' );

	## カスタム投稿タイプ内に固定P追加 routing add_page

	function custom_rewrite_basic() {
		$arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
		foreach( $arr as $k => $v ) {
			if( isset( $v[ 'add_page' ] ) && is_array( $v[ 'add_page' ] ) && count( $v[ 'add_page' ] ) ) {
				foreach( $v[ 'add_page' ] as $vv ) {
					if( isset( $vv[ 'name' ] ) && isset( $vv[ 'pade_id' ] ) ) {
						add_rewrite_rule( '^' . $k . '/' . $vv[ 'name' ] . '/?$', 'index.php?page_id=' . $vv[ 'pade_id' ], 'top' );
					}
				}
			}
		}
	}
	add_action( 'init', 'custom_rewrite_basic' );

	## アーカイブ管理画面 一覧表示

	function manage_posts_columns ( $columns ) {

		$this_post_type = get_query_var( 'post_type' );
		/* common */
		// remove default feild
		unset( $columns[ 'tags' ] );       // タグ&カスタムフィールド
		unset( $columns[ 'comments' ] );   // コメント

		/* post_type */
		$arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
		$add_column_array = [];
		foreach( $arr as  $k => $v ) {
			if( $this_post_type === $k ) {
				$count = 0;
				foreach( $v[ 'columns' ][ 'column' ] as  $vv ) {
					$add_column_array[ 'column' . $count ] = $vv[ 'name' ];
					$count++;
				}
				if( ! $v[ 'columns' ][ 'author' ] ) {
					unset( $columns[ 'author' ] );
				}
				break;
			}
		}
		wp_oo_array_insert( $columns, 2, $add_column_array );
		return $columns;
	}
	add_filter( 'manage_posts_columns', 'manage_posts_columns' );
	// 一覧での表示項目
	function res_column( $type, $arg, $this_post_id ) {
		switch( $type ) {
			case 'debug':
				$val = get_field( $arg, $this_post_id );
				var_dump( $val );
				break;
			case 'normal':
				$val = get_field( $arg, $this_post_id );
				echo ( $val ) ? $val : '--';
				break;
			case 'image':
				$temp_img_arr = get_field( $arg, $this_post_id );
				echo ( isset( $temp_img_arr[ 'sizes' ][ 'thumbnail' ] ) ) ? '<img src="' . $temp_img_arr[ 'sizes' ][ 'thumbnail' ] . '" width="90">' : '--';
				break;
			case 'date':
				$date = get_field( $arg, $this_post_id );
				echo $date ? date_i18n( 'Y-m-d', $date ) : '--';
				break;
			case 'time':
				$date = get_field( $arg, $this_post_id );
				echo $date ? date_i18n( 'H:i', $date ) : '--';
				break;
			case 'radio_select':
				$temp_arr = get_field( $arg, $this_post_id ); // 返り値:arr
				echo ( isset( $temp_arr[ 'label' ] ) ) ? $temp_arr[ 'label' ] : '--';
				break;
			case 'file':
				$file = get_field( $arg, $this_post_id );
				if( $file ) {
					echo '<a href="' . $file . '" target="_blank">PDFファイル</a>';
				} else {
					echo '--';
				}
				break;
			case 'checkbox':
				$temp_arr = get_field( $arg, $this_post_id ); // 返り値:arr
				$temp_arr = is_array( $temp_arr ) ? $temp_arr : [];
				$res_arr = [];
				for( $i = 0; $i < count( $temp_arr ); $i++ ) {
					$res_arr[] = $temp_arr[ $i ][ 'label' ];
				}
				echo ( $res_arr ) ? implode( ' , ', $res_arr ) : '--';
				break;
			case 'taxonomy':
				$temp_arr = is_array( get_the_terms( $this_post_id, $arg ) ) ? get_the_terms( $this_post_id, $arg ) : [];
				$res_arr = [];
				foreach( $temp_arr as  $v ) {
					// カテゴリー3階層まで取得
					$temp = '';
					if( $v->parent != 0 ) {
						$temp_parent = get_term( $v->parent, $arg );
						if( $temp_parent->parent != 0 ) {
							$temp .= get_term( $temp_parent->parent, $arg )->name . ' > ';
						}
						$temp .= $temp_parent->name . ' > ';
					}
					$temp .= $v->name;
					$res_arr[] = $temp ;
				}
				echo ( $res_arr ) ? implode( ' / ', $res_arr ) : '--';
				break;
			case 'relation':
				$temp_arr = is_array( get_field( $arg, $this_post_id ) ) ? get_field( $arg, $this_post_id ) : [];
				$res_arr = [];
				foreach( $temp_arr as  $v ) {
					$res_arr[] = get_the_title( $v );
				}
				echo ( $res_arr ) ? implode( '/', $res_arr ) : '--';
				break;
			case 'post_object':
				$temp_post_id = get_field( $arg, $this_post_id ) ? get_field( $arg, $this_post_id ) : false;
				if( $temp_post_id ) {
					echo get_the_title( $temp_post_id );
				} else {
					echo '--';
				}
				break;
			case 'newmark':
				$date_compare = date_i18n( 'Ymd', strtotime( date_i18n( 'Y-m-d' ) . '-1 month' ) );
				$temp_date    = get_the_date( 'Ymd', $this_post_id );
				if( $temp_date > $date_compare ) {
					echo '○：初回投稿日より1カ月以内';
				} else {
					echo '✕：初回投稿日より1カ月経過';
				}
				break;
			case 'replace':
				$acf_val = get_field( $arg[ 'acf_key' ], $this_post_id );
				echo isset( $arg[ 'acf_key' ][ $acf_val ] ) ? $arg[ 'acf_key' ][ $acf_val ] : $acf_val;
				break;
			case 'supple':
				echo $arg;
				break;
			case 'linktype':
				// custom
				$temp_arr =  get_field( $arg, $this_post_id ) ;
				if( $temp_arr[ 'type' ][ 'value' ] === 'type_nolink' ) {
					echo 'リンクなし';
				} elseif( $temp_arr[ 'type' ][ 'value' ] === 'type_url' ) {
					echo 'リンク-URL';
				} elseif( $temp_arr[ 'type' ][ 'value' ] === 'type_detail' ) {
					echo 'リンク-詳細ページ';
				} elseif( $temp_arr[ 'type' ][ 'value' ] === 'type_pdf' ) {
					echo 'リンク-PDFファイル';
				} else {
					echo 'リンク設定なし';
				}
				break;
			case 'func':
				$func = $arg[ 'func_name' ];
				echo $func( $this_post_id, $arg );
				break;
			default:
				echo '-';
		}
	}
	function disp_post_column ( $column, $this_post_id ) {
		$this_post_type = get_query_var( 'post_type' );
		$res_arr = [];
		$arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
		foreach( $arr as $k => $v ) {
			if( $k === $this_post_type ) {
				$res_arr = $v[ 'columns' ][ 'column' ] ?? [];
				$count = 0;
				foreach( $res_arr as  $vv ) {
					if( $column === 'column' . $count ) {
						res_column( $vv[ 'type' ], $vv[ 'arg' ], $this_post_id );
						break;
					}
					$count++;
				}
				break;
			}
		}
	}
	add_action( 'manage_posts_custom_column', 'disp_post_column', 10, 2 );

	/* サンプル：カスタム投稿タイプ

		'addposttypename' => [
			'name'           => 'カスタム投稿タイプ名称',
			'posts_per_page' => 10,
			// エディタ
			'editor'         => [
				'link',           // リンク
				'unlink',         // リンク解除
				'|',              // 区切り線
				'formatselect',   // 見出しやpなどブロック要素の設定
				'bullist',        // ul li
				'numlist',        // ol li
				'forecolor',      // テキストカラー
				'table'           // 表
			],
			'gutenberg'      => false, // Gutenberg
			'eyecatch'       => false,
			// slug
			'slug'           => [
				'auto_slug'  => true, // slugの自動生成 * 'post' . $this_post_id (191002~)
				'rewrite'    => true  // 特定のディレクトリ(zzz)内にアーカイブする場合は右記の配列を記述 [ 'slug' => 'zzz/addposttypename' ]
			],
			// add_page
			// 設定後はWordPress管理画面 > 設定 > パーマリンク設定からフラッシュ（設定保存）
			'add_page'       => [
				[
					'name'           => 'pageneme', // リンクURL： /xxx/pageneme/
					'pade_id'        => '3' // 固定ページのID
				]
			],
			// sitemap_xml
			'sitemap'        => [
				'archive'    => '0.5', // アーカイブがない場合は「false」
				'single'     => '0.6', // シングルがない場合は「false」
				'add_arg'    => []
			],
			// posts_archive = 一覧での表示項目
			// 下記の他に debug, file, checkbox, date, time, relation, supple, newmark, replace, func あり cf) wp_functions_setting
			'columns'        => [
				'author'     => false,
				'column'     => [
					[
						'name'       => '一覧表示項目',
						'type'       => 'normal',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => '画像',
						'type'       => 'image',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => '日付',
						'type'       => 'date',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'ラジオボタン or SELECT',
						'type'       => 'radio_select',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'カテゴリー',
						'type'       => 'taxonomy',
						'arg'        => 'cat_xxx' // taxonomy
					]
				]
			]
		]
		*/

	/* サンプル：管理画面の投稿一覧 posts_archive_columns

		'addposttypename' => [
			// posts_archive = 一覧での表示項目
			'columns'        => [
				'author'     => false,
				'column'     => [
					[
						'name'       => '一覧表示項目',
						'type'       => 'normal',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => '画像',
						'type'       => 'image',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => '日付',
						'type'       => 'date',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'ラジオボタン or SELECT',
						'type'       => 'radio_select',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'ファイル',
						'type'       => 'file',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'チェックボックス',
						'type'       => 'checkbox',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'カスタムタクソノミー',
						'type'       => 'taxonomy',
						'arg'        => 'cat_xxx' // taxonomy
					],
					[
						'name'       => '関連',
						'type'       => 'relation',
						'arg'        => 'acf_xx' // acf
					],
					[
						'name'       => 'NEWマーク',
						'type'       => 'newmark',
						'arg'        => '-1 month' // option
					],
					[
						'name'       => '文字列変換',
						'type'       => 'replace',
						'arg'        => [
							'acf_key'    => 'acf_xx', // acf : 返り値の文字列を変更
							'replace'    => [
								'show'       => '表示'
								'hide'       => '非表示'
							]
						]
					],
					[
						'name'       => '注釈',
						'type'       => 'supple',
						'arg'        => '*注釈文面' // acf
					],
					[
						'name'       => '独自関数設定',
						'type'       => 'func',
						'arg'        => [
							'acf_key'    => 'acf_xx',
							'func_name'  => 'create_column_loop_xxx'
						]
					]
				]
			]
		]

	/* サンプル：独自関数 posts_archive_columns

	function create_column_loop_xxx( $this_post_id, $arg ) {
		$acf_loop = wp_oo_acf_loop( get_field( $arg[ 'acf_key' ], $this_post_id ) );
		$res_arr = [];
		foreach( $acf_loop as  $v ) {
			$res_arr[] = '<a href="' . $v[ 'aaa' ] . '" target="_blank">' . $v[ 'bbb' ] . '</a>';
		}
		return join( ' / ', $res_arr );
	}
	*/

	/**------------------------------------------------------
	 *
	 * カスタムタクソノミー
	 *
	------------------------------------------------------ */

	##	カスタムタクソノミー追加

	function create_taxonomy() {
		$arr = ( defined( 'CUSTOM_TAXONOMY_CHILD' ) ) ? CUSTOM_TAXONOMY_CHILD : CUSTOM_TAXONOMY; // multisite_adjust
		foreach( $arr as $k => $v ) {
			$bool_tax_type = ( $v[ 'tax_type' ] === 'tag' ) ? false : true;
			$args = [
				'label'               => $v[ 'name' ],
				'rewrite'             => [ 'slug' => $k ],
				'hierarchical'        => $bool_tax_type
			];
			if( isset( $v[ 'labels' ] ) ) {
				$args[ 'labels' ] = $v[ 'labels' ];
			}
			register_taxonomy( $k, $v[ 'post_type' ], $args );
		}
	}
	add_action( 'init', 'create_taxonomy' );

	##	カテゴリ選択欄

	if( is_admin() ) {
		// class : Walker_Category_Checklist を上書き
		include_once ABSPATH . '/wp-admin/includes/template.php';
		class admin_category_adjust_checklist extends Walker_Category_Checklist{
			function start_el( &$output, $category, $depth = 0, $args = [], $id = 0 ) {
				$arr = ( defined( 'CUSTOM_TAXONOMY_CHILD' ) ) ? CUSTOM_TAXONOMY_CHILD : CUSTOM_TAXONOMY; // multisite_adjust
				// 親カテゴリの時はチェックボックス非表示
				$target_taxonomy_parent_checkbox_hide = [];
				// チェックボックスをラジオボタンに変更
				$target_taxonomy_change_radio         = [];
				foreach( $arr as  $k => $v ) {
					if( $v[ 'style' ] === 'parent_no_child_checkbox' || $v[ 'style' ] === 'parent_no_child_radio' ) {
						$target_taxonomy_parent_checkbox_hide[] = $k;
					}
					if( $v[ 'style' ] === 'radio' || $v[ 'style' ] === 'parent_no_child_radio' ) {
						$target_taxonomy_change_radio[] = $k;
					}
				}
				// 以下変更しない
				extract( $args );
				if( empty( $taxonomy ) ) $taxonomy = 'category';
				if( $taxonomy == 'category' ) {
					$name = 'post_category';
				} else {
					$name = 'tax_input[' . $taxonomy . ']';
				}
				$class = in_array( $category->term_id, $popular_cats ) ? [ 'popular-category' ] : [];
				// 該当タクソノミーで親カテゴリの時はチェックボックス表示しない
				$class = $class ? ' class="' . join( ' ', $class ) . '"' : '';
				if( in_array( $taxonomy, $target_taxonomy_parent_checkbox_hide ) && get_term_children( $category->term_id, $taxonomy ) ){
					$style = $category->parent === 0 ? 'style="font-weight:bold;"' : '';
					$output .= "\n" .'<li id=' . $taxonomy . '-' . $category->term_id . $class . '><label class="selectit"' . $style . '>' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
				// 該当タクソノミーでラジオボタンに変更
				} elseif( in_array( $taxonomy, $target_taxonomy_change_radio ) ) {
					$output .= "\n" . '<li id="' . $taxonomy . '-' . $category->term_id . '"' . $class . '><label class="selectit"><input value="' . $category->term_id . '" type="radio" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args[ 'disabled' ] ), false, false ) . '> ' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
				}else{
					$output .= "\n" . '<li id="' . $taxonomy . '-' . $category->term_id . '"' . $class . '><label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args[ 'disabled' ] ), false, false ) . '> ' . esc_html( apply_filters( 'the_category', $category->name ) ) . '</label>';
				}
			}
		}
	}

	##	カテゴリの並べ替え停止

	if( is_admin() ) {
		function wp_category_terms_checklist_no_sort( $args, $post_id = null ) {
			$args[ 'checked_ontop' ] = false;
			// 入力欄調整親カテゴリ非表示/ラジオボタンに変更
			$args[ 'walker' ] = new admin_category_adjust_checklist();
			return $args;
		}
		add_action( 'wp_terms_checklist_args', 'wp_category_terms_checklist_no_sort' );
	}

	##	投稿一覧でのタクソノミー絞り込み表示

	class ADD_POSTS_FILTER_DROPDOWN_TAXONOMY {
		public $taxonomy_slug;
		public $taxonomy_name;
		static private $_methods = [];
		static public function add_method( $name, Closure $callback ) {
			self::$_methods[ $name ] = $callback;
		}
		public function __call( $name, array $args ) {
			$func = self::$_methods[ $name ];
			return call_user_func_array( $func->bindTo( $this, get_class( $this ) ), $args );
		}
		public function each_taxonomy( $taxonomy_id, $taxonomy_name, $taxonomy_post_type ) {
			$this_post_type = get_query_var( 'post_type' );
			$terms = get_terms( $taxonomy_id );
			$tag = '';
			$tb = '';
			if( $terms && $this_post_type === $taxonomy_post_type ) {
				$selected = get_query_var( $taxonomy_id );
				$tag .= $tb . "" . '<select name="' . $taxonomy_id . '">' . "\n";
				$tag .= $tb . "\t" . '<option value="">' . $taxonomy_name  . '</option>' . "\n";
				foreach( $terms as $v ){
					$tag_selected = ( $selected === $v->slug ) ? ' selected="selected"' : '';
					$tag .= $tb . "\t" . '<option' . $tag_selected . ' value="' . $v->slug . '">' . $v->name . '</option>' . "\n";
				}
				$tag .= $tb . "" . '</select>' . "\n";
			}
			echo $tag;
		}
	}
	$add_posts_filter_dropdown_taxonomy = new ADD_POSTS_FILTER_DROPDOWN_TAXONOMY();
	$arr = ( defined( 'CUSTOM_TAXONOMY_CHILD' ) ) ? CUSTOM_TAXONOMY_CHILD : CUSTOM_TAXONOMY; // multisite_adjust
	foreach ( $arr as $k => $v ) {
		ADD_POSTS_FILTER_DROPDOWN_TAXONOMY::add_method( 'each_taxonomy_' . $k, function() use ( $v ) {
			global $k;
			return $this->each_taxonomy( $k, $v[ 'name' ], $v[ 'post_type' ] );
		} );

		add_action( 'restrict_manage_posts', [ $add_posts_filter_dropdown_taxonomy, 'each_taxonomy_' . $k ] );
	}

	/**------------------------------------------------------
	 *
	 * 固定ページ
	 *
	------------------------------------------------------ */

	## 固定ページ一覧項目表示

	function manage_pages_columns ( $columns ) {
		// remove default feild
		unset( $columns[ 'comments' ] );
		$add_column_array = [];
		$add_column_array[ 'type' ] = '種別';
		$add_column_array[ 'postname' ] = 'SLUG';
		$add_column_array[ 'template' ] = 'テンプレート';
		wp_oo_array_insert( $columns, 2, $add_column_array );
		return $columns;
	}
	add_filter( 'manage_pages_columns', 'manage_pages_columns' );
	function disp_page_column ( $column, $this_post_id ) {
		$post = get_post( $this_post_id );
		$postname = esc_attr( $post->post_name );
		if( $column === 'type' ) {
			$arr = ( defined( 'CUSTOM_TAXONOMY_CHILD' ) ) ? CUSTOM_TAXONOMY_CHILD : CUSTOM_TAXONOMY; // multisite_adjust
			$post_type_arr = ( defined( 'CUSTOM_POSTTYPE_CHILD' ) ) ? CUSTOM_POSTTYPE_CHILD : CUSTOM_POSTTYPE; // multisite_adjust
			$add_page_id_arr = [];
			foreach( $post_type_arr as  $v ) {
				if( isset( $v[ 'add_page' ] ) ) {
					$add_page_id_arr = array_merge( $add_page_id_arr, array_column( $v[ 'add_page' ], 'page_id' ) );
				}
			}
			if( in_array( $postname, array_keys( $arr ) ) ) {
				echo '非表示（階層設定用）';
			} elseif( strpos( $postname, 'admin' ) === 0 ) {
				echo '管理画面';
			} elseif( strpos( basename( get_page_template() ), 'redirect' ) === 0 ) {
				echo '非表示（階層設定用）';
			} else {
				$add   = [];
				if( $postname !== esc_attr( $post->post_title ) ) {
					$add[] = '管理画面';
				}
				if( in_array( $post->ID, $add_page_id_arr ) ) {
					$add[] = 'ルーティング変更';
				}
				$add = $add ? '（' . join( ' / ', $add ) . '）' : '';
				echo '固定P'. $add;
			}
		} elseif( $column === 'postname' ) {
			echo $postname;
		} elseif( $column === 'template' ) {
			echo basename( get_page_template() );
		}
	}
	add_action( 'manage_pages_custom_column', 'disp_page_column', 10, 2 );

	## 特定ページでGutenberg無効化

	function disable_block_editor_for_page( $use_block_editor, $this_post ) {
		$arr = ( defined( 'PAGES_SETTING_CHILD' ) ) ? PAGES_SETTING_CHILD : PAGES_SETTING; // multisite_adjust
		if( in_array( $this_post->ID, array_keys( $arr ) ) ) {
			if( isset( $arr[ $this_post->ID ][ 'gutenberg' ] ) && $arr[ $this_post->ID ][ 'gutenberg' ] ) {
				return $use_block_editor;
			}
		} else {
			return false;
		}
	}
	add_filter( 'use_block_editor_for_post', 'disable_block_editor_for_page', 10, 2 );

	/**------------------------------------------------------
	 *
	 * 管理画面 各種自動更新
	 *
	------------------------------------------------------ */

	if( ! defined( 'WPADMIN_UPDATE' ) || ! WPADMIN_UPDATE ) {
		add_filter( 'pre_site_transient_update_core', '__return_zero' );
		add_filter( 'site_option__site_transient_update_plugins', '__return_zero' );
		remove_action( 'wp_version_check', 'wp_version_check') ;
		remove_action( 'admin_init', '_maybe_update_core' );
	}

	/**------------------------------------------------------
	 *
	 * 管理画面 js,css
	 *
	------------------------------------------------------ */

	function common_admin_head_setting() {
		$arr = WPADMIN_JSCSS;
		$this_post_type = get_query_var( 'post_type' );
		$wpuser_id = get_current_user_id();
		$tag = '';
		foreach( $arr as $k => $v ) {
			foreach( $v as $kk => $vv ) {
				if(
					// user
					(
						( $vv[ 'user' ] === 'all' )
						||
						( $vv[ 'user' ] === 'user' && $wpuser_id !== 1 )
						||
						( in_array( $wpuser_id, explode( ',', $vv[ 'user' ] ) ) )
					)
					&&
					// post_type
					(
						( $vv[ 'post_type' ] === 'all' )
						||
						( $vv[ 'post_type' ] === $this_post_type )
						||
						( isset( $_GET[ 'taxonomy' ] ) && $_GET[ 'taxonomy' ] === $vv[ 'post_type' ] )
					)
				) {
					if( $k === 'css' ) {
						$tag .= '<link rel="stylesheet" href="' . get_bloginfo( 'template_directory' ) . '/wpoo/css/' . $vv[ 'fname' ] . '" type="text/css" media="screen">' . "\n";
					} elseif( $k === 'js' ) {
						$tag .= '<script src="' . get_bloginfo( 'template_directory' ) . '/wpoo/js/' . $vv[ 'fname' ] . '"></script>' . "\n";
					}
				}
			}
		}
		echo $tag;
	}
	add_action( 'admin_head', 'common_admin_head_setting' );

	/**------------------------------------------------------
	 *
	 * マルチサイト
	 *
	------------------------------------------------------ */

	if( defined( 'MULTISITE_BLOG' ) && function_exists( 'get_current_blog_id' ) ) {
		$current_blog_id = get_current_blog_id();
		$arr = MULTISITE_BLOG;
		if( isset( $arr[ $current_blog_id ] ) && $current_blog_id != 1 ) {
			if( !defined( 'MULTISITEBLOGNAME' ) ) define( 'MULTISITEBLOGNAME', $arr[ $current_blog_id ] );
			if( !defined( 'MULTISITETHEMEDIR' ) ) define( 'MULTISITETHEMEDIR', '/c_' . $arr[ $current_blog_id ] );
			if( !defined( 'MULTISITEBLOGDIR' ) ) define( 'MULTISITEBLOGDIR', '/' . $arr[ $current_blog_id ] );
		} else {
			if( !defined( 'MULTISITEBLOGNAME' ) ) define( 'MULTISITEBLOGNAME', 'base' );
			if( !defined( 'MULTISITETHEMEDIR' ) ) define( 'MULTISITETHEMEDIR', '/base' );
			if( !defined( 'MULTISITEBLOGDIR' ) ) define( 'MULTISITEBLOGDIR', '' );
		}
	}