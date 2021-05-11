<?php
/*--------------------------------------------------------------------------

	Template Name: xx_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ページタイトル';
	$DIRNAME             = 'ディレクトリ';
	define( 'DIRCODE',  'xx' );
	define( 'PAGECODE', 'index' );

	/* no_wp */
	if( ! defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', '/home/oldoffice/www/org01/ct18' );
	include_once ROOTREALPATH . '/wp/wp-load.php';

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = array(
		DIRCODE .'/' => $DIRNAME,
		'current'       => $PAGENAME
	);

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';
	/*
		wp_themes では下記を使用
		parts_sidebar
		parts_footer
		も同様
	*/
	//include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
					<div class="hgroup">
						<h2 class="heading02">見出し2</h2>
					</div>
					<div class="box">
						<h3 class="heading03">HEADING2</h3>
						<div class="part">
							<div class="cont texts">
								<p>TEXTTEXTTEXT</p>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_footer.php'; ?>
