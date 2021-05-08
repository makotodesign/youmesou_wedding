<?php
/*--------------------------------------------------------------------------

	page_xxx_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */

	/* ajax_check_mode */
	// urlに「?ajax=off」を記述するとチェックモードが表示されます。
	$ajax_check_mode = ( isset( $_GET[ 'ajax' ] ) && $_GET[ 'ajax' ] === 'off' ) ? true : false;
$ajax_check_mode = true;

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/xx_index_mod.php';
	if( isset( $ajax_check_mode ) && $ajax_check_mode ) {
		include_once ROOTREALPATH . '/mod/contents/xx_index_ajax_wp_mod.php';
	}

	/* js */
	$HEAD->js = '';
	$HEAD->js  .= ( isset( $ajax_check_mode ) && $ajax_check_mode ) ? '' : '<script id="ajax_script" src="/js/' . DIRCODE . '/ajax.js"></script>' . "\n";

/*---------------------------------------------------------------------------*/
?>
					<div class="box">
						<div id="xx_index_filter_part" class="part">
							<form class="cont">
								<div class="form_input_set">
									<div class="form_fieldset">
										<div class="form_legend">
											<p>filter_zz</p>
										</div>
										<div class="form_input">
											<p id="filter_zz_set" class="input_checkbox_wrap checkbox_vertical">
<?php
	/* master : filter_cont */
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t\t\t\t\t";

	for( $i = 0; $i < 3; $i++ ) {
		$tag .= $tb . "" . '<input type="checkbox" id="filter_zz_a" name="filter_zz[]" value="あ" class="input_check"><label for="filter_zz_a" class="check_label">A</label>' . "\n";
	}
	echo $tag;
?>
											</p>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div id="xx_index_status_part" class="part">
							<p class="text"><?= '※ 該当○○ 999件中 1～20件を表示' ?></p>
						</div>
					</div>
					<div id="xx_index_ajax_target_set" class="box">
						<div id="xx_index_ajax_loader" class="part">
							<p><img src="/images/lib/loader/loader01.gif" alt="しばらくお待ちください"></p>
						</div>
						<div id="xx_index_ajax_main_part" class="part">
<?php
	/* ajax : main_cont */
	// コーディング用
	$tag = '';
	$tb = "\t\t\t\t\t\t\t";

	$tag .= $tb . "" . '<div class="list_cont">' . "\n";
	for( $i = 0; $i < 10; $i++ ) {
		$tag .= $tb . "\t" . '<p class="object_fit"><a href="/xx/single_yy/"><img src="/images/xx/index_yy.jpg" alt="YY"></a></p>' . "\n";
		$tag .= $tb . "\t" . '<p class="text">TEXT</p>' . "\n";
	}
	$tag .= $tb . "" . '</div>' . "\n";

	echo $tag;

	// ajax_check_mode
	if( isset( $ajax_check_mode ) && $ajax_check_mode ) echo $json_arr[ 'tag_main_cont' ];
?>
						</div>
						<div class="part">
							<nav id="xx_index_pager" class="pager_cont">
<?php
	/* ajax : pager */
	// コーディング用
	$tag = '';
	$tb = "\t\t\t\t\t\t\t\t";

	$tag .= $tb . "" . '<ul">' . "\n";
	for( $i = 0; $i < 10; $i++ ) {
		$tag .= $tb . "\t" . '<li><a class="page-numbers"><span>&lt;</span></a></li>' . "\n";
		$tag .= $tb . "\t" . '<li><span class="page-numbers current"><span>1</span></span></li>' . "\n";
		$tag .= $tb . "\t" . '<li><span class="page-numbers dots">&hellip;</span></li>' . "\n";
		$tag .= $tb . "\t" . '<li><a class="page-numbers"><span>2</span></a></li>' . "\n";
		$tag .= $tb . "\t" . '<li><a class="page-numbers"><span>3</span></a></li>' . "\n";
		$tag .= $tb . "\t" . '<li><span class="page-numbers dots">&hellip;</span></li>' . "\n";
		$tag .= $tb . "\t" . '<li><a class="page-numbers"><span>99</span></a></li>' . "\n";
		$tag .= $tb . "\t" . '<li><a class="page-numbers"><span>&gt;</span></a></li>' . "\n";
	}
	$tag .= $tb . "" . '</ul>' . "\n";
	echo $tag;

	// ajax_check_mode
	if( isset( $ajax_check_mode ) && $ajax_check_mode ) echo $json_arr[ 'pager' ];
?>
							</nav>
						</div>
					</div>
