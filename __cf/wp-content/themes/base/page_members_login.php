<?php
/*--------------------------------------------------------------------------

	Template Name: page_members_login

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'ログイン';
	$DIRNAME             = '会員ページ';
	define( 'DIRCODE',  'members' );
	define( 'PAGECODE', 'login' );

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* members_login */
	include_once ROOTREALPATH . '/mod/contents/wp_login.class.php';
	$WPOO_LOGIN = new wp_oo_login( 'login_mode', array( 1, 2 ) ); // $arg01 = login_mode( ログインページ ) || loggedin_mode( ログイン後 ) || disp_self_mode( ログイン判定のみ ), $arg02 = arr:限定ユーザーID
	$WPOO_LOGIN->login_check_redirect( PUBLICDIR . '/members/' );

	/* contents_module */

/*---------------------------------------------------------------------------*/
?>
					<div class="box">
						<div class="part">
<?php
	if( $WPOO_LOGIN->status === 'not_login' ){
?>
							<div class="cont">
								<form id="login_form" method="post" action="<?= wp_login_url( get_permalink() ) ?>">
									<div class="form_input_set">
										<div class="form_fieldset">
											<div class="form_legend">
												<p><span class="login"><label for="log">ログインID<span class="must">＊</span></label></span></p>
											</div>
											<div class="form_input">
												<p><input type="text" id="log" name="log" class="input_text" value=""></p>
											</div>
										</div>
										<div class="form_fieldset">
											<div class="form_legend">
												<p><span class="pass"><label for="pwd">パスワード<span class="must">＊</span></label></span></p>
											</div>
											<div class="form_input">
												<p><input type="password" id="pwd" name="pwd" class="input_text" value=""></p>
											</div>
										</div>
									</div>
									<div class="form_buttons form_submit_set">
										<button type="submit" id="login" value="" class="submit_send button"><span>ログイン</span></button>
									</div>
								</form>
							</div>
<?php
		if( $WPOO_LOGIN->login_failed ){
?>
							<div class="cont texts">
								<p class="caution">ログインIDまたはパスワードが間違っています。</p>
							</div>
<?php
		}
	} elseif( $WPOO_LOGIN->status === 'loggedin_other_account' ){
?>
							<div class="cont texts">
								<p>ログインしていますが、現在のアカウントではアクセスできません。<br>ログアウトの上、閲覧権限のあるアカウントで再ログインしてください。</p>
							</div>
							<div class="cont">
								<a href="<?= wp_logout_url( PUBLICDIR . '/members/login/' ) ?>" class="button"><span>ログアウト</span></a>
							</div>
<?php
	}
?>
						</div>
					</div>
