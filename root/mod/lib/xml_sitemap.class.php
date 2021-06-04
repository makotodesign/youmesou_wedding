<?php
/**************************************************************************
 *
 * xml_sitemap.class
 * 		XMLサイトマップ生成クラス
 *
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.2
 *
 * @history
 * 		2018-01-30	新規作成 N [1.1.1]
 * 		2021-05-08	調整 [18.1.1]
 * 		2021-06-03	priority,changefreq を除去 [18.1.2]
 *
 * *************************************************************************/

class xml_sitemap {

	const tb = "";

	/* 全体サイトマップ */
	public function res_sitemaps_code( $arr, $images_in_page = false ) {
		$code = '';
		$code .= self::tb . "" . '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$add_param = ( $images_in_page ) ? ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"' : '';
		$code .= self::tb . "" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' . $add_param . '>' . "\n";
		$code .= self::res_sitemaps_parts( $arr, $images_in_page );
		$code .= self::tb . "" . '</urlset>' . "\n";
		return $code;
	}

	/* 各ページ */
	private static function res_sitemaps_parts( $arr, $images_in_page ) {
		$code = '';
		foreach( $arr as  $v ) {
			if( isset( $v[ 'url' ] ) && $v[ 'url' ] ) {
				$code .= self::tb . "\t" . '<url>' . "\n";
				$code .= self::tb . "\t\t" . '<loc>' . self::escape_xml( $v[ 'url' ] ) . '</loc>' . "\n";
				if( isset( $v[ 'date' ] ) && $v[ 'date' ] ) {
					$code .= self::tb . "\t\t" . '<lastmod>' . $v[ 'date' ] . '</lastmod>' . "\n";
				}
				if( isset( $v[ 'priority' ] ) && $v[ 'priority' ] ) {
					$code .= self::tb . "\t\t" . '<priority>' . $v[ 'priority' ] . '</priority>' . "\n";
				}
				if( $images_in_page && isset( $v[ 'images' ] ) && is_array( $v[ 'images' ] ) ) {
					$code .= self::res_sitemaps_images( $v[ 'images' ] );
				}
				$code .= self::tb . "\t" . '</url>' . "\n";
			}
		}
		return $code;
	}

	/* ページ内画像 */
	private static function res_sitemaps_images( $arr ) {
		$code = '';
		foreach( $arr as  $v ) {
			if( isset( $v[ 'url' ] ) && isset( $v[ 'alt' ] ) && $v[ 'url' ] && $v[ 'alt' ] ) {
				$code .= self::tb . "\t\t" . '<image:image>' . "\n";
				$code .= self::tb . "\t\t\t" . '<image:loc>' . self::escape_xml( $v[ 'url' ] ) . '</image:loc>' . "\n";
				$code .= self::tb . "\t\t\t" . '<image:caption>' . $v[ 'alt' ] . '</image:caption>' . "\n";
				$code .= self::tb . "\t\t" . '</image:image>' . "\n";
			}
		}
		return $code;
	}

	/* func : escape */
	private static function escape_xml( $str ) {
		return str_replace ( array ( '&', '"', "'", '<', '>' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), $str );
	}
}

