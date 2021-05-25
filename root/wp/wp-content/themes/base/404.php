<?php
/*--------------------------------------------------------------------------

	Template Name: 404

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '404error';
	$DIRNAME             = 'ERROR';
	define( 'DIRCODE',  'error' );
	define( 'PAGECODE', '404' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* js */
	$HEAD->js = '';

	// breadcrumb
	$breadcrumb_arr = [
		'current'       => $PAGENAME
	];

	$HEAD->google_fonts_text = [
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

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
					<div class="box error_box">
						<div class="part">
							<div class="cont texts">
								<p class="error_text"><span class="font_mincho">404 Not Found</span></p>
								<p>現在、このページは削除などの理由で存在しませんので、エラーページが表示されています。</p>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
