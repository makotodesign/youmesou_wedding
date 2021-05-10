<?php
/*--------------------------------------------------------------------------

	single-productsec

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '*';
	$DIRNAME             = '製品EC';
	define( 'DIRCODE',  'productsec' );
	define( 'PAGECODE', 'single' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';

	/* page_option */
	$HEAD->title                = $wp_single_title;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = true;

	// breadcrumb
	$breadcrumb_arr = [
		DIRCODE .'/' => $DIRNAME,
		'current'       => '必ず設定' //$wp_single_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/

// print '<pre>'.'$_SESSION' . '：';var_dump($_SESSION);print '</pre>' . "\n";

// print '<pre>'.'ec_oo_get_token()' . '：';var_dump(ec_oo_get_token());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_is_loggedin()' . '：';var_dump(ec_oo_is_loggedin());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_carts_total_quantity()' . '：';var_dump(ec_oo_get_carts_total_quantity());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_carts_total_price()' . '：';var_dump(ec_oo_get_carts_total_price());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_carts_items()' . '：';var_dump(ec_oo_carts_items());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_customer_name()' . '：';var_dump(ec_oo_get_customer_name());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_customer_company()' . '：';var_dump(ec_oo_get_customer_company());print '</pre>' . "\n";
// print '<pre>'.'ec_oo_is_favorite( 3 )' . '：';var_dump(ec_oo_is_favorite( 3 ));print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_product_data( id, code01 )' . '：';var_dump(ec_oo_get_product_data( 'id', 'code01' ));print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_product_data( class_id, code01 )' . '：';var_dump(ec_oo_get_product_data( 'class_id', 'code01' ));print '</pre>' . "\n";
// print '<pre>'.'ec_oo_get_product_data( price, code01 )' . '：';var_dump(ec_oo_get_product_data( 'price', 'code01' ));print '</pre>' . "\n";
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $DIRNAME //$wp_single_title ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
<?php	$v = $wp_single_array;?>
					<div class="box">
						<h3 class="heading03"><?= $v[ 'post_title' ] ?></h3>
						<div class="part image_texts_tb_pc">
							<div class="cont image_item">
								<p class="pic"><img src="<?= $v[ 'productsec_pic_main' ] ?>" alt="<?= $v[ 'post_title' ] ?>"></p>
							</div>
							<div class="cont texts_item texts">
								<p>productsec_code：<?= $v[ 'productsec_code' ] ?></p>
								<p>price：<?= tax_adjust( $v[ 'productsec_price' ] );?>yen</p>
<?php	if( $arr[ 'productsec_ec_flag' ] ) : ?>
								<div class="cart_btn">
									<form method="post" action="/ec/products/add_cart/<?= $v[ 'productsec_ec_id' ] ?>" data-ec_form_group="<?= $v[ 'productsec_ec_id' ] ?>" data-ec_form_role="add_cart">
										<p>product_id：<input type="hidden" name="product_id" value="<?= $v[ 'productsec_ec_id' ] ?>"><?= $v[ 'productsec_ec_id' ] ?></p>
										<p>ProductClass：<input type="hidden" name="ProductClass" value="<?= $v[ 'productsec_ec_class_id' ] ?>"><?= $v[ 'productsec_ec_class_id' ] ?></p>
										<p>quantity：<input type="text" name="quantity" value="1" style="display:inline-block;width:100px;"></p>
										<input type="hidden" name="bundlekey" value="<?= $bundlekey ?>">
										<input type="hidden" name="_token" value="">
									</form>
									<div class="btn_wrap">
										<button id="ec_cart_2_btn" type="submit" data-ec_submit_role="add_cart" data-target="modal_target_<?= $v[ 'productsec_ec_id' ] ?>" class="cart_in button bc_strong icon_cart off"><span>カートに追加</span></button>
									</div>
									<p class="to_cart_message_after_cart_in" style="display: none;"><a href="/ec/">カートへはこちら</a></p>
									<div id="modal_target_<?= $v[ 'productsec_ec_id' ] ?>" class="modal_target">
										<div class="cont texts">
											<p class="center">カートに追加しました</p>
										</div>
										<div class="cont btn_wrap center">
											<a class="button" data-role="modal_close"><span>買い物を続ける</span></a>
											<a href="/ec/" class="button bc_strong"><span>カートに行く</span></a>
										</div>
									</div>
									<form action="/ec/products/add_favorite/<?= $v[ 'productsec_ec_id' ] ?>" method="post">
										<div class="btn_wrap">
<?php		if( ec_oo_is_favorite( $v[ 'productsec_code' ] ) ) :  ?>
												<button type="submit" class="button" disabled="disabled"><span>お気に入りに追加済です</span></button> 
<?php		else : ?>
												<button type="submit" class="button" data-role="favorite" data-ec_id="<?= $v[ 'productsec_ec_id' ] ?>"><span>お気に入りに追加</span></button>
<?php		endif; ?>
										</div>
									</form>
								</div>
<?php	else : ?>
								<p class="text caution icon_kome">現在販売しておりません。</p>
<?php	endif;?>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php';?>
