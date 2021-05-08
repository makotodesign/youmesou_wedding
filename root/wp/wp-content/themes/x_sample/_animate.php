<?php
/*--------------------------------------------------------------------------

	Template Name: xx_animate

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ページタイトル';
	$DIRNAME             = 'ディレクトリ';
	define( 'DIRCODE',  'animate' );
	define( 'PAGECODE', 'index' );

	/* realpath & includes ( * ct12よりWordPressテーマで不要 ) */
	if( ! defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', '/home/oldoffice/www/org01/ct18' );
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* css */
	$HEAD->css = '';
	// *テスト用 基本使用不可
	//$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $HEAD->fpath_add_date_query( '/css/lib/animate.css' ) . '" media="all">' . "\n";
	$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $HEAD->fpath_add_date_query( '/css/lib/aos.css' ) . '" media="all">' . "\n";
	$HEAD->css .= "\t" . '<link rel="stylesheet" type="text/css" href="' . $HEAD->fpath_add_date_query( '/css/top/top_sample.css' ) . '" media="all">' . "\n";


	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="' . PUBLICDIR . '/js/lib/jquery.cycle2.min.js"></script>' . "\n";
	$HEAD->js .= "\t" . '<script src="' . PUBLICDIR . '/js/lib/jquery.cycle2.tile.js"></script>' . "\n";
//	$HEAD->js .= "\t" . '<script src="' . PUBLICDIR . '/js/lib/jquery.cycle2.flip.js"></script>' . "\n";
	$HEAD->js .= "\t" . '<script src="' . PUBLICDIR . '/js/lib/aos.js"></script>' . "\n";
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/top/_top_sample.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
	//	DIRCODE .'/' => $DIRNAME
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="promo_wrap">
			<div id="promo01" class="promo">
				<div class="promo_cont">
					<p class="promo_pic"><img src="/images/top/promo_01.jpg" alt="必ず記述"></p>
					<div class="promo_info">
						<p class="promo_catch">CATCH01</p>
						<p class="promo_text">だみーぶんしょうですだみーぶんしょうでょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
					</div>
				</div>
			</div>
			<div id="promo02" class="promo">
				<div class="promo_cont">
					<p class="promo_pic"><img src="/images/top/promo_02.jpg" alt="必ず記述"></p>
					<div class="promo_info">
						<p class="promo_catch">CATCH02</p>
						<p class="promo_text">だみーぶんしょうですだみーぶんしょうでょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
					</div>
				</div>
			</div>
			<div id="promo03" class="promo">
				<div class="promo_cont">
					<p class="promo_pic"><img src="/images/top/promo_03.jpg" alt="必ず記述"></p>
					<div class="promo_info">
						<p class="promo_catch">CATCH03</p>
						<p class="promo_text">だみーぶんしょうですだみーぶんしょうでょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
					</div>
				</div>
			</div>
			<div class="promo_progress">progress</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents wide_contents">
				<section class="area">
					<div class="hgroup">
						<h2 class="heading02"><?= $PAGENAME ?></h2>
					</div>
					<div class="box bg_fixed">
						<h3 class="heading03">HEADING2</h3>
						<div class="part texts">
							<p class="animated bounce">TEXTTEXTTEXT</p>
						</div>
						<div class="part texts">
							<p class="animated bounce">TEXTTEXTTEXT</p>
						</div>
						<div class="part texts">
							<p class="animated bounce">TEXTTEXTTEXT</p>
						</div>
					</div>
				</section>
				<section class="area bg_fixed">
					<div class="box">
						<h3 class="heading03">HEADING2</h3>
						<div class="part texts">
							<p class="animated bounce">TEXTTEXTTEXT</p>
						</div>
						<div class="part texts">
							<p class="animated bounce">TEXTTEXTTEXT</p>
						</div>
						<div class="part texts">
							<p class="animated bounce">TEXTTEXTTEXT</p>
						</div>
					</div>
				</section>
				<section class="area">
					<div class="box">
						<div class="part">
							<ul class="clm3_pc clm2_tb">
								<li class="cont clm_item" data-aos="fade-up">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="fade-down">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="fade-up">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="fade-right">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="fade-up">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="fade-left">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
							</ul>
						</div>
						<div class="part">
							<ul class="clm3_pc clm2_tb">
								<li class="cont clm_item" data-aos="flip-left">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="flip-up">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="flip-right">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="zoom-in-up">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="zoom-in-down">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="zoom-in-up">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
							</ul>
						</div>
						<div class="part">
							<ul class="clm3_pc clm2_tb">
								<li class="cont clm_item" data-aos="fade-left">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="fade-left">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
								<li class="cont clm_item" data-aos="flip-left">
									<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								</li>
							</ul>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_footer.php';?>
