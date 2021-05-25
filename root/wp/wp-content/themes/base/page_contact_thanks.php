<?php
/*--------------------------------------------------------------------------

	Template Name: page_contact_thanks

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'お問い合せ送信完了';
	$DIRNAME             = 'お問い合せ';
	define( 'DIRCODE',  'contact' );
	define( 'PAGECODE', 'thanks' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* form_setting */
	include_once ROOTREALPATH . '/mod/lib/form.class.php';
	$SENDMAIL = new send_form_mail( ROOTREALPATH . '/mod/form_config/contact_config.php' );

	/* reCAPTCHA */
	if( RECAPTCHA_V3_SITEKEY && RECAPTCHA_V3_SECRETKEY ) {
		$POST_token       = $_POST[ 'recaptcha_response' ] ?? NULL;
		$POST_action      = $_POST[ 'action' ] ?? NULL;
		$recaptcha_result = null;
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify' );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( [
			'secret'   => RECAPTCHA_V3_SECRETKEY,
			'response' => $POST_token
		 ] ) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$api_response = curl_exec( $ch );
		curl_close( $ch );
		$recaptcha_result = json_decode( $api_response );
		$result_status = null;
		if ( $recaptcha_result->success && $recaptcha_result->action === $POST_action && $recaptcha_result->score >= 0.5 ) {
			$result_status = true;
		} else {
			$result_status = false;
		}
		if( ! $result_status ) {
			die( 'ロボットによる不正な送信と判定し、処理をストップしました' );
		}
	}

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		DIRCODE .'/' => $DIRNAME,
		'current'       => $PAGENAME
	];

	$HEAD->google_fonts_text = [
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<p class="title_text"><?= $DIRNAME ?></p>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
					<div class="box">
						<div class="part step_part">
							<div class="step_cont">
								<p class="step_step">1</p>
								<p class="step_text">項目入力</p>
							</div>
							<div class="step_cont">
								<p class="step_step">2</p>
								<p class="step_text">内容確認</p>
							</div>
							<div class="step_cont current">
								<p class="step_step">3</p>
								<p class="step_text">送信完了</p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<p><?php $SENDMAIL->disp_message(); ?></p>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
