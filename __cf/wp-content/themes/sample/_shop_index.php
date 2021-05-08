<?php
/*--------------------------------------------------------------------------

	Template Name: shop_archive

	@memo

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME = '*下部で設定';
	$DIRNAME = 'ショップリスト';
	define( 'DIRCODE', 'shop' );
	define( 'PAGECODE', 'archive' );

	/* realpath & includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/shops_index_mod.php';
	$PAGENAME = $pref_for_shop . 'の取り扱い店舗一覧';

	/* css */
	$HEAD->css = '';
	$HEAD->css .= '<link rel="stylesheet" type="text/css" href="' . PUBLICDIR . '/css/utility/pager.css" media="all">' . "\n";
	$HEAD->css .= '<link rel="stylesheet" type="text/css" href="' . PUBLICDIR . '/css/' . DIRCODE . '/style.css" media="all">' . "\n";

	/* js */
	$HEAD->js = '';
	$HEAD->js .= '<script src="' . PUBLICDIR . '/js/' . DIRCODE . '/script.js"></script>' . "\n";

	/* page_option ( over write ) : title / meta / h1 / og_cullent_img */
	$HEAD->title            = '';
	$HEAD->meta_description = '';
	$HEAD->back_navi_url    = '/';

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/data/includes/header_mod.php';

/*---------------------------------------------------------------------------*/
?>
	<div class="title_wrap">
		<div class="title">
			<p><?= $DIRNAME ?></p>
		</div>
	</div>
	<div class="contents_wrap">
		<div class="contents">
<?php
/* side_navi */
/********************* is_pc ************************/
	if( is_pc() ){
		include_once ROOTREALPATH . "/data/includes/side_navi_" . DIRCODE . "_mod.php";
	}
/********************* end **************************/
?>
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents main_contents">
				<div class="area">
					<section>
<?php
/********************* is_pc ************************/
	if( is_pc() ) {
?>
						<div class="hgroup">
							<h2 class="heading02"><?= $PAGENAME ?></h2>
						</div>
<?php
	}
/********************* end **************************/
?>
						<div class="box shoplist_box">
<?= $tag_shop_list ?>
						</div>
						<div class="box pager">
							<nav>
								<div class="part pager_button pager_bc_original">
									<ul>
<?= $tag_pager ?>
									</ul>
								</div>
							</nav>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
<?php	include_once ROOTREALPATH . "/data/includes/footer_mod.php";?>