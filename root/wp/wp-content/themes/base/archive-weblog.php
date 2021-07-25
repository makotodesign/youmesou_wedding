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
	$arr = $wp_posts_array;
/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $wp_archive_title ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents main_side">
				<section class="area">
					<div class="box">
<?php foreach( $arr as  $v ) : ?>
						<a class="part image_texts_grid cover_wrap" href="<?= $v[ 'permalink' ] ?>">
							<div class="cont image_item">
								<p class="object_fit"><img src="<?= $v[ 'eyecatch' ] ?>" alt="<?= $v[ 'post_title' ] ?>"></p>
							</div>
							<div class="cont texts_item texts">
								<p class="date"><?= $v[ 'post_date' ] ?></p>
								<p class="title"><?= $v[ 'post_title' ] ?></p>
								<p class="excerpt"><?= $v[ 'post_excerpt' ] ?></p>
							</div>
						</a>
<?php endforeach; ?>
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
