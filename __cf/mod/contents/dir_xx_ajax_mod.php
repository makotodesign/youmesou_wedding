<?php
/*--------------------------------------------------------------

	products_index_mod

	@memo

---------------------------------------------------------------*/

##	base

	/* includes */
	// master : fillter
	include_once ROOTREALPATH . '/mod/master/master_xxx_fillter.php'; // $master_fillter_field_arr, $master_fillter_field_price_arr

##	tag

	/* func : fillter_list */
	function disp_fillter_list( $cat, $set_name ) {
		global $master_fillter_field_arr,$separate;
		$tag = '';
		$tb = ( $separate ) ? "\t\t\t\t\t\t\t\t\t\t" : "\t\t\t\t\t\t\t\t\t";
		$arr = ( isset( $master_fillter_field_arr[ $cat ][ $set_name ] ) && $master_fillter_field_arr[ $cat ][ $set_name ] ) ? $master_fillter_field_arr[ $cat ][ $set_name ] : [];
		foreach( $arr as $k => $v ) {
			$tag .= $tb . "\t" . '<input type="checkbox" id="fillter_' . $set_name . '_' . $k . '" name="fillter_' . $set_name . '[]" value="' . $k . '" class="input_check"><label for="fillter_' . $set_name . '_' . $k . '" class="check_label">' . $v . '</label>' . "\n";
		}
		return $tag;
	}
?>