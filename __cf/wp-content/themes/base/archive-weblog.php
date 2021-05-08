<?php
/*--------------------------------------------------------------------------

	archive-weblog

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME = '*';
	$DIRNAME = 'ブログ';
	define( 'DIRCODE', 'weblog' );
	define( 'PAGECODE', 'archive' );

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* js */
	$HEAD->js = '';
	$HEAD->js .= '<script src="' . PUBLICDIR . '/js/lib/jquery.autopager.js"></script>' . "\n";
	$HEAD->js .= '<script src="' . PUBLICDIR . '/js/' . DIRCODE . '/script.js"></script>' . "\n";

/*---------------------------------------------------------------------------*/
?>
<?php
	$tag = '';
	$tb  = "\t\t\t\t\t";
	// $arr = $wp_posts_array;

	/* wp : weblog_index_box */
	// weblog_autopage
	if( $max_page > 1 ){
		$tag .= $tb . "\t" . '<nav class="part">' . "\n";
		$tag .= $tb . "\t\t" . '<div class="btn_cont">' . "\n";
		$tag .= $tb . "\t\t\t" . '<p class="autopager_btn"><a href="' . $next_page_link . '" class="button"><span>さらに読み込む</span></a></p>' . "\n";
		$tag .= $tb . "\t\t" . '</div>'."\n";
		$tag .= $tb . "\t" . '</nav>' . "\n";
	}
	$tag .= $tb . "" . '</div>' . "\n";

	echo $tag;
?>
