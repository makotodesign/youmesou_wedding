		<header class="header_wrap">
<?php
	/* memo */
	// base.jsで topnav_list がtopnav,topnav_wrapに囲まれた上でここに移動します
?>
			<div class="header">
				<a class="logo_set" href="/">
					<h1 class="logo"><span><img src="/images/common/logo.svg" alt="XXX"></span></h1>
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

/* グロナビがロゴの「下」or「横」 */
// 下の場合は下記 ganv_wrap 必要
// base.js /* gnav */ あわせて変更
/*
			</div>
			<div class="gnav_wrap">
*/
?>
				<nav class="gnav">
					<ul class="topnav_list">
						<li><a href="/xx/" class="icon_arrow"><span>MENU</span></a></li>
						<li><a href="/xx/" class="icon_arrow"><span>MENU</span></a></li>
					</ul>
					<ul class="gnav_list">
						<li><a href="/" data-gnav="home"><span>HOME</span></a></li>
						<li><a href="/aaa/"><span>MENU_A</span></a></li>
						<li class="submenu_wrap">
							<a href="/bbb/"><span>MENU_B</span></a>
							<div class="submenu">
								<ul>
									<li><a class="submenu_link" href="/bbb/bb01/" title="B_01"><span>MENU_B_01</span></a></li>
									<li><a class="submenu_link" href="/bbb/bb02/" title="B_02"><span>MENU_B_02</span></a></li>
								</ul>
							</div>
						</li>
						<li class="submenu_wrap">
							<a href="/ccc/"><span>MENU_C</span></a>
							<div class="submenu">
								<ul>
									<li><a class="submenu_link" href="/ccc/cc01/" title="B_01"><span>MENU_C_01</span></a></li>
									<li><a class="submenu_link" href="/ccc/cc02/" title="B_02"><span>MENU_C_02</span></a></li>
								</ul>
							</div>
						</li>
						<li><a href="/ddd/"><span>MENU_D</span></a></li>
						<li><a href="/eee/" data-navcurrent="false"><span>MENU_E</span></a></li>
					</ul>
				</nav>
			</div>
		</header>
