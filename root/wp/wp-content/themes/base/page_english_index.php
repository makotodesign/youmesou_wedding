<?php
/*--------------------------------------------------------------------------

	Template Name: page_english_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'English';
	$DIRNAME             = 'English';
	define( 'DIRCODE',  'english' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	// $HEAD->title                = $wp_page_title;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		//'/' . DIRCODE . '/' => $DIRNAME,
		'current'       => $wp_page_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';
	$arr = $wp_page_array[ 'contents' ];
/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?=  $wp_page_title ?></h1>
<?php 	if( $wp_page_title_sub ) : ?>
				<p class="title_text_sub"><?=  $wp_page_title_sub ?></p>
<?php 	endif;?>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
<?php foreach( $arr as  $v ) : ?>
					<div class="box">
						<div class="hgroup">
							<h2 class="heading02"><?= $v[ 'title' ] ?></h2>
						</div>
						<div class="part">
							<div class="cont entry_wrap">
								<?= $v[ 'content' ] ?>
							</div>
						</div>
					</div>
<?php endforeach; ?>
					<div class="box">
						<div class="part">
							<div class="cont texts">
								<div class="btn_wrap center">
									<a href="/contact/" class="button icon_arrow_right"><span>Contact us</span></a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
