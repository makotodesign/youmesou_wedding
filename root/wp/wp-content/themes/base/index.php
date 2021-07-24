<?php
/*--------------------------------------------------------------------------

	home

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '結水荘Wedding';
	define( 'DIRCODE',  'top' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/top_news_wp_mod.php';

	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = $PAGENAME;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';
	$HEAD->modal_flag = false;

/*---------------------------------------------------------------------------*/
?>
		<div class="promo_wrap">
			<div id="promo01" class="promo">
				<div class="promo_cont">
					<p class="promo_pic"><img src="/images/top/promo_pic01.jpg" alt="必ず記述"></p>
					<h1 class="hidden"><?= $PAGENAME ?></h1>
				</div>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="top_contents contents">
				<section id="top_introduction_area" class="area">
					<div class="hgroup">
						<h2 class="heading02">海の街　神戸・垂水<br>JR垂水駅北側、まるで時が止まったような路地<br>築100年の古民家で<br>心のこもった結婚式はいかがですか？</h2>
					</div>
					<div class="box">
						<div class="part image_texts_pc image_texts_tb">
							<div class="cont image_item">
								<p class="pic"><img src="/images/top/pic_01.jpg" alt="必ず記述"></p>
							</div>
							<div class="cont texts_item">
								<h2 class="heading04">見出し2</h2>
								<p class="text">だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="part texts_image_pc texts_image_tb">
							<div class="cont image_item">
								<p class="pic"><img src="/images/top/pic_01.jpg" alt="必ず記述"></p>
							</div>
							<div class="cont texts_item">
								<h2 class="heading04">見出し2</h2>
								<p class="text">だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="part">
							<div class="cont texts">
								<div class="btn_wrap center">
									<a href="/" class="button icon_arrow_right"><span>料金プランはこちら</span></a>
								</div>
							</div>
						</div>
					</div>
				</section>
				<section id="top_movie_area" class="area">
					<div class="hgroup">
						<h2 class="heading02">紹介ムービー</h2>
					</div>
					<div class="box">
						<div class="part">
							<div class="cont youtube_wrap">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/Yo3HcmElXrA&t" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="part">
							<div class="cont youtube_wrap">
								<iframe width="560" height="315" src="https://www.youtube.com/embed/Hm-FRUvwz_s" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>