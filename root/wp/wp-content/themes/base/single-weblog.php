<?php
/*--------------------------------------------------------------------------

	single-weblog

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '*';
	$DIRNAME             = '結水荘日記';
	define( 'DIRCODE',  'weblog' );
	define( 'PAGECODE', 'single' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	//include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = '必ず設定'; //$wp_single_title;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		'/' . DIRCODE . '/' => $DIRNAME,
		'current'       => '必ず設定' //$wp_single_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME //$wp_single_title ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents main_side">
				<section class="area main_area">
					<div class="hgroup">
						<h2 class="heading02"><?= $PAGENAME ?></h2>
					</div>
					<div class="box">
						<h3 class="heading03">HEADING2</h3>
						<div class="part">
							<div class="cont texts">
								<p>TEXTTEXTTEXT</p>
							</div>
						</div>
					</div>
					<div class="box recommend_box">
						<h3 class="heading03">関連記事</h3>
						<div class="part clm3_tb_pc">
							<a class="cont clm_item cover_wrap" href="">
								<p class="object_fit"><img src="" alt=""></p>
								<p class="date">20211/8/4</p>
								<p class="title">てすとてsと関連</p>
							</a>
						</div>
					</div>
				</section>
<?php include_once( TEMPLATEPATH . '/parts_sidebar.php' );?>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
