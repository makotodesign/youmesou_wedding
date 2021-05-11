<?php
/*--------------------------------------------------------------------------

	archive-news

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'お知らせ一覧';
	$DIRNAME             = 'お知らせ';
	define( 'DIRCODE',  'news' );
	define( 'PAGECODE', 'archive' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = $wp_archive_title;
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		'current'       => $wp_archive_title
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $wp_archive_title ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents main_side">
				<section class="area main_area">
					<div class="box">
						<div class="part news_archive">
<?php	foreach( $wp_posts_array as  $v ) : ?>
							<div class="cont news_wrap">
								<p class="news_date"><time datetime="<?= $v[ 'post_date_code' ] ?>"><?= $v[ 'post_date' ] ?></time></p>
								<div class="news_summary">
									<p class="news_title"><?= $v[ 'title' ] ?></p>
								</div>
							</div>
<?php	endforeach; ?>
						</div>
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
