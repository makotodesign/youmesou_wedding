<?php
/*--------------------------------------------------------------------------

	Template Name: page_xxx_yyy_csvdownload

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ページ名';
	$DIRNAME             = 'ディレクトリ';
	define( 'DIRCODE',  'xxx' );
	define( 'PAGECODE', 'yyy' );
	// add "_csvdownload"

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_csvdownload_wp_mod.php';

/*---------------------------------------------------------------------------*/
