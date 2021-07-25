<?php

## setting * 必記述

	// db
	define( 'DB_HOST',              'mysql589.phy.lolipop.jp' );
	define( 'DB_USER',              'LAA0255312' );
	define( 'DB_PASSWORD',          '3CmKub72' );
	define( 'DB_NAME',              'LAA0255312-cmfc7r' );

## debug_mode

	// 公開後falseに切り替え
	if( isset( $_GET[ 'debug' ] ) && $_GET[ 'debug' ] === 'on' ) {
		define( 'WP_DEBUG', true ); // 強制デバッグモード
	} else {
		define( 'WP_DEBUG', false ); // 通常（公開時 false）
	}

## mmory

	// メモリー割り当て
	define('WP_MEMORY_LIMIT',     '256M'); // user
	define('WP_MAX_MEMORY_LIMIT', '512M'); // administrator

## key * 必記述

	/*
		認証用ユニークキー ※ 下記アドレスで生成してコピペ
		@since 2.6.0
		https://api.wordpress.org/secret-key/1.1/salt/
	*/
	define('AUTH_KEY',         '?c{H4,1$zi36$As}6e+(yg++<LuB2TjQ0|[yeWD:?1r5D*[WE,WfkJ/V 95zyao?');
	define('SECURE_AUTH_KEY',  'Nz]y_}L-oO]@i1I$XXtg-L+w_.?AHKZ-?(sC{EV++MN~0|egj]q$*9bfJBKrH5ox');
	define('LOGGED_IN_KEY',    'oR Qh4cBj0Cdkw/:A)h^+w.Y]uA-L|-x$)XSs|~:I.:-;.@Kz+BI07r0;j_dd+`,');
	define('NONCE_KEY',        'H*n=h:?5rBEAW!-#V-H6(Ph*X`PW-v(T4s1nK0*HsNwH$5FwnOOt_]K T Z+on+{');
	define('AUTH_SALT',        'lzoB+{5[LTJ(:ToXXt%3,{5D[RB)jZ-y9I*, Wx1yuDfoM1aks&:E<:))||)12bw');
	define('SECURE_AUTH_SALT', '0A:i;!rqn7dLqln+|fa:3T<$Ux%f`CUkN2Vi:@BMmN3:~A?o#A&Dh~4zlDON)l])');
	define('LOGGED_IN_SALT',   'BzW;RVn6|b7% TMv+cf__1?=kAv{4189y&Xt3Z~%YpgaQoO6.Sz/a+&Q7wWR`)]a');
	define('NONCE_SALT',       'H{kxNDOp9PYH=@ ZD1sg5CS .R|MdeIe:o,n-H{$e0]++x9Uhn_8P`_RO$M+0Pos');
## option

	// multisite
	/*
	define( 'WP_ALLOW_MULTISITE',   true );
	// after multisite run
	define( 'DOMAIN_CURRENT_SITE',  'www.domain.com' );
	define( 'PATH_CURRENT_SITE',    '/' );
	define( 'MULTISITE',            true );
	define( 'SUBDOMAIN_INSTALL',    false );
	define( 'SITE_ID_CURRENT_SITE', 1 );
	define( 'BLOG_ID_CURRENT_SITE', 1 );
	*/

## default * 編集不可

	// db
	define( 'DB_CHARSET',           'utf8' );
	define( 'DB_COLLATE',           '' );
	// prefix
	$table_prefix =                 'wp_';
	// lang
	define( 'WPLANG',               'ja' );

## run wordpress * 編集不可

	// run wordpress
	if( ! defined( 'ABSPATH' ) ) define( 'ABSPATH', DIRNAME(__FILE__) . '/' );
	include_once ABSPATH . 'wp-settings.php';