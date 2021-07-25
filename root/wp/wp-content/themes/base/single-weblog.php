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
		'/' . DIRCODE . '/' => $DIRNAME,
		'current'       => $wp_single_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';
/*---------------------------------------------------------------------------*/
?>

		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $wp_single_title ?></h1>
				<p class="title_text_sub"><?=  $wp_single_array[ 'post_date' ] ?></p>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents main_side">
				<section class="area main_area">
					<div class="box">
						<!-- <h3 class="heading03"><?= $wp_single_title ?></h3> -->
						<div class="part">
							<div class="cont">
								<p class="object_fit"><img src="<?= $wp_single_array[ 'eyecatch' ] ?>" alt="<?= $wp_single_title ?>"></p>
							</div>
							<div class="cont entry_wrap">
								<?=  $wp_single_array[ 'post_content' ] ?>
							</div>
						</div>
					</div>
<?php if( !empty( $wp_relation_array ) ) : ?>
					<div class="box recommend_box">
						<h3 class="heading03">関連記事</h3>
<?php 	foreach( $wp_relation_array as  $v ) : ?>
						<div class="part clm3_tb_pc">
							<a class="cont clm_item cover_wrap" href="">
								<p class="object_fit"><img src="<?= $v[ 'eyecatch' ] ?>" alt="<?= $v[ 'post_title' ] ?>"></p>
								<p class="date"><?= $v[ 'post_date' ] ?></p>
								<p class="title"><?= $v[ 'post_title' ] ?></p>
							</a>
						</div>
<?php 	endforeach; ?>
					</div>
<?php endif; ?>
				</section>
<?php include_once( TEMPLATEPATH . '/parts_sidebar.php' );?>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
