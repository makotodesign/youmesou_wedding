<?php
/*--------------------------------------------------------------------------

	Template Name: page_privacy_index

	@memo

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME            = '個人情報保護方針';
	$DIRNAME             = '個人情報保護方針';
	define( 'DIRCODE',  'privacy' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */

	/* css */
	$HEAD->css  = '';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	$HEAD->meta_description     = 'auto';
	$HEAD->modal_flag           = false;

	// breadcrumb
	$breadcrumb_arr = [
		'current'       => $PAGENAME
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
						<div class="part">
							<div class="cont texts">
								<p>個人情報保護のため以下のプライバシーポリシーを定め周知徹底を図ります。</p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<h4 class="heading04">個人情報の適切な収集について</h4>
								<p>必要な範囲で個人情報を収集し、収集した情報はガイドラインに則り利用します。</p>
								<h4 class="heading04">個人情報の安全管理について</h4>
								<p>個人情報の漏えい･滅失･き損を防ぐため、必要かつ適切な安全管理措置を講じるとともに継続的な改善に努めます。</p>
								<h4 class="heading04">個人情報に関する法令及びその他の規範の遵守について</h4>
								<p>個人情報の取扱いについて、個人情報の保護に関する法律、その他個人情報保護関連法令を遵守します。</p>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<p>以上のプライバシーポリシーを改定することがあります。その場合の改定内容は当WEBサイトに記載いたします。</p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">WEBサイトでお伺いする情報について</h3>
						<div class="part">
							<div class="cont texts">
								<p>当WEBサイトをご利用される場合、一部のコンテンツでは個人情報をお伺いする場合があります。これらは任意かつ自主的にご提供いただくものです。</p>
								<p>お伺いする情報は、お名前･メールアドレス･電話番号といったものが主なものになります。</p>
								<p>また、それ以外の質問をさせていただく場合がありますが、これは必要最低限の項目を除いて選択可能なものになっており、任意でご提供いただけるものとしています。</p>
								<p>なお、同意なしにお伺いした情報を改変することはありません。</p>
								<p>お伺いした情報は同意いただいた場合、または正当な理由がある場合を除き第三者に開示または提供しません。</p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">保障及び責任制限</h3>
						<div class="part">
							<div class="cont texts">
								<p>当WEBサイトの利用は、アクセスいただいた皆様の責任において行われるものとします。</p>
								<p>また、当WEBサイトにリンクが設定されている他のウェブサイトから取得された各種情報の利用によって生じたあらゆる損害に関しては一切の責任を負うことはできません。</p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">準拠法</h3>
						<div class="part">
							<div class="cont texts">
								<p>当WEBサイトは法律の異なる全世界の国々からアクセスすることが可能ですが、法律原理の違いに関わらず日本国の法律に拘束されることに同意するものとします。</p>
								<p>また当WEBサイトのコンテンツが適切であるかなどの記述や表示は一切行いません。当サイトへのアクセスは自由意志によるものとし、当サイトの利用に関しての責任はアクセスいただいた皆様にあるものとします。</p>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php';?>
