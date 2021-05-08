<?php
/*--------------------------------------------------------------------------

	Template Name: maintenance

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME = '現在調整中です';
	$DIRNAME = 'メンテナンス';
	define( 'DIRCODE', 'maintenance' );
	define( 'PAGECODE', 'maintenance' );

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */

	/* css */
	$HEAD->css = '';

	/* js */
	$HEAD->js = '';

	/* head & header */
	$HEAD->disp_tag_head();

/*---------------------------------------------------------------------------*/
?>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<div class="mono_area">
					<section>
						<div class="box error_box">
							<div class="part texts">
								<p class="error_text fas fa-exclamation-triangle"><span class="font_mincho">Under Construction</span></p>
								<p>現在、WEBサイトを調整中です。<br>再開までしばらくおまちください。<br>よろしくお願いいたします。</p>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
