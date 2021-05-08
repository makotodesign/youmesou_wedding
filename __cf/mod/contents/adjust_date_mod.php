<?php
/*--------------------------------------------------------------------------

	adjust_date_mod

	@memo

---------------------------------------------------------------------------*/

##	setting

	// クリニック開院
	$yyyy_clinic_open   = 1959;
	$mmdd_clinic_open   = 1001;

	// 院長就任
	$yyyy_doctor_start  = 1999;
	$mmdd_doctor_start  = 0601;

	// 和暦
	$yyyy_wareki_adjust = 1988;

##	tag

	// 開院からの年数（次に迎える年数）
	$yy_duration_clinic = date_oo( 'Y' ) - $yyyy_clinic_open + ( ( date_oo( 'md' ) < $mmdd_clinic_open ) ? 1 : 2 );

	// 院長就任からの年数
	$yy_duration_doctor = date_oo( 'Y' ) - $yyyy_doctor_start + ( ( date_oo( 'md' ) < $mmdd_doctor_start ) ? 0 : 1 );

	// 和暦表記
	$yy_wareki          = date_oo( 'Y' ) - $yyyy_wareki_adjust;
?>