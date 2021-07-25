<?php
/*--------------------------------------------------------------------------

	Template Name: page_plan_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ウェディングプラン';
	$DIRNAME             = '結水荘ウェディングプラン';
	define( 'DIRCODE',  'plan' );
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
<?php 	foreach( $wp_page_array[ 'plans' ] as $v ) : ?>
					<div class="box">
						<h2 class="heading03 title"><?= $v[ 'title' ] ?><span class="price"><?=  tax_adjust( $v[ 'price'] ) ?>円</span><span class="taxword">（<?= TAXWORD ?>）</span></h2>
						<p></p>
						<div class="part image_texts_pc">
							<div class="cont image_item gallery_wrap">
								<div class="pic_main gallery_target">
									<p class="object_fit"><img src="<?= $v[ 'plan_image' ][ 0 ] ?>" alt="<?= $v[ 'title' ] ?>"></p>
								</div>
								<div class="cont clm5_tb_pc snap_sp gallery_handle_set" data-target="gallery_target01">
<?php  		for( $i = 0; $i < count( $v[ 'plan_image' ] ); $i++ ) : ?>
<?php  			if( $i === 0 ) : ?>
									<a class="clm_item current">
<?php  			else : ?>
									<a class="clm_item">
<?php  			endif; ?>
										<p class="object_fit"><img src="<?= $v[ 'plan_image' ][ $i ] ?>" alt="<?= $v[ 'title' ] ?>"></p>
									</a>
<?php   	endfor;?>
								</div>
								<div class="part snap_dots"><span class="current"></span><span></span><span></span><span></span><span></span></div>
							</div>
							<div class="cont texts_item texts">
<?php  		if( $v[ 'caption' ] ) : ?>
								<p class="caption"><?= $v[ 'caption' ] ?></p>
<?php 		endif; ?>
<?php  		if( $v[ 'include' ] ) : ?>
								<p class="badge"><span>含まれるもの</span></p>
								<ul>
<?php  			foreach( $v[ 'include' ] as  $vv ) : ?>
									<li><?= $vv[ 'content' ] ?></li>
<?php  			endforeach; ?>
								</ul>
<?php  		if( $v[ 'coution' ] ) : ?>
								<p><?= $v[ 'coution' ] ?></p>
<?php 		endif; ?>
							</div>
<?php  		endif; ?>
						</div>
					</div>
<?php 	endforeach ;?>
<?php 	foreach( $wp_page_array[ 'plans_other' ] as $v ) : ?>
					<div class="box">
						<h2 class="heading03 title"><?= $v[ 'title' ] ?></h2>
						<div class="part image_texts_pc">
							<div class="cont image_item gallery_wrap">
								<div class="pic_main gallery_target">
									<p class="object_fit"><img src="<?= $v[ 'plan_image' ][ 0 ] ?>" alt="<?= $v[ 'title' ] ?>"></p>
								</div>
								<div class="cont clm5_tb_pc snap_sp gallery_handle_set" data-target="gallery_target01">
<?php  		for( $i = 0; $i < count( $v[ 'plan_image' ] ); $i++ ) : ?>
<?php  			if( $i === 0 ) : ?>
									<a class="clm_item current">
<?php  			else : ?>
									<a class="clm_item">
<?php  			endif; ?>
										<p class="object_fit"><img src="<?= $v[ 'plan_image' ][ $i ] ?>" alt="<?= $v[ 'title' ] ?>"></p>
									</a>
<?php   	endfor;?>
								</div>
								<div class="part snap_dots"><span class="current"></span><span></span><span></span><span></span><span></span></div>
							</div>
							<div class="cont texts_item texts">
<?php  		if( $v[ 'caption' ] ) : ?>
								<p class="caption"><?= $v[ 'caption' ] ?></p>
<?php 		endif; ?>
<?php  		if( $v[ 'party_contents' ] ) : ?>
								<p class="badge"><span>内容</span></p>
								<ul>
<?php  			foreach( $v[ 'party_contents' ] as  $vv ) : ?>
									<li><?= $vv[ 'content' ] ?></li>
<?php  			endforeach; ?>
								</ul>
<?php  			if( $v[ 'coution' ] ) : ?>
								<p><?= $v[ 'coution' ] ?></p>
<?php 			endif; ?>
							</div>
<?php  		endif; ?>
						</div>
					</div>
<?php 	endforeach ;?>
					<div class="box">
						<div class="part">
							<div class="cont texts">
								<div class="btn_wrap center">
									<a href="/contact/" class="button icon_arrow_right"><span>お問い合わせ・申し込み</span></a>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
