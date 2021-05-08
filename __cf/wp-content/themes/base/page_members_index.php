<?php
/*--------------------------------------------------------------------------

	Template Name: page_members_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ログイン済';
	$DIRNAME             = '会員ページ';
	define( 'DIRCODE',  'members' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* members_login */
	include_once ROOTREALPATH . '/mod/contents/wp_login.class.php';
	$WPOO_LOGIN = new wp_oo_login( 'loggedin_mode', array( 1, 2 ) ); // loginmode( ログインページ ) || loggedin_mode( ログイン後 ) || disp_self_mode( ログイン判定のみ ), $arg02 = arr:限定ユーザーID配列
	$WPOO_LOGIN->login_check_redirect( PUBLICDIR . '/members/login/' );

	/* contents_module */

/*---------------------------------------------------------------------------*/
?>
					<div class="box">
						<h3 class="heading03">ログイン済</h3>
						<div class="part">
							<div class="cont">
								<p><?= '$WPOO_LOGIN->status' . ':'.var_export( $WPOO_LOGIN->status, true ) ?></p>
								<p><?= '$WPOO_LOGIN->get_user_info()' . ':'.var_export( $WPOO_LOGIN->get_user_info(), true ) ?></p>
							</div>
						</div>
						<div class="part">
							<div class="cont">
								<a href="<?= wp_logout_url( PUBLICDIR . '/members/login/' ) ?>" class="button"><span>ログアウト</span></a>
							</div>
						</div>
					</div>

