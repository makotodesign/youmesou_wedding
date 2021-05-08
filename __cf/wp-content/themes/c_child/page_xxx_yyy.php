<?php
/*--------------------------------------------------------------------------

	Template Name: c_child-page_xxx_yyy
	*child

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ページタイトル';
	$DIRNAME             = 'ディレクトリ';
	define( 'DIRCODE',  'xxx' );
	define( 'PAGECODE', 'yyy' );

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes' . MULTISITETHEMEDIR . '/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= MULTISITEBLOGNAME;?>_<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
			<div class="<?= MULTISITEBLOGNAME;?>_<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
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
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php';?>
