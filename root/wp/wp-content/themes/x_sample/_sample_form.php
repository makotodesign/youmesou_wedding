<?php
/*--------------------------------------------------------------------------

	Template Name: page_sample_form

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = 'サンプルフォーム';
	$DIRNAME             = 'ディレクトリ';
	define( 'DIRCODE',  'sample' );
	define( 'PAGECODE', 'form' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* form
		リファレンス
	*/
	// setting
	$fpath_thanks        = '/sample/thanks/';
	$form_id             = 'sample_form';
	// core
	include_once ROOTREALPATH . '/mod/lib/form.class.php';
	$FS = new formset( $fpath_thanks, $form_id, "\t\t\t\t"); // fpath_thanks、formのidを22、23行目で上書きした場合記述。
	// option
	$FS->no_confirm                         = false;                                 // true : 確認画面を経由せずに完了画面へ遷移
	$FS->def_confirm_error_mesasge          = '※ こちらは必須項目となっております'; // 確認画面でのエラーメッセージ
	$FS->def_submit_value_form_to_confirm   = ' 入力内容の確認画面へ ';            // 入力画面での送信ボタン名
	$FS->def_submit_value_confirm_to_thanks = ' 上記の内容で送信 ';                // 確認画面での送信ボタン名
	$FS->def_submit_value_return            = ' 入力画面に戻る ';                  // 確認画面での戻るボタン名
	$FS->def_submit_value_no_confirm        = ' 上記の内容で送信 ';                // 確認画面省略時の 入力画面での送信ボタン名
	$FS->is_sendfile                        = true;                                  // 添付ファイル送信機能のオン（true）オフ（false）
	$FS->file_type_check                    = 'image';                               // 'image' もしくは カンマ区切りの拡張子

	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>' . "\n";
	$HEAD->js .= "\t" . '<script src="' . PUBLICDIR . '/js/lib/jquery.validate.js"></script>' . "\n";
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/contact/script_max.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
	//	DIRCODE .'/' => $DIRNAME
	];

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
					<div class="hgroup">
						<h2 class="heading02"><?= $PAGENAME ?></h2>
					</div>
					<div class="box">
						<h3 class="heading03">pc-sp用 メールフォーム＆確認画面</h3>
						<div class="part">
<?php	if( $FS->is_form() ) : ?>
							<p>送信画面テキスト</p>
<?php	elseif( $FS->is_confirm() ) : ?>
							<p>確認画面テキスト</p>
<?php	endif;?>
						</div>
						<div class="part">
<?php
/******* reference *********************************************************************************

	[ form ]

	//30行目$FS = new formset();
	$FS = new formset( $fpath_thanks, $form_id, "\t\t\t\t");
	fpath_thanks、formのidを22、23行目で上書きした場合記述。
	第三引数はインデントタブの数を上書き指定。

******************************************************************************************************/
?>
							<form id="<?= $FS->form_id;?>" method="post" action="<?= $FS->form_action ?>"<?= $FS->res_enctype() ?> class="cont">
								<div class="form_input_set">
<?php
/******* reference *********************************************************************************

	[ input / select ]

	// type : text, textarea, email, tel, date, number
	$FS->res( $type, $id, $must, $option )
		$type				*必須(str)
		$id					*必須(str)
			補足 *以下共通
				・id属性は   $form_id . '_' . $id
				・name属性は 'form_' . $id
		$must 				*省略可           ※ 必須の場合:'must'
		$option             *省略可           ※ 下記参照

	// type : radio, checkbox, select
	$FS->res( $type, $id, $elements, $option )
		$type				*必須('radio')
		$id					*必須(str)
		$elements			*必須(str)        ※ カンマ区切りの要素
		$option             *省略可           ※ 下記参照

	// type : pref 都道府県SELECT
	$FS->res( 'pref', $id, $must, $option )
		$type				*必須('pref')
		$id					*必須(str)
		$option             *省略可           ※下記参照

	// type : hidden
	$FS->res( 'hidden', $id, $val, $option )
		$type				*必須('hidden')
		$id					*必須(str)
		$val				*省略可           def:'text_hide'

	// type : file
	$FS->res( 'file', $id, $must )
		$type				*必須('hidden')
		$id					*必須(str)
		$must 				*省略可           ※ 必須の場合:'must'

	-------------------

		*radio / checkbox / select / hidden のpラッパー

			p.input_radio_wrap
			p.input_radio_wrap.radio_vertical_pc
			p.input_checkbox_wrap
			p.input_checkbox_wrap.radio_vertical_pc

			スマホで適切なラップ
			PCで縦積みにする場合

		radio / checkbox / select / hidden のpラッパー

			p.hidden_text

			入力画面での上下パディング

******************************************************************************************************/
?>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>テキスト</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'textid', '', [
												'add_class'         => 'size_m',              //（例）'size_m size_s size_ss other' ※ inputに付与するclass スペース区切り
												'placeholder'       => '',                    //（例）'入力ヒントの表示' ※ ie10以上動作
												'default_value'     => ''                     //（例）'value初期値' ※ $_SESSION 優先
												// * 最後のカンマは省く
											] ) ?></p>
<?php if( $FS->is_form() ) : // 送信画面 ?>?>
											<p class="form_caption caption">*注釈記載</p>
<?php endif;?>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>メール</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'email', 'email', '', [
												// email はフォームにひとつだけ使用可 *確認用メールなどは 'text' で作成
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>電話</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'tel', 'telid', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>日付</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'date', 'dateid', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>数値</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'number', 'numberid', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>テキストエリア</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'textarea', 'textareaid', '', [
												'add_class'         => 'size_m',              //（例）'size_m size_s size_ss other' ※ inputに付与するclass
												'placeholder'       => '入力ヒント'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ラジオボタン</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap"><?= $FS->res( 'radio', 'radioid', '要素01,要素02', [
												'checked_num'       => 2,                     // ※ 初期チェックされている番号数値[1-99]
												'elements_value'    => 'element01,element02', // 要素を他のvalue値で扱いたい場合
												'handle_name'       => '',                    //（例）'handle_user' ※ 表示切替JS用ハンドルclass
												'sync'              => 0,                     //（例）3 ※ syncの開始番号（離れたのradioとnameを共有する場合に使用）
												'add_attr_data'     => ''                     //（例）'data-ppp="PPP" data-rrr="RRR"' ※追記するデータ属性
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>チェックボックス</p>
										</div>
										<div class="form_input">
											<p class="input_checkbox_wrap"><?= $FS->res( 'checkbox', 'checkboxid', '要素01,要素02', [
												'checked_num'       => 2,                     // ※ 初期チェックされている番号数値[1-99]
												'elements_value'    => 'element01,element02', // 要素を他のvalue値で扱いたい場合
												'add_attr_data'     => '',                    //（例）'data-ppp="PPP" data-rrr="RRR"' ※追記するデータ属性
												'must'              => ''                     //（例）'must'
												] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>セレクト</p>
										</div>
										<div class="form_input">
											<p class="input_select_wrap"><?= $FS->res( 'select', 'selectid', '要素01,要素02', [
												'selected_num'      => 2,                     // ※ 初期チェックされている番号数値[1-99]
												'elements_value'    => 'element01,element02', //要素を他のvalue値で扱いたい場合
												'add_attr_data'     => '',                    //（例）'data-ppp="PPP" data-rrr="RRR"' ※追記するデータ属性
												'element_first'     => '',                    //（例）'選択してください' ※初期値 value は空
												'must'              => ''                     //（例）'must' ※セレクトを必須にする場合
												// * 最後のカンマは除く
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>HIDDEN</p>
										</div>
										<div class="form_input">
										<p class="hidden_text"><?= 'HIDDEN値' ?></p>
											<p><?= $FS->res( 'hidden', 'hiddenid', 'HIDDEN値' ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ファイル</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'file', 'file01id' ) ?></p>
											<p><?= $FS->res( 'file', 'file02id' ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>県名</p>
										</div>
										<div class="form_input">
											<p class="input_select_wrap"><?= $FS->res( 'pref', 'prefid' ) ?></p>
										</div>
									</div>
<?php
/******* reference *********************************************************************************

	[ must ]
	※ この「must」は必須マークの記述とスマホのエラー文表示位置指定を行う
	$FS->must( $id, $str )
		$id					*必須(str) ※ 必須項目のid
	$FS->res( $type, $id, $must );
		$must = 'must'      : 必須
		$must = ''          : 必須設定しない場合 ※ 省略した場合を含む

******************************************************************************************************/
?>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>必須テキスト<?= $FS->must( 'textmustid' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'textmustid', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>必須テキスト変更<?= $FS->must( 'textmustid02', '必須テキスト' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'textmustid02', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>必須ダミー<span class="must">*</span></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'textmustid03', '', [
											] ) ?></p>
										</div>
									</div>
<?php
/******* reference *********************************************************************************

	[ res_switch_code ]
	※ この「res_switch_code」は表示非表示切り替えのform_fieldsetに割り当てるclass
	※ 切り替えを行うradioが必要
	$FS->res_switch_code( $handle_name, '2', 'hide' );
		$handle_name                  *必須(str)    ※ 切替ハンドルの名称
		$handle_num                   *必須(int)    ※ 表示する際のハンドル番号
		$init_status                  *必須(int)    ※ 初期表示 : 'show', 初期非表示 : 'hide'
		$duplication_attr_style_check *オプション    ※ 複数のres_switch_codeを同じ箇所に記述する場合に使用
			start   : 一つ目の使用
			inherit : 途中の使用
			end     : 最後の使用 *通常（$this->duplication_attr_style = false）に戻す
			※ この場合 start, inherit の deta_target 属性に handle_name が付与される
	// radio
	オプションに'handle'指定 ハンドル名は上記と同じ
	$FS->res( 'radio', $id, 'element01,element02', [ 'handle' => handle_name ] );

******************************************************************************************************/
?>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ハンドル</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap"><?= $FS->res( 'radio', 'radiohandleid', '要素01,要素02', [
												'checked_num'       => 2,
												'handle_name'       => 'handle_xxx'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset"<?= $FS->res_switch_code( 'handle_xxx', '2', 'hide' );?>>
										<div class="form_legend">
											<p>要素01の時表示（初期非表示）</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'target01id', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset"<?= $FS->res_switch_code( 'handle_xxx', '1', 'show' );?>>
										<div class="form_legend">
											<p>要素02の時表示（初期表示）</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'target02id', '', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset"<?=
										$FS->res_switch_code( 'handle_xxx', '1', 'show', 'start' );
										$FS->res_switch_code( 'handle_yyy', '2', 'hide', 'inherit' );
										$FS->res_switch_code( 'handle_zzz', '1', 'show', 'end' );
									?>>
										<div class="form_legend">
											<p>複数の条件がある場合</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'target02id', '', [
											] ) ?></p>
										</div>
									</div>
<?php
/******* reference *********************************************************************************

	頻出する記述例

******************************************************************************************************/
?>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>お客様種別</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap"><?= $FS->res( 'radio', 'user', '法人,個人', [
												'checked_num'       => 2,
												'handle_name'       => 'handle_user'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset"<?= $FS->res_switch_code( 'handle_user', '2', 'hide' );?>>
										<div class="form_legend">
											<p>会社名<?= $FS->must( 'company' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'company', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset"<?= $FS->res_switch_code( 'handle_user', '1', 'show' );?>>
										<div class="form_legend">
											<p>お名前<?= $FS->must( 'name' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'name', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>お名前 sep2<?= $FS->must( 'name01' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'name01', 'must', [
												'add_class'         => 'size_m',
												'placeholder'       => '姓：'
											] ) ?></p>
											<p><?= $FS->res( 'text', 'name02', 'must', [
												'add_class'         => 'size_m',
												'placeholder'       => ' 名：'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>メールアドレス<?= $FS->must( 'email' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'email', 'email', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>メールアドレス(確認用)<?= $FS->must( 'email_again' );?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'email_again', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>電話番号<?= $FS->must( 'tel' ) ?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'tel', 'tel', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>電話番号_sep3<?= $FS->must( 'tel01' ) ?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'tel', 'tel01', 'must', [
												'add_class'         => 'size_s'
											] ) ?> - <?= $FS->res( 'tel', 'tel02', 'must', [
												'add_class'         => 'size_s'
											] ) ?> - <?= $FS->res( 'tel', 'tel03', 'must', [
												'add_class'         => 'size_s'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ご住所<?= $FS->must( 'address' );?></p>
										</div>
										<div class="form_input">
											<p>〒 <?= $FS->res( 'text', 'zip', 'must', [
												'add_class'         => 'size_m'
											] ) ?></p>
											<p><?= $FS->res( 'text', 'address', 'must', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ご住所 sep<?= $FS->must( 'address01' );?></p>
										</div>
										<div class="form_input">
											<p>〒 <?= $FS->res( 'text', 'zip01', 'must', [
												'add_class'         => 'size_s'
											] ) ?> <?= $FS->res( 'text', 'zip02', 'must', [
												'add_class'         => 'size_s'
											] ) ?></p>
											<p class="input_select_wrap"><?= $FS->res( 'pref', 'pref' );?></p>
											<p><?= $FS->res( 'text', 'address01', 'must', [
													'placeholder'       => '住所01 市区町村'
											] ) ?></p>
											<p><?= $FS->res( 'text', 'address02', '', [
													'placeholder'       => '住所02 番地・マンション名'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>RADIO 横並び</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap"><?= $FS->res( 'radio', 'radio_horizon', 'あ,い,う', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>RADIO 縦積み</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'radio', 'radio_vertical', 'あ,い,う', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>CHECKBOXO 縦積み</p>
										</div>
										<div class="form_input">
											<p class="input_checkbox_wrap checkbox_vertical_pc"><?= $FS->res( 'checkbox', 'checkbox_vertical', 'あ,い,う', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>SELECT</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'select', 'select', 'AAA,BBB,CCC', [
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
											<p>規約<?= $FS->must( 'kiyaku' );?></p>
										</div>
										<div class="form_input">
											<p class="input_checkbox_wrap"><?= $FS->res( 'checkbox', 'kiyaku', '規約に同意する', '', [
												'must' => 'must'
											] ) ?></p>
										</div>
									</div>
<?php
/******* reference *********************************************************************************

	[ submit ]
	$FS->submit( $class_send, $class_back )
		$class_send			*略可(str)			def:''
		$class_back			*略可(str)			def:'bc0' ※ 確認画面でもどるボタンのクラス

******************************************************************************************************/
?>
								</div>
								<div class="form_submit_set">
									<div class="form_buttons"><?= $FS->submit();?></div>
								</div>
							</form>
						</div>
					</section>
				</div>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php';?>
