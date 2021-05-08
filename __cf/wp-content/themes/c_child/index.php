<?php
/*--------------------------------------------------------------------------

	home

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'トップページタイトル';
	define( 'DIRCODE',  'top' );

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/top_news_wp_mod.php';

	/* css */
	$HEAD->css = '';

	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option ( over write ) : title / meta / h1 / og_cullent_img */
	$HEAD->title                = $PAGENAME;
	$HEAD->meta_description     = '';

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes' . MULTISITETHEMEDIR . '/parts_header.php';
	$HEAD->modal_flag = false;

/*---------------------------------------------------------------------------*/
?>
		<div class="promo_wrap">
		</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes' . MULTISITETHEMEDIR . '/parts_footer.php';?>