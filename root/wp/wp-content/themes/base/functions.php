<?php
/**--------------------------------------------------------------
 *
 * functions
 *
 * @version
 * 		18.1.2
 *
 * @history
 * 		2016-07-08	再構築 N
 * 		2018-01-02	ct10に合わせて再記述
 * 		2018-6-27	ct12に合わせて再記述
 * 		2018-7-25	editor設定機能を追加
 * 		 			css.jsの管理者分岐修正
 * 					管理画面-投稿一覧にカスタムタクソノミー表示追加
 * 					管理画面-投稿一覧に投稿と固定Pを分割表示[ 12.2.1 ]
 * 		2019-02-14	fanction_setting.phpに設定項目を移動[ 12.3.1 ]
 * 		2019-03-01	定数をシンプル化[ 13.1.1 ]
 * 		2019-03-01	定数をシンプル化[ 13.2.1 ]
 * 		2019-04-24	カスタム投稿タイプ内に固定P生成システム実装[ 13.3.1 ]
 * 		2019-05-24	WordPress5.2.1に対応[ 14.1.1 ]
 * 		2019-10-02	カスタム投稿タイプの設定項目を追加[ 14.2.1 ]
 * 					gutenberg, slug->rewrite
 * 					auto_slug の場合のslugを post1234 に変更 * 1234 = 投稿ID
 * 		2020-03-26	functions.php 設定値のみに変更 [ 16.1.1 ]
 * 					マルチサイトへの対応[ 16.1.1 ]
 * 		2020-12-25	管理画面ダッシュボード・サイドメニューのマルチサイトへの対応[ 17.1.1 ]
 * 		2021-05-08	注釈表記を変更 [ 18.1.1 ]
 * 		2021-06-30  post_type newsのカスタムフィールド値を変更 [ 18.1.2 ]
 *
 --------------------------------------------------------------*/

	/**------------------------------------------------------
	 *
	 * ダッシュボード, 管理画面サイドメニュー
	 *
	 * @reference
	 * 		1：admin
	 * 		2：client
	 *
	 * @memo
	 * 		サンプル
	 * 			wp_functions_setup - l.249付近
	 *
	------------------------------------------------------ */

	const ADMIN_MENU_EDITOR_PRO = false;

	const WPADMIN_NAV = [
		// 'お知らせ' => [
		// 	'type'         => 'posttype',
		// 	'path'         => 'edit.php?post_type=news',
		// 	'user'         => [ 1, 2 ],
		// 	'add_submenu'  => [
		// 		/*
		// 			「一覧」と「新規追加」はposttypeの場合自動
		// 		*/
		// 		'トップページ表示設定' => [
		// 			'path'     => 'post.php?post=24&action=edit',
		// 			'user'     => [ 1, 2 ]
		// 		]
		// 	]
		// ],
		'日常更新' => array(
			'type'        => 'heading_dashboard' // ダッシュボード用区切り見出し
		),

		'結水荘日記' => [
			'type'        => 'posttype',
			'path'        => 'edit.php?post_type=weblog',
			'user'        => [ 1, 2 ]
		],
		'ページコンテンツ設定' => array(
			'type'        => 'heading_dashboard' // ダッシュボード用区切り見出し
		),
		'Top設定' => [
			'type'        => 'page',
			'path'        => 'post.php?post=77&action=edit',
			'user'        => [ 1, 2 ]
		],
		'プラン設定' => [
			'type'        => 'page',
			'path'        => 'post.php?post=68&action=edit',
			'user'        => [ 1, 2 ]
		],
		'メンバー設定' => [
			'type'        => 'page',
			'path'        => 'post.php?post=70&action=edit',
			'user'        => [ 1, 2 ]
		],
		/*
		'サンプル投稿タイプ名' => [
			'type'        => 'posttype',
			'path'        => 'edit.php?post_type=xxx',
			'user'        => [ 1, 2 ]
		],
		'サンプル固定ページ名' => [
			'type'        => 'page',
			'path'        => 'post.php?post=999&action=edit',
			'user'        => [ 1, 2 ]
		],
		*/
		'メディア' => [
			'type'         => 'media',
			'user'         => [ 1 ]
		],
		'ユーザー' => [
			'type'         => 'user',
			'user'         => [ 1 ]
		]
	];

	/**------------------------------------------------------
	 *
	 * カスタム投稿タイプ
	 *
	 * @memo
	 * 		サンプル詳細
	 * 			CUSTOM_POSTTYPE
	 * 				wp_functions_setup - 704付近
	 * 			管理画面の投稿一覧 posts_archive_columns
	 * 				wp_functions_setup - 776付近
	 * 			独自関数 posts_archive_columns
	 * 				wp_functions_setup - 856付近
	 * 		重要
	 * 			変更時 WP管理画面 設定 >パーマリンク 更新必須
	 *
	------------------------------------------------------ */

	const CUSTOM_POSTTYPE = [

		// 'news' => [
		// 	'name'           => 'お知らせ',
		// 	'posts_per_page' => 20,
		// 	// editor
		// 	'editor'         => [ 'link', 'unlink' ],
		// 	'gutenberg'      => false,
		// 	'eyecatch'       => false,
		// 	// routing
		// 	'slug'           => [
		// 		'auto_slug'  => true,
		// 		'rewrite'    => true
		// 	],
		// 	'add_page'       => [],
		// 	// sitemap_xml
		// 	'sitemap'        => [
		// 		'archive'    => '0.1',
		// 		'single'     => '0.1',
		// 		'add_arg'    => [
		// 			'meta_key'       => 'link_type',
		// 			'meta_value'     => 'type_detail'
		// 		]
		// 	],
		// 	// posts_archive_columns
		// 	'columns'        => [
		// 		'author'     => false,
		// 		'column'     => [
		// 			[
		// 				'name'       => 'リンクタイプ',
		// 				'type'       => 'linktype',
		// 				'arg'        => 'news_link'
		// 			]
		// 		]
		// 	]
		// ],
		'weblog' => [
			'name'           => '結水荘日記',
			'posts_per_page' => 10,
			// editor
			'editor'         => [],
			'gutenberg'      => false,
			// routing
			'slug'           => [
				'auto_slug'  => true,
				'rewrite'    => true
			],
			'add_page'       => [
				[]
			],
			// sitemap_xml
			'sitemap'        => [
				'archive'    => '0.5', // アーカイブがない場合は「false」
				'single'     => '0.6', // シングルがない場合は「false」
				'add_arg'    => []
			],
			// posts_archive_columns
			'columns'        => [
				'author'     => false,
				'column'     => [
				]
			]
		]
		/*
		'sampleosttype' => [
			'name'           => 'サンプルカスタム投稿タイプ名称',
			'posts_per_page' => 10,
			// editor
			'editor'         => [],
			'gutenberg'      => false,
			// routing
			'slug'           => [
				'auto_slug'  => true,
				'rewrite'    => true
			],
			'add_page'       => [
				[]
			],
			// sitemap_xml
			'sitemap'        => [
				'archive'    => '0.5', // アーカイブがない場合は「false」
				'single'     => '0.6', // シングルがない場合は「false」
				'add_arg'    => []
			],
			// posts_archive_columns
			'columns'        => [
				'author'     => false,
				'column'     => [
				]
			]
		]
		*/
	];

	const EDITOR_BLOCK_FORMAT = '段落=p;大見出し=h4;小見出し=h5;';

	/**------------------------------------------------------
	 *
	 * カスタムタクソノミー
	 *
	 * @reference
	 * 		style
	 * 			checkbox || radio || parent_no_child_checkbox || parent_no_child_radio
	 * 		tax_type
	 * 			taxonomy || tag
	 *
	 * @memo
	 * 		変更時 WP管理画面 設定 >パーマリンク 更新必須
	 *
	------------------------------------------------------ */

	const CUSTOM_TAXONOMY = [

		/*
		'cat_xxx' => [
			'name'           => 'サンプルタクソノミー名',
			'post_type'      => 'xxx',
			'style'          => 'radio',
			'tax_type'       => 'taxonomy',
			'posts_per_page' => 10
		]
		*/
	];

	/**------------------------------------------------------
	 *
	 * 固定ページ
	 * 		Gutenberg 無効化, editor アイコン
	 *
	 * @reference
	 * 		gutenberg
	 * 			デフォルト false
	 * 		editor
	 * 		エディタアイコンの設定
	 * 		link,          リンク
	 * 		unlink,        リンク解除
	 * 		|,             区切り線
	 * 		formatselect,  見出しやpなどブロック要素の設定
	 * 		bullist,       ul li
	 * 		numlist,       ol li
	 * 		forecolor,     テキストカラー
	 * 		table          表
	 *
	------------------------------------------------------ */

	const PAGES_SETTING = [
		/*
		page_id => [
			'gutenberg'      => true
			'editor'    => [
				'link',
				'unlink',
				'|',
				'formatselect',
				'bullist',
				'numlist',
				'forecolor',
				'table'
			]
		]
		*/
	];

	/**------------------------------------------------------
	 *
	 * 管理画面 各種自動更新
	 *
	 * @memo
	 * 		自動更新停止 = false
	 *
	------------------------------------------------------ */

	const WPADMIN_UPDATE = true;

	/**------------------------------------------------------
	 *
	 * 管理画面 js,css
	 *
	 * @reference
	 * 		user       all || user || *(int)userid,
	 * 		post_type  all || post || page || *custom_posttype_name
	 * 		fname      admin_***_****.js
	 *
	------------------------------------------------------ */

	const WPADMIN_JSCSS = [
		'css'  => [
			[
				'user'       => 'all',
				'post_type'  => 'all',
				'fname'      => 'admin_all.css'
			],
			[
				'user'       => 'all',
				'post_type'  => 'all',
				'fname'      => 'admin_wp55_adjust.css'
			],
			[
				'user'       => 'user',
				'post_type'  => 'all',
				'fname'      => 'admin_user_common.css'
			],
			[
				'user'       => 'user',
				'post_type'  => 'page',
				'fname'      => 'admin_user_page.css'
			]
		],
		'js'  => [
			[
				'user'       => 'user',
				'post_type'  => 'all',
				'fname'      => 'admin_user_common.js'
			],
			[
				'user'       => 'user',
				'post_type'  => 'page',
				'fname'      => 'admin_user_page.js'
			],
			[
				'user'       => 'all',
				'post_type'  => 'news',
				'fname'      => 'admin_user_news.js'
			],
			[
				'user'       => 'all',
				'post_type'  => 'all',
				'fname'      => 'admin_menu_current.js'
			]
		]
	];

	/**------------------------------------------------------
	 *
	 * マルチサイト
	 * 		各種自動更新
	 *
	 * @reference
	 * 		MULTISITE_BLOG
	 * 			(int)blog_id => 'blog_name'
	 * 			※ c_は記入不要
	 * 		MULTISITE_BLOG_TYPE
	 * 			same : 子テーマもcssは同じ
	 * 			each : 子テーマごとにcss分離
	 *
	 * @memo
	 * 		baseは省略
	 * 		設定後 子ブログで下記の定数使用可能
	 * 			MULTISITEBLOGNAME : 'mmm'    (def : 'base')
	 * 			MULTISITETHEMEDIR : '/c_mmm' (def : 'base')
	 * 			MULTISITEBLOGDIR  : '/mmm''  (def : '')
	 *
	------------------------------------------------------ */

	const MULTISITE_BLOG = [
		// 2 => 'mmm',
		// 3 => 'nnn'
	];

	const MULTISITE_BLOG_TYPE = 'same';

	/**------------------------------------------------------
	 * RUN
	------------------------------------------------------ */

	if( !defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', substr( ABSPATH, 0, -4 ) );
	include_once ROOTREALPATH . '/mod/setup/setting.php';
	include_once 'wpoo/wp_functions_init.php';
	include_once 'wpoo/wp_functions_oofunc.php';
	include_once 'wpoo/wp_functions_setup.php';

	/**------------------------------------------------------
	 *
	 * EC
	 * 		eccube4
	 *
	 * @memo
	 * 		稼働時
	 * 			ECCUBE_INSTALLED を「true」
	 * 			WPEC_ACF_KEY_PIC, WPEC_ACF_KEY_CODE ECCUBE側で反映
	 * 		重要
	 * 			使用しない場合は ECCUBE_INSTALLED を「false」
	 * 			wp_functions_ec.php は他のwpooファイル読み込み後
	 *
	------------------------------------------------------ */

	const ECCUBE_INSTALLED = false;

	const WPEC_POST_TYPE     = 'productsec';
	const WPEC_ACF_KEY_PIC   = WPEC_POST_TYPE . '_pic_main';
	const WPEC_ACF_KEY_CODE  = WPEC_POST_TYPE . '_code';
	const WPEC_USER_IDS      = [ 1, 2 ];
	if( ECCUBE_INSTALLED ) include_once 'wpoo/wp_functions_ec.php';

/*== options ===========================================================================*/