<?php
/*--------------------------------------------------------------

	functions

	@version
		17.1.1 multisite_child

	@memo
		2021-01-04	マルチサイト用に修正
		2020-03-18	マルチサイト用に構築

---------------------------------------------------------------*/

/* -------------------------------------------------------------

	setting

---------------------------------------------------------------*/

##	language

	//const ICL_LANGUAGE_CODE = 'en';

/* ----------------------------------
	ダッシュボード, サイドメニュー
	*	reference : wp_functions_setting - l.70付近
---------------------------------- */

##	menu（管理画面 : メニュー）

	const WPADMIN_NAV_CHILD = array(

		/* sample */
		/*
		'追加投稿タイプ名' => array(
			'type'        => 'posttype',
			'path'        => 'edit.php?post_type=xxx',
			'user'        => array( 1, 2 )
		),
		'追加固定ページ名' => array(
			'type'        => 'page',
			'path'        => 'post.php?post=999&action=edit',
			'user'        => array( 1, 2 )
		),
		*/

		// サイドメニュー メディア・ユーザーの設定
		'メディア' => array(
			'type'         => 'media',
			'user'         => array( 1 )
		),
		'ユーザー' => array(
			'type'         => 'user',
			'user'         => array( 1 )
		)
	);

/* ----------------------------------
	カスタム投稿タイプの追加
	カスタムタクソノミーの追加
	*	reference : wp_functions_setting - 380付近
	*	WP管理画面 設定 >パーマリンク 更新
---------------------------------- */

##	custom_post_type

	const CUSTOM_POSTTYPE_CHILD = array(

		/*
		'addposttypename' => array(
			'name'           => 'カスタム投稿タイプ名称',
			'posts_per_page' => 10,
			// エディタ
			'editor'         => array(),
			'gutenberg'      => false,
			'eyecatch'       => false,
			// slug
			'slug'           => array(
				'auto_slug'  => true,
				'rewrite'    => true
			),
			// add_page
			'add_page'       => array(
				array()
			),
			// sitemap_xml
			'sitemap'        => array(
				'archive'    => '0.5',
				'single'     => '0.6',
				'add_arg'    => array()
			),
			// 一覧での表示項目
			'columns'        => array(
				'author'     => false,
				'column'     => array(
				)
			)
		)
		*/
	);

##	custom_taxonomy

	const CUSTOM_TAXONOMY_CHILD = array(
	);

##	pages_setting

	const PAGES_SETTING_CHILD = array(
	);

/*--------  options ---------------------------------------------------------------*/
