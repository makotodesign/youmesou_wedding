<?php
/*--------------------------------------------------------------

	xx_search_wp_mod

	@memo

---------------------------------------------------------------*/

##	setting

##	base

	/* wp : wpdb */
	global $wpdb;

##	data : wp

	/* get_posts */
	$arr = [];
	$i = 0;
	if( have_posts() ) {
		while( have_posts() ) {
			the_post();
			/* wp_elements */
			// id
			$this_post_id                                            = $post->ID;
			// base
			$arr[ $i ][ 'post_id' ]                                  = $this_post_id;
			$arr[ $i ][ 'post_title' ]                               = get_the_title( $this_post_id );
			$arr[ $i ][ 'permalink' ]                                = get_permalink( $this_post_id );
			// dete
			$arr[ $i ][ 'post_date' ]                                = get_the_date( 'Ymd', $this_post_id );
			$arr[ $i ][ 'post_date_code' ]                           = get_the_date( 'Y-m-d', $this_post_id );
			/* add_post_num */
			$i++;
		}
	}

	$wp_posts_array = $arr;

	/* pager */
	global $wp_rewrite;
	global $wp_query;
	$paginate_base = get_pagenum_link( 1 );
	if( strpos( $paginate_base, '?' ) || ! $wp_rewrite->using_permalinks() ) {
		$paginate_format = '';
		$paginate_base   = add_query_arg( 'paged', '%#%' );
	} else {
		$paginate_format = ( substr( $paginate_base, -1, 1 ) == '/' ? '' : '/' ) . user_trailingslashit( 'page/%#%/', 'paged' );
		$paginate_base  .= '%_%';
	}
	$args = array(
		'base'     => $paginate_base,
		'format'   => $paginate_format,
		'total'    => $wp_query->max_num_pages,
		'mid_size' => 5,
		'type'     => 'array',
		'current'  => get_query_var( 'paged', 1 )
	);
	$arr = paginate_links( $args );
    $total_results = $wp_query->found_posts;

	$wp_pager_array = $arr;

##	tag

	/* xx_search_box */
	$tag = '';
	$tb = "\t\t\t\t\t\t";
	$arr = $wp_posts_array;

	$tag .= $tb . "" . '<div id="xxx_search_box" class="box">' . "\n";
	$tag .= $tb . "\t" . '<div class="part">' . "\n";
	if( $arr ) {
		$tag .= $tb . "\t\t" . '<p class="text caution">検索結果 ' . $total_results . '件中 ' . count( $arr ) . '件を表示しております</p>' . "\n";
	} else {
		$tag .= $tb . "\t\t" . '<p class="text caution">該当する検索結果はございません。</p>' . "\n";
	}
	$tag .= $tb . "\t" . '</div>' . "\n";
	if( $arr ) {
		$tag .= $tb . "\t" . '<div class="dissertation_index_search_part">' . "\n";
		for( $i = 0; $i < count( $arr ); $i++ ) {
		}
		$tag .= $tb . "\t" . '</div>' . "\n";
	}
	$tag .= $tb . "" . '</div>' . "\n";

	$tag_xx_search_box = $tag;

	/* pager_box */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t";
	$arr = $wp_pager_array;

	if( $wp_pager_array ) {
		$tag .= $tb . "" . '<div class="box pager">' . "\n";
		$tag .= $tb . "\t" . '<div class="part pager_button pager_bc_original">' . "\n";
		$tag .= $tb . "\t\t" . '<ul>' . "\n";
		if( is_array( $arr ) && $arr ) {
			foreach( $arr as $v ){
				$tag .= $tb . "\t\t\t" . '<li>' . $v . '</li>' . "\n";
			}
		}
		$tag .= $tb . "\t\t" . '</ul>' . "\n";
		$tag .= $tb . "\t" . '</div>' . "\n";
		$tag .= $tb . "" . '</div>' . "\n";
	}

	$tag_pager_box = $tag;

	/* str */
	$str_search_title = '「' . $GET_searchword . '」の検索結果';
