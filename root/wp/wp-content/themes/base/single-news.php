<?php
/*--------------------------------------------------------------------------

	single-news

	@memo

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME            = 'お知らせ';
	$DIRNAME             = 'お知らせ';
	define( 'DIRCODE',  'news' );
	define( 'PAGECODE', 'single' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = $wp_single_title;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		DIRCODE .'/' => $DIRNAME,
		'current'       => $wp_single_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<p class="title_text"><?= $PAGENAME ?></p>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents main_side">
				<article class="area main_area">
<?php	$v = $wp_single_array; ?>
					<div class="hgroup">
						<h2 class="heading02"><?= $v[ 'post_title' ] ?></h2>
						<p class="news_date"><time datetime="<?= $v[ 'post_date_code' ] ?>"><?= $v[ 'post_date' ] ?></time></p>
					</div>
					<div class="box">
						<div class="part">
							<div class="cont entry_wrap">
								<?= $v[ 'detail' ] ?>
							</div>
						</div>
					</div>
				</article>
<?php	include_once TEMPLATEPATH . '/parts_sidebar.php'; ?>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
