<?php
/*--------------------------------------------------------------------------

	Template Name: easylogin

	@memo
		2016-02-04 cording_template で表示

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME = '簡易ログイン';
	$DIRNAME = 'PHPデモ';
	define( 'DIRCODE', 'phpdemo' );
	define( 'PAGECODE', 'easylogin' );

	/* realpath & includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/contents/xx_easylogin_mod.php';

	/* css */
	$HEAD->css = '';

	/* js */
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

	<div class="title_wrap">
		<div class="title">
			<h1><img src="/images/common/title/title_default.jpg" alt="<?= $PAGENAME ?>"></h1>
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
							<li><a href="/00_stock/sample/php_easylogin.demo.php">EASYLOGIN</a></li>
						</ul>
					</div>
				</nav>
			</div><!--side_contents-->
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents main_contents">
				<section class="area">
					<div class="hgroup">
						<h2 class="heading02">簡易ログインデモ</h2>
					</div>
<?php
/******* login *******/
	if( $easy_login === false ) {
?>
						<div class="box">
							<div class="part texts">
								<p>内容をご覧いただくにあたり、パスワードを入力しログインしてください。</p>
<?= $tag_password_error_message ?>
							</div>
							<div class="part form_set02">
								<form id="login_form" method="post" action="">
									<input type="password" id="password" name="form_password" class="input_text size_l" value="">
									<input type="submit" id="submit_login" value=" ログイン " class="submit_send button bc_original btn_small" data-theme="b">
								</form>
							</div>
						</div>
<?php
	} else { // for_login
?>
						<div class="box">
							<div class="part texts">
								<p>ログインが完了しました。</p>
							</div>
						</div>
<?php
	}
/******* login_end *******/
?>
				</section>
			</div>
		</div>
	</div>
<?php	include_once ROOTREALPATH . "/data/includes/footer_mod.php";?>