<?php
/*--------------------------------------------------------------------------

	Template Name: csv_download

	@memo

---------------------------------------------------------------------------*/
?>
						<div class="box">
							<div class="part form_set02">
<?php
	if( '' ){
?>
								<form id="password_check_form" method="post" action="/00_stock/mod/action/***.php">
									<div class="form_submit_set">
										<div class="form_buttons">
											<input type="submit" id="submit_check" value="　CSVダウンロード　" class="submit_send button bc_original" data-role="button" data-theme="a">
										</div>
									</div>
								</form>
<?php
	} else {
?>
								<form id="password_check_form" method="post" action="">
									<div class="form_input_set">
										<div class="form_fieldset">
											<div class="form_legend">
												<p>ID</p>
											</div>
											<div class="form_input">
												<p><span class="input_cover_start"></span><input type="text" id="password_check_form_id" name="id" class="input_text size_l" value=""></p>
											</div>
										</div>
										<div class="form_fieldset">
											<div class="form_legend">
												<p>パスワード</p>
											</div>
											<div class="form_input">
												<p><span class="input_cover_start"></span><input type="password" id="password_check_form_password" name="password" class="input_text size_l" value=""></p>
											</div>
										</div>
									</div>
									<div class="form_submit_set">
										<div class="form_buttons">
											<input type="submit" id="password_check_form_submit_check" value="　ログイン　" class="submit_send button bc_original" data-role="button" data-theme="a">
										</div>
									</div>
								</form>
<?php
	}
?>
							</div>
						</div>
