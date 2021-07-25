<?php
/*--------------------------------------------------------------------------

	Template Name: page_member_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'メンバー紹介';
	$DIRNAME             = 'メンバー紹介';
	define( 'DIRCODE',  'member' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

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
	$arr = $wp_page_array[ 'members' ]; 
/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
<?php 	if( $wp_page_array[ 'title_sub' ] ) : ?>
				<p class="title_text_sub"><?=  $wp_page_array[ 'title_sub' ] ?></p>
<?php 	endif;?>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
<?php foreach( $arr as  $v ) : ?>
					<div class="box">
						<div class="part texts_image_pc texts_image_tb float_right_sp">
							<div class="cont image_item">
								<p class="object_fit"><img src="<?= $v[ 'logo' ] ?>" alt="<?= $v[ 'name' ] ?>"></p>
							</div>
							<div class="cont texts_item">
								<p class="badge"><?= $v[ 'genre' ] ?></p>
								<h2 class="heading04 title"><?= $v[ 'name' ] ?></h4>
								<div class="entry_wrap">
									<?= $v[ 'comment' ] ?>
								</div>
<?php if(  $v[ 'url' ] ) : ?>
								<p class="link_arrow link_external"><a href="<?= $v[ 'url' ] ?>/" target="_blank"><?= $v[ 'url' ] ?></a></p>
<?php endif; ?>
							</div>
						</div>
					</div>
<?php endforeach; ?>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
