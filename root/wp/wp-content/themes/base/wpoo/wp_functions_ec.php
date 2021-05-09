<?php
/**--------------------------------------------------------------
 *
 * wp_functions_ec
 *
 * @version
 * 		18.1.1
 *
 * @history
 * 		2021-05-05	新規作成 [ 18.1.1 ]
 *
 --------------------------------------------------------------*/

##	管理画面にCSVダウンロードを反映

	function wp_oo_admin_page_csvdownload_to_ec() {
		if( defined( 'WPEC_POST_TYPE' ) ) {
			$add_param_to_ec = WPEC_POST_TYPE . '_to_ec';
		} else {
			$add_param_to_ec = 'products_to_ec';
		}
		$tag = '';
		$tb = "\t\t\t\t";
		$tag .= $tb . "" . '<div class="wrap">' . "\n";
		$tag .= $tb . "\t" . '<h1>ECCUBE登録用CSVダウンロード</h1>' . "\n";
		$tag .= $tb . "\t" . '<p>下記に期間を入力した上でCSVをダウンロードしてください。</p>' . "\n";
		$tag .= $tb . "\t" . '<hr>' . "\n";
		$tag .= $tb . "\t" . '<form method="post" action="' . esc_url( home_url( '/mod/wpec/wpadmin_csvdownload_wp_to_ec.php' ) ) . '">' . "\n";
		$tag .= $tb . "\t\t" . '<table class="form-table tools-privacy-policy-page" role="presentation">' . "\n";
		$tag .= $tb . "\t\t\t" . '<tbody>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '<tr>' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t\t\t\t" . '<input type="date" name="date_start" value="' . date_i18n( 'Y-m-d' ) . '" max="' . date_i18n( 'Y-m-d' ) . '"> - <input type="date" name="date_end" value="' . date_i18n( 'Y-m-d' ) . '" max="' . date_i18n( 'Y-m-d' ) . '">' . "\n";
		$tag .= $tb . "\t\t\t\t\t\t" . '<input type="hidden" name="csv_name" value="' . $add_param_to_ec . '">' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '</tr>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '<tr>' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t\t\t\t" . '<input type="submit" name="submit" class="button button-primary" value="CSVダウンロード">' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '</tr>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '<tr>' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '<td>' . "\n";
		$tag .= $tb . "\t\t\t\t\t\t" . '<p><a href="' . home_url() . '/ec/ec_admin/product/product_csv_upload' . '" target="_blank">ECCUBE商品一括登録画面はこちら</a></p>' . "\n";
		$tag .= $tb . "\t\t\t\t\t" . '</td>' . "\n";
		$tag .= $tb . "\t\t\t\t" . '</tr>' . "\n";
		$tag .= $tb . "\t\t\t" . '</tbody>' . "\n";
		$tag .= $tb . "\t\t" . '</table>' . "\n";
		$tag .= $tb . "\t" . '</form>' . "\n";
		$tag .= $tb . "" . '</div>' . "\n";
		echo $tag;
	}
	function wp_oo_register_admin_page_csvdownload_to_ec(){
		add_submenu_page( 'edit.php?post_type=' . WPEC_POST_TYPE, 'ECCUBE登録用CSVダウンロード', 'ECCUBE用CSV', 'edit_posts', 'csvdownload_to_ec', 'wp_oo_admin_page_csvdownload_to_ec' );
	}
	add_action( 'admin_menu', 'wp_oo_register_admin_page_csvdownload_to_ec' );