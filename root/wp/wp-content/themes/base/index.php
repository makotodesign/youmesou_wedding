<?php
/*--------------------------------------------------------------------------

	home

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '必ず記述';
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
	$HEAD->modal_flag = true;

/*---------------------------------------------------------------------------*/
?>
		<div class="promo_wrap">
			<div id="promo01" class="promo">
				<div class="promo_cont">
					<p class="promo_pic"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
					<div class="promo_info">
						<p class="promo_catch">CATCH01</p>
						<p class="promo_text">だみーぶんしょうですだみーぶんしょうでょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
					</div>
				</div>
			</div>
			<div class="promo_progress">progress</div>
		</div>
		<div class="contents_wrap">
			<div class="top_contents contents">
<?php	if( $wp_top_headnews_array ) : ?>
				<section class="top_headnews_area area">
					<div class="headnews_box box">
						<div class="headnews_part">
<?php		foreach( $wp_top_headnews_array as $v ) : ?>
							<div class="news_wrap">
								<p class="news_date"><time datetime="' . $v[ 'post_date_code' ]. '"><?= $v[ 'post_date' ] ?></time></p>
								<div class="news_summary">
									<p class="news_title"><?= $v[ 'title' ] ?></p>
								</div>
							</div>
<?php		endforeach; ?>
						</div>
<?php		foreach( $wp_top_headnews_array as $v ) : ?>
<?php			if( $v[ 'news_link_type' ] === 'type_detail_modal' ) : ?>
						<div id="headnews_<?= $v[ 'post_id' ] ?>" class="part modal_target">
							<?= $v[ 'detail' ] ?>
						</div>
<?php			endif; ?>
<?php		endforeach; ?>
					</div>
				</section>
<?php	endif; ?>
				<section class="top_xx_area area">
					<div class="hgroup">
						<h2 class="heading_top">みだし</h2>
					</div>
					<div class="box">
						<div class="part">
							<div class="cont texts">
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
				</section>
				<section class="top_news_area area">
					<div class="hgroup">
						<h1 class="heading_top">NEWS</h1>
					</div>
					<div class="box">
						<div class="part news_archive">
<?php	if( $wp_top_normalnews_array ) : ?>
<?php		foreach( $wp_top_normalnews_array as $v ) : ?>
							<div class="cont news_wrap">
								<p class="news_date"><time datetime="<?= $v[ 'post_date_code' ] ?>"><?= $v[ 'post_date' ] ?></time></p>
								<div class="news_summary">
									<p class="news_title"><?= $v[ 'title' ] ?></p>
								</div>
							</div>
<?php		endforeach; ?>
<?php	else : ?>
							<div class="cont texts">
								<p>現在、お知らせございません</p>
							</div>
<?php	endif; ?>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>