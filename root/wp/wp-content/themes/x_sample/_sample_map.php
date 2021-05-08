<?php
/*--------------------------------------------------------------------------

	Template Name: page_sample_map

	@memo

---------------------------------------------------------------------------*/

##	page setting

	/* base */
	$PAGENAME            = 'アクセスマップ';
	$DIRNAME             = 'ディレクトリ';
	define( 'DIRCODE',  'sample' );
	define( 'PAGECODE', 'map' );

	/* includes */
	include_once ROOTREALPATH . '/mod/setup/setup.php';

	/* contents_module */
	include_once ROOTREALPATH . '/mod/lib/map_script_func.php';

	/* map_setting */
	// tool : http://www.geocoding.jp/
	$map_set_arr = [
		[
			'map_id'           => 'map01',
			'map' => [
				'lat'           => 34.718067,
				'lng'           => 135.261194,
				'zoom'          => 15
			],
			'markers' => [
				[
					'title'     => 'TITLE0',
					'address'   => '〒0010001<br>ADDRESSADDRESSADDRESSADDRESS',
					'open'      => 'true',
					'lat'       => 'false',
					'lng'       => 'false',
					'icon'      => 'def' // def || parking
				]
			]
		]
	];

	/* js */
	$HEAD->js = '';
	$HEAD->js .= "\t" . '<script src="https//maps.google.com/maps/api/js?key=' . GOOGLE_API_KEY . '"></script>' . "\n";
	$HEAD->js .= map_setting_script( $map_set_arr );
	$HEAD->js .= "\t" . '<script src="' . $HEAD->fpath_add_date_query( '/js/utility/gmap.js' ) . '"></script>' . "\n";

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
						<div class="part map_part">
							<div class="cont map_cont">
								<div id="map01" class="map"></div>
							</div>
						</div>
						<div class="part map_info_part">
							<div class="cont">
								<address>〒000-0000　ADDRESS</address>
								<p class="link_gmap"><a target="_blank" href="GOOGLE_MAP_URL">Google Map</a></p>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="part map_part">
							<div class="cont map_cont">
								<div id="map02" class="map"></div>
							</div>
						</div>
						<div class="part map_info_part">
							<div class="cont">
								<address>〒000-0000　ADDRESS</address>
								<p class="link_gmap"><a target="_blank" href="GOOGLE_MAP_URL">Google Map</a></p>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="part map_part">
							<div class="cont map_iframe_wrap">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3279.4891919452502!2d135.2589751161705!3d34.71806168043003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60008c559ae013a5%3A0x5edfbef1d2694a3d!2zT2xkIE9mZmljZSAmIENPLiAvIOagquW8j-S8muekvuOCquODvOODq-ODieOCquODleOCo-OCuQ!5e0!3m2!1sja!2sjp!4v1581600384965!5m2!1sja!2sjp" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
							</div>
							<div class="cont btn_wrap">
								<a href="https://goo.gl/maps/WVge77LMgAJdM4z17" class="button" target="_blank"><span>Googleマップ</span></a>
							</div>
						</div>
					</div>
					<div class="box">
						<div class="part">
							<div class="cont texts">
								<h3 class="heading04 icon_train">電車でお越しの方へ</h3>
								<ul>
									<li>JR○○駅 徒歩3分</li>
									<li>阪神電鉄○○駅 徒歩3分</li>
								</ul>
							</div>
						</div>
						<div class="part">
							<div class="cont texts">
								<h3 class="heading04 icon_car">お車でお越しの方へ</h3>
								<ul>
									<li>だみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうですだみーぶんしょうです</li>
								</ul>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
<?php	include_once TEMPLATEPATH . '/parts_footer.php';?>
