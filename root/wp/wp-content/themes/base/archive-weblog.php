<?php
/*--------------------------------------------------------------------------

	archive-weblog

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '結水荘日記';
	$DIRNAME             = '結水荘日記';
	define( 'DIRCODE',  'weblog' );
	define( 'PAGECODE', 'archive' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	//include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = '必ず設定'; //$wp_archive_title;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		'current'       => '必ず設定' //$wp_archive_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';
$wp_pager_array = [];//temp
/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME;//$wp_archive_title ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents main_side">
				<section class="area">
					<div class="box">
						<a class="part image_texts_grid cover_wrap" href="">
							<div class="cont image_item">
								<p class="object_fit"><img src="/images/top/pic_01.jpg" alt=""></p>
							</div>
							<div class="cont texts_item texts">
								<p class="date">2021/8/1</p>
								<p class="title">ダミータイトルダーミータイt流</p>
								<p class="excerpt">文章です。文章です。文章です。文章です。文章です。文章です。文章です。文章です。文章です。文章です。文章です。文章です。</p>
							</div>
						</a>
					</div>
<?php	if( $wp_pager_array ) : ?>
					<div class="box">
						<div class="part">
							<div class="cont pager_wrap">
								<ul>
<?php		foreach( $wp_pager_array as  $v ) : ?>
									<li><?= $v ?></li>
<?php		endforeach; ?>
								</ul>
							</div>
						</div>
					</div>
<?php	endif; ?>
				</section>
<?php	include_once TEMPLATEPATH . '/parts_sidebar.php'; ?>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>