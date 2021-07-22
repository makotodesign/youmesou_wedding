<?php
/*--------------------------------------------------------------------------

	parts_header

	@memo

---------------------------------------------------------------------------*/

##	header_mod



/*-------------------------------------------------------------------------*/

?>
		<header class="header_wrap">
			<div class="header_topnav_wrap hide_sp_tb">
				<div class="header_topnav">
					<ul class="ecnav_list">
						<li><a href="/ec/mypage/login" id="topnav_ec_login" class="v_ec_login <?= $ec_login_class ?>"><span>ログイン</span></a></li>
						<li><a href="/ec/entry" id="topnav_ec_register" class="v_ec_register <?= $ec_login_class ?>"><span>会員登録</span></a></li>
						<li><a href="/ec/logout" id="topnav_ec_logout" class="v_ec_logout <?= $ec_login_class ?>"><span>ログアウト</span></a></li>
						<li><a href="/ec/mypage/favorite" id="topnav_ec_favorite" class="v_ec_favorite <?= $ec_login_class ?>"><span>お気に入り</span></a></li>
						<li><a href="/ec/mypage/" id="topnav_ec_mypage" class="v_ec_mypage <?= $ec_login_class ?>"><span>MYページ</span></a></li>
					</ul>
				</div>
			</div>
			<div class="header">
				<a class="logo_set" href="/">
					<p class="logo"><span><img src="/images/common/logo.svg" width="300" height="60" alt="必ず記述"></span></p>
				</a>
<?php
	/* memo */
	// base.jsで hnav_list がhnav_wrapに囲まれた上でここに移動します
	/* pc : hnav ナビや検索、電話番号など表示 */
	// markup はgnav内に記載
/*
				<nav class="hnav">
					<ul class="hnav_list">
						<li><a href="/xx/" class="icon_arrow"><span>MENU</span></a></li>
						<li><a href="/xx/" class="icon_arrow"><span>MENU</span></a></li>
					</ul>
					<form class="hsearch" method="post" action="">
						<div class="search_cont">
							<p class="input_wrap"><input type="text" name="" place_polder="Search･･･"></p>
							<button type="submit"><span>検索</span></button>
						</div>
					</form>
					<div class="langnav">
						<p class="lang_current"><span>Ja</span></p>
						<ul class="langnav_list">
							<li><a href="/en/"><span>En</span></a></li>
						</ul>
					</div>
					<div class="hcontact">
						<p class="header_tel"><a href="tel:000-000-0000"><span class="icon_tel">TEL</span><span>000-000-0000</span></a></p>
					</div>
				</nav>
*/
?>
				<p class="gnav_btn menu"><span></span><span></span><span></span></p>
<?php
/* gnav が headerの「下」or「横」 */
// 下の場合は下記 ganv_wrap 必要
/*
			</div>
			<div class="gnav_wrap">
*/
?>
				<nav class="gnav">
					<ul class="topnav_list hide_pc">
						<li><a href="/xx/"><span>MENU</span></a></li>
						<li><a href="/xx/"><span>MENU</span></a></li>
					</ul>
					<ul class="gnav_list">
						<li><a href="/" data-gnav="home"><span>HOME</span></a></li>
						<li><a href="/aaa/"><span>MENU_A</span></a></li>
						<li class="submenu_wrap">
							<a href="/bbb/"><span>MENU_B</span></a>
							<div class="submenu">
								<ul>
									<li><a href="/bbb/bb01/"><span>MENU_B_01</span></a></li>
									<li><a href="/bbb/bb02/"><span>MENU_B_02</span></a></li>
								</ul>
							</div>
						</li>
						<li class="submenu_wrap">
							<a href="/ccc/"><span>MENU_C</span></a>
							<div class="submenu">
								<ul>
									<li><a href="/xx/" ><span>xx</span></a></li>
									<li><a href="/xx/sample_markup.php" ><span>sample_markup</span></a></li>
									<li><a href="/contact/" ><span>contact</span></a></li>
									<li><a href="/news/" ><span>news</span></a></li>
									<li><a href="/productsec/65" ><span>productsec</span></a></li>
								</ul>
							</div>
						</li>
						<li><a href="/ddd/"><span>MENU_D</span></a></li>
						<li><a href="/eee/" data-navcurrent="false"><span>MENU_E</span></a></li>
					</ul>
				</nav>
			</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_breadcrumb.php'; ?>
		</header>
