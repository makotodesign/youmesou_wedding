<?php
/*--------------------------------------------------------------

	sitemap_index_xml

	@memo

---------------------------------------------------------------*/

	ini_set( 'display_errors', 1 );
	error_reporting(E_ALL);

##	base

	header( 'Content-Type:text/xml; charset=utf-8' );
	$dir = 'sitemaps/';

##	file_list

	$file_list = [];
	$base_url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER['REQUEST_URI'];
	$base_url = str_replace( 'sitemap_index.php', '', $base_url );

	if( is_dir( $dir ) ) {
		if ( $dir_handle = opendir( $dir ) ) {
			while ( ( $file = readdir( $dir_handle ) ) !== false ) {
				if( filetype( $dir . $file ) === 'file' )
				$file_list[] = $file;
			}
			closedir( $dir_handle );
		}
	}

##	tag

	$tag = '';
	$tb  = "";
	 $tag .= $tb . "" . '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$tag .= $tb . "" . '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	foreach( $file_list as  $v ) {
		$tag .= $tb . "\t" . '<sitemap>' . "\n";
		$tag .= $tb . "\t\t" . '<loc>' . $base_url . $dir . $v . '</loc>' . "\n";
		$tag .= $tb . "\t\t" . '<lastmod>' . date( 'Y-m-d\TH:i:s+09:00', filemtime( './' . $dir . $v ) ) . '</lastmod>' . "\n";
		$tag .= $tb . "\t" . '</sitemap>' . "\n";
	}
	$tag .= $tb . "" . '</sitemapindex>' . "\n";
	echo $tag;