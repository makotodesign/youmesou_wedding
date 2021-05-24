<?php
/**************************************************************************
 *
 * form.class
 * 		メールフォーム作成クラス
 *
 * @package
 * 		send_form_mail
 * 		formset
 * @author
 * 		oldoffice.com
 * @php
 * 		7.4
 * @version
 * 		18.1.1
 *
 * @history
 * 		2008-11-27	送信先設定を「thanks.php」から「form.config.php」に変更
 * 		2008-11-27	複数送信先設定を可能に"CC","BCC"
 * 		2011-03-02	受信時の不具合修正
 * 		2011-03-02	受信時の不具合修正
 * 		2012-10-04	classを send_form_mail に変更
 * 					記述全体変更 [ver4]
 * 		2015-02-17	PHP5対応,confirm機能付加
 * 					記述全体変更 [ver5]
 * 		---
 * 		2015-02-27	確認用クラスを追記 [ver6]
 * 		2015-03-03	サイズ指定クラスなどをスペースなしで引数に記載できるよう変更
 * 		2015-03-04	checkboxtextのテキスト設定を削除 *CSSで対応
 * 		2015-03-04	thanksへのアクションをコンストラクターで設定できるよう変更
 * 					バグ修正（res_handole,selectの引数）
 * 		---
 * 		2015-03-05	セキュリティ強化
 * 					ヌルバイト除去,タグ除去,半角カナ修正 [ver6.2]
 * 		2015-03-09	thanksページリロードに対応 send_form_mail [ver6.3]
 * 		2015-03-09	checkbox,selectにelements_valueを追加 [ver6.3.2]
 * 		2015-03-09	typeにhiddenを追加 [ver6.3.3]
 * 		2015-03-09	must_check_arr のバグ修正 [ver6.3.4]
 * 		2015-03-30	$this->send_comp : メッセージ完了を変数(boolien)に設定 [ver6.3.5]
 * 					※ 送信完了メッセージ表示後1回のみ
 * 		2015-04-01	確認画面から送信画面へ戻る際のデータ保持 [ver.6.4.1]
 * 		2015-04-10	checkbox が空の場合の送信画面データ保持に関する修正 [ver.6.4.2]
 * 		2015-05-14	formのidを引数で変更できるように修正 N [ver.6.4.3]
 * 		2015-07-28  textareaにplaceholderを設定できるように引数を追加 K
 * 		2015-08-25  selectのselected不具合修正 N [ver.6.4.4]
 * 		2015-11-17  is_confirm_error不具合修正 K
 * 					spでの戻るボタンの動作不具合の修正 K [ver.6.4.5]
 * 		2016-07-11  is_pc,is_spのデフォルト値を設定 N 旧テンプレート対応 [ver.6.4.6]
 * 		2016-07-14  type:hiddenのフォームでのテキスト表示切替え機能 N [ver.6.4.7]
 * 		2016-08-04  prefのselected不具合を修正 N [ver.6.4.8]
 * 		2016-08-04  type:hiddenのフォームでのテキスト表示切替え不具合を修正 N [ver.6.4.9]
 * 		2017-01-20  thanksの結果メッセージを値でとれるように変更 N [ver.6.4.10]
 * 		            disp_message( $arg[※略可def:false] )の引数にtrueで値を返す
 * 		2017-07-28  各フォームの内容をタグ化出来るようにreturn関数を追加 N [ver.6.4.11]
 * 		2017-07-28  *_codeの関数を複製でないように作成 N [ver.6.4.12]
 * 					フォーム内のsubmitvalueなどをoverwriteできるように変数追加
 * 		2017-07-28  確認画面を経由せずに完了画面へ遷移できる機能を実装 N [ver.6.4.13]
 * 		2017-09-05  確認画面を経由せずに完了画面へ遷移できる機能を修正 N [ver.6.4.14]
 * 		2018-01-09  ct09にあわせてデフォルトタブを調整 N [ver.6.4.15]
 * 		2018-01-17  idの値がサイト全体で固有になるように設定 N [ver.6.5.1]
 * 		2018-02-02  name属性に再度「form_」付与 N [ver.6.5.2]
 * 		2018-02-19	radio,checkbox のラベル内にspan追記（ct10）[ver.7.1.1]
 * 		2018-02-19	radio,checkbox のhandleクラス名をlabelに転記（ct10）[ver.7.1.2]
 * 		2018-03-14	input type=file に一部対応（確認画面は未実装）[ver.7.1.3]
 * 		---
 * 		2018-03-17	クラスコードを全体見直し [ver.8.1.1]
 * 					1. ファイル添付が行えるように設定
 * 						※ 添付ファイルの形式を選択
 * 						※ 確認画面で添付ファイル=画像は画像確認
 * 					2. メールヘッダーを迷惑メールにならないように記述
 * 					3. 返信メール受け取りの送信元表示をアドレスから名称へ変更
 * 						※ config で設定 * 自動返信メールのみ
 * 					4. 確認画面での送信停止機能エラーを修正
 * 					5. 送信メールの文面追加機能
 * 						※ config で設定 * 送信メールのみ
 * 		2018-03-23	表示切替時の確認画面不具合を修正
 * 					確認からブラウザで戻った時の挙動修正 [ver.8.1.2]
 * 		2018-04-04	エラーの記述位置を変更 [ver.8.1.2]
 * 		2018-05-30
 * 		2018-06-06	ct11にあわせてバージョンふり直し [ver.11.1.1]
 * 					・JavaScript用data属性がradio,selectに記述できるように修正
 * 					・confirm画面でradio/selectのvalueが表示される不具合を修正
 * 					・confirm画面でhideのvalueが表示・非表示に対応されていない不具合を修正
 * 					・JavaScriptで表示非表示を設定した箇所の確認画面での挙動修正
 * 		2018-08-08  PHP7への対応 [ver.12.1.1]
 * 		            ･ res_hidden
 * 		2018-11-09  radio、checkbox、selectでelement_valueが入っていない時の不具合を修正 [ver.12.1.2]
 * 		2018-11-15  radio、checkbox、selectでelement_valueが0や空白の時の不具合を修正
 * 		            hidden 'text_hide'で不要なコード出力を除去
 * 		            hidden 'text_hide'の箇所を再記述 [ver.12.1.3]
 * 		2018-11-09  hidden(text_show) confirm にspan追加 [ver.12.1.4]
 * 		2018-11-09  class付与機能改善, swith_form_confirm関数追加 [ver.12.2.1]
 * 		2018-12-07  is_pcの解除漏れを修正 [ver.12.2.2]
 * 		2019-01-25  送信メールの言語をJapanerse からuni（UTF-8）に変更
 * 		2019-03-01  不正に開かれた場合にconfigを読みにいかないように設定 [ver.13.1.1]
 * 		----------------------
 * 		2019-06-15  formの記述方式を一新
 * 					下位互換を切断[ver.14.1.1]
 * 		2019-07-25	returnmail_to に対する form_config の設定値追加 [ ver 14.2.1 ]
 * 		2019-07-26	2019年現在でメールソフトのエンコードと徹底的に戦う [ ver 14.3.1 ]
 * 		2019-09-05	selectedの番号設定バグを修正 [ ver 14.3.2 ]
 * 		2019-09-05	radioのvalバグを修正 [ ver 14.3.3 ]
 * 		----------------------
 * 		2020-02-20	form送信の仕組みを一新
 * 					UTF-8 で全て送信されるよう Gmailの送信方式を採用
 * 					全ての文字列をbase64に変換して送信[ver.15.1.1]
 * 		----------------------
 * 		2020-04-03	form送信の仕組みを一新
 * 					select を jQuery validate に対応 [ver.16.1.1]
 * 		2020-04-14	form生成時のswitch_disp複数設置時 style 属性を重複させない[ver.16.1.2]
 * 		----------------------
 * 		2021-02-11	$this->POST に値を加える変数追加 [ver.18.1.1]
 * 		2021-02-24	$send_comp 時点で 保持セッション unset  [ver.18.2.1]
 * 		2021-03-16	selected_num がある場合の selected の重複を回避  [ver.18.2.2]
 * 		----------------------
 * 		2021-05-04	ct18 に伴い res出力を設定 [ver.18.1.1]
 * 					must, submit は echo > return
 *
*************************************************************************/

/**------------------------------------------------------
 *
 * send_form_mail
 *
------------------------------------------------------ */

class send_form_mail {

	public  $send_comp;

	private $POST;
	private $post_keys               = [];
	private $act;

	private $sendmail_to;
	private $sendmail_from_email;
	private $sendmail_title;
	private $sendmail_contents;
	private $sendmail_header         = '';
	private $sendmail_body           = '';
	private $sendmail_bcc_bool;
	private $sendmail_bcc_email;

	private $bool_files              = false;
	private $boundary;
	private $server;

	private $ok_message;
	private $error_message;
	public  $no_open_message         = 'このページは不正に開かれました'; // 英語訳 : This page has been opened illegally!
	private $reload_message;

	private $auto_return;
	private $returnmail_to;
	private $returnmail_from_name;
	private $returnmail_from_email;
	private $returnmail_title;
	private $returnmail_contents;
	private $returnmail_header       = '';
	private $returnmail_body         = '';

	### constructor

	function __construct( $config_file_fpath, $POST_add = [] ) {

		/* $_POST取得 */
		$this->POST = ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) ? $_POST : [];
		// sanitize
		$this->POST = OOBASE::sanitize_server_request( $this->POST );

		if( $this->POST && $this->POST[ 'act' ] === 'on' ) {

			// post情報の変数化
			foreach( $this->POST as $k => $v ) {
				// checkbox && no_confirm に対応
				${$k} = ( is_array( $v ) ) ? implode( '/',  $v ) : $v;
				$this->post_keys[] = $k;
			}

			// post情報強制追加
			foreach( $POST_add as $k => $v ) {
				${$k} = $v;
			}

			// 設定ファイル情報
			include_once $config_file_fpath;

			$this->sendmail_to           = isset( $mail_to )               && $mail_to               ? $mail_to               : '';
			$this->sendmail_from_email   = isset( $mail_from )             && $mail_from             ? $mail_from             : '';
			$this->sendmail_title        = isset( $title )                 && $title                 ? $title                 : '';
			$this->sendmail_contents     = isset( $contents )              && $contents              ? $contents              : '';

			$this->sendmail_bcc_bool     = isset( $BCC )                   && $BCC === 'on'          ? true                   : false;
			$this->sendmail_bcc_email    = isset( $BCC_mail_to )           && $BCC_mail_to           ? $BCC_mail_to           : [];

			$this->ok_message            = isset( $ok_message )            && $ok_message            ? $ok_message            : 'Your email has been sent!';    // 日本語訳「メールは送信されました」
			$this->error_message         = isset( $error_message )         && $error_message         ? $error_message         : 'Email not sent.';              // 日本語訳「メールは送信されませんでした」
			$this->no_open_message       = isset( $no_open_message )       && $no_open_message       ? $no_open_message       : $this->no_open_message;
			$this->reload_message        = isset( $reload_message )        && $reload_message        ? $reload_message        : 'Email has already been sent.'; // 日本語訳「すでにメールは送信されています」

			$this->auto_return           = isset( $auto_return )           && $auto_return === 'on'  ? true                   : false;
			$this->returnmail_to         = isset( $returnmail_to )         && $returnmail_to         ? $returnmail_to         : '';
			$this->returnmail_from_email = isset( $returnmail_from )       && $returnmail_from       ? $returnmail_from       : '';
			$this->returnmail_from_name  = isset( $mail_name )             && $mail_name             ? $mail_name             : $this->returnmail_from_email;
			$this->returnmail_title      = isset( $return_title )          && $return_title          ? $return_title          : '';
			$this->returnmail_contents   = isset( $return_contents )       && $return_contents       ? $return_contents       : '';

			// 送信状況
			$this->send_comp = false;

			// boundary & server
			$this->boundary = md5( uniqid( rand() ) );

			// file_check
			if( isset( $_SESSION[ 'files' ] ) ) {
				$this->bool_files =true;
			}
		}
	}

	### public function

	/* 完了画面メッセージ表示（ 1.不正アクセスを判別 > 2.送信 > 3.表示） */

	public function res_message() {

		if( ! isset( $_SESSION[ 'ticket' ], $this->POST[ 'ticket' ] )) {
			$res_message = $this->no_open_message;
		} else {
			// リロードによる再送信停止
			if( isset( $_SESSION[ 'ticket' ], $this->POST[ 'ticket' ] ) && $_SESSION[ 'ticket' ] === $this->POST[ 'ticket' ] ) {
				// session
				unset( $_SESSION[ 'ticket' ] );

				// sendmail
				$this->create_sendmail_header();
				$this->create_sendmail_body();

				// returnmail
				$this->create_returnmail_header();
				$this->create_returnmail_body();

				// 文字コード変換 & メール送信
				mb_language( 'Japanese' ); // utf8
				mb_internal_encoding( 'UTF-8' );
				// 全てをUTF-8変換 *A 200220 西
				// メールのタイトルはOutlookなど対応が遅れているソフトがあるため「ISO-2022-JP」に変換。機種依存文字などはは使用できない。*A 190726 西
				//mb_encode_mimeheader( $this->sendmail_title, 'ISO-2022-JP' );
				if( mb_send_mail( $this->sendmail_to, $this->sendmail_title, $this->sendmail_body, $this->sendmail_header ) ) {
					$res_message = $this->ok_message;
					$this->send_comp = true;
					foreach( $this->post_keys as  $v ) {
						unset( $_SESSION[ $v ] );
					}
					if( $this->auto_return == "on" ) {
						// 上記*Aと同様
						//mb_encode_mimeheader( $this->returnmail_title, 'ISO-2022-JP' );
						mb_send_mail( $this->returnmail_to, $this->returnmail_title, $this->returnmail_body, $this->returnmail_header );
					}
				} else {
					$res_message = $this->error_message;
				}
			} else {
				$res_message = $this->reload_message;
			}
		}
		return $res_message;
	}

	public function disp_message() {
		echo $this->res_message();
	}

	### private function

	private function create_sendmail_header() {

		$this->sendmail_header = '';

//		送信メールヘッダー仕様
//		1. メール送信元表示 = メールアドレス
//		2. 送信エラーの通知 = あり
//
		$this->sendmail_header .= 'Return-Path: ' . $this->sendmail_from_email . "\r\n";
		$this->sendmail_header .= 'From: ' . $this->sendmail_from_email . "\r\n";
		$this->sendmail_header .= 'Reply-To: ' . $this->sendmail_from_email . "\r\n";
		if( $this->sendmail_bcc_bool ) {
			for( $i = 0; $i < count( $this->sendmail_bcc_email ); $i++ ) {
				$this->sendmail_header .= 'Bcc: ' . $this->sendmail_bcc_email[ $i ] .  "\r\n";
			}
		}
		$this->sendmail_header .= 'MIME-Version: 1.0' . "\r\n";
		$this->sendmail_header .= 'Content-Type: multipart/alternative; boundary="' . $this->boundary . '"' . "\r\n";
		// 2020-02-20 ファイル部分に関しては保留 西
		/*
		if( $this->bool_files ) {
			$this->sendmail_header .= 'Content-Type: multipart/mixed;boundary="' . $this->boundary . '"' .  "\r\n";
			$this->sendmail_header .= 'X-Mailer: PHP/'. phpversion() .  "\r\n";
		}
		*/
	}

	private function create_sendmail_body() {

		$this->sendmail_body = '';
		// text_message
		$this->sendmail_body .= '--' . $this->boundary . "\r\n";
		$this->sendmail_body .= 'Content-Type: text/html; charset="UTF-8"' . "\r\n";
		$this->sendmail_body .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$this->sendmail_body .=  "\r\n";
		$this->sendmail_body .= base64_encode( nl2br( $this->sendmail_contents ) ) . "\r\n";
		$this->sendmail_body .= '--' . $this->boundary . "\r\n";
		$this->sendmail_body .= 'Content-Type: text/html; charset="UTF-8"' . "\r\n";
		$this->sendmail_body .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$this->sendmail_body .=  "\r\n";
		$this->sendmail_body .= base64_encode( nl2br( $this->sendmail_contents ) ) . "\r\n";
		$this->sendmail_body .= '--' . $this->boundary . '--' . "\r\n";
		/*
		// 2020-02-20 ファイル部分に関しては保留 西
		if( $this->bool_files ) {
			// tmp_file
			foreach( $_SESSION[ 'files' ] as $k => $v ) {
				$this->sendmail_body .= 'Content-Type: application/octet-stream; name="' . mb_encode_mimeheader( $v[ 'name' ], 'ISO-2022-JP-MS' ) . '"' .  "\r\n";
				$this->sendmail_body .= 'Content-Disposition: attachment; filename="' . mb_encode_mimeheader( $v[ 'name' ], 'ISO-2022-JP-MS' ) . '"' .  "\r\n";
				$this->sendmail_body .= 'Content-Transfer-Encoding: base64' .  "\r\n";
				$this->sendmail_body .= '' .  "\r\n";
				$this->sendmail_body .=  $v[ 'file' ] .  "\r\n";
				$this->sendmail_body .= '--' . $this->boundary .  "\r\n";
			}
			$_SESSION[ 'files' ] = [];
		}
		*/
	}

	private function create_returnmail_header() {

		$this->returnmail_header = '';
		$this->returnmail_header .= 'Return-Path: ' . $this->returnmail_from_email .  "\r\n";
		// 上記*Aと同様
		$this->returnmail_header .= 'From: ' . mb_encode_mimeheader( $this->returnmail_from_name, 'UTF-8' ) . '<' . $this->returnmail_from_email . '>' .  "\r\n";
		$this->returnmail_header .= 'Reply-To: ' . $this->returnmail_from_email .  "\r\n";
		$this->returnmail_header .= 'Organization: ' . mb_encode_mimeheader( $this->returnmail_from_name, 'UTF-8' ) .  "\r\n";
		$this->returnmail_header .= 'Content-Type: multipart/alternative; boundary="' . $this->boundary . '"' .  "\r\n";
	}

	private function create_returnmail_body() {

		$this->returnmail_body = '';
		// text_message
		$this->returnmail_body .= '--' . $this->boundary . "\r\n";
		$this->returnmail_body .= 'Content-Type: text/html; charset="UTF-8"' . "\r\n";
		$this->returnmail_body .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$this->returnmail_body .=  "\r\n";
		$this->returnmail_body .= base64_encode( nl2br( $this->returnmail_contents ) ) . "\r\n";
		$this->returnmail_body .= '--' . $this->boundary . "\r\n";
		$this->returnmail_body .= 'Content-Type: text/html; charset="UTF-8"' . "\r\n";
		$this->returnmail_body .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$this->returnmail_body .=  "\r\n";
		$this->returnmail_body .= base64_encode( nl2br( $this->returnmail_contents ) ) . "\r\n";
		$this->returnmail_body .= '--' . $this->boundary . '--' . "\r\n";
	}
}

/**------------------------------------------------------
 *
 * formset
 *
------------------------------------------------------ */

class formset {

	public $debug_report;

	public $tb;
	public $step;
	public $form_id;
	public $form_action;
	public $form_enctype;
	public $POST                               = [];
	public $FILES                              = [];
	public $session;
	public $direct_target_value;
	public $must_check_array                   = [];

	public $no_confirm                         = false; // true : 確認画面を経由せずに完了画面へ遷移
	public $is_sendfile                        = false; // true : ファイル送信機能

	public $def_confirm_error_mesasge          = ' 必須項目が入力されていません ';
	public $def_submit_value_form_to_confirm   = ' 入力内容の確認画面へ ';
	public $def_submit_value_confirm_to_thanks = ' 上記の内容で送信 ';
	public $def_submit_value_return            = ' 入力画面に戻る ';
	public $def_submit_value_no_confirm        = ' 上記の内容で送信 ';

	public $file_max_size                      = 5000;
	public $file_type_check                    = false;

	private $fpath_thanks;
	private $def_class_size_arr = [
		'l'  => 'size_l',
		'm'  => 'size_m',
		's'  => 'size_s',
		'ss' => 'size_ss'
	];
	private $check_type_arr = [
		'text',
		'textarea',
		'email',
		'tel',
		'date',
		'number',
		'radio',
		'checkbox',
		'select',
		'pref',
		'hidden',
		'file'
	];
	// radio_sync
	private $radio_sync = [];
	private $file_error = [];
	private $duplication_attr_style = false;

	### constructor

	function __construct( $fpath_thanks = 'thanks/', $arg_form_id = 'contact_form', $tb = "\t\t\t\t\t\t\t\t\t" ) {

		// def
		$this->step         = 'step_form';
		$this->form_id      = $arg_form_id;
		$this->form_action  = '';
		$this->fpath_thanks = $fpath_thanks;
		$this->form_enctype = '';

		// post
		if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
			$this->POST = $_POST;
			// sanitize
			$this->POST = OOBASE::sanitize_server_request( $this->POST );
		}

		// session
		if( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
			if( isset( $_SESSION ) ) {
				$this->session = array_merge( $_SESSION, $this->POST ); // post優先
			} else {
				$this->session = $this->POST;
			}
			$_SESSION = $this->session;
		}

		// confirm
		if( isset( $this->POST[ 'step' ] ) && $this->POST[ 'step' ] == 'step_confirm' ) {
			$this->step        = 'step_confirm';
			$this->form_id     = 'confirm_form';
			$this->form_action = ' action="' . $this->fpath_thanks . '"';
		}
		// def tb
		$this->tb = $tb;
	}

	### public function

	/* action / enctype */

	public function res_action() {
		if( $this->no_confirm ) {
			$this->form_action = ' action="' . $this->fpath_thanks . '"';
		}
		return $this->form_action;
	}

	public function disp_action() {
		echo $this->res_action();
	}

	public function res_enctype() {
		if( $this->is_sendfile ) {
			$this->form_enctype = ' enctype="multipart/form-data"';
		}
		return $this->form_enctype;
	}

	public function disp_enctype() {
		echo $this->res_action();
	}

	/* form要素 */

	public function res ( $type, $id, $arg01 = '', $arg02 = '', $arg03 = '' ) {
		switch( $type ) {
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
			case 'date':
				return $this->res_input_text(     $type, $id, $arg01, $arg02 );
				break;
			case 'textarea':
				return $this->res_textarea(       $type, $id, $arg01, $arg02 );
				break;
			case 'radio':
				return $this->res_input_radio(    $type, $id, $arg01, $arg02 );
				break;
			case 'checkbox':
				return $this->res_input_checkbox( $type, $id, $arg01, $arg02, $arg03 );
				break;
			case 'select':
				return $this->res_select(         $type, $id, $arg01, $arg02, $arg03 );
				break;
			case 'pref':
				return $this->res_pref(           $type, $id, $arg01, $arg02 );
				break;
			case 'hidden':
				return $this->res_hidden(         $type, $id, $arg01, $arg02 );
				break;
			case 'file':
				return $this->res_input_file(     $type, $id, $arg01, $arg02 );
				break;
			default:
				return 'type error';
		}
	}

	public function disp ( $type, $id, $arg01 = '', $arg02 = '', $arg03 = '' ) {
		echo $this->res ( $type, $id, $arg01, $arg02, $arg03 );
	}

	/* form submit */

	public function submit ( $class_send = '', $class_back = 'bc0' ) {
		$tag = "\n";
		$tb = $this->tb;
		$back_link = 'javascript:history.back();';
		$tag_back   = $tb . "\t" . '<a href="' . $back_link . '" id="submit_back" class="submit_back button' . self::add_space( $class_back ) . '"><span>' . $this->def_submit_value_return . '</span></a>' . "\n";
		$tag_submit = $tb . "\t" . '<button type="submit" id="submit_thanks" class="submit_send button' . self::add_space( $class_send ) . '"><span>' . $this->def_submit_value_confirm_to_thanks . '</span></button>' . "\n";
		// 確認画面エラー
		if( $this->is_confirm_error() ) {
			$tag .= $tag_back;
		} elseif( $this->no_confirm || $this->is_confirm() ) {
			$_SESSION[ 'ticket' ] = md5( uniqid() . mt_rand() );
			$tag .= $tb . "\t" . '<input type="hidden" id="ticket" name="ticket" value="' . htmlspecialchars( $_SESSION[ 'ticket' ], ENT_QUOTES ) . '">' . "\n";
			$tag .= $tb . "\t" . '<input type="hidden" id="act" name="act" value="on">' . "\n";
			$tag .= $tag_submit . $tag_back;
		} elseif( $this->is_form() ) {
			$tag .= $tb . "\t" . '<input type="hidden" name="step" value="step_confirm">' . "\n";
			$tag .= $tb . "\t" . '<button type="submit" id="submit_confirm" class="submit_send button' . self::add_space( $class_send ) . '"><span>' . $this->def_submit_value_form_to_confirm . '</span></button>' . "\n";
			if( $this->no_confirm ) {
			}
		}
		return $tag . $tb;
	}

	/* 必須表記 */

	public function must( $id, $str = '＊' ) {
		$tag = '<span id="' . $this->form_id . '_' . $id . '_must" class="must">' . $str . '</span>';
		return $tag;
	}

	public function disp_must( $id, $str = '＊' ) {
		echo $this->must( $id, $str );
	}

	/* 表示・非表示切換（ターゲット） */

	public function res_switch_code( $handle_name, $handle_num, $init_disp = 'show', $duplication_attr_style_check = 'nocheck' ) {
		$attr = $handle_name . '_' . sprintf( '%02d', $handle_num );
		$add_attr_data_target = '';
		if( isset( $_SESSION[ 'form_' . $handle_name ] ) ) {
			$init_disp_css = ( $attr === $_SESSION[ 'form_' . $handle_name ] ) ? '' : ' style="display:none;"';
		} else {
			$init_disp_css = ( $init_disp === 'hide' ) ? ' style="display:none;"' : '';
		}
		// switch_res_code を同一箇所に複数使用した際にstyleの重複を防ぐ
		/*
			start : 一つ目の使用
			inherit : 途中の使用
			end : 最後の使用 *通常（$this->duplication_attr_style = false）に戻す
		*/
		if( $duplication_attr_style_check === 'start' ) {
			if( $init_disp_css ) {
				$this->duplication_attr_style = true;
			}
			$add_attr_data_target = '_' . $handle_name;
		} elseif( $duplication_attr_style_check === 'inherit' ) {
			$init_disp_css = ( $this->duplication_attr_style ) ? '' : $init_disp_css;
			if( $init_disp_css ) {
				$this->duplication_attr_style = true;
			}
			$add_attr_data_target = '_' . $handle_name;
		} elseif( $duplication_attr_style_check === 'end' ) {
			$init_disp_css = ( $this->duplication_attr_style ) ? '' : $init_disp_css;
			$this->duplication_attr_style = false;
		}
		$tag =' data-target' . $add_attr_data_target . '="' . $attr . '"' . $init_disp_css;
		return $tag;
	}

	public function disp_switch_code( $handle_name, $handle_num, $init_disp = 'show', $duplication_attr_style_check = false ) {
		echo $this->res_switch_code( $handle_name, $handle_num, $init_disp, $duplication_attr_style_check );
	}

	/* 表示・非表示切換（直指定ハンドル-クラス）※ラジオ以外 */

	public function switch_handle_add_class_code( $handle_name, $handle_num, $class_on = 'current', $class_off = '', $current = false ) {
		$str = $handle_name . '_' . sprintf( '%02d', $handle_num );
		if( isset( $_SESSION[ $handle_name ] ) && $_SESSION[ $handle_name ] ) {
			if( $_SESSION[ $handle_name ] == $str ) {
				$tag = self::add_space( $str ) . self::add_space( $class_on );
				$this->direct_target_value = $str;
			} else {
				$tag = self::add_space( $str ) . self::add_space( $class_off );
			}
		} else {
			if( $current ) {
				$tag = self::add_space( $str ) . self::add_space( $class_on );
				$this->direct_target_value = $str;
			} else {
				$tag = self::add_space( $str ) . self::add_space( $class_off );
			}
		}
		if( ! $this->direct_target_value ) {
			$this->direct_target_value = $_SESSION[ $handle_name ];
		}
		return $tag;
	}

	public function switch_handle_add_class( $handle_name, $handle_num, $class_on = 'current', $class_off = '', $current = false ) {
		echo $this->switch_handle_add_class_code( $handle_name, $handle_num, $class_on, $class_off, $current );
	}

	/* 状態判定 */
	// 初期フォーム
	public function is_form() {
		if( $this->step == 'step_form' ) {
			return true;
		} else {
			return false;
		}
	}

	// 確認画面
	public function is_confirm() {
		if( $this->step == 'step_confirm' ) {
			return true;
		} else {
			return false;
		}
	}

	// 確認画面エラー
	public function is_confirm_error() {
		if( $this->step == 'step_confirm' ) {
			$temp_res = false;
			$arr = $this->must_check_array;
			for( $i = 0; $i < count( $arr ); $i++ ) {
				if( ! isset( $this->POST[ 'form_' . $arr[ $i ] ] ) || $this->POST[ 'form_' . $arr[ $i ] ] == '' ) {
					$temp_res = true;
					break;
				}
			}
		// 画像チェック
		} elseif( count( $this->file_error ) > 0 ) {
			$temp_res = true;
		} else {
			$temp_res =  false;
		}
		return $temp_res;
	}

	// 初期フォーム/確認画面切り替え
	public function swith_form_cornfirm( $str_form, $str_confirm ) {
		if( $this->step == 'step_confirm' ) {
			return $str_confirm;
		} else {
			return $str_form;
		}
	}

	### tag_form_elements

	// text, email, tel, date, number
	private function res_input_text( $type, $id, $must, $setting ) {

		$add_class      = isset( $setting[ 'add_class' ] )     ? $setting[ 'add_class' ]      : '';
		$input_cover    = isset( $setting[ 'input_cover' ] )   ? $setting[ 'input_cover' ]    : '';
		$checked_num    = isset( $setting[ 'checked_num' ] )   ? $setting[ 'checked_num' ]    : '';
		$confirm_cover  = isset( $setting[ 'confirm_cover' ] ) ? $setting[ 'confirm_cover' ]  : '';
		$placeholder    = isset( $setting[ 'placeholder' ] )   ? $setting[ 'placeholder' ]    : '';
		$default_value  = isset( $setting[ 'default_value' ] ) ? $setting[ 'default_value' ]  : '';
		$attr_min       = isset( $setting[ 'min' ] )           ? $setting[ 'min' ]            : '';
		$attr_max       = isset( $setting[ 'max' ] )           ? $setting[ 'max' ]            : '';

		$add_datepicker_class = '';
		$add_attr_min = '';
		$add_attr_max = '';
		$res_type = 'text';
		if( $type == 'text' ) {
			$res_type = 'text';
		} elseif( $type == 'email' ) {
			$res_type = 'text';
		} elseif( $type == 'tel' ) {
			$res_type = 'tel';
		} elseif( $type == 'date' ) {
			$res_type = 'date';
			$add_datepicker_class = ' datepicker';
			$add_attr_min = $attr_min ? ' min="' . $attr_min . '"' : '';
			$add_attr_max = $attr_max ? ' max="' . $attr_max . '"' : '';
		} elseif( $type == 'number' ) {
			$res_type = 'number';
		}
		$id            = ( $type == 'email' ) ? 'email' : $id ;
		$add_class     = ( $add_class ) ? self::add_space( $add_class ) : '';
		$placeholder   = ( $placeholder ) ? ' placeholder="' . $placeholder . '"' : '' ;
		$default_value = ( ( $default_value ) && ! self::session_val( 'form_' . $id ) ) ? $default_value : self::session_val( 'form_' . $id ) ;

		if( $this->step == 'step_form' ) {
			$tag = '<input type="' . $res_type . '" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" class="input_text' . $add_class . $add_datepicker_class . '" value="' . $default_value . '"' . $placeholder . $add_attr_min . $add_attr_max . '>';
			$tag = ( $input_cover ) ? self::cover_tag( $tag, $input_cover ) : $tag;
		} elseif( $this->step == 'step_confirm' ) {
			$temp_post = isset( $this->POST[ 'form_' . $id ] ) ? $this->POST[ 'form_' . $id ] : '';
			$tag = $this->confirm_tag( $id, $temp_post, $must );
			$confirm_cover = ( $confirm_cover ) ? $confirm_cover : $input_cover;
			$tag = ( $confirm_cover ) ? self::cover_tag( $tag, $confirm_cover ) : $tag;
		}
		$this->must_arr_push( $id, $must );
		return $tag;
	}

	// textarea
	private function res_textarea( $type, $id, $must, $setting ) {

		$add_class      = isset( $setting[ 'add_class' ] )      ? $setting[ 'add_class' ]      : '';
		$placeholder    = isset( $setting[ 'placeholder' ] )    ? $setting[ 'placeholder' ]    : '';

		$add_class  = ( $add_class ) ? self::add_space( $add_class ) : '';
		$placeholder = ( $placeholder ) ? ' placeholder="' . $placeholder . '"' : '' ;

		if( $this->step == 'step_form' ) {
			$tag = '<textarea id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" class="textarea' . $add_class . '"' . $placeholder . '>' . self::session_val( 'form_' . $id ) . '</textarea>';
		} elseif( $this->step == 'step_confirm' ) {
			$temp_post = isset( $this->POST[ 'form_' . $id ] ) ? $this->POST[ 'form_' . $id ] : '';
			$tag = '<span>' . nl2br( $temp_post, false ) . '</span>' . $this->confirm_tag( $id, $temp_post, $must, 'hidden' );
		}
		$this->must_arr_push( $id, $must );
		return $tag;
	}

	// radio
	private function res_input_radio( $type, $id, $elements, $setting ) {

		$checked_num    = isset( $setting[ 'checked_num' ] )    ? $setting[ 'checked_num' ]    : '';
		$handle_name    = isset( $setting[ 'handle_name' ] )    ? $setting[ 'handle_name' ]    : '';
		$elements_value = isset( $setting[ 'elements_value' ] ) ? $setting[ 'elements_value' ] : '';
		$sync           = isset( $setting[ 'sync' ] )           ? $setting[ 'sync' ]           : '';
		$add_attr_data  = isset( $setting[ 'add_attr_data' ] )  ? $setting[ 'add_attr_data' ]  : '';

		$arr            = explode( ',', $elements );
		$arr_value      = ( $elements_value || $elements_value === 'no_elements_value' ) ? explode( ',', $elements_value ) : [];
		$arr_attr_data  = explode( ',', $add_attr_data );

		// sync（他のradio群と連結する場合）
		if( isset( $this->radio_sync[ $id ] ) && $sync > 0 ) {
			$preset_elements_num = count( $this->radio_sync[ $id ] );
		} else {
			$preset_elements_num = 0;
			$this->radio_sync[ $id ] = [];
		}
		if( $this->step == 'step_form' ) {
			$tag = "\n";
			$tb = $this->tb . "\t\t";
			for( $i = 0; $i < count( $arr ); $i++ ) {
				$res_handle_name = ( $handle_name ) ? self::add_space( $handle_name ) . '_' . sprintf( '%02d', $i + 1 ) : '';
				$val = ( isset( $arr_value[ $i ] ) && $arr_value[ $i ] ) ? $arr_value[ $i ] : $arr[ $i ];
				$attr_data = ( isset( $arr_attr_data[ $i ] ) ) ? ' ' . $arr_attr_data[ $i ] : '';
				if( self::session_val( 'form_' . $id ) ) {
					if( self::session_val( 'form_' . $id ) === $val ) {
						$checked = ' checked';
						$current_handle_name = $handle_name . '_' . sprintf( '%02d', $i + 1 );
					} else {
						$checked = '';
					}
				} else {
					if( intval( $checked_num ) > 0 && ( $i + 1 ) == $checked_num ) {
						$checked = ' checked';
						$current_handle_name = $handle_name . '_' . sprintf( '%02d', $i + 1 );
					} elseif( ! $checked_num && $i == 0 ) {
						$checked = ' checked';
						$current_handle_name = $handle_name . '_' . sprintf( '%02d', $i + 1 );
					} else {
						$checked = '';
					}
				}
				$tag .= $tb . "\t" . '<label class="radio_label' . $res_handle_name . '"><input type="radio" id="' . $this->form_id . '_' . $id . sprintf( '%02d', $i + $preset_elements_num + 1 ) . '" name="form_' . $id . '" value="' . $val . '" class="input_check"'. $attr_data . $checked . '><span>' . $arr[ $i ] . '</span></label>' . "\n";
			}
			if( $handle_name != '' || $handle_name === 'no_handle_name' ) {
				$tag .= $tb . "\t" . '<input type="hidden" id="' . $this->form_id . '_' . $handle_name . '" name="form_' . $handle_name . '" value="' . $current_handle_name . '">' . "\n";
			}
			$tag .= $tb;
		} elseif( $this->step == 'step_confirm' ) {
			if( is_array( $arr_value ) && count( $arr_value ) > 0 ) {
				$checked_num = array_search( $this->POST[ 'form_' . $id ], $arr_value );
				$text = $arr[ $checked_num ];
			} else {
				$text = false;
			}
			$tag = $this->confirm_tag( $id, $this->POST[ 'form_' . $id ], '', $text );
		}
		// for sync
		if( ! empty( $sync ) && $sync > 0) {
			$this->radio_sync[ $id ] = array_merge( $arr, $this->radio_sync[ $id ] );
		}
		return $tag;
	}

	// checkbox
	private function res_input_checkbox( $type, $id, $elements, $setting ) {

		$checked_num     = isset( $setting[ 'checked_num' ] )    ? $setting[ 'checked_num' ]    : '';
		$elements_value  = isset( $setting[ 'elements_value' ] ) ? $setting[ 'elements_value' ] : '';
		$add_attr_data   = isset( $setting[ 'add_attr_data' ] )  ? $setting[ 'add_attr_data' ]  : '';
		$must            = isset( $setting[ 'must' ] )           ? $setting[ 'must' ]           : '';

		$arr             = explode( ',', $elements);
		$arr_value       = $elements_value ? explode( ',', $elements_value ) : [];
		$checked_num_arr = ( $checked_num === '' ) ? [] : explode( ',', $checked_num );
		$session_array   = ( isset( $_SESSION[ 'form_' . $id ] ) && is_array( $_SESSION[ 'form_' . $id ] ) ) ? $_SESSION[ 'form_' . $id ] : [];

		if( $this->step == 'step_form' ) {
			$tag = "\n";
			$tb = $this->tb . "\t\t";
			for( $i = 0; $i < count( $arr ); $i++ ) {
				$val = isset( $arr_value[ $i ] ) ? $arr_value[ $i ] : $arr[ $i ];
				if( isset( $session_array ) && $session_array ) {
					$checked = in_array( $val, $session_array ) ? ' checked' : '';
				} else {
					$checked = in_array( ( $i + 1 ), $checked_num_arr ) ? ' checked' : '';
				}
				$tag .= $tb . "\t" . '<label class="checkbox_label"><input type="checkbox" id="' . $this->form_id . '_' . $id . sprintf( '%02d', $i + 1 ) . '" name="form_' . $id . '[]" value="' . $val . '" class="input_check"' . $checked . '><span>' . $arr[ $i ] . '</span></label>' . "\n";
			}
			$tag .= $tb;
		} elseif( $this->step == 'step_confirm' ) {
			$post_merge = ( isset( $this->POST[ 'form_' . $id ] ) && is_array( $this->POST[ 'form_' . $id ] ) ) ? implode( ' , ', $this->POST[ 'form_' . $id ] ) : '';
			$tag = $this->confirm_tag( $id, $post_merge, $must );
		}
		$this->must_arr_push( $id, $must );
		return $tag;
	}

	// select
	private function res_select( $type, $id, $elements, $setting ) {

		$selected_num   = isset( $setting[ 'selected_num' ] )   ? $setting[ 'selected_num' ]    : '';
		$elements_value = isset( $setting[ 'elements_value' ] ) ? $setting[ 'elements_value' ] : '';
		$add_attr_data  = isset( $setting[ 'add_attr_data' ] )  ? $setting[ 'add_attr_data' ]  : '';
		$element_first  = isset( $setting[ 'element_first' ] )  ? $setting[ 'element_first' ]  : '';
		$must           = isset( $setting[ 'must' ] )           ? $setting[ 'must' ]           : '';

		$arr            = explode( ',', $elements);
		$arr_value      = $elements_value ? explode( ',', $elements_value ) : [];
		$arr_attr_data  = explode( ',', $add_attr_data );

		if( $this->step == 'step_form' ) {
			$tag = "\n";
			$tb = $this->tb . "\t\t";
			$tag .= $tb . "\t" . '<select id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '">' . "\n";
			if( $element_first ) {
				$selected = ( isset( $_SESSION[ 'form_' . $id ] ) || $element_first ) ? '' : ' selected';
				$tag .= $tb . "\t\t" . '<option value=""' . $selected . ' >' . $element_first . '</option>' . "\n";
			}
			for( $i = 0; $i < count( $arr ); $i++ ) {
				$add_disabled = '';
				$add_class = '';
				if( preg_match( '/^(disabled)/',  $arr[ $i ] ) ) {
					$arr[ $i ] = preg_replace( '/^(disabled)/', $arr[ $i ] );
					$add_disabled = ' disabled="disabled"';
					$add_class = ' class="disabled"';
				}
				$val = ( isset( $arr_value[ $i ] ) ) ? $arr_value[ $i ] : $arr[ $i ];
				$attr_data = ( isset( $arr_attr_data[ $i ] ) ) ? ' ' . $arr_attr_data[ $i ] : '';
				if( isset( $_SESSION[ 'form_' . $id ] ) ) {
					$selected = ( $val == $_SESSION[ 'form_' . $id ] ) ? ' selected' : '';
				} elseif( $selected_num ) {
					$selected = ( $i == ( $selected_num - 1 ) ) ? ' selected' : '';
				} else {
					$selected = ( $i == 0 && ! $element_first ) ? ' selected' : '';
				}
				$tag .= $tb . "\t\t" . '<option value="' . $val . '"'. $attr_data . $selected . $add_disabled . $add_class . '>' . $arr[ $i ] . '</option>' . "\n";
			}
			$tag .= $tb . "\t" . '</select>' . "\n" . $tb;
		} elseif( $this->step == 'step_confirm' ) {
			if( is_array( $arr_value ) && count( $arr_value ) > 0 ) {
				$selected_num = array_search( $this->POST[ 'form_' . $id ], $arr_value );
				$text = $arr[ $selected_num ];
			} else {
				$text = false;
			}
			$tag = $this->confirm_tag( $id, $this->POST[ 'form_' . $id ], $must, $text );
		}
		$this->must_arr_push( $id, $must );
		return $tag;
	}

	// pref
	private function res_pref( $type, $id, $setting ) {

		$elements = '北海道,青森県,岩手県,宮城県,秋田県,山形県,福島県,茨城県,栃木県,群馬県,埼玉県,千葉県,東京都,神奈川県,新潟県,山梨県,長野県,富山県,石川県,福井県,岐阜県,静岡県,愛知県,三重県,滋賀県,京都府,大阪府,兵庫県,奈良県,和歌山県,鳥取県,島根県,岡山県,広島県,山口県,徳島県,香川県,愛媛県,高知県,福岡県,佐賀県,長崎県,熊本県,大分県,宮崎県,鹿児島県,沖縄県';

		return $this->res_select( $type, $id, $elements, $setting );
	}

	// hidden
	private function res_hidden( $type, $id, $val, $setting ) {

		$text_show      = isset( $setting[ 'text_show' ] )      ? $setting[ 'text_show' ]  : 'text_hide';

		$text_show      = empty( $text_show ) ? 'text_hide' : $text_show;
		$text           = ( $text_show == 'text_hide' ) ? '' : '<span>' . $val . '</span>';

		if( $this->step == 'step_form' ) {
			$tag = $text . '<input type="hidden" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" value="' . $val . '">';
		} elseif( $this->step == 'step_confirm' ) {
			if( $text_show == 'text_hide' ) {
				$tag = $this->confirm_tag( $id, $this->POST[ 'form_' . $id ], '', 'hidden' );
			} else {
				$tag = $text . $this->confirm_tag( $id, $this->POST[ 'form_' . $id ], '', 'hidden' );
			}
		}
		return $tag;
	}

	// file
	private function res_input_file( $type, $id, $must, $setting ) {

		$input_cover    = isset( $setting[ 'input_cover' ] )   ? $setting[ 'input_cover' ]    : '';

		if( $this->step == 'step_form' ) {
			$tag = '<input type="file" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" value="' . self::session_val( 'form_' . $id ) . '">';
			$tag = self::cover_tag( $tag, $input_cover );
		} elseif( $this->step == 'step_confirm' ) {
			$this->file_check_and_to_session( $id );
			$tag = $this->confirm_file( $id, $must );
		}
		return $tag;
	}

	### public function

	private static function add_space( $str ) {
		return isset( $str ) && ! empty( $str ) ? ' ' . $str : '';
	}

	private static function session_val( $form_id ) {
		return $_SESSION[ $form_id ] ?? '';
	}

	private static function cover_tag( $tag, $cover_str, $delimiter = ',' ) {
		$cover_arr = explode( ',', $cover_str);
		$cover_start = isset( $cover_arr[ 0 ] ) && $cover_arr[ 0 ] ? '<span class="input_cover_prefix">'  . $cover_arr[ 0 ] . '</span>' : '';
		$cover_end   = isset( $cover_arr[ 1 ] ) && $cover_arr[ 1 ] ? '<span class="input_cover_postfix">' . $cover_arr[ 1 ] . '</span>' : '';
		return $cover_start . $tag . $cover_end;
	}

	private function confirm_tag( $id, $post, $must = '', $disp_text = false ) {
		if( $must === 'must' && $post === '' ) {
			$tag = '<span class="confirm_error">' . $this->def_confirm_error_mesasge . '</span>';
		} elseif( $disp_text === 'hidden' ) {
			$tag = '<input type="hidden" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" value="' . $post . '">';
		} elseif( $disp_text ) {
			$tag = $disp_text. '<input type="hidden" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" value="' . $post . '"><input type="hidden" id="' . $this->form_id . '_' . $id . '_disptext" name="form_' . $id . '_label" value="' . $disp_text . '">';
		} else {
			$tag = '<span>' . $post . '</span><input type="hidden" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" value="' . $post . '">';
		}
		return $tag;
	}

	private function confirm_file( $id, $must = '' ) {
		if( $must === 'must' && ( $this->FILES[ 'form_' . $id ][ 'res' ] === 'no_file' ) ) {
			$tag = '<span class="confirm_error">' . $this->def_confirm_error_mesasge . '</span>';
			$this->file_error[] = $id;
		} else {
			if( $this->FILES[ 'form_' . $id ][ 'res' ] === 'error_maxsize' ) {
				$tag = 'error_file_size !';
				$this->file_error[] = $id;
			} elseif( $this->FILES[ 'form_' . $id ][ 'res' ] === 'error_image' ) {
				$tag = 'error_file_type_image !';
				$this->file_error[] = $id;
			} elseif( $this->FILES[ 'form_' . $id ][ 'res' ] === 'error_filetype' ) {
				$tag = 'error_file_type !';
				$this->file_error[] = $id;
			} else {
				if( $this->FILES[ 'form_' . $id ][ 'check_image' ] ) {
					$tag = $this->file[ 'name' ];
				} else {
					$tag = '<img src="data:' . $this->FILES[ 'form_' . $id ][ 'type' ] . ';base64,' . $_SESSION[ 'files' ][ 'form_' . $id ][ 'file' ] . '" width="150" >';
				}
				$tag .= '<input type="hidden" id="' . $this->form_id . '_' . $id . '" name="form_' . $id . '" value="' . $this->FILES[ 'form_' . $id ][ 'res' ] . '">';
			}
		}
		return $tag;
	}

	private function must_arr_push( $id, $must ) {
		if( $must === 'must' && ! in_array( $id, $this->must_check_array ) ){
			array_push( $this->must_check_array, $id );
		}
	}

	private function file_check_and_to_session ( $id ) {
		$this->FILES[ 'form_' . $id ][ 'res' ] = 'no_file';
		if( isset( $_FILES[ 'form_' . $id ] ) ) {
			$tmp_file = $_FILES[ 'form_' . $id ];
			// file_check
			$temp_arr = [];
			// 仮アップロード
			if( $tmp_file[ 'tmp_name' ] ) {
				$temp_arr[ 'tmp_name' ]    = $tmp_file[ 'tmp_name' ];
				$temp_arr[ 'name' ]        = $tmp_file[ 'name' ];
				$temp_arr[ 'size' ]        = $tmp_file[ 'size' ];
				$temp_arr[ 'type' ]        = $tmp_file[ 'type' ];
				$fname_sep_arr             = explode( '.', $tmp_file[ 'name' ] );
				$temp_arr[ 'ext' ]         = $fname_sep_arr[ count( $fname_sep_arr ) - 1 ];
				// アップロードされたファイル形式チェック
				$temp_type                 = explode( '/', $tmp_file[ 'type' ] );
				$temp_arr[ 'check_image' ] = ( $temp_type[ 0 ] === 'image' ) ? true : false;

				if( ( $tmp_file[ 'size' ] / 1024 ) > $this->file_max_size ) {
					$res = 'error_maxsize';
				// file_type_checkがimageでmineに合致しない場合
				} elseif( $this->file_type_check && $this->file_type_check === 'image' && ! $temp_arr[ 'check_image' ] ) {
					$res = 'error_image';
				// カンマ区切りのfile_type_checkに拡張子が含まれない場合
				} elseif( $this->file_type_check && $this->file_type_check != 'image' && ! in_array( $temp_arr[ 'ext' ], explode( ',', $this->file_type_check ) ) ) {
					$res = 'error_filetype';
				} else {
					//エンコードして分割
					$temp_open_file            = fopen( $tmp_file[ 'tmp_name' ], 'r' );
					$temp_open_file_contents   = fread( $temp_open_file, filesize( $tmp_file[ 'tmp_name' ] ) );
					fclose( $temp_open_file );
					$temp_arr[ 'file' ]        = chunk_split( base64_encode( $temp_open_file_contents ) );
					$_SESSION[ 'files' ][ 'form_' . $id ] = $temp_arr;
					$res = $tmp_file[ 'name' ];
				}
				$this->FILES[ 'form_' . $id ][ 'res' ]         = $res;
				$this->FILES[ 'form_' . $id ][ 'size' ]        = $tmp_file[ 'size' ];
				$this->FILES[ 'form_' . $id ][ 'type' ]        = $tmp_file[ 'type' ];
				$this->FILES[ 'form_' . $id ][ 'check_image' ] = $tmp_file[ 'check_image' ];
			}
		}
	}
}
