<?php
/**--------------------------------------------------------------
 *
 * wp_functions_option
 *
 * @version
 * 		18.1.1
 *
 * @memo
 * 		functions.php 末尾に追記
 * 		各項目 編集して使用
 *
 --------------------------------------------------------------*/

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		管理画面全体でアイキャッチ有効化
	 *
	------------------------------------------------------ */

	add_theme_support( 'post-thumbnails' );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		ACF ラジオボタン・セレクト・チェックボックスの選択肢自動表示
	 *
	 * @memo
	 * 		year, month, nendo
	 * 			wp_functions_init に移動
	 * 			auto_year, auto_month, auto_nendo に変更
	 *
	------------------------------------------------------ */

	##	posttypename || page_slug

	function acf_load_field_choices__xxx( $field ) {
		if( is_admin() ) include( ROOTREALPATH . '/mod/master/wp_export_master_xxx.php' );
		$this_post = get_queried_object();
		if( is_admin() && isset( $this_post->ID ) && intval( $this_post->ID ) === 999 ) {
			$field[ 'choices' ] = [];
			foreach( $wp_export_master_xxx_array as  $k => $v ) {
				$field[ 'choices' ][ $k ] = $v[ 'name' ];
			}
		}
		return $field;
	}
	add_filter( 'acf/load_field/name=xxx', 'acf_load_field_choices__xxx' );

	##	posttypename || page_slug（別形式）

	function acf_load_field_choices__yyy( $field ) {
		$this_post_type = get_query_var( 'post_type' );
		if( $this_post_type === 'posttypename' ) {
			/* $field 取得 */
			$arr = [
				'k01' => 'V01',
				'k02' => 'V02',
				'k03' => 'V03'
			];
			$default_value = 'k02';
			/* $field 上書き */
			$field[ 'choices' ] = $arr;
			$field[ 'default_value' ] = $default_value;
		}
		return $field;
	}
	add_filter( 'acf/load_field/name=yyy', 'acf_load_field_choices__yyy' );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		監理画面 投稿一覧ユーザー検索
	 *
	------------------------------------------------------ */

	function extended_user_search( $user_query ) {
	// Make sure this is only applied to user search
		if( $user_query->query_vars[ 'search' ] ){
			$search = trim( $user_query->query_vars[ 'search' ], '*' );
			if ( $_REQUEST[ 's' ] == $search ){
				global $wpdb;
				$user_query->query_from .= " JOIN wp_usermeta UM1 ON UM1.user_id = {$wpdb->users}.ID AND UM1.meta_key = 'first_name'";
				$user_query->query_from .= " JOIN wp_usermeta UM2 ON UM2.user_id = {$wpdb->users}.ID AND UM2.meta_key = 'last_name'";
				$user_query->query_where = 'WHERE 1=1' . $user_query->get_search_sql( $search, [ 'user_login', 'user_email', 'user_nicename', 'display_name', 'UM1.meta_value', 'UM2.meta_value' ], 'both' );
			}
		}
	}
	add_action( 'pre_user_query', 'extended_user_search' );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		マスターファイル生成
	 *
	------------------------------------------------------ */

	function create_export_master_file() {

		$this_post = get_queried_object();
		$this_post_type = get_query_var( 'post_type' );

		/* post_type_name */
		if( $this_post_type === 'xxx' ) {
			$the_master_name = 'master_' . $this_post_type;
			$arr = [];
			$i = 0;
			// get_posts
			$args = [
				'posts_per_page' => -1,
				'post_type'      => $this_post_type
			];
			$the_query = new WP_Query( $args );
			// export_code
			$code = '';
			$tb  = "";
			$code .= $tb . "" . '<?php' . "\n";
			$code .= $tb . "" . '/*--------------------------------------------------------------' . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "\t" . 'wp_export_' . $the_master_name . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "\t" . 'update : ' . date_i18n( 'Y-m-d h:i:s' ) . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "" . '---------------------------------------------------------------*/' . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "" . '## master' . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "\t" . '$wp_export_' . $the_master_name . '_array = [' . "\n";
			if( $the_query->have_posts() ) {
				$count = 0;
				// 編集エリア ここから
				// 値が複数パターン
				while( $the_query->have_posts() ) {
					$the_query->the_post();
					$this_post_id                                      = $the_query->post->ID;
					// $arr[ 'key' ]                                      = $this_post_id;
					// $arr[ 'post_id' ]                                  = $this_post_id;
					// $arr[ 'post_title' ]                               = get_the_title( $this_post_id );
					// $arr[ 'permalink' ]                                = get_permalink( $this_post_id );
					// key
					$code .= $tb . "\t\t" . '' . $this_post_id . ' => [' . "\n";
					$code .= $tb . "\t\t\t" . '"post_title"                    => "' . get_the_title( $this_post_id ) . '",' . "\n";
					$code .= $tb . "\t\t\t" . '"acfxxxxxxxxx"                  => "' . get_field( 'xxx_acfname', $this_post_id ) . '",' . "\n";
					$code .= $tb . "\t\t\t" . '"modified_date"                 => "' . get_the_modified_date( 'Y-m-d', $this_post_id ) . '"' . "\n"; // last( !important )
					// last_data
					$count++;
					$code .= ( $the_query->found_posts === $count ) ? $tb . "\t\t" . ')' . "\n" : $tb . "\t\t" . '),' . "\n" ;
				}
				// 値がひとつパターン
				while( $the_query->have_posts() ) {
					$the_query->the_post();
					$this_post_id                                      = $the_query->post->ID;
					$code .= $tb . "\t\t" . '"' . $this_post_id . '" => "' . get_the_title( $this_post_id );
					// last_data
					$count++;
					$code .= ( $the_query->found_posts === $count ) ? '"' . "\n" : '",' . "\n" ;
				}
				// 編集エリア ここまで
			}
			$code .= $tb . "\t" . ');' . "\n";
			$export_code = $code;

			$fpath_export = ROOTREALPATH . '/mod/master/wp_export_' . $the_master_name . '.php';
			file_put_contents( $fpath_export, $export_code );

		/* page_slug */
		} elseif( $this_post->ID === 99 ) {
			$the_master_name = 'master_' . get_post_field( 'post_name', $this_post->ID );
			$res_arr = [];
			// export_code
			$code = '';
			$tb  = "";
			$code .= $tb . "" . '<?php' . "\n";
			$code .= $tb . "" . '/*--------------------------------------------------------------' . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "\t" . 'wp_export_' . $the_master_name . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "\t" . 'update : ' . date_i18n( 'Y-m-d h:i:s' ) . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "" . '---------------------------------------------------------------*/' . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "" . '## master' . "\n";
			$code .= $tb . "" . '' . "\n";
			$code .= $tb . "\t" . '$wp_export_' . $the_master_name . '_array = [' . "\n";
			$arr = get_field( 'xxx', $this_post->ID );
			$count = 0;
			// 編集エリア ここから
			// 値が複数パターン
			foreach( $arr as  $v ) {
				// key
				$code .= $tb . "\t\t" . '"' . $v[ 'key' ]. '" => [' . "\n";
				$code .= $tb . "\t\t\t" . '"name"      => "' . $v[ 'name' ] . '",' . "\n";
				// last_data
				$count++;
				$code .= ( count( $arr ) === $count ) ? $tb . "\t\t" . ')' . "\n" : $tb . "\t\t" . '),' . "\n" ;
			}
			// 値がひとつパターン
			foreach( $arr as  $v ) {
				// key
				$code .= $tb . "\t\t" . '"' . $v[ 'code' ]. '" => "' . $v[ 'name' ];
				// last_data
				$count++;
				$code .= ( count( $arr ) === $count ) ? '"' . "\n" : '",' . "\n" ;
			}
			// 編集エリア ここまで
			$code .= $tb . "\t" . ');' . "\n";
			$export_code = $code;

			$fpath_export = ROOTREALPATH . '/mod/master/wp_export_' . $the_master_name . '.php';
			file_put_contents( $fpath_export, $export_code );
		}
	}
	add_action( 'save_post', 'create_export_master_file', 10, 1 );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		アップロードCSVからDB書き込み
	 *
	------------------------------------------------------ */

	function update_db_by_csv( $this_post_id ) {

		global $wpdb;
		/* setting
			db _cms/wpよりsqlインポート
				* テーブル名を付与「oo_csv_xxx」
				* csvの1行目とdbのfield名と完全一致させる
			csv
				* 必須項目(key) は必ず unique で作成
				* 数値型(type_int)設定、dbも合わせる
				* カナ変換対象の列設定
				* 半角英数チェック(asc_check) ※ハイフン、アンダーバー可
		*/
		// wp
		$setting                = [
			// key : CSVアップロード固定ページ post_id
			9999 => [
				'db_table_name'      => 'oo_csv_xxx',	// テーブル名
				'acf_name_csv'       => 'csv_to_db', 	// acf名 *csvの返り値はファイルURL
				'csvparse'           => [
					'total_fields'   => 3,				// csvの返り値はファイルURL
					'title_row_num'  => 1,				// 対象外行数 1,2,...
				],
				'csv_setting'        => [
					'key'            => 'xxx_id',		// [重要] csv内key列 || autoincrement
					'update'         => false,
					'type_int'       => [			// 数値型の列指定
					],
					'type_float'       => [			// float型の列指定
					],
					'convert_kana'   => [			// 半角カナ変換、全角数値変換の列指定
						'xxx_text'
					],
					'asc_check'      => [			// 半角英数のチェック
						'xxx_id'
					]
				],
				'db_table_field_name' => [
					'aaa',
					'bbb'
				]
			]
		];
		$log = [];
		$debug_log = [];

		if( in_array( $this_post_id, array_keys( $setting ) ) ){

			/* base_info */
			$db_update = true;
			// csv_fname
			$fpath_csv = get_field( $setting[ $this_post_id ][ 'acf_name_csv' ], $this_post_id );
			// db_fieldsname
			$sql = 'DESCRIBE ' . $setting[ $this_post_id ][ 'db_table_name' ];
			$db_fields = $wpdb->get_results( $sql );
			$db_fields_arr = [];
			$check = 'check:';
			foreach( $db_fields as  $v ) {
				$db_fields_arr[] = $v->Field;
			}
			//$log[] = var_export($db_fields_arr,true);

			/* csv_parse */
			if( $db_update ) {
				if( ! $fpath_csv ) {
					$log[] = 'fpath_csv : x(wp-admin or functions.php)';
					$db_update = false;
				} else {
					$log[] = 'fpath_csv : o';
					include_once ROOTREALPATH . '/mod/lib/csv_parse.class.php';
					$CP = new csv_parse();
					$CP->set_keys = $setting[ $this_post_id ][ 'db_table_field_name' ];
					$csv_title_row_num = $setting[ $this_post_id ][ 'csvparse' ][ 'title_row_num' ];
					$arr_csv = $CP->result_array( $fpath_csv, $setting[ $this_post_id ][ 'csvparse' ][ 'total_fields' ], 'fieldname', $csv_title_row_num );
					$arr_csv_keys = ( $setting[ $this_post_id ][ 'db_table_field_name' ] ) ? $setting[ $this_post_id ][ 'db_table_field_name' ] : array_keys( $arr_csv[ 0 ] );
				}
			}

			/* csv check */
			if( $db_update ) {
				if( ! is_array( $arr_csv ) || ! $arr_csv ) {
					$log[] = 'arr_csv : x(csv_content)';
					$db_update = false;
				} elseif( $setting[ $this_post_id ][ 'csv_setting' ][ 'key' ] !== 'autoincrement' ) {
					if( ! isset( $setting[ $this_post_id ][ 'csv_setting' ][ 'key' ] ) ) {
						$log[] = 'arr_csv : o,x("no csv_setting_key" functions.php)';
						$db_update = false;
					} elseif( ! in_array( $setting[ $this_post_id ][ 'csv_setting' ][ 'key' ], $arr_csv_keys ) ) {
						$log[] = 'arr_csv : o,o,x("no match csv_setting_key csv_filds_name" functions.php)';
						$db_update = false;
					}
				} else {
					$log[] = 'arr_csv : o,o,o';
					$csv_key = $setting[ $this_post_id ][ 'csv_setting' ][ 'key' ];
				}
			}
			/* db : fields_check */
			if( $db_update ) {
				$temp_log = [];
				foreach( $arr_csv_keys as  $v ) {
					if( ! in_array( $v, $db_fields_arr ) ) {
						$temp_log[] = $v;
					}
				}
				if( count( $temp_log ) > 0 ) {
					$log[] = 'arr_csv_fields_name : x(' . join( ',', $temp_log ) . ':not db_fields_name)';
					$db_update = false;
				} else {
					$log[] = 'arr_csv_fields_name : o';
				}
			}

			/* create_arr */
			if( $db_update ) {
				$array_values = [];
				$placeholders = [];
				$check_duplicate_arr = [];
				$temp_log = [];
				for( $i = 0; $i < count( $arr_csv ); $i++ ) {
					if( $csv_key !== 'autoincrement' ) {
						if( ! $arr_csv[ $i ][ $csv_key ] ) {
							$temp_log[] = 'record[' . ( $i + $csv_title_row_num + 1 ) . '][ ' . $csv_key . ' ] : empty';
						} elseif( in_array( $arr_csv[ $i ][ $csv_key ], $check_duplicate_arr ) ) {
							$temp_log[] = 'record[' . ( $i + $csv_title_row_num + 1 ) . '][ ' . $csv_key . ' ] : duplicate';
						}
					} else {
						$temp_placeholder = [];
						foreach( $arr_csv[ $i ] as $kk => $vv ) {
							if( in_array( $kk, $setting[ $this_post_id ][ 'csv_setting' ][ 'asc_check' ] ) && ! preg_match( '/^[_a-zA-Z0-9-]+$/', $vv ) ) {
								$temp_log[] = 'cell[' . ( $i + $csv_title_row_num + 1 ) . '][ ' . $kk . ' ] : x "' . $vv . ' - no_ascii"';
							}
							$array_values[] = ( in_array( $kk, $setting[ $this_post_id ][ 'csv_setting' ][ 'convert_kana' ] ) ) ? mb_convert_kana( $vv, 'KVas' ) : $vv;
							if( in_array( $kk, $setting[ $post_id ][ 'csv_setting' ][ 'type_int' ] ) ) {
								$temp_placeholder[] = '%d';
							} elseif( in_array( $kk, $setting[ $post_id ][ 'csv_setting' ][ 'type_float' ] ) ) {
								$temp_placeholder[] = '%f';
							} else {
								$temp_placeholder[] = '%s';
							}
						}
						$placeholders[] = '(' . join( ',', $temp_placeholder ) . ')';
						if( $csv_key !== 'autoincrement' ) {
							$check_duplicate_arr[] = $arr_csv[ $i ][ $csv_key ];
						}
					}
				}
				if( $temp_log ) {
					$log[] = 'create_sql : !(' . join( ',', $temp_log ) . ')';
				} else {
					$log[] = 'create_sql : o';
				}
			}

			/* db : delate */
		if( $db_update ) {
			if( ! $setting[ $post_id ][ 'csv_setting' ][ 'update' ] ) {
				$sql = 'DELETE FROM ' . $setting[ $post_id ][ 'db_table_name' ];
				if( $wpdb->query( $sql ) ) {
					$log[] = 'delate : o';
					$log[] = var_export( $setting[ $post_id ][ 'csv_setting' ][ 'update' ], true );
				} else {
					$log[] = 'delate : -';
				}
			} else {
				$log[] = 'delate : -';
			}
		}

			/* db : insert*/
		if( $db_update ) {
			// $sql = 'INSERT INTO ' . $setting[ $post_id ][ 'db_table_name' ] . ' (' . join( ',', $arr_csv_keys ) . ') VALUES ' . join( ',', $placeholders );
			$sql_table        = $setting[ $post_id ][ 'db_table_name' ];
			$sql_keys         = join( ',', $arr_csv_keys );
			$sql_placeholders = join( ',', $placeholders );
			$sql = "INSERT INTO
					{$sql_table} ({$sql_keys})
				VALUES
					$sql_placeholders
			";
			// $setting[ $post_id ][ 'csv_setting' ][ 'update' ] により、ON DUPLICATE KEY 追記
			if( $setting[ $post_id ][ 'csv_setting' ][ 'update' ] ) {
				$sql .= ' ON DUPLICATE KEY UPDATE ';
				$temp_arr =[];
				foreach( $arr_csv_keys as $v ) {
					// primary key は含めず他全てを更新
					if( $v !== $setting[ $post_id ][ 'csv_setting' ][ 'update' ] ) {
						$temp_arr[] = $v . ' = VALUES( ' . $v . ' )';
					}
				}
				$sql .= join( ',', $temp_arr );
			}
			if( $wpdb->query( $wpdb->prepare( $sql, $array_values ) ) ) {
				$log[] = 'insert : o success!';
			} else {
				$log[] = 'insert : x';
				$log[] = $wpdb->prepare( $sql, $array_values );
			}
		}

			/* log */
			//if( $debug_log ) $log[] = '[debug : ' . join( '/', $debug_log ) . ']';
			$wpdb->insert(
				'oo_csv_log',
				[
					'csv_table' => $setting[ $this_post_id ][ 'db_table_name' ],
					'log' => join( ' / ', $log ),
					'log_date' => date_i18n( 'Y-m-d H:i:s' )
				],
				[ '%s', '%s' ]
			);
		}
	}
	add_action( 'save_post', 'update_db_by_csv' );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		管理画面での投稿タイトルの自動生成
	 *
	------------------------------------------------------ */

	function auto_write_title( $this_post_id, $this_post ) {

		// acf_name rewrite
		$acf_val = get_field( 'acf_name', $this_post_id );
		if( $acf_val ) {
			if( $this_post->post_type == 'post' ){
				$title = $acf_val;
				remove_action( 'wp_insert_post', 'auto_write_title' );
				wp_update_post( array(
					'ID' => $this_post_id,
					'post_title' => $title
				) );
				add_action('wp_insert_post', 'auto_write_title', 10, 2 );
			}
		}
	}
	add_action('wp_insert_post', 'auto_write_title', 10, 2);

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		管理画面 投稿一覧での独自検索
	 *
	------------------------------------------------------ */

	function custom_search( $search, $wp_query ) {
		global $wpdb;
		$setting_post_type ='xxx';
		if( ! $wp_query->is_search ) return $search;
		if( ! isset( $wp_query->query_vars ) ) return $search;

		$search_words = explode( ' ', isset( $wp_query->query_vars[ 's' ] ) ? $wp_query->query_vars[ 's' ] : '' );
		if( count( $search_words ) > 0 ) {
			$search = 'AND post_type = "' . $setting_post_type . '"';
			foreach ( $search_words as $v ) {
				if( ! empty( $v ) ) {
					$v = '%' . esc_sql( $v ) . '%';
					$search .= ' AND (
						' . $wpdb->posts . '.post_title LIKE "' . $v . '"
						OR
						' . $wpdb->posts . '.post_content LIKE "' . $v . '"
						OR
						' . $wpdb->posts . '.ID IN (
							SELECT distinct post_id
							FROM ' . $wpdb->postmeta . '
							WHERE meta_value LIKE "' . $v . '"
						)
					)';
				}
			}
		}
		return $search;
	}
	add_filter('posts_search','custom_search', 10, 2);

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		管理画面 投稿一覧での独自絞り込み
	 *
	------------------------------------------------------ */

	// 01 : 絞込みクエリ追加
	function add_admin_archive_acf_query( $vars ) {
		// この箇所は各関数内で設定 - 01
		$add_query_name = 'filter_xxx';

		$vars[] = $add_query_name;
		return $vars;
	}
	add_filter( 'query_vars', 'add_admin_archive_acf_query' );
	// 02 : 絞込みプルダウン追加
	function add_admin_archive_acf_filter(){
		// この箇所は各関数内で設定 - 02
		$add_query_name = 'filter_xxx';
		$target_post_type_array = [ 'posttypename01', 'posttypename02', 'posttypename03' ];
		global $wp_query;
		$this_post_type = get_query_var( 'post_type' );
		if ( in_array( $this_post_type, $target_post_type_array ) ) {
			$tag = '';
			$tb  = "\t\t\t\t\t\t";
			$tag .= $tb . "\t" . '<select name="' . $add_query_name . '">' . "\n";
			$tag .= $tb . "\t" . '<option value="">XXを選択</option>' . "\n";
			$temp_arr = get_posts( [ 'posts_per_page' => -1,'post_type' => 'post' ] );
			foreach( $temp_arr as $v ) {
				$selected = ( get_query_var( $add_query_name ) == strval( $v->ID ) ) ? ' selected="selected"' : '';
				$tag .= $tb . "\t" . '<option value="'. $v->ID. '"'. $selected. '>'. $v->post_title. '</option>';
			}
			$tag .= $tb . "\t" . '</select>' . "\n";
			echo $tag;
		}
	};
	add_action( 'restrict_manage_posts', 'add_admin_archive_acf_filter' );
	// 03 : where query の追記
	function add_admin_archive_acf_where( $where ) {
		// この箇所は各関数内で設定 - 02
		$add_query_name = 'filter_xxx';
		$meta_key = 'acf_key';
		global $wpdb;
		if( is_admin() ) {
			$value = get_query_var( $add_query_name );
			if( ! empty( $value ) ) {
				$where .= $wpdb->prepare(
					" AND EXISTS (
						SELECT *
						FROM
							{$wpdb->postmeta} as m
						WHERE
							m.post_id = {$wpdb->posts}.ID
							AND
							m.meta_key = '{$meta_key}'
							AND
							m.meta_value LIKE %s
					)",
					'%"' . $value . '"%'
				);
				/* シリアル化された配列にLIKE */
				// m.meta_value like %s
				// '%"' . $value . '"%'
				/* IN */
				// m.meta_value IN %s
				// '("' . join( '","', $arr ) . '")'
			}
		}
		return $where;
	};
	add_filter( 'posts_where', 'add_admin_archive_acf_where' );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		管理画面 投稿画面 独自メタボックス追加
	 *
	------------------------------------------------------ */

	function admin_csvdownlad_meta_box() {
		$add_param = 'aaa';
		$this_post = get_queried_object();
		$tag = '';
		$tb = "\t\t\t\t";
		$tag .= $tb . "" . '<a href="/xxx/xxx_csvdownload/?postid=' . $this_post->ID . '&param=' . $add_param . '">CSVダウンロード</a>' . "\n";
		echo $tag;
	}
	function custom_meta_box_output() {
		add_meta_box( 'custom_meta_box', 'CSVダウンロード', 'admin_csvdownlad_meta_box', 'post', 'side', 'low' );
	}
	add_action( 'admin_menu', 'custom_meta_box_output' );

	/**------------------------------------------------------
	 *
	 * OPTION
	 * 		管理画面 投稿画面 独自ページ追加
	 *
	------------------------------------------------------ */

	function admin_csvdownlad_page() {
		$add_param = 'aaa';
		$this_post = get_queried_object();
		$tag = '';
		$tb = "\t\t\t\t";
		// sample01
		$tag .= $tb . "" . '<div class="wrap">' . "\n";
		$tag .= $tb . "\t" . '<h1>CSVダウンロード</h1>' . "\n";
		$tag .= $tb . "\t" . '<p>下記に期間を入力した上でCSVをダウンロードしてください。</p>' . "\n";
		$tag .= $tb . "\t" . '<hr>' . "\n";
		$tag .= $tb . "\t" . '<form method="post" action="' . esc_url( home_url( '/xxx/yyy_csvdownload/' ) ) . '">' . "\n";
		$tag .= $tb . "\t\t" . '<table class="form-table tools" role="presentation">' . "\n";
		$tag .= $tb . "\t\t\t" . '<tbody>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '<tr>' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t\t\t\t" . '<input type="date"" name="date_start"> - <input type="date"" name="date_end">' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '</tr>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '<tr>' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t\t\t\t" . '<input type="submit" name="submit" class="button button-primary" value="CSVダウンロード">' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '</tr>' . "\n";
		$tag .= $tb . "\t\t\t" . '</tbody>' . "\n";
		$tag .= $tb . "\t\t" . '</table>' . "\n";
		$tag .= $tb . "\t" . '</form>' . "\n";
		$tag .= $tb . "" . '</div>' . "\n";
		// sample02
		$tag .= $tb . "" . '<div class="wrap">' . "\n";
		$tag .= $tb . "\t" . '<h1>CSVダウンロード</h1>' . "\n";
		$tag .= $tb . "\t" . '<a href="/xxx/yyy_csvdownload/?postid=' . $this_post->ID . '&param=' . $add_param . '">CSVダウンロード</a>' . "\n";
		$tag .= $tb . "" . '</div>' . "\n";
		echo $tag;
	}
	function wpdocs_register_admin_csvdownlad_page(){
		add_menu_page( 'CSVダウンロード', 'CSVダウンロード', 'edit_posts', 'xxx_yyy_csvdownload', 'admin_csvdownlad_page', 'dashicons-admin-post', 40 );
	}
	add_action( 'admin_menu', 'wpdocs_register_admin_csvdownlad_page' );