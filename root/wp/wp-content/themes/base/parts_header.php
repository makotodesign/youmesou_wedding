<?php
/*--------------------------------------------------------------------------

	parts_header

	@memo

---------------------------------------------------------------------------*/

##	header_mod

	/* ec */
	$ec_login_class = 'ec_not_loggedin';
	if( function_exists( 'ec_oo_is_loggedin' ) && ec_oo_is_loggedin() ) {
		$ec_login_class = 'ec_loggedin';
	}
	$ec_cart_class = 'off';
	$ec_cart_quantity = 0;
	if( function_exists( 'ec_oo_get_carts_total_quantity' ) && ec_oo_get_carts_total_quantity() > 0 ) {
		$ec_cart_class = 'on';
		$ec_cart_quantity = ec_oo_get_carts_total_quantity();
	}
	$ec_oo_carts_items = [];
	$add_attr_ec_oo_carts_items_setup = 'ready';
	if( function_exists( 'ec_oo_carts_items' ) ) {
		$ec_oo_carts_items = ec_oo_carts_items();
		$add_attr_ec_oo_carts_items_setup = ' setup';
	}
	$add_class_message_no_cart_hide = '';
	$add_cart_btn_in_ecnav_cart_set_hide = '';
	if( ! function_exists( 'ec_oo_carts_items' ) || $ec_oo_carts_items ) {
		$add_class_message_no_cart_hide = ' v_hide';
	} elseif( ! function_exists( 'ec_oo_carts_items' ) || ! $ec_oo_carts_items ) {
		$add_cart_btn_in_ecnav_cart_set_hide = ' v_hide';
	}

/*-------------------------------------------------------------------------*/

?>
		<header class="header_wrap">
			<div class="header_topnav_wrap hide_sp_tb">
				<div class="header_topnav">
<?php
	/* ec */
?>
					<ul class="ecnav_list">
						<li><a href="/ec/mypage/login" id="topnav_ec_login" class="v_ec_login <?= $ec_login_class ?>"><span>ログイン</span></a></li>
						<li><a href="/ec/entry" id="topnav_ec_register" class="v_ec_register <?= $ec_login_class ?>"><span>会員登録</span></a></li>
						<li><a href="/ec/logout" id="topnav_ec_logout" class="v_ec_logout <?= $ec_login_class ?>"><span>ログアウト</span></a></li>
						<li><a href="/ec/mypage/" id="topnav_ec_mypage" class="v_ec_mypage <?= $ec_login_class ?>"><span>MYページ</span></a></li>
						<li class="ecnav_cart_wrap">
							<a href="/ec/" id="topnav_ec_cart" class="v_ec_cart <?= $ec_cart_class ?>"><span>カート（<em id="carts_total_quantity" class="carts_total_quantity"><?= $ec_cart_quantity ?></em>）</span></a>
							<div id="ecnav_cart_set" class="ecnav_cart_set on" data-status="<?= $add_attr_ec_oo_carts_items_setup ?>">
								<div class="cart_items">
<?php		if( $ec_oo_carts_items ) :  ?>
<?php			foreach( $ec_oo_carts_items as $v ) : ?>
									<div class="image_texts cart_item">
										<div class="image_item">
											<p class="object_fit"><img src="<?= $v[ 'pic' ] ?>" alt="<?= $v[ 'name' ] ?>"></p>
										</div>
										<div class="texts_item">
											<p><span class="cart_item_name"><?= $v[ 'name' ] ?></span></p>
<?php				if( $v[ 'class01' ] && $v[ 'class02' ] ) :  ?>
											<p><span class="cart_item_class"><?= $v[ 'class01' ] ?><br><?= $v[ 'class02' ] ?> × 16mm</span></p>
<?php				elseif( $v[ 'class01' ] || $v[ 'class02' ] ) : ?>
											<p><span class="cart_item_class"><?= $v[ 'class01' ] . $v[ 'class02' ] ?> × 16mm</span></p>
<?php				endif; ?>
											<p><span class="cart_item_price">￥<?= number_format( $v[ 'price' ] ) ?></span><span class="cart_item_taxword"> <?= TAXWORD ?></span></p>
											<p><span class="cart_item_quantity">数量：</span><span class="cart_item_quantity_num"><?= $v[ 'quantity' ] ?></span></p>
										</div>
									</div>
<?php			endforeach; ?>
<?php		endif; ?>
								</div>
								<div class="message_no_cart<?= $add_class_message_no_cart_hide ?>">
									<p>現在カートの中身はございません。</p>
								</div>
								<div class="btn_wrap vartical">
									<a href="/ec/" class="button v_cart bc_strong<?= $add_cart_btn_in_ecnav_cart_set_hide ?>"><span>カートへ進む</span></a>
									<a data-role="close" class="button v_close bc0"><span>キャンセル</span></a>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="header">
				<a class="logo_set" href="/">
					<p class="logo"><span><img src="/images/common/logo.svg" alt="必ず記述"></span></p>
				</a>
<?php
	/* memo */
	// base.jsで hnav_list がhnav_wrapに囲まれた上でここに移動します
	/* pc : hnav ナビや検索、電話番号など表示 */
	// markup はgnav内に記載
/*
				<nav class="hnav">
					<ul class="hnav_list">
						<li><a href="/xx/" class="icon_arrow"><span>MENU</span></a></li>
						<li><a href="/xx/" class="icon_arrow"><span>MENU</span></a></li>
					</ul>
					<form class="hsearch" method="post" action="">
						<div class="search_cont">
							<p class="input_wrap"><input type="text" name="" place_polder="Search･･･"></p>
							<button type="submit"><span>検索</span></button>
						</div>
					</form>
					<div class="langnav">
						<p class="lang_current"><span>Ja</span></p>
						<ul class="langnav_list">
							<li><a href="/en/"><span>En</span></a></li>
						</ul>
					</div>
					<div class="hcontact">
						<p class="header_tel"><a href="tel:000-000-0000"><span class="icon_tel">TEL</span><span>000-000-0000</span></a></p>
					</div>
				</nav>
*/
?>
				<p class="gnav_btn menu"><span></span><span></span><span></span></p>
<?php
/* gnav が headerの「下」or「横」 */
// 下の場合は下記 ganv_wrap 必要
/*
			</div>
			<div class="gnav_wrap">
*/
?>
				<nav class="gnav">
					<ul class="topnav_list hide_pc">
						<li><a href="/xx/"><span>MENU</span></a></li>
						<li><a href="/xx/"><span>MENU</span></a></li>
					</ul>
					<ul class="gnav_list">
						<li><a href="/" data-gnav="home"><span>HOME</span></a></li>
						<li><a href="/aaa/"><span>MENU_A</span></a></li>
						<li class="submenu_wrap">
							<a href="/bbb/"><span>MENU_B</span></a>
							<div class="submenu">
								<ul>
									<li><a href="/bbb/bb01/"><span>MENU_B_01</span></a></li>
									<li><a href="/bbb/bb02/"><span>MENU_B_02</span></a></li>
								</ul>
							</div>
						</li>
						<li class="submenu_wrap">
							<a href="/ccc/"><span>MENU_C</span></a>
							<div class="submenu">
								<ul>
									<li><a href="/xx/" ><span>xx</span></a></li>
									<li><a href="/xx/sample_markup.php" ><span>sample_markup</span></a></li>
									<li><a href="/contact/" ><span>contact</span></a></li>
									<li><a href="/news/" ><span>news</span></a></li>
									<li><a href="/productsec/65" ><span>productsec</span></a></li>
								</ul>
							</div>
						</li>
						<li><a href="/ddd/"><span>MENU_D</span></a></li>
						<li><a href="/eee/" data-navcurrent="false"><span>MENU_E</span></a></li>
					</ul>
				</nav>
			</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_breadcrumb.php';?>
		</header>
