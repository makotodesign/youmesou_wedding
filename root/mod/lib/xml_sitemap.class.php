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
 * 		18.1.1
 *
 * @history
 * 		2018-01-30	新規作成 N [1.1.1]
 * 		2021-05-08	調整 [18.1.1]
 *
 * *************************************************************************/

class xml_sitemap {

	### constructor

	function __construct() {
	}

	### func : public

	/* 全体サイトマップ */
	public function res_sitemaps_code( $arr, $images_in_page = false ) {
		$code = '';
		$tb  = "";

		$code .= $tb . "" . '<?xml version="1.0" encoding="utf-8"?>' . "\n";
		$add_param = ( $images_in_page ) ? ' xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"' : '';
		$code .= $tb . "" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
		$code .= $add_param;
		$code .= '>' . "\n";
		$code .= self::res_sitemaps_parts( $arr, $images_in_page );
		$code .= $tb . "" . '</urlset>' . "\n";
	}

	### private

	/* 各ページ */
	private static function res_sitemaps_parts( $arr, $images_in_page ) {
		$temp_code = '';
		$tb  = "";
		for( $i = 0; $i < count( $arr ); $i++ ) {
//			$temp_code .= var_export($arr[ $i ],true)."\n";
			$temp_code .= $tb . "\t" . '<url>' . "\n";
			$temp_code .= $tb . "\t\t" . '<loc>' . self::escape_xml( $arr[ $i ][ 'url' ] ) . '</loc>' . "\n";
			if( isset( $arr[ $i ][ 'date' ] ) && $arr[ $i ][ 'date' ] ) {
				$temp_code .= $tb . "\t\t" . '<lastmod>' . $arr[ $i ][ 'date' ] . '</lastmod>' . "\n";
			}
			if( isset( $arr[ $i ][ 'changefreq' ] ) && $arr[ $i ][ 'changefreq' ] ) {
				$temp_code .= $tb . "\t\t" . '<changefreq>' . $arr[ $i ][ 'changefreq' ] . '</changefreq>' . "\n";
			}
			if( isset( $arr[ $i ][ 'priority' ] ) && $arr[ $i ][ 'priority' ] ) {
				$temp_code .= $tb . "\t\t" . '<priority>' . $arr[ $i ][ 'priority' ] . '</priority>' . "\n";
			}
			if( $images_in_page && isset( $arr[ $i ][ 'images' ] ) && is_array( $arr[ $i ][ 'images' ] ) ) {
				$temp_arr = $arr[ $i ][ 'images' ];
				$temp_code .= self::res_sitemaps_images( $temp_arr );
			}
		$temp_code .= $tb . "\t" . '</url>' . "\n";
		}
		return $temp_code;
	}

	/* ページ内画像 */
	private static function res_sitemaps_images( $arr ) {
		$temp_code = '';
		$tb  = "";
		for( $i = 0; $i < count( $arr ); $i++ ) {
			if( isset( $arr[ $i ][ 'url' ] ) && isset( $arr[ $i ][ 'alt' ] ) && $arr[ $i ][ 'url' ] && $arr[ $i ][ 'alt' ] ) {
				$temp_code .= $tb . "\t\t" . '<image:image>' . "\n";
				$temp_code .= $tb . "\t\t\t" . '<image:loc>' . self::escape_xml( $arr[ $i ][ 'url' ] ) . '</image:loc>' . "\n";
				$temp_code .= $tb . "\t\t\t" . '<image:caption>' . $arr[ $i ][ 'alt' ] . '</image:caption>' . "\n";
				$temp_code .= $tb . "\t\t" . '</image:image>' . "\n";
			}
		}
		return $temp_code;
	}

	/* func : escape */
	private static function escape_xml( $str ) {
		return str_replace ( array ( '&', '"', "'", '<', '>' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), $str );
	}
}

