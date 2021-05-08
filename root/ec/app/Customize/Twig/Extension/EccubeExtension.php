<?php
/*--------------------------------------------------------------

	EccubeExtension

	@version
		18.1.1

	@memo

---------------------------------------------------------------*/

namespace Customize\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Customize\Util\GetWpdb;
class EccubeExtension extends AbstractExtension
{
	public function getFunctions() {
		return [
			new TwigFunction( 'oo_get_wp_pic_main_path', [ $this, 'ooGetWpPicMainPath' ] ),
			new TwigFunction( 'oo_get_wp_permalink',     [ $this, 'ooGetWpPermalink' ] ),
			new TwigFunction( 'oo_fpath_add_date_query', [ $this, 'ooFpathAddDateQuery' ] ),
			new TwigFunction( 'oo_google_fonts_preload', [ $this, 'ooGoogleFontsPreload' ] ),
			new TwigFunction( 'oo_get_wp_parts_header',  [ $this, 'ooGetWpPartsHeader' ] ),
			new TwigFunction( 'oo_get_wp_parts_footer',  [ $this, 'ooGetWpPartsFooter' ] ),
			new TwigFunction( 'oo_get_wp_parts_footer',  [ $this, 'ooGetWpPartsFooter' ] ),
			new TwigFunction( 'wp_site_url', 'site_url' ),
			new TwigFunction( 'wp_home_url', 'home_url' )
		];
	}

	/**
	 * Wpから画像パスを取得
	 *
	 * @return string
	 */
	public function ooGetWpPicMainPath( $wpProductCode, $type = 'medium' ) {

		return GetWpdb::productsPicMain( $wpProductCode, $type );
	}

	/**
	 * Wpからpermalinkを取得
	 *
	 * @return string
	 */
	public function ooGetWpPermalink( $wpProductCode ) {

		return GetWpdb::productsPermalink( $wpProductCode );
	}

	/**
	 * head.class fpath_add_date_query( ファイル更新日パラメータ付与 )
	 *
	 * @return string
	 */
	public static function ooFpathAddDateQuery( $fpath_no_prefix ) {
		$output = '';
		if( defined( 'ROOTREALPATH' ) && file_exists( ROOTREALPATH . $fpath_no_prefix ) ) {
			$temp_prefix = '';
			if( defined( 'PUBLICDIR' ) ) {
				$temp_prefix = PUBLICDIR;
			} elseif( function_exists( 'home_url' ) ) {
				$temp_prefix = home_url();
			}
			$output = $temp_prefix . $fpath_no_prefix;
			$date_query = date( 'ymds', filemtime( ROOTREALPATH . $fpath_no_prefix ) );
			$output .= '?' . $date_query;
		}
		return $output;
	}

	/**
	 * Google Fonts Preload
	 *
	 * @return string
	 */
	public static function ooGoogleFontsPreload() {
		$tag = '';
		if( defined( 'FONTS_PRELOAD' ) ) {
			if( isset( FONTS_PRELOAD[ 'googlefonts_pc' ] ) ) {
				$tag .= "\t" . '<link rel="preconnect" href="https://fonts.gstatic.com"> ' . "\n";
				foreach( FONTS_PRELOAD[ 'googlefonts_pc' ] as  $v ) {
					$tag .= "\t" . '<link rel="stylesheet" href="' . $v . '"> ' . "\n";
				}
				if( isset( FONTS_PRELOAD[ 'otherfonts' ] ) ) {
					foreach( FONTS_PRELOAD[ 'otherfonts' ] as  $v ) {
						$tag .= "\t" . '<link rel="preload" as="style" href="' . $v . '" onload="this.rel=' . "'" . 'stylesheet' . "'" . '">' . "\n";
					}
				}
			}
		}
		return $tag;
	}

	/**
	 * wp parts_header
	 *
	 * @return string
	 */
	public static function ooGetWpPartsHeader() {
		$tag = '';
		if( defined( 'TEMPLATEPATH' ) && file_exists( TEMPLATEPATH . '/parts_header.php' ) ) {
			ob_start();
			include_once( TEMPLATEPATH . '/parts_header.php' );
			$tag = ob_get_clean();
		}
		$tag = str_replace( "\t\t<header class=\"header_wrap\">\r\n", '', $tag );
		$tag = str_replace( "\r\n\t\t</header>", '', $tag );
		return $tag;
	}

	/**
	 * wp parts_footer
	 *
	 * @return string
	 */
	public static function ooGetWpPartsFooter() {
		$tag = '';
		if( defined( 'ROOTREALPATH' ) && file_exists( TEMPLATEPATH . '/parts_footer.php' ) ) {
			ob_start();
			include_once( TEMPLATEPATH . '/parts_footer.php' );
			$tag = ob_get_clean();
		}
		$tag = str_replace( "\r\n</body>\r\n</html>", '', $tag );
		return $tag;
	}

	/**
	 * head.class modal
	 *
	 * @return string
	 */
	public static function resTagModal() {
		$tag = '';
		$tag .= "\t" . '<div id="modal_overlay" class="modal_overlay">' . "\n";
		$tag .= "\t\t" . '<div class="modal_bg"></div>' . "\n";
		$tag .= "\t\t" . '<div class="modal_wrap">' . "\n";
		$tag .= "\t\t\t" . '<div class="modal">' . "\n";
		$tag .= "\t\t\t" . '</div>' . "\n";
		$tag .= "\t\t\t" . '<p class="modal_close"></p>' . "\n";
		$tag .= "\t\t" . '</div>' . "\n";
		$tag .= "\t" . '</div>' . "\n";
		return $tag;
	}
}