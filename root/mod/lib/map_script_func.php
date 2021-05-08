<?php
/*--------------------------------------------------------------

	map_script_func

	@memo

---------------------------------------------------------------*/

##	func

	/* func : map_script */
	function map_setting_script( $arr, $type = 'pc' ) {

		$tag = '';
		$tb  = "\t";

		$tag .= $tb . "" . '<script>' . "\n";
		$tag .= $tb . "\t" . 'var mapinfo = [' . "\n";
		for( $i = 0; $i < count( $arr ); $i++ ) {
			$tag .= $tb . "\t\t" . '{' . "\n";
			$tag .= $tb . "\t\t\t" . 'mapID           : "' . $arr[ $i ][ 'map_id' ] . '",' . "\n";
			$tag .= $tb . "\t\t\t" . 'map : {' . "\n";
			$tag .= $tb . "\t\t\t\t" . 'lat          : ' . $arr[ $i ][ 'map' ][ 'lat' ] . ',' . "\n";
			$tag .= $tb . "\t\t\t\t" . 'lng          : ' . $arr[ $i ][ 'map' ][ 'lng' ] . ',' . "\n";
			$tag .= $tb . "\t\t\t\t" . 'zoom         : ' . $arr[ $i ][ 'map' ][ 'zoom' ] . '' . "\n";
			$tag .= $tb . "\t\t\t" . '},' . "\n";
			$tag .= $tb . "\t\t\t" . 'markers : [' . "\n";
			$temp_arr = $arr[ $i ][ 'markers' ];
			for( $j = 0; $j < count( $temp_arr ); $j++ ) {
				$tag .= $tb . "\t\t\t\t" . '{' . "\n";
				$tag .= $tb . "\t\t\t\t\t" . 'title    : "' . $temp_arr[ $j ][ 'title' ] . '",' . "\n";
				$tag .= $tb . "\t\t\t\t\t" . 'address  : "' . $temp_arr[ $j ][ 'address' ] . '",' . "\n";
				$tag .= $tb . "\t\t\t\t\t" . 'open     : ' . $temp_arr[ $j ][ 'open' ] . ',' . "\n";
				$tag .= $tb . "\t\t\t\t\t" . 'lat      : ' . $temp_arr[ $j ][ 'lat' ] . ',' . "\n";
				$tag .= $tb . "\t\t\t\t\t" . 'lng      : ' . $temp_arr[ $j ][ 'lng' ] . ',' . "\n";
				$tag .= $tb . "\t\t\t\t\t" . 'icon : {' . "\n";
				// def_marker
				if( $temp_arr[ $j ][ 'icon' ] === 'def' ) {
					$tag .= $tb . "\t\t\t\t\t\t" . 'use  : false' . "\n";
				// parking
				} else {
					$tag .= $tb . "\t\t\t\t\t\t" . 'use  : true,' . "\n";
					$tag .= $tb . "\t\t\t\t\t\t" . 'url    : "https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png", // parking' . "\n";
					$tag .= $tb . "\t\t\t\t\t\t" . 'size   : {' . "\n";
					$tag .= $tb . "\t\t\t\t\t\t\t" . 'w  : 32,' . "\n";
					$tag .= $tb . "\t\t\t\t\t\t\t" . 'h  : 32' . "\n";
					$tag .= $tb . "\t\t\t\t\t\t" . '}' . "\n";
				}
				$tag .= $tb . "\t\t\t\t\t" . '}' . "\n";
				$tag .= $tb . "\t\t\t\t" . '}';
				$tag .= ( $j === count( $temp_arr ) - 1 ) ? '' : ',';
				$tag .= "\n";
			}
			$tag .= $tb . "\t\t\t" . ']' . "\n";
			$tag .= $tb . "\t\t" . '}';
			$tag .= ( $i === count( $arr ) - 1 ) ? '' : ',';
			$tag .= "\n";
		}
		$tag .= $tb . "\t" . '];' . "\n";
		$tag .= $tb . "" . '</script>' . "\n";

		return $tag;
	}
