<?php
/**--------------------------------------------------------------
 *
 * wp_news_parts_func
 *
 * @memo
 *
 --------------------------------------------------------------*/

##	func

	/* func : news_parts */
	function res_news_parts( $content, $link_type, $title, $link_set_array ) { // $content : 'add_class' || 'news_title'
		$this_domain = '';
		if( function_exists( 'home_url' ) ) {
			$this_domain = home_url();
		} else {
			$this_domain = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'HTTP_HOST' ];

		}
		switch( $link_type ) {
			case 'type_nolink':
				$href      = '';
				$add_attr  = '';
				$add_class = '';
				break;
			case 'type_url':
				$href      = isset( $link_set_array[ 'url' ] ) ? $link_set_array[ 'url' ] : '';
				$add_attr  = strpos( $href, $this_domain ) ? '' : ' target="_blank"'; // 外部リンク判定
				$add_class = strpos( $href, $this_domain ) ? '' : 'link_external';
				break;
			case 'type_detail':
				$href      = isset( $link_set_array[ 'permalink' ] ) ? $link_set_array[ 'permalink' ] : '';
				$add_attr  = '';
				$add_class = '';
				break;
			case 'type_detail_modal':
				$href      = isset( $link_set_array[ 'modal_target' ] ) ? '#' : '';
				$add_attr  = isset( $link_set_array[ 'modal_target' ] ) ? ' data-target="' . $link_set_array[ 'modal_target' ] . '"' : '';
				$add_class = 'modal_handle';
				break;
			case 'type_detail_openclose':
				$href      = isset( $link_set_array[ 'openclose_target' ] ) ? '#' : '';
				$add_attr  = isset( $link_set_array[ 'openclose_target' ] ) ? ' data-target="' . $link_set_array[ 'openclose_target' ] . '"' : '';
				$add_class = 'openclose_handle plus';
				break;
			case 'type_pdf':
				$href      = isset( $link_set_array[ 'pdf' ] ) ? $link_set_array[ 'pdf' ] : '';
				$add_attr  = ' target="_blank"';
				$add_class = '';
				break;
			default:
				$href      = '';
				$add_attr  = '';
				$add_class = '';
		}
		$href = $href ? ' href="' . $href . '"' : '';
		$fixed_class = $add_class ? ' class="' . $add_class . '"' : '';
		$news_title = ( $href ) ? '<a' . $href . $add_attr . $fixed_class . '>' . $title . '</a>' : $title;
		if( $content === 'title' ) {
			return $news_title;
		} elseif( $content === 'href' ) {
			return $href;
		} elseif( $content === 'add_attr' ) {
			return $add_attr;
		} elseif( $content === 'class' ) {
			return trim( $fixed_class );
		} elseif( $content === 'class_array' ) {
			return $add_class ? explode( ' ', trim( $add_class ) ) : [];
		} elseif( $content === 'all_attr' ) {
			return $href . $add_attr . $fixed_class;
		}
	}
