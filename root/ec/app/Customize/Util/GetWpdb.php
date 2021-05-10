<?php
/*--------------------------------------------------------------

	GetWpdb

	@history
	eccubeからwpの$wpdbを使用
---------------------------------------------------------------*/

namespace Customize\Util;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GetWpdb{

	/**
	 * oldoffice
	 *
	 * product_code から wordpress products > pic_main を取得
	 * mypage > favorite の場合は商品クラスが取得されていないため
	 * eccube に登録された wp_product_code から  を取得
	 * このために両方のフィールドに登録する
	 *
	 * 定数（ WordPress functions.php ）
	 * 	WPEC_POST_TYPE
	 * 	WPEC_ACF_KEY_PIC
	 * 	WPEC_ACF_KEY_CODE
	 */
	public static function productsPicMain( $wpProductCode, $type = 'medium' ){

		global $wpdb;

		$res = false;
		$sql = "SELECT
				posts1.ID
			FROM
				{$wpdb->posts} AS posts1
				LEFT JOIN {$wpdb->postmeta} AS postmeta1 ON ( posts1.ID = postmeta1.post_id AND postmeta1.meta_key = %s )
				LEFT JOIN {$wpdb->postmeta} AS postmeta2 ON ( posts1.ID = postmeta2.post_id AND postmeta2.meta_key = %s )
			WHERE
				postmeta1.meta_value = %s
		";
		$sqlVal = [
			WPEC_ACF_KEY_CODE,
			WPEC_ACF_KEY_PIC,
			$wpProductCode
		];
		$wpPostId = $wpdb->get_var( $wpdb->prepare( $sql, $sqlVal ) );

		if( $wpPostId ) {
			$res = wp_oo_acf_image( get_field( WPEC_ACF_KEY_PIC, $wpPostId ), $type );
		}
		return $res;
	}

	/**
	 * oldoffice
	 *
	 * product_code から wordpress products > permalink を取得
	 */
	public static function productsPermalink( $wpProductCode ){

		global $wpdb;

		$res = false;
		$sql = "SELECT
				posts1.ID
			FROM
				{$wpdb->posts} AS posts1
				LEFT JOIN {$wpdb->postmeta} AS postmeta1 ON ( posts1.ID = postmeta1.post_id AND postmeta1.meta_key = %s )
			WHERE
				postmeta1.meta_value = %s
		";
		$sqlVal = [
			WPEC_ACF_KEY_CODE,
			$wpProductCode
		];
		$wpPostId = $wpdb->get_var( $wpdb->prepare( $sql, $sqlVal ) );

		if( $wpPostId ) {
			$res = get_permalink( $wpPostId );
		}
		return $res;
	}

	/**
	 * oldoffice
	 *
	 * eccube product_id から wordpress products > pic_main を取得
	 *
	 */
	public static function productsPicMainByEccubeProductId( $eccubeProductId, $type = 'medium' ){

		global $wpdb;

		$res = false;
		$sql = "SELECT
				wp_products_code
			FROM
				dtb_product
			WHERE
				id = %s
		";
		$sqlVal = [
			$eccubeProductId
		];
		$wpProductCode = $wpdb->get_var( $wpdb->prepare( $sql, $sqlVal ) );

		if( $wpProductCode ) {
			$res = self::productsPicMain( $wpProductCode, $type );
		}
		return $res;
	}

	/**
	 * oldoffice
	 *
	 * product_code から wordpress products > permalink を取得
	 */
	public static function productsPermalinkByEccubeProductId( $eccubeProductId ){

		global $wpdb;

		$res = false;
		$sql = "SELECT
				wp_products_code
			FROM
				dtb_product
			WHERE
				id = %s
		";
		$sqlVal = [
			$eccubeProductId
		];
		$wpProductCode = $wpdb->get_var( $wpdb->prepare( $sql, $sqlVal ) );

		if( $wpProductCode ) {
			$res = self::productsPermalink( $wpProductCode );
		}
		return $res;
	}
}
