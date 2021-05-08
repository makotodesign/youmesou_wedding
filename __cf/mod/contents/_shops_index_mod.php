<?php
/*--------------------------------------------------------------

	ショップリスト 一覧ページモジュール

	@memo
		2015-xx-xx 新規作成

---------------------------------------------------------------*/

## BASE

	/* SETTING */
	$disp_data_num = 20; // 1ページ当たりの表示件数

	/* PATH */
	$DB_class_fpath  = '/mod/lib/db.class.php';

	/* CLASS */
	// DB
	include_once ROOTREALPATH . $DB_class_fpath;
	$host   = '***';
	$user   = '****';
	$path   = '****';
	$dbname = '****';
//	$DB = new db( $host, $user, $path, $dbname );

	/* GET */
	$pref_get_query = ( $_GET[ "pref" ] ) ? $_GET[ "pref" ] : '1'; //都道府県名  1→47 : 北海道ー沖縄
	$pager_num		= (isset($_GET["pager_num"]) && !empty($_GET["pager_num"]) && !is_null($_GET["pager_num"])) ? $_GET["pager_num"] : 1;

	$pref_num       = array( '', '北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県','栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県','石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県',		'三重県','滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県','岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県','佐賀県','長崎県','熊本県','大分県','宮崎県', '鹿児島県','沖縄県' );
	$pref_for_shop  = $pref_num[ $pref_get_query ];
	if ( $pref_get_query <= 7 ){
		$cr_area_name = '北海道・東北';
	} elseif ( $pref_get_query <= 14 ){
		$cr_area_name = '関東';
	} elseif ( $pref_get_query <= 20 ){
		$cr_area_name = '甲信越・北陸';
	} elseif ( $pref_get_query <= 24 ){
		$cr_area_name = '東海';
	} elseif ( $pref_get_query <= 30 ){
		$cr_area_name = '近畿';
	} elseif ( $pref_get_query <= 39 ){
		$cr_area_name = '中国・四国';
	} elseif ( $pref_get_query <= 47 ){
		$cr_area_name = '九州・沖縄';
	}

	/* DB */
	$sql = '
		SELECT
			*
		FROM
			shop01
			WHERE
				shop01.pref = "' . $pref_for_shop . '"
	';
//	$DB->query( $sql );
//	$db_arr = $DB->result_arr();
	$arr_pref = $db_arr;

##	DATA
	/* master */
	$pref_arr = array(
		'北海道・東北' => array(
			array('1','北海道') ,
			array('2','青森県') ,
			array('3','岩手県') ,
			array('4','宮城県') ,
			array('5','秋田県') ,
			array('6','山形県') ,
			array('7','福島県')
		),
		'関東' => array(
			array( '8','茨城県' ),
			array( '9','栃木県' ),
			array( '10','群馬県' ),
			array( '11','埼玉県' ),
			array( '12','千葉県' ),
			array( '13','東京都' ),
			array( '14','神奈川県' )
		),
		'甲信越・北陸' => array(
			array( '15','新潟県' ),
			array( '16','富山県' ),
			array( '17','石川県' ),
			array( '18','福井県' ),
			array( '19','山梨県' ),
			array( '20','長野県' )
		),
		'東海' => array(
			array( '21','岐阜県' ),
			array( '22','静岡県' ),
			array( '23','愛知県' ),
			array( '24','三重県' )
		),
		'近畿' => array(
			array( '25','滋賀県' ),
			array( '26','京都府' ),
			array( '27','大阪府' ),
			array( '28','兵庫県' ),
			array( '29','奈良県' ),
			array( '30','和歌山県' )
		),
		'中国・四国' => array(
			array( '31','鳥取県' ),
			array( '32','島根県' ),
			array( '33','岡山県' ),
			array( '34','広島県' ),
			array( '35','山口県' ),
			array( '36','徳島県' ),
			array( '37','香川県' ),
			array( '38','愛媛県' ),
			array( '39','高知県' ),
		),
		'九州・沖縄' => array(
			array( '40','福岡県' ),
			array( '41','佐賀県' ),
			array( '42','長崎県' ),
			array( '43','熊本県' ),
			array( '44','大分県' ),
			array( '45','宮崎県' ),
			array( '46','鹿児島県' ),
			array( '47','沖縄県' )
		)
	);

##	FUNC


##	TAG

	/* 結果件数表示 */
	$total_shop_count = count($arr_pref);
	$start_num = (($pager_num - 1) * $disp_data_num) + 1;
	$end_num = ($total_shop_count > ($pager_num * $disp_data_num)) ? ($pager_num * $disp_data_num) : $total_shop_count;

	// サイドナビ
	$tag = '';
	$tb = "\t\t\t\t\t\t\t";
	if( is_array( $pref_arr ) && count( $pref_arr ) > 0 ){
		foreach( $pref_arr as $area => $prefs ){
			if( $area == $cr_area_name ){
				$heading_accordion_class = ' heading_minus';
				$ul_acc_setting = ' minus';
			} else {
				$heading_accordion_class = ' heading_plus';
				$ul_acc_setting = ' plus';
			}
			$tag .= $tb . "" . '<li data-role="collapsible">' . "\n";
			$tag .= $tb . "\t" . '<h4 class="heading_side_accordion' . $heading_accordion_class . '">' . $area . '</h4>' . "\n";
			$tag .= $tb . "\t" . '<ul data-role="listview" class="child list_accordion' . $ul_acc_setting . '">' . "\n";
			foreach( $prefs as $pref ){
				$cr_class = '';
				if( $pref_get_query == $pref[ 0 ] ){
					$cr_class =	' class="current"';
				}
				$tag .= $tb . "\t\t" . $dd_cur.'<li><a' . $cr_class . ' href="/shops/?pref='.$pref[ 0 ].'">'. $pref[ 1 ] .'</a></li>' . "\n";
			}
			$tag .= $tb . "\t" . "</ul>" . "\n";
			$tag .= $tb . "" . "</li>" . "\n";
		}
	}
	$tag .= $tb . "" . '<li><a href="/shops/?pref=mass_retailer">量販店リスト</a></li>' . "\n";
	$tag_side_nav = $tag; //SIDENAVI

	// 店舗リスト
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t";
	for($i = ($start_num-1); $i < $end_num; $i++){
		$tag .= $tb . "" . '<div class="part shop_list">' . "\n";
		$tag .= $tb . "\t" . '<h4 class="heading03">' . mb_convert_kana( $arr_pref[ $i ][ 'shop_name' ], "KV" ) . '</h4>' . "\n";
		if( isset( $arr_pref[ $i ][ 'zip' ] ) && $arr_pref[ $i ][ 'zip' ] && isset( $arr_pref[ $i ][ 'address' ] ) && $arr_pref[ $i ][ 'address' ] ){
			$tag .= $tb . "\t" . '<p class="text">〒'. $arr_pref[ $i ][ 'zip' ] . switch_pc_sp( '&nbsp;', '<br>' ) . mb_convert_kana( $arr_pref[ $i ][ 'address' ], "KV" ) .'</p>' . "\n";
		}
		if( isset( $arr_pref[ $i ][ 'tel' ] ) && $arr_pref[ $i ][ 'tel' ] ){
			$tag .= $tb . "\t" . '<p class="text">TEL : '. $arr_pref[ $i ][ 'tel' ] . '</p>' . "\n";
		}
		if( isset( $arr_pref[ $i ][ 'url' ] ) && $arr_pref[ $i ][ 'url' ] ){
			$tag .= $tb . "\t" . '<p class="text">URL : <a href="'. $arr_pref[ $i ][ 'url' ] . '" target="_blank">'. $arr_pref[ $i ][ 'url' ] . '</a></p>' . "\n";
		}
		$tag .= $tb . "" . '</div>' . "\n";
	}
	$tag_shop_list = ( $tag ) ? $tag: '<p>現在、正規取引店はございません。</p>' ;

	// ページャー
	$tag = '';
	$tb = "\t\t\t\t";
	for($i = 0; $i < (count($arr_pref)/$disp_data_num); $i++)
	{
		if($pager_num == ($i+1))
		{
			$tag .= $tb."".'<li><span data-role="button" data-theme="a" data-inline="true" class="ui-disabled">'. ( $i+1 ) .'</span></li>'."\n";
		}
		else
		{
			$tag .= $tb."".'<li><a data-role="button" data-theme="a" data-inline="true"' . $transition_reverse . ' href="/shops/?pref='.$pref_get_query.'&pager_num='.($i+1).'">&nbsp;'.($i+1).'&nbsp;</a></li>'."\n";
		}
	}
	$tag_pager = $tag;

?>