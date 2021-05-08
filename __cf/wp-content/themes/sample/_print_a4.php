<?php
/*--------------------------------------------------------------------------

	Template Name: print_a4

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME = 'A4';
	$DIRNAME = '印刷用ページ';
	define( 'DIRCODE', 'print' );
	define( 'PAGECODE', 'a4' );

	/* realpath & includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */

	/* css */
	$HEAD->css_pc_media = 'screen';
	$HEAD->css = '';
	if( is_pc() ) {
		$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . PUBLICDIR . '/css/utility/a4_print.css" media="print">' . "\n";
		$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . PUBLICDIR . '/css/utility/a4_screen.css" media="screen">' . "\n";
		$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . PUBLICDIR . '/css/' . DIRCODE . '/style.css" media="screen">' . "\n";
	}

	/* js */
	$HEAD->js = '';

	/* page_option ( over write ) : title / meta / h1 / og_cullent_img */
	$HEAD->title = '';
	$HEAD->meta_description = '';

	/* head & header */
	$HEAD->disp_tag_head();

/*---------------------------------------------------------------------------*/
?>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents print_contents">
				<div class="mono_area">
					<section>
						<div class="box">
							<div class="estimate_info part texts">
								<p>No.</p>
								<p>2013年00月00日</p>
							</div>
							<div class="estimate_to part texts">
								<p>株式会社○○御中</p>
							</div>
							<div class="estimate_heading part">
								<h2 class="heading02">御見積書</h2>
							</div>
							<div class="estimate_sign part texts">
								<div class="sign_cont">
									<p>株式会社オールドオフィス</p>
									<p>〒658-0032<br>神戸市東灘区住吉宮町3-15-15</p>
								</div>
							</div>
						</div>
						<div class="box">
							<div class="estimate_total part texts">
								<p>下記の通り御見積させていただきます</p>
								<p class="estimate_total_price">御見積金額 ： <span class="price">￥200,000</span>　（消費税込み）</p>
								<p class="caption">※ 見積有効期限は本書日付後60日限りですので、日限後ご発注の際にはご照会のほどお願い申し上げます。</p>
							</div>
						</div>
						<div class="box">
							<div class="estimate_detail part texts">
								<table width="100%" border="1" class="box print_table">
									<tr>
										<th scope="col">内容</th>
										<th scope="col">単価</th>
										<th scope="col">数量</th>
										<th scope="col">合計</th>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr class="shokei">
										<td>小計</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr class="tax">
										<td>消費税</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr class="total">
										<td>合計</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</table>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
