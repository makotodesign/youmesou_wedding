<?php
/*--------------------------------------------------------------

	setting

	@version
		18.1.1

	@memo
		2019-03-05	公開パスはsite_configphpに以降 [ 13.1.1 ]
		2021-05-05	大幅整理 [ 18.1.1 ]

---------------------------------------------------------------*/

##	base

	/* site */
	const PUBLICDIR           = '';

##	common

	/* site */
	const SITENAME               = '結水荘Wedding';
	const META_DESCRIPTION       = '神戸垂水の古民家で一生の思い出に残るウェディングはいかがですか。撮影プラン10万円〜、挙式プラン１０万円〜、撮影+挙式プラン15万円';
	const META_KEYWORDS          = '結婚式会場、レンタル、古民家、ウェディング会場';
	const GOOGLE_ANALYTICS_ID    = 'UA-00000000-1';
	const RECAPTCHA_V3_SITEKEY   = ''; // reCAPTCHA v3 サイトキー
	const RECAPTCHA_V3_SECRETKEY = ''; // reCAPTCHA v3 シークレットキー
	const GOOGLE_API_KEY         = ''; // AIzaSyDvD13PIcDRAUGj1CCR4oyJSktL31UInyc
	const FACEBOOK               = 'https://www.facebook.com/yumiso111';
	const INSTAGRAM               = 'https://www.instagram.com/youmesowedding';

	/* tax ( 2021-04-01- ) */
	define( 'TAXRATE', 1.1 );
	define( 'TAXWORD', '税込' );

	/* fonts preload */
	const FONTS_PRELOAD = [
		// pc def:overwrite
		'googlefonts_pc' => [
			'noto_sans' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap'
			// 'noto_serif' => 'https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@400;700&display=swap'
			//'noto_sans' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700;900&family=Noto+Serif+JP:wght@400;700&display=swap'
		],
		// sp def:overwrite
		'googlefonts_sp' => [
		],
		// 共通読み込み
		'otherfonts' => [
			// PUBLICDIR . '/utility/fonts/yakuhanjp'
		]
	];
