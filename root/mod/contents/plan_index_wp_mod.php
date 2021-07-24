<?php
/**--------------------------------------------------------------
 *
 * plan_index_wp_mod
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	setting

	/* wp */
	// admin_page

##	base

##	data

##	wp

	/* post */
	$arr = [];
	if( have_posts() ) {
		the_post();
		// id
		$this_post_id                                      = $post->ID;
		// dete
		$arr[ 'modified_date' ]                            = get_the_modified_date( 'Y-m-d', $this_post_id );
		// acf
		$arr[ 'title_sub' ]                                = get_field( 'title_sub', $this_post_id );
		// acr : loop
		$arr[ 'plans' ]                                     = wp_oo_acf_loop( get_field( 'plans', $this_post_id ) );
		foreach( $arr[ 'plans' ] as $k => $v ) {
			$arr[ 'plans' ][ $k ][ 'caption' ]           = wp_oo_acf_textarea( $v[ 'caption' ] );
			$arr[ 'plans' ][ $k ][ 'coution' ]           = wp_oo_acf_textarea( $v[ 'coution' ] );
			$temp_include_arr                            = $v[ 'include' ] ?? [] ;
			foreach( $temp_include_arr as $kt => $vt ) {
				$arr[ 'plans' ][ $k ][ 'include' ][ $kt ][ 'content' ]   =  wp_oo_acf_textarea( $vt[ 'content' ] );
			}
			$temp_image_arr                              = $v[ 'plan_image' ] ?? [] ;
			foreach( $temp_image_arr as $kk => $vv){
				$arr[ 'plans' ][ $k ][ 'plan_image' ][ $kk ]         = $vv[ 'pic' ][ 'url' ] ?? '';
			}
		}
		$arr[ 'plans_other' ]                                     = wp_oo_acf_loop( get_field( 'plans_other', $this_post_id ) );
		foreach( $arr[ 'plans_other' ] as $k => $v ) {
			$arr[ 'plans_other' ][ $k ][ 'caption' ]           = wp_oo_acf_textarea( $v[ 'caption' ] );
			$arr[ 'plans_other' ][ $k ][ 'coution' ]           = wp_oo_acf_textarea( $v[ 'coution' ] );
			$temp_party_contents_arr                            = $v[ 'party_contents' ] ?? [] ;
			foreach( $temp_party_contents_arr as $kp => $vp ) {
				$arr[ 'plans' ][ $k ][ 'party_contents' ][ $kp ][ 'content' ]   =  wp_oo_acf_textarea( $vp[ 'content' ] );
			}
			$temp_image_arr                              = $v[ 'plan_image' ] ?? [] ;
			foreach( $temp_image_arr as $kk => $vv){
				$arr[ 'plans_other' ][ $k ][ 'plan_image' ][ $kk ]         = $vv[ 'pic' ][ 'url' ] ?? '';
			}
		}
	}
	$wp_page_array = $arr;