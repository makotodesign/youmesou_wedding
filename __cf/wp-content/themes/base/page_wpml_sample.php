<?php
/*--------------------------------------------------------------------------

	Template Name: wpml_sample

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME     = 'サンプル';
	$DIRNAME      = 'WPML';
	define( 'DIRCODE', 'wpml' );
	define( 'PAGECODE', 'sample' );

	if( ICL_LANGUAGE_CODE === 'en' ) {
		$PAGENAME = 'CHECK WPML_EN';
		$DIRNAME  = 'CHECK_EN';
	} elseif( ICL_LANGUAGE_CODE === 'zh-hans' ) {
		$PAGENAME = 'CHECK WPML_ZHHANS';
		$DIRNAME  = 'CHECK_ZHHANS';
	} elseif( ICL_LANGUAGE_CODE === 'ko' ) {
		$PAGENAME = 'CHECK WPML_KO';
		$DIRNAME  = 'CHECK_KO';
	}

	/* includes */
	include_once ROOTREALPATH . '/mod/base/base_mod.php';

/*---------------------------------------------------------------------------*/
?>
		<div class="title_wrap">
			<div class="title">
				<h1 class="title_text"><?= $PAGENAME ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="main_area">
					<div class="hgroup">
						<h2 class="heading02"><?= $PAGENAME ?></h2>
					</div>
					<div class="box">
						<h3 class="heading03">各種言語定数・関数<</h3>
						<div class="part">
							<div class="texts_cont texts">
<?php
	$tag = '';
	$tb = "\t\t\t\t\t\t\t";

	// wpml 定数 ICL_LANGUAGE_CODE
	$tag .= $tb . "" . '<p>ICL_LANGUAGE_CODE : ' . ICL_LANGUAGE_CODE . '</p>' . "\n";

	// oo_switch_langg( $def, $word_arr )
	$def = '日本語';
	$word_arr = array(
		'en'      => '英語',
		'zh-hans' => '中国語',
		'ko'      => '韓国語'
	);
	$tag .= $tb . "" . '<p>oo_switch_langg( $def, $word_arr ) : ' . oo_switch_langg( $def, $word_arr ) . '</p>' . "\n";
	$tag .= $tb . "" . '<p>oo_switch_langg( $def, $word_arr ) : ' . oo_switch_langg( '日本語', array( 'en' => '英語', 'zh-hans' => '中国語', 'ko' => '韓国語' ) ) . '</p>' . "\n";

	// oo_is_lang( $lang_code )
	$lang_code = 'ja';
	$tag .= $tb . "" . '<p>oo_is_lang( "ja" ) : ' . var_export( oo_is_lang( 'ja' ),true ) . '</p>' . "\n";
	$tag .= $tb . "" . '<p>oo_is_lang( "en" ) : ' . var_export( oo_is_lang( 'en' ),true ) . '</p>' . "\n";
	$tag .= $tb . "" . '<p>oo_is_lang( "zh-hans" ) : ' . var_export( oo_is_lang( 'zh-hans' ),true ) . '</p>' . "\n";
	$tag .= $tb . "" . '<p>oo_is_lang( "ko" ) : ' . var_export( oo_is_lang( 'ko' ),true ) . '</p>' . "\n";
	if( oo_is_lang( 'ja' ) ) {
		$tag .= $tb . "" . '<p>現在、日本語サイト表示</p>' . "\n";
	} elseif( oo_is_lang( 'en' ) ) {
		$tag .= $tb . "" . '<p>現在、英語サイト表示</p>' . "\n";
	} elseif( oo_is_lang( 'zh-hans' ) ) {
		$tag .= $tb . "" . '<p>現在、中国語サイト表示</p>' . "\n";
	} elseif( oo_is_lang( 'ko' ) ) {
		$tag .= $tb . "" . '<p>現在、韓国語サイト表示</p>' . "\n";
	}
	echo $tag;

	if( oo_is_lang( 'ja' ) ) {
?>
					<p>現在、日本語サイト表示</p>
<?php
	} elseif( oo_is_lang( 'en' ) ) {
		$tag .= $tb . "" . '<p>現在、英語サイト表示</p>' . "\n";
	} elseif( oo_is_lang( 'zh-hans' ) ) {
		$tag .= $tb . "" . '<p>現在、中国語サイト表示</p>' . "\n";
	} elseif( oo_is_lang( 'ko' ) ) {
		$tag .= $tb . "" . '<p>現在、韓国語サイト表示</p>' . "\n";
	}
?>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">リンク例</h3>
						<div class="part texts">
							<div class="texts_cont texts">
								<p><a href="<?= LDIR ?>/xxx/yyy/">一般リンク</a></p>
							</div>
						</div>
					</div>
					<div class="box">
						<h3 class="heading03">HEADING2</h3>
						<div class="part">
							<div class="texts_cont texts">
								<ul class="side_navi">
									<li><a href="/wpml/sample">日本語</a></li>
									<li><a href="/en/wpml/sample">英語</a></li>
									<li><a href="/zh-hans/wpml/sample">中国語</a></li>
									<li><a href="/ko/wpml/sample">韓国語</a></li>
									<li><a href="<?= LDIR ?>/wpml/sample">現在のページ</a></li>
								</ul>
							</div>
						</div>
					</div>
				</section>
			</div>
