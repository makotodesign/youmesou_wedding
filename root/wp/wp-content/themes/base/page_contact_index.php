<?php
/*--------------------------------------------------------------------------

	Template Name: page_contact_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'お問い合わせ・お申し込み';
	$DIRNAME             = 'お問い合わせ';
	define( 'DIRCODE',  'contact' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* form */
	// setting
	$fpath_thanks        = '/contact/thanks/';
	$form_id             = 'contact_form';
	// core
	include_once ROOTREALPATH . '/mod/lib/form.class.php';
	$FS = new formset( $fpath_thanks, $form_id );

	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>' . "\n";
	$HEAD->js .= "\t" . '<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>' . "\n";
	if( RECAPTCHA_V3_SITEKEY && $FS->is_confirm() ) {
		$tag  = '';
		$tag .= "\t" . '<script src="https://www.google.com/recaptcha/api.js?render=' . RECAPTCHA_V3_SITEKEY . '"></script>' . "\n";
		$tag .= "\t" . '<script>' . "\n";
		$tag .= "\t\t" . 'grecaptcha.ready(function() {' . "\n";
		$tag .= "\t\t\t" . 'grecaptcha.execute("' . RECAPTCHA_V3_SITEKEY . '", {action:"contact"}).then( function(token) {' . "\n";
		$tag .= "\t\t\t\t" . 'console.log(token);' . "\n";
		$tag .= "\t\t\t\t" . '$("#my_token").val(token);' . "\n";
		$tag .= "\t\t\t" . '});' . "\n";
		$tag .= "\t\t" . '});' . "\n";
		$tag .= "\t" . '</script>' . "\n";
		$HEAD->js .=  $tag;
	}
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		//'/' . DIRCODE . '/' => $DIRNAME,
		'current'       => $PAGENAME
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
				<div class="area">
<?php	if( $FS->is_form() ) : ?>
					<div class="box">
						<div class="part step_part">
							<div class="step_cont current">
								<p class="step_step">1</p>
								<p class="step_text">項目入力</p>
							</div>
							<div class="step_cont">
								<p class="step_step">2</p>
								<p class="step_text">内容確認</p>
							</div>
							<div class="step_cont">
								<p class="step_step">3</p>
								<p class="step_text">送信完了</p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<p>お問い合わせ・お申し込みは下記フォームよりご連絡ください。<br>追ってご連絡いたしますのでよろしくお願いいたします。</p>
								<p><a href="/contact/privacy/">個人情報保護方針</a></p>
							</div>
						</div>
					</div>
<?php	elseif( $FS->is_confirm() ) : ?>
					<div class="box">
						<div class="part step_part">
							<div class="step_cont">
								<p class="step_step">1</p>
								<p class="step_text">項目入力</p>
							</div>
							<div class="step_cont current">
								<p class="step_step">2</p>
								<p class="step_text">内容確認</p>
							</div>
							<div class="step_cont">
								<p class="step_step">3</p>
								<p class="step_text">送信完了</p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<p class="text">入力内容をご確認いただき、よろしければ送信ボタンをクリックしてください。</p>
							</div>
						</div>
					</div>
<?php	endif; ?>
					<div class="box">
						<div class="part form_set01">
							<form id="<?= $FS->form_id ?>" method="post"<?= $FS->form_action ?><?= $FS->res_enctype() ?> class="cont">
								<div class="form_input_set">
									<div class="form_fieldset">
										<div class="form_legend">
											<p>内容</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap" ><?= $FS->res( 'radio', 'user', 'お問い合わせ,お申し込み', [
												'handle_name'       => 'handle_user'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>お名前<?= $FS->must( 'name' ); ?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'name', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>メールアドレス<?= $FS->must( 'email' ); ?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'email', 'email', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>電話番号</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'tel', 'tel', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>メッセージ</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'textarea', 'message', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>規約<?= $FS->must( 'kiyaku' ); ?></p>
										</div>
										<div class="form_input">
											<p class="input_checkbox_wrap"><?= $FS->res( 'checkbox', 'kiyaku', '規約に同意する', [
													'must'              => 'must'
											] ) ?></p>
										</div>
									</div>
								</div>
								<div class="form_submit_set">
<?php	if( RECAPTCHA_V3_SITEKEY && $FS->is_confirm() ) : ?>
									<input type="hidden" name="recaptcha_response" id="my_token">
									<input type="hidden" name="action" value="contact">
<?php	endif; ?>
									<div class="form_buttons"><?= $FS->submit() ?></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
