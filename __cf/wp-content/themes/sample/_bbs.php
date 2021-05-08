<?php
/*--------------------------------------------------------------------------

	Template Name: php_bbs

	@memo
		2014-05-15 cording_template で表示
		2015-03-06 bbs.class変更に伴い修正 N

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME = 'BBS掲示板クラス';
	$DIRNAME = 'PHPデモ';
	define( 'DIRCODE', 'phpdemo' );
	define( 'PAGECODE', 'bbs' );

	/* realpath & includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

	/* contents_module */
//	include_once ROOTREALPATH . '/00_stock/mod/contents/xxxx_mod.php';

	/* css */
	$HEAD->css = '';

	/* js*/
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

	BBS(XML-RPC)モジュール

	@memo
		2014-05-15 設置 K

	@memo
		2014-05-15 K
			wordpressへの掲示板投稿用クラスです。pearのxml-rpcを使用
			動作確認 wordpress ver 3.7.1
		2015-03-06 N
		2015-03-06 bbs.class変更に伴い修正 N

---------------------------------------------------------------*/
## base

	/* path */
	$fpath_bbs_class  = ROOTREALPATH . '/mod/bbs.class.php';
	$fpath_form_class = ROOTREALPATH . '/mod/form.class.php';
	/* xml-rpc setting */
//	$host        = 'domain.com'; // ドメインのみ
//	$bbs_blog_id = 12;
//	$user        = 'admin';
//	$passwd      = 'eciffodlo';
//	$publish     = 0; // 0=下書き 1=公開
//	$xmlrpc_path = PUBLICDIR . '/bbs/xmlrpc.php'; // マルチサイトの場合 ディレクトリ名も含める
//	$categories  = array( 'xxx' ); // wp_slug
	$host        = 'oldmt.heteml.jp'; // ドメインのみ
	$bbs_blog_id = 1;
	$user        = 'admin';
	$passwd      = 'eciffodlo';
	$publish     = 0; // 0=下書き 1=公開
	$xmlrpc_path = PUBLICDIR . '/xmlrpc.php'; // マルチサイトの場合 ディレクトリ名も含める
	$categories  = []; // wp_slug
	/* mail setting */
	$mail_from   = 'nishikawa@oldoffice.com'; // 送信元
	$mail_to     = 'nishikawa@oldoffice.com'; // 送信先

	/* class */
	include_once $fpath_bbs_class;
	$BE = new bbs_entry( $host, $bbs_blog_id, $user, $passwd, $publish, $xmlrpc_path );

	include_once $fpath_form_class;

## data

	/* post */
	$send_title            = $_POST[ 'form_name' ];
	$send_content          = $_POST[ 'form_message' ];
	$cf_arr[ 'key' ]       = 'bbs_q_text';
	$cf_arr[ 'value' ]     = $_POST[ 'form_message' ];
	$customfields_array[]  = $cf_arr;

## set

	if( $_POST[ 'act' ] == 'on' ){
		$BE->set_content( $send_title, $categories, $send_content, $customfields_array );
		$post_id = $BE->post_entry(); // 投稿後の記事ID
	}

	if( $post_id ){
		$success = true;

		$res_title = "WEBサイト掲示板への投稿認証";

		$res_cont = 'WEBサイト掲示板に投稿がありました'."\n";
		$res_cont .= "------------------------------------------------\n";
		$res_cont .= "\n";
		$res_cont .= '山口レディースクリニックWEBサイトの掲示板に'."\n";
		$res_cont .= '投稿がありましたので、ご確認の上、認証してください。'."\n";
		$res_cont .= "\n";
		$res_cont .= 'http://domain.com/bbs/wp-admin/post.php?post=' . $post_id . '&action=edit' . "\n";
		$res_cont .= "\n";
		$res_cont .= "------------------------------------------------";
		$res_cont .= "\n";
		$res_cont .= 'Q＆A掲示板投稿内容'."\n";
		$res_cont .= 'ハンドルネーム：'.$send_title."\n";
		$res_cont .= '質問内容：'.$send_content."\n";

		mb_language('Japanese');
		mb_internal_encoding("utf-8");
		mb_send_mail($mail_to,$res_title,$res_cont,"From:$mail_from");

		$display_message = '投稿を受け付けました。';
	}

	$display_message_tag = '';
	if( $display_message ){
		$display_message_tag = '<p id="bbs_result_message">' . $display_message . '</p>';
	}


/*------------------------------------------------------------------------*/
?>
<script>

$(function(){

	// bbs notice
	var $target = $("#bbs_result_message");
	$target.fadeIn( 1000, function(){ $target.fadeOut(1500); });

});

</script>				<div class="box" id="bbs_form_box">
							<h3 class="heading01">ご質問掲示板</h3>
							<?= $display_message_tag ?>
							<form method="post" action="" id="bbs_form" class="part">
								<table class="table01">
									<tr>
										<th scope="row">ハンドルネーム<span class="must">*</span></th>
										<td>
											<input type="text" id="name" name="form_name" class="input_text normal">
										</td>
									</tr>
									<tr>
										<th scope="row">ご質問<span class="must">*</span></th>
										<td>
											<textarea id="message" name="form_message" class="textarea normal"></textarea>
										</td>
									</tr>
								</table>
								<input type="hidden" name="act" value="on">
								<input id="submit" type="submit" value="　上記の内容で送信　" class="button bc_rosy">
							</form>
						</div>