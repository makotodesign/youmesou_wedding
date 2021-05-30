<?php

## setting * 必記述

	// db
	define( 'DB_HOST',              'mysql2.conoha.ne.jp' );
	define( 'DB_USER',              '55iz8_ct' );
	define( 'DB_PASSWORD',          'Old2000_old' );
	define( 'DB_NAME',              '55iz8_ct18' );

## debug_mode

	// 公開後falseに切り替え
	if( isset( $_GET[ 'debug' ] ) && $_GET[ 'debug' ] === 'on' ) {
		define( 'WP_DEBUG', true ); // 強制デバッグモード
	} else {
		define( 'WP_DEBUG', true ); // 通常（公開時 false）
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
	define('AUTH_KEY',         'X!3|55-%V?.Z4 +`:-MD:evR;w4H{h(N:s9I5-}F D#+W|c{Th_d?+a{p_}Uno`|');
	define('SECURE_AUTH_KEY',  'xl~GJ+!)L%!8kSH8KqD+)u}:]*otS{f^i7:bXeo3/A:4XVg#L`T1U|;s523v_9nR');
	define('LOGGED_IN_KEY',    '6~5q7VF?gpVI0c{rt$^aMuY|73t0F|q0ns<:o)ax^ZA].H4{7g-qJ(KGkm{mx4Oj');
	define('NONCE_KEY',        '1P@%5NL7hZs?.+};X|WY0zMY0Dtv=?E5sFMYWv)^.(@oQ@XC^*to)=50|.;IzqZQ');
	define('AUTH_SALT',        '#61QWJ~+c5 bpT6W`^;t||.PmmY2c>|U0V6:AQyH6c(vT|FiS/aDqrdKSM5c5]J&');
	define('SECURE_AUTH_SALT', 'lIN7i~}W@OU_l-(?@+p;hNBsoth>Y:A;I3~23Sm;UXUgEd&4Vx_rnw+9]VIfdrrr');
	define('LOGGED_IN_SALT',   '#Gw8r8BNbfF}X]2n.Eph^CvK#@#wbsyxZNhPm<I4zUmhhTM2SkZ)e9[J_<aO&]|S');
	define('NONCE_SALT',       'ku8&f|P!_s4!:ON^> C0{bL,7su>8?gGC~P hNvKF`S&v+.JX(^&v;X+CSBWMTNV');

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