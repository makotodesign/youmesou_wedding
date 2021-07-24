<?php
/*--------------------------------------------------------------------------

	Template Name: page_plan_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ウェディングプラン紹介';
	$DIRNAME             = '結水荘ウェディングプラン';
	define( 'DIRCODE',  'plan' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	//include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

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
		'current'       => $PAGENAME
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
				<p class="title_text_sub">サブタイトル文章</p>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
					<div class="box">
						<h2 class="heading03 title">HEADING2</h2>
						<div class="part image_texts_pc">
							<div class="cont image_item gallery_wrap">
								<div class="pic_main gallery_target">
									<p class="object_fit"><img src="/images/lib/parts/color01.jpg" alt="必ず記述"></p>
								</div>
								<div class="cont clm5_tb_pc snap_sp gallery_handle_set" data-target="gallery_target01">
									<a class="clm_item current">
										<p class="object_fit"><img src="/images/lib/parts/color01.jpg" alt="必ず記述"></p>
									</a>
									<a class="clm_item">
										<p class="object_fit"><img src="/images/lib/parts/color02.jpg" alt="必ず記述"></p>
									</a>
									<a class="clm_item">
										<p class="object_fit"><img src="/images/lib/parts/color03.jpg" alt="必ず記述"></p>
									</a>
									<a class="clm_item">
										<p class="object_fit"><img src="/images/lib/parts/color04.jpg" alt="必ず記述"></p>
									</a>
									<a class="clm_item">
										<p class="object_fit"><img src="/images/lib/parts/color05.jpg" alt="必ず記述"></p>
									</a>
								</div>
								<div class="part snap_dots"><span class="current"></span><span></span><span></span><span></span><span></span></div>
							</div>
							<div class="cont texts_item texts">
								<p class="caption">プライベート空間でゆっくりと。和室やレトロな雰囲気の洋室、お庭でも<br>ソロウェディングにもおすすめのプランです（お衣装代減額あり）</p>
								<p class="badge"><span>含まれるもの</span></p>
								<ul>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
									<li>新郎新婦衣装</li>
								</ul>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
