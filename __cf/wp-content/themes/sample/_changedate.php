<?php
/*--------------------------------------------------------------------------

	Template Name: php_changedate

	@memo

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME = 'changedate';
	$DIRNAME = 'PHPデモ';
	define( 'DIRCODE', 'phpdemo' );
	define( 'PAGECODE', 'changedate' );

	/* realpath & includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
//	include_once ROOTREALPATH . '/00_stock/mod/contents/sample_php_changedate_mod.php';

	/* css */
	$HEAD->css = '';

	/* JS */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option ( over write ) : title / meta / h1 / og_cullent_img */
	$HEAD->title = '';
	$HEAD->meta_description = '';
	$HEAD->back_navi_url = '/';

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/data/includes/header_mod.php';

/*---------------------------------------------------------------------------*/
?>
<?php
/*--------------------------------------------------------------

	name

	@memo

---------------------------------------------------------------*/

##	base

	/* path */
	$CD_class_fpath  = '/mod/lib/changedate.class.php'; // 日付変換_CD

	/* class */
	// CD
	include_once ROOTREALPATH . $CD_class_fpath;
	$CD = new change_date( 'yyyy年yy年YY年Y年mm月m月MM月M月dd日d日(ww)(w)(W)' );

/*---------------------------------------------------------

 指定形式　※サンプルは「2008年7月6日」
	yyyy = 2008;
	yy   = 08;
	YY   = 平成20;
	Y    = H20;
	mm   = 07;
	m    = 7;
	MM   = July;
	M    = Jul;
	dd   = 06;
	d    = 6;
	ww   = Friday;
	w    = Fri;
	W    = 金

---------------------------------------------------------------*/

##	tag

	/* 名称 */

	$str ="1999年08/13日";

?>
	<div class="title_wrap">
		<div class="title">
			<h1>change_date</h1>
		</div>
	</div>
	<div class="contents_wrap">
		<div class="contents">
			<div class="side_contents">
				<nav>
					<div class="side_area side_navi_area">
						<ul class="list_trans" data-role="listview">
							<li><a href="/00_stock/sample/php_db.demo.php">DB</a></li>
							<li><a href="/00_stock/sample/php_calendar.demo.php">CALENDAR</a></li>
							<li><a href="/00_stock/sample/php_csvparse.demo.php">CSVPARSE</a></li>
							<li><a href="/00_stock/sample/php_resizeimg.demo.php">RESIZEIMG</a></li>
							<li><a href="/00_stock/sample/php_changedate.demo.php">CHANGEDATE</a></li>
						</ul>
					</div>
				</nav>
			</div><!--side_contents-->
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents main_contents">
				<div class="area">
					<section>
						<div class="box">
							<div class="part texts">
								<p><?= $CD->res_date( '08年9月12日' ) ?></p>
								<p><?= $CD->res_date( date_oo( 'Y/m/d' ) ); //現在 ?></p>
								<p><?= $CD->res_date( $str ) ?></p>
								<p><?php $CD2 = new change_date( 'YY年MM月d日(ww)' );echo $CD2->res_date( $str );?></p>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
<?php	include_once ROOTREALPATH . "/data/includes/footer_mod.php";?>