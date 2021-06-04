<?php
/**************************************************************************
 *
 * wp_sitemaps_auto_create_cron
 * 		サイトマップXML 自動生成 CRON
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.1
 *
 * @history
 * 		2021-06-03	新規制作N[ 18.1.1 ]
 *
 * @memo
 * 		さくらの場合：cronコマンド
 * 			cd /home/c9220330/public_html/oldoffice-dev.com/ct18/contents; /usr/local/bin/php wp_sitemaps_auto_create_cron.php
 * 		Conohaの場合：cronコマンド
 * 			cd /home/c9220330/public_html/oldoffice-dev.com/ct18/contents; /usr/local/bin/php wp_sitemaps_auto_create_cron.php
 *
 * *************************************************************************/

##	setting

	// if( ! is_null( $_SERVER[ 'REMOTE_ADDR' ] ) ) {
	// 	echo 'access error!';
	// 	return;
	// }

##	setting

	/* wp_blog */
	// マルチサイトの場合は、「c_theme」を追記
	$wp_blogs = [
		'base'
	];
	$the_posts_per_page = 1000; // server_memoryにあわせて調整

##	base

	/* includes */
	define( 'ROOTREALPATH', '/home/c9220330/public_html/oldoffice-dev.com/ct18' );
	include_once ROOTREALPATH . '/wp/wp-load.php';
	include_once ROOTREALPATH . '/mod/setup/setup.php';
	include_once ROOTREALPATH . '/mod/lib/xml_sitemap.class.php';
	$XS = new xml_sitemap();

##	data

	$arr = CUSTOM_POSTTYPE ?? [];
	foreach( $arr as $k => $v ) {
		$xml_arr          = [];
		$blog_url         = get_bloginfo( 'url' ) . '/' . $k . '/';
		$today            = date_i18n( 'Y-m-d\TH:i:s+09:00' );
		$this_found_posts = wp_count_posts( $k )->publish;
		// archive
		if( isset( $v[ 'sitemap' ][ 'archive' ] ) && $v[ 'sitemap' ][ 'archive' ] ) {
			// 一つ目の配列にarchiveを含める
			$xml_arr[ 0 ][] = array(
				'url'              => $blog_url,
				'date'             => $today,
				'priority'         => $v[ 'sitemap' ][ 'archive' ]
			);
		}
		// single
		if( isset( $v[ 'sitemap' ][ 'single' ] ) && $v[ 'sitemap' ][ 'single' ] ) {
			$create_file_num = intval( ceil( $this_found_posts / $the_posts_per_page ) );
			for( $i = 0; $i < $create_file_num; $i++ ) {
				$fpath_sitemaps = ROOTREALPATH . '/sitemaps/' . $k . ( $i === 0 ? '' : '_' . ( $i + 1 )  ) . '.xml';
				// 最後のファイルか、ファイルが存在していない場合のみ
				if(
					( $i === $create_file_num - 1 )
					||
					! file_exists( $fpath_sitemaps )
				) {
					$args = [
						'posts_per_page' => $the_posts_per_page,
						'offset'         => $i * $the_posts_per_page + 1,
						'post_type'      => $k
					];
					$args = array_merge( $args, $v[ 'sitemap' ][ 'add_arg' ] );
					$the_query = new WP_Query( $args );
					if( $the_query->have_posts() ) {
						while( $the_query->have_posts() ) {
							$the_query->the_post();
							$arr = [];
							// id
							$this_post_id        = $the_query->post->ID;
							$arr[ 'url' ]        = get_permalink( $this_post_id );
							$arr[ 'date' ]       = get_the_modified_date( 'Y-m-d\TH:i:s+09:00', $this_post_id );
							$arr[ 'priority' ]   = $v[ 'sitemap' ][ 'single' ];
							// add_res
							$xml_arr[ $i ][] = $arr;
						}
					}
					// sitemap_code
					$code = '';
					$code .= $XS->res_sitemaps_code( $xml_arr[ $i ] );
					// create_xml_file
					file_put_contents( $fpath_sitemaps, $code );
				}
			}
		}
	}