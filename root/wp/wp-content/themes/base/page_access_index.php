<?php
/*--------------------------------------------------------------------------

	Template Name: page_access_index

	@memo

---------------------------------------------------------------------------*/

##	page_setting

	/* base */
	$PAGENAME            = '結水荘へのアクセス';
	$DIRNAME             = 'アクセス';
	define( 'DIRCODE',  'access' );
	define( 'PAGECODE', 'index' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	//include_once ROOTREALPATH . '/mod/contents/' . DIRCODE . '_' . PAGECODE . '_wp_mod.php';

	/* js */
	$HEAD->js = '';
	//$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/' . DIRCODE . '/script.js' ) . '"></script>' . "\n";

	/* page_option */
	$HEAD->title                = 'auto';
	// $HEAD->title                = $wp_page_title;
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
				<h1 class="title_text"><?= $PAGENAME ?></h1>
			</div>
		</div>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<section class="area">
					<div class="box">
						<div class="part map_part">
							<div class="cont googlemap">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282.8273799285475!2d135.05173591522424!3d34.63380228045173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x600083be429c31f9%3A0xb0d203249f27c5f2!2z57WQ5rC06I2YICjjgobjgYbjgb_jgZ3jgYbjg7tZdW1pc2_vvInmmK3lkozjga7pgrjlroXjg6zjg7Pjgr_jg6vjgrnjg5rjg7zjgrk!5e0!3m2!1sja!2sjp!4v1627168198700!5m2!1sja!2sjp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
							</div>
							<div class="cont summary">
								<div class="address texts">
									<p>〒655-0033 <br class="hide_tb_pc">兵庫県神戸市垂水区旭が丘1丁目５-26</p>
									<p class="tel" title="TEL"><a href="tel:080-7037-4947">080-7037-4947</a></p>
									<p><a href="https://goo.gl/maps/DEiQWqoivhm4YQKh8" class="button btn_small" target="_blank"><span>Google Maps</span></a></p>
								</div>
								<div class="railway texts">
									<h5 class="heading05">電車でお越しの方へ</h5>
									<p>JR神戸線「垂水駅」・山陽電鉄「山陽垂水駅」</p>
									<ol>
										<li>JR垂水駅東口（山電の場合は、改札出て、高架下ショッピングモールを東に抜けるとJR垂水駅の東口に出ます）より、北（みなと銀行のある方）へ進みます。</li>
										<li>商店街を抜けて、垂水小学校の西端に沿ってさらに進むと、お地蔵様が見えてきます。</li>
										<li>そのお地蔵様の向かって左側の道をT字路に行き当たるまで、進みます。</li>
										<li>行き当たりましたら、少し右を覗いていただくと、2階に赤いエステサロンの看板がある建物が見えます。（建物下の角にはごみステーションがあります）</li>
										<li>その建物の手前の路地が結水荘のある路地です。路地をさらに100mほどお進みください。</li>
									</ol>
								</div>
								<div class="car texts">
									<h5 class="heading05">お車でお越しの方へ</h5>
									<p>＊結水荘前の路地には車は入れません。<br>＊地図アプリ等のルート検索では、結水荘の西側の道を示すことがありますが、入口は東側路地のみになりますのでご注意ください。</p>
									<p>最寄りのコインパーキングは「タイムズ垂水旭が丘」です</p>
									<p class="link_arrow link_external"><a href="https://times-info.net/P28-hyogo/C108/park-detail-BUK0035838/" target="_blank">コインパーキング詳細</a></p>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php'; ?>
