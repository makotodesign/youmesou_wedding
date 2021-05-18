<?php
/*--------------------------------------------------------------------------

	Template Name: xx_samplemarkup

	@memo

---------------------------------------------------------------------------*/

##	error_reporting

	ini_set( 'display_errors', 1 );
	error_reporting(E_ALL);

##	page_setting

	/* base */
	$PAGENAME            = 'サンプルマークアップ';
	$DIRNAME             = 'ディレクトリ';
	$DIRNAME_en          = 'Directory';
	define( 'DIRCODE',  'xx' );
	define( 'PAGECODE', 'samplemarkup' );

	/* no_wp */
	if( ! defined( 'ROOTREALPATH' ) ) define( 'ROOTREALPATH', '/home/oldoffice/www/org01/ct18' );
	include_once ROOTREALPATH . '/wp/wp-load.php';

	/* includes ( * ct12よりWordPressテーマで不要 ) */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* form */
	include_once ROOTREALPATH . '/mod/lib/form.class.php';
	$FS = new formset( '/xx/thanks/', 'xx_form' );

	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/utility/swiper.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                 = 'auto';
	$HEAD->h1_text               = '';
	$HEAD->meta_description      = '';
	$HEAD->canonical             = ''; // '/xx/sample_markup/'
	$HEAD->meta_keywords         = '';
	$HEAD->meta_robots           = ''; // noindex
	// sns
	$HEAD->disp_facebook_script  = false; // facebook_like_btn / facebook_timeline
	$HEAD->disp_twitter_script   = false; // twitter_btn / twitter_timeline
	$HEAD->disp_line_script      = false; // line_btn
	$HEAD->disp_youtube_script   = false; // youtube_btn
	$HEAD->disp_pinterest_script = false; // pinterest_save_btn
	$HEAD->og_image_url          = '';
	$HEAD->back_navi_url         = '/';
	// modal
	$HEAD->modal_flag = true;

	// breadcrumb
	$breadcrumb_arr = array(
		DIRCODE .'/' => $DIRNAME,
		'current'       => $PAGENAME
	);

	/* head & header */
	$HEAD->disp_tag_head();
	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_header.php';

	$areaflag = ''; // main_side *サンプルマークアップ用 使用不可
	$areaflag = isset( $_GET[ 'area' ] )? $_GET[ 'area' ] : $areaflag;

/*---------------------------------------------------------------------------*/
?>
<!--css サンプルマークアップ用 使用不可-->
		<style type="text/css">.sample_size .pic{width:80px;height:80px;}.sample_size .object_fit{width:240px;}.sample_area:not(.main_area){background-color:#eee}</style>
<!--title-->
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
				<p class="title_text_sub"><?= $DIRNAME ?></p>
			</div>
		</div>
<!--contents_wrap-->
		<div class="contents_wrap">
			<div class="<?= DIRCODE; ?>_<?= PAGECODE ?>_contents contents<?= $areaflag === 'main_side' ? ' main_side' : '';  ?>">
				<section class="area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">見出し2</h2>
					</div>
					<div class="cgroup">
						<p class="catch">キャッチ</p>
					</div>
<!--	基本形-->
					<div class="box">
						<h3 class="heading03">見出し3</h3>
						<div class="part">
							<h4 class="heading04">見出し4</h4>
							<div class="cont texts">
								<p>TEXTTEXTTEXT</p>
							</div>
						</div>
					</div>
<!--	PHP用マークアップ-->
<?php
	$tag = '';
	$tb = "\t\t\t\t\t";

	/* wp : xxx_yyy_box */

	$tag .= $tb . "" . '<div class="box">' . "\n";
	$tag .= $tb . "\t" . '<div class="part">' . "\n";
	$tag .= $tb . "\t\t" . '<div class="cont texts">' . "\n";
	$tag .= $tb . "\t\t\t" . '<p>TEXTTEXTTEXT</p>' . "\n";
	$tag .= $tb . "\t\t" . '</div>' . "\n";
	$tag .= $tb . "\t" . '</div>' . "\n";
	$tag .= $tb . "" . '</div>' . "\n";

	// echo $tag;
?>
				</section>
<!-- 	area 区切り -->
				<section class="area sample_area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">セクション区切り</h2>
					</div>
					<div class="box wide_pc">
						<h3 class="heading03">PC幅広</h3>
						<div class="part">
							<div class="cont texts">
								<p>TEXTTEXTTEXT</p>
							</div>
						</div>
					</div>
					<div class="box full">
						<h3 class="heading03">横いっぱい</h3>
						<div class="part">
							<div class="cont texts">
								<p>TEXTTEXTTEXT</p>
							</div>
						</div>
					</div>
				</section>
<!--シェアパーツ-->
				<section class="area sample_area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">共通パーツ</h2>
					</div>
					<div class="box">
						<div class="part tel_part">
							<div class="cont tel_item">
								<p class="mark_freedial tel"><a href="tel:0120-58-4567">0120-58-4567</a></p>
							</div>
							<div class="cont texts supple_item">
								<dl>
									<dt>【営業時間】</dt>
									<dd>10:00～18:30</dd>
									<dt>【定休日】</dt>
									<dd>土・日曜日</dd>
								</dl>
							</div>
						</div>
					</div>
				</section>
<!--	一般文字組み-->
				<section class="area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">一般テキスト・画像</h2>
					</div>
					<div class="box">
						<h3 class="heading03">見出し3</h3>
						<div class="part">
							<h4 class="heading04">見出し4</h4>
							<div class="cont texts">
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうです<br>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
							<h4 class="heading04">見出し4</h4>
							<div class="cont texts">
								<h5 class="heading05">見出し5</h5>
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
							<div class="cont texts">
								<h5 class="heading05">見出し5</h5>
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<ul>
									<li>リスト</li>
									<li>リスト</li>
								</ul>
								<ol>
									<li>リスト</li>
									<li>リスト</li>
								</ol>
								<ul>
									<li>リスト</li>
									<li>リスト
										<ol>
											<li>ネスト</li>
											<li>ネスト</li>
										</ol>
										<ul class="ul_line">
											<li>ネスト</li>
										</ul>
									</li>
								</ul>
								<ul class="ul_arrow">
									<li>リスト</li>
								</ul>
								<ol class="ol_circle">
									<li>リスト</li>
									<li>リスト</li>
								</ol>
								<ol class="ol_kome">
									<li>リスト</li>
									<li>リスト</li>
								</ol>
								<dl>
									<dt>リストメイ</dt>
									<dd>リスト</dd>
									<dt>リストメイリストメイ</dt>
									<dd>リストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリストリスト</dd>
								</dl>
							</div>
							<div class="cont texts">
								<ul class="ul_title">
									<li title="３文字">ul_title</li>
									<li title="３文字">リストリストリスト</li>
									<li title="３文字">回り込まないリスト回り込まないリスト</li>
								</ul>
							</div>
							<div class="cont texts">
								<ul class="ul_title_4">
									<li title="４文字文">ul_title_4</li>
									<li title="４文字文">常に回り込むリスト常に回り込むリスト常に回り込むリスト</li>
								</ul>
							</div>
							<div class="cont texts">
								<ul class="ul_title_5_tb">
									<li title="５文字文字">ul_title_5_tb</li>
									<li title="５文字文字">タブレットサイズ以上で回り込むリストタブレットサイズ以上で回り込むリストタブレットサイズ以上で回り込むリスト</li>
								</ul>
							</div>
							<div class="cont texts">
								<ul class="ul_title_6_pc">
									<li><span class="title">６文字文字文</span>ul_title_6_pc</li>
									<li><span class="title">６文字文字文</span>PC以上で回り込むリストPC以上で回り込むリストPC以上で回り込むリストPC以上で回り込むリストPC以上で回り込むリストPC以上で回り込むリスト</li>
								</ul>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<p class="catch">キャッチ</p>
								<p><span class="caution">だみーぶんしょうですだみーぶんしょうです</span><strong>だみーぶんしょうです</strong>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<p class="supple">ちいさなもじちいさなもじちいさなもじちいさなもじちいさなもじちいさなもじちいさなもじちいさなもじちいさなもじ</p>
								<p class="icon_kome supple">だみーぶんしょうですだみーぶんしょうですょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<p class="center">センターテキスト</p>
								<p class="right">ライトテキスト</p>
								<p class="big">ビッグテキスト</p>
								<p>だみーぶんしょうです<span class="bold">ボールド</span>だみーぶんしょうです<span class="accent">アクセント</span>だみーぶんしょうです<span class="marker">マーカー</span>だみーぶんしょうです<a class="tooltip" data-tooltip="ツールチップ本文">ツールチップ</a>だみーぶんしょうです</p>
							</div>
							<div class="cont entry_wrap">
								<h3>エントリーラップ</h3>
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<h4>エントリーラップ</h4>
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<h5>エントリーラップ</h5>
								<p>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
								<ul>
									<li>リスト</li>
									<li>リスト</li>
								</ul>
								<ol>
									<li>リスト</li>
									<li>リスト</li>
								</ol>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">価格日付電話</h3>
						<div class="part">
							<div class="cont texts">
								<h4 class="heading04">価格関連</h4>
								<p><span class="price"><?= tax_adjust( 1500 ) ?>yen</span> (<?= TAXWORD ?>)</p>
								<p><span class="price"><?= tax_adjust( 1500, 2 ) ?>yen</span> (<?= TAXWORD ?>)</p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<h4 class="heading04">日付関連</h4>
								<p class="date"><time datetime="2100-01-01">2100.01.01</time></p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<h4 class="heading04">電話関連</h4>
								<p class="mark_title tel" title="TEL"><a href="tel:000-000-0000">000-000-0000</a></p>
								<p class="mark_freedial tel"><a href="tel:0120-00-0000">0120-00-0000</a></p>
								<p class="mark_title fax" title="FAX"><a href="tel:0120-00-0000">000-000-0000</a></p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">リンクテキスト</h3>
						<div class="part">
							<div class="cont texts">
								<p class="link_arrow"><a href="/">リンク</a></p>
								<p class="link_arrow link_external"><a href="/" target="_blank">外部サイトリンク</a></p>
								<p class="link_arrow link_sscroll"><a href="#sscroll_target" class="sscroll">ページ内リンク</a></p>
								<p class="link_arrow"><a href="/xxx.pdf">PDF</a><span class="pdf_mark">PDF</span></p>
								<ul class="text ul_arrow">
									<li><a href="/">リンク</a></li>
									<li class="link_external"><a href="/" target="_blank">外部サイトリンク</a></li>
									<li class="link_sscroll"><a href="#contents_wrap" class="sscroll">ページ内リンク</a></li>
									<li><a href="/xxx.pdf">PDF</a><span class="pdf_mark">PDF</span></li>
									<li><span class="link_parent">ページメイ</span><a href="/">リンク</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="box sample_size">
						<h3 class="heading03">画像</h3>
						<div class="part">
							<div class="cont texts">
								<h4 class="heading04">画像一般</h4>
								<p class="text"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="pic"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="pic"><a href="/"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></a></p>
								<p class="pic frame"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
							</div>
						</div>
						<div class="part">
							<div class="cont">
								<h4 class="heading04">画像CMS自動リサイズ・トリミング</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="object_fit"><img src="/images/lib/parts/noimage_icon.svg" alt="noimage"></p>
								<h4 class="heading04">画像レスポンシブ自動変換</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy_sp.jpg" alt="必ず記述" data-switchimg="dummy_sp.jpg,dummy_tb.jpg,dummy_pc.jpg,dummy_spyoko.jpg"></p>
								<p class="object_fit"><img src="/images/lib/parts/dummy_sp.jpg" alt="必ず記述" data-switchimg="dummy_sp.jpg,dummy_pc.jpg"></p>
							</div>
						</div>
					</div>
				</section>
<!--ボタン-->
				<section class="area sample_area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">ボタン</h2>
					</div>
					<div class="box">
						<h3 class="heading03">ボタン</h3>
						<div class="part">
							<div class="cont btn_wrap">
								<a href="/" class="button"><span>ボタンDEF</span></a>
							</div>
							<div class="cont btn_wrap">
								<a href="/" class="button auto"><span>ボタン幅AUTO</span></a>
							</div>
							<div class="cont btn_wrap">
								<a href="/" class="button full"><span>ボタン横いっぱい</span></a>
							</div>
							<div class="cont btn_wrap center">
								<a href="/" class="button"><span>ボタンセンター</span></a>
								<a href="/" class="button"><span>ボタンセンター</span></a>
							</div>
							<div class="cont btn_wrap">
								<a href="/" class="button btn_small"><span>ボタンスモール</span></a>
							</div>
							<div class="cont btn_wrap">
								<a href="/" class="button_sp"><span>ボタンスマホだけ</span></a>
							</div>
							<div class="cont btn_wrap grow">
								<a href="/" class="button"><span>ボタン横並び</span></a>
								<a href="/" class="button"><span>横並び</span></a>
								<a href="/" class="button"><span>横並び</span></a>
							</div>
							<div class="cont btn_wrap vertical">
								<a href="/" class="button icon_arrow"><span>icon_arrow</span></a>
								<a href="/" class="button icon_arrow_right"><span>icon_arrow_right</span></a>
								<a href="/" class="button icon_tel"><span>icon_tel</span></a>
								<a href="/" class="button icon_tel_inline"><span>icon_tel_inline</span></a>
								<a href="/" class="button icon_facebook bc_strong"><span>icon_facebook</span></a>
								<a href="tel:000-000-0000" class="button icon_tel"><span>000-000-0000</span></a>
								<a href="/" class="button bc_strong"><span>ボタンカラー bc_strong</span></a>
								<a href="/" class="button bc0"><span>ボタンカラーbc0</span></a>
							</div>
						</div>
					</div>
<!--	ページャー-->
					<div class="box">
						<h3 class="heading03">ページャー </h3>
						<div class="part">
							<nav class="cont pager_wrap">
								<ul class="pager_next_back">
									<li><a class="prev" href="/xx/"><span>&laquo; 戻る</span></a></li>
									<li><a class="next" href="/xx/"><span>次へ &raquo;</span></a></li>
								</ul>
							</nav>
							<nav class="cont pager_wrap">
								<ul>
									<li><a class="page-numbers" href="/xx/"><span>&lt;</span></a></li>
									<li><span class="page-numbers current"><span>1</span></span></li>
									<li><span class="page-numbers dots">&hellip;</span></li>
									<li><a class="page-numbers" href="/xx/"><span>2</span></a></li>
									<li><a class="page-numbers" href="/xx/"><span>3</span></a></li>
									<li><span class="page-numbers dots">&hellip;</span></li>
									<li><a class="page-numbers" href="/xx/"><span>99</span></a></li>
									<li><a class="page-numbers" href="/xx/"><span>&gt;</span></a></li>
								</ul>
							</nav>
							<nav class="cont btn_wrap">
								<p class="pager_to_home"><a class="button" href="/xx/" title="一覧へ戻る"><span>一覧へ戻る</span></a></p>
								<p class="pager_continue"><a class="button" href="/xx/" title="続きを読む"><span>続きを読む</span></a></p>
							</nav>
						</div>
					</div>
<!--	SPメニューグル-プ-->
					<div class="box">
						<h3 class="heading03">SPグループメニュー</h3>
						<div class="part">
							<div class="cont btn_group_sp">
								<a href="/" class="button_sp"><span>MENU</span></a>
								<a href="/" class="button_sp"><span>MENU</span></a>
								<a href="/" class="button_sp"><span>MENU</span></a>
							</div>
						</div>
					</div>
				</section>
<!--レイアウト box-->
				<section class="area <?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">レイアウト</h2>
					</div>
<!--	囲みBOX-->
					<div class="box">
						<h3 class="heading03">見出し3</h3>
						<div class="part cover_wrap with_label">
							<div class="cont">
								<h4 class="heading_in_cover">みだしよん</h4>
								<p class="text">だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
<!--	検索BOX-->
					<div class="box">
						<h3 class="heading03">検索</h3>
						<div class="part">
							<form class="cont search_wrap" method="get" action="">
								<p class="input_wrap"><input type="text" name="coursename" placeholder="Search･･･"></p>
								<button class="button" type="submit"><span>検索</span></button>
							</form>
						</div>
					</div>
<!--	モーダル *要js-->
					<div class="box">
						<h3 class="heading03">Modal_BOX</h3>
						<div class="part">
							<div class="cont btn_wrap">
								<a class="button modal_handle" data-target="modal_target_01"><span>モーダル</span></a>
							</div>
						</div>
						<div id="modal_target_01" class="modal_target">
							<h4 class="heading04">モーダル表示コンテンツ</h4>
							<div class="cont texts">
								<p>TEXTTEXTTEXT</p>
							</div>
						</div>
					</div>
<!--	開閉BOX *要js-->
					<div class="box">
						<h3 class="heading03">Openclose_BOX</h3>
						<div class="part openclose_wrap">
							<h5 class="openclose_handle plus"><span>def_CLOSE</span></h5>
							<div class="cont openclose_target">
								<p class="text">Open_contents</p>
							</div>
						</div>
						<div class="part openclose_wrap">
							<h5 class="openclose_handle minus" data-target="openclose_target_01"><span>def_OPEN</span></h5>
							<div id="openclose_target_01" class="cont openclose_target">
								<p class="text">data-target指定のない場合は .openclose_handle.next()</p>
							</div>
						</div>
						<div class="part openclose_wrap">
							<a class="openclose_handle plus button_sp" data-target="openclose_target_03"><span>OPENCLOSE_BUTTON_SP</span></a>
							<div id="openclose_target_03" class="cont openclose_target target_wrap_sp">
								<p class="text">Open_contents</p>
							</div>
						</div>
						<div class="part openclose_wrap">
							<a class="openclose_handle plus button_sp" data-target="openclose_target_04"><span>OPENCLOSE_MENU_SP</span></a>
							<div id="openclose_target_04" class="cont openclose_target btn_group_sp">
								<a href="/" class="button_sp bc0"><span>MENU</span></a>
								<a href="/" class="button_sp bc0"><span>MENU</span></a>
								<a href="/" class="button_sp bc0"><span>MENU</span></a>
							</div>
						</div>
					</div>
<!--	タブBOX *jsのタブ切り替えを実装したい場合は、js_から始まる各クラス名を付与 -->
					<div class="box">
						<h3 class="heading03">Tab_BOX</h3>
						<div class="part tab_wrap">
							<div class="cont tab_handle_set">
								<a class="current"><span>たぶいち</span></a>
								<a title="たぶに"><span>たぶに</span></a>
								<a title="たぶさん"><span>たぶさん</span></a>
							</div>
							<div class="cont tab_target">
								<p class="text">CONTENTS01</p>
							</div>
							<div class="cont tab_target">
								<p class="text">CONTENTS02</p>
							</div>
							<div class="cont tab_target">
								<p class="text">CONTENTS03<br>CONTENTS03</p>
							</div>
						</div>
					</div>
<!--	イメージ-テキスト いろいろ-->
					<div class="box">
						<h3 class="heading03">PCイメージテキストTBイメージテキストSP縦積み</h3>
						<div class="part image_texts_pc image_texts_tb">
							<div class="cont image_item">
								<p class="pic"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</div>
							<div class="cont texts_item">
								<h4 class="heading04">見出し4</h4>
								<p class="text">だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">PCてきすといめーじTBてきすといめーじSPふろーとらいと</h3>
						<div class="part texts_image_pc texts_image_tb float_right_sp">
							<div class="cont image_item">
								<p class="pic"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</div>
							<div class="cont texts_item">
								<h4 class="heading04">見出し4</h4>
								<p class="text">だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="part image_texts_grid_pc image_texts_grid_tb float_right_sp">
							<h3 class="heading03">PCいめーじてきすとグリッドTBいめーじてきすとグリッドSPふろーとらいと</h3>
							<div class="cont image_item">
								<p class="pic"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</div>
							<div class="cont texts_item">
								<p class="text">だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">PCカラム3・TBカラム2・SPスナップ</h3>
						<div class="part clm3_pc clm2_tb snap_sp">
							<a href="#" class="cont clm_item">
								<h4 class="heading04">スライド01</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</a>
							<a href="#" class="cont clm_item">
								<h4 class="heading04">スライド02</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</a>
							<a href="#" class="cont clm_item">
								<h4 class="heading04">スライド03</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</a>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">PCカラム4・TBカラム3・SPスリック</h3>
						<div class="part clm3_pc clm2_tb slick_sp">
							<div class="cont clm_item">
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
							</div>
							<div class="cont clm_item">
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
							</div>
							<div class="cont clm_item">
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
							</div>
							<div class="cont clm_item">
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
							</div>
							<div class="cont clm_item">
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
							</div>
						</div>
					</div>
<!--	swiper テスト段階-->
<?php
/** swiper_on start **/
// 2020-04-23 N
// 現在導入中につき使用不可
if( isset( $_GET[ 'swiper' ] ) && $_GET[ 'swiper' ] == 'on' ) {
?>
					<div class="box swiper-container">
						<h3 class="heading03">SWIPER</h3>
						<div class="part swiper_pc swiper_tb swiper_sp swiper-wrapper">
							<a href="#" class="swiper-slide">
								<h4 class="heading04">スライド01</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</a>
							<a href="#" class="swiper-slide">
								<h4 class="heading04">スライド02</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</a>
							<a href="#" class="swiper-slide">
								<h4 class="heading04">スライド03</h4>
								<p class="object_fit"><img src="/images/lib/parts/dummy.jpg" alt="必ず記述"></p>
								<p class="caption">キャプション</p>
							</a>
						</div>
						<div class="swiper-controler">
							<div class="swiper-button-prev"></div>
							<div class="swiper-pagination"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>
<?php
}
/** swiper_on end **/
?>
				</section>
<!--テーブル-->
				<section id="sscroll_target" class="area sample_area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">テーブル</h2>
					</div>
					<div class="box">
						<h3 class="heading03">一般テーブル　SP横スクロール</h3>
						<div class="part">
							<div class="cont scroll_wrap">
								<table class="table">
									<caption>表:名称</caption>
									<tfoot>
										<tr>
											<td colspan="2">表の名前</td>
										</tr>
									</tfoot>
									<tbody>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>&nbsp;</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="part">
							<div class="cont scroll_wrap">
								<table class="table">
									<caption>表:名称</caption>
									<thead>
										<tr>
											<th scope="col">TH</th>
											<th scope="col">TH</th>
											<th scope="col">TH</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<p>TDTDTDTDTDTDTDTDTD</p>
											</td>
											<td>
												<p>TDTDTDTDTDTDTDTDTD</p>
											</td>
											<td>
												<p>TDTDTDTDTDTDTDTDTD</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="part">
							<div class="cont">
								<table class="table_line">
									<caption>表:名称</caption>
									<tbody>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="part">
							<div class="cont">
								<table class="table table_block_sp">
									<caption>表:名称</caption>
									<tbody>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
											<td>
												<p>TD</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
											<td>
												<p>TD</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH</th>
											<td>
												<p>TD</p>
											</td>
											<td>
												<p>TD</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="part">
							<div class="cont">
								<table class="table_line table_block_sp add_thead">
									<caption>表:名称</caption>
									<thead>
										<tr>
											<th scope="col"></th>
											<th scope="col">TH_C01</th>
											<th scope="col">TH_C02</th>
											<th scope="col">TH_C03</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">TH_R01</th>
											<td data-title="TH_C01">
												<p>TD01</p>
											</td>
											<td data-title="TH_C02">
												<p>TD02</p>
											</td>
											<td data-title="TH_C03">
												<p>TD03</p>
											</td>
										</tr>
										<tr>
											<th scope="row">TH_R02</th>
											<td data-title="TH_C01">
												<p>TD01</p>
											</td>
											<td data-title="TH_C02">
												<p>TD02</p>
											</td>
											<td data-title="TH_C03">
												<p>TD03</p>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</section>
<!--フォーム-->
				<section class="area<?= $areaflag === 'main_side' ? ' main_area' : '' ?>">
					<div class="hgroup">
						<h2 class="heading02">フォーム</h2>
					</div>
					<div class="box">
						<div class="part form_set01">
							<form id="<?= $FS->form_id ?>" method="post" action="<?= $FS->form_action;  ?>">
								<div class="form_input_set">
									<div class="form_fieldset">
										<div class="form_legend">
											<p>テキスト<?= $FS->must( 'textid' ); ?></p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'text', 'textid', '', [
													'add_class'         => 'size_s',
													'placeholder'       => '入力ヒント',
													'default_value'     => ''
											] ) ?></p>
<?php	if( $FS->is_form() ) : ?>
												<p class="form_caption caption">*注釈記載</p>
<?php	endif; ?>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>HIDDEN</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'hidden', 'hiddenid', 'HIDDEN値', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>テキストエリア</p>
										</div>
										<div class="form_input">
											<p><?= $FS->res( 'textarea', 'textareaid', '', [
													'add_class'         => 'size_m',
													'placeholder'       => '入力ヒント'
													// * 最後のカンマは省く
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>電話番号_sep3<?php
												$FS->must( 'tel01' );
											?></p>
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
											<p>ご住所 sep<?= $FS->must( 'address01' ); ?></p>
										</div>
										<div class="form_input">
											<p>〒 <?= $FS->res( 'text', 'zip01', 'must', [
													'add_class'         => 'size_s'
											] ) ?> - <?= $FS->res( 'text', 'zip02', 'must', [
													'add_class'         => 'size_s'
											] ) ?></p>
											<p class="input_select_wrap"><?= $FS->res( 'pref', 'pref' ) ?></p>
											<p><?= $FS->res( 'text', 'address01', 'must', [
													'placeholder'       => '住所01 市区町村'
											] ) ?></p>
											<p class="form_caption caption">*</p>
											<p><?= $FS->res( 'text', 'address02', '', [
													'placeholder'       => '住所02 番地・マンション名'
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ラジオボタン pc横並び</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap horizon_tb_pc"><?= $FS->res( 'radio', 'radiohid', '要素01,要素02', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>ラジオボタン pc縦並び</p>
										</div>
										<div class="form_input">
											<p class="input_radio_wrap radio_vertical_pc"><?= $FS->res( 'radio', 'radiovid', '要素01,要素02', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>チェックボックス pc横並び</p>
										</div>
										<div class="form_input">
											<p class="input_checkbox_wrap horizon_tb_pc"><?= $FS->res( 'checkbox', 'checkboxhid', '要素01,要素02', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>チェックボックス pc縦並び</p>
										</div>
										<div class="form_input">
											<p class="input_checkbox_wrap checkbox_vertical_pc"><?= $FS->res( 'checkbox', 'checkboxvid', '要素01,要素02', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>セレクト</p>
										</div>
										<div class="form_input">
											<p class="input_select_wrap"><?= $FS->res( 'select', 'selectid', '要素01,要素02', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>セレクト（インライン）</p>
										</div>
										<div class="form_input">
											<p class="input_select_wrap size_s"><?= $FS->res( 'select', 'selectids', '要素01,要素02', [
											] ) ?></p>
											<p class="input_select_wrap size_ss"><?= $FS->res( 'select', 'selectidss', '要素01,要素02', [
											] ) ?></p>
										</div>
									</div>
									<div class="form_fieldset">
										<div class="form_legend">
											<p>県名</p>
										</div>
										<div class="form_input">
											<p class="input_select_wrap"><?= $FS->res( 'pref', 'prefid', '', [
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
											<p>ご利用規約<?= $FS->must( 'kiyaku' ); ?></p>
										</div>
										<div class="form_input">
											<div class="kiyaku_wrap">
												<h4 class="heading_kiyaku">みだし</h4>
												<p>テキスト</p>
											</div>
											<p class="input_checkbox_wrap"><?= $FS->res( 'checkbox', 'kiyaku', '同意する', [
											] ) ?></p>
<?php if( $FS->is_form() ) : ?>
											<p class="form_caption caption"><a href="/xx/kiyaku/">規約詳細</a></p>
<?php endif; ?>
										</div>
									</div>
								</div>
								<div class="form_submit_set">
									<div class="form_buttons"><?php $FS->submit(); ?></div>
								</div>
							</form>
						</div>
					</div>
<?php
// 必要に応じてコメント解除
/*
<!-- SNS -->
					<div class="box">
						<h3 class="heading03">SNS</h3>
						<div class="part">
							<div class="cont">
								<div class="fb-like" data-href="<?= ( empty( $_SERVER[ 'HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] ?>" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
								<div class="tw_tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="<?= ( empty( $_SERVER[ 'HTTPS'] ) ? 'http://' : 'https://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] ?>" data-size="large">Tweet</a></div>
								<div class="twitter_btn"><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Share</a></div>
								<div class="line_btn"><div class="line-it-button" style="display: none;" data-lang="ja" data-type="share-a" data-ver="2" data-url="https://social-plugins.line.me/ja/how_to_install#lineitbutton"></div></div>
								<div class="youtube_btn"><div class="g-ytsubscribe" data-channelid="xxxxxxxxxxx" data-layout="default" data-count="default"></div></div>
							</div>
							<div class="cont">
								<div class="fb-page" data-href="https://www.facebook.com/pg/%E3%83%A9%E3%83%A0%E3%82%AD%E3%83%B3%E3%82%B4%E3%83%AB%E3%83%95%E3%82%B0%E3%83%AA%E3%83%83%E3%83%97%E3%82%B8%E3%83%A3%E3%83%91%E3%83%B3-Lamkin-Golf-Grips-Japan-1458131991108870/ads/?ref=page_internal" data-tabs="timeline" data-width="400" data-height="600" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true"></div>
							</div>
							<div class="cont">
								<a class="twitter-timeline" data-height="600" href="https://twitter.com/LamkinJapan?ref_src=twsrc%5Etfw">Tweets by LamkinJapan</a>
							</div>
						</div>
					</div>
<!--カレンダー 7列タイプ-->
					<div class="box">
						<h3 class="heading03">CALENDAR_column7</h3>
						<div class="part">
							<div class="cont calendar_cont">
								<h4 class="heading04">2020年1月のカレンダー</h4>
								<p>月曜スタート</p>
								<p>tableクラス付与:calendar_table</p>
								<p>close_date:21,23</p>
								<p>close_wday:4(木曜日)</p>
								<p>open_date:1,2,3,4,5,6,7</p>
								<table class="calendar_table calendar_column7">
									<tr>
										<th class="monday">月</th><th class="tuesday">火</th><th class="wednesday">水</th><th class="thursday">木</th><th class="friday">金</th><th class="saturday">土</th><th class="sunday">日</th>
									</tr>
									<tr>
										<td>&nbsp;</td><td>&nbsp;</td><td class="wednesday past">1</td><td class="thursday past">2</td><td class="friday past">3</td><td class="saturday past">4</td><td class="sunday past">5</td>
									</tr>
									<tr>
										<td class="monday past">6</td><td class="tuesday past">7</td><td class="wednesday past">8</td><td class="thursday past close">9</td><td class="friday past">10</td><td class="saturday past">11</td><td class="sunday past">12</td>
									</tr>
									<tr>
										<td class="monday past">13</td><td class="tuesday past">14</td><td class="wednesday past">15</td><td class="thursday past close">16</td><td class="friday past">17</td><td class="saturday past">18</td><td class="sunday past">19</td>
									</tr>
									<tr>
										<td class="monday past">20</td><td class="tuesday past close">21</td><td class="wednesday past">22</td><td class="thursday past close">23</td><td class="friday past">24</td><td class="saturday past">25</td><td class="sunday past">26</td>
									</tr>
									<tr>
										<td class="monday past">27</td><td class="tuesday today">28</td><td class="wednesday future">29</td><td class="thursday future close">30</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
<!--カレンダー バーティカルタイプ-->
					<div class="box">
						<h3 class="heading03">CALENDAR_vertical</h3>
						<div class="part">
							<div class="cont calendar_cont">
								<h4 class="heading04">2020年1月のカレンダー</h4>
								<table class="calendar_table calendar_vertical">
									<tr class="saturday past">
										<th>1/1 (土)</th>
										<td>
										</td>
									</tr>
									<tr class="sunday past">
										<th>1/2 (日)</th>
										<td>
										</td>
									</tr>
									<tr class="monday today">
										<th>6/6 (月)</th>
										<td>
										</td>
									</tr>
									<tr class="tuesday future close">
										<th>6/7 (火)</th>
										<td>
										</td>
									</tr>
									<tr class="wednesday future">
										<th>6/8 (水)</th>
										<td>
										<p>EVENT NAME_01</p>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
*/
?>
				</section>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_sidebar.php'; ?>
			</div>
		</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_footer.php'; ?>
