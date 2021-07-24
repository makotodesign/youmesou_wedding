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
					<ul class="topnav_list">
						<li><a href="<?= FACEBOOK ?>" class="facebook sns_link" target="_blank"></a></li>
						<li><a href="<?= INSTAGRAM ?>" class="instagram sns_link" target="_blank"></a></li>
						<li><a href="/english/"  class="buttoned_link"><span>English</span></a></li>
					</ul>
				</div>
			</div>
			<div class="header">
				<a class="logo_set" href="/">
					<p class="logo"><span><img src="/images/common/logo_wedding.png" width="300" alt="結水荘ウェディング"></span></p>
				</a>
				<p class="gnav_btn menu"><span></span><span></span><span></span></p>
				<nav class="gnav">
					<ul class="topnav_list hide_pc">
						<li><a href="<?= FACEBOOK ?>" class="facebook sns_link" target="_blank"><span>Facebook</span></a></li>
						<li><a href="<?= INSTAGRAM ?>" class="instagram sns_link" target="_blank"><span>Instagram</span></a></li>
						<li><a href="/english/"  class="buttoned_link"><span>English</span></a></li>
					</ul>
					<ul class="gnav_list">
						<li><a href="/" data-gnav="home"><span>HOME</span></a></li>
						<li><a href="/plan/"><span>プラン紹介</span></a></li>
						<li><a href="/weblog/"><span>結水荘日記</span></a></li>
						<li><a href="/member/"><span>メンバー紹介</span></a></li>
						<li><a href="/access/"><span>アクセス</span></a></li>
						<li><a href="/contact/"><span>お問い合わせ</span></a></li>
					</ul>
				</nav>
			</div>
<?php	include_once ROOTREALPATH . '/wp/wp-content/themes/base/parts_breadcrumb.php'; ?>
		</header>
