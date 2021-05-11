<?php
/*--------------------------------------------------------------------------

	parts_sidebar

	@memo

	@reference
		x_sample / _parts_sidebar_max

---------------------------------------------------------------------------*/
?>
				<nav class="area side_area">
<?php	if( DIRCODE === 'news' ) : ?>
					<div class="side_box">
						<ul class="sidenav">
							<li><a href="/news/"><span>お知らせ一覧</span></a></li>
<?php		foreach( wp_oo_sidebar_backnumber( 'posttype_xxx', 'yearly' ) as $v ) : ?>
							<li><a href="<?= $v[ 'link' ][ 'link' ] . $v[ 'link' ][ 'link' ] ?>"><span><?= $v[ 'name' ] ?>（<?= $v[ 'count' ] ?>）</span></a></li>
<?php		endforeach; ?>
						</ul>
					</div>
<?php	elseif( DIRCODE === 'contact' || DIRCODE === 'privacy' ) : ?>
					<div class="side_box">
						<ul class="sidenav">
							<li><a href="/contact/"><span>お問い合わせ</span></a></li>
							<li><a href="/privacy/"><span>個人情報保護方針</span></a></li>
						</ul>
					</div>
<?php	elseif( DIRCODE === 'xxx' ) : ?>
					<div class="side_box">
						<ul class="sidenav">
							<li><a href="/aaa/"><span>AAA</span></a></li>
							<li><a href="/bbb/"><span>BBB</span></a></li>
						</ul>
					</div>
<?php	elseif( DIRCODE === 'sample_posttype' ) : ?>
					<div class="side_box">
						<h3 class="heading_side">category</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_taxonomy( 'cat_xxx' ) as $v ) : ?>
							<li><a href="<?= $v[ 'link' ] ?>"><span><?= $v[ 'name' ] ?>（<?= $v[ 'count' ] ?>）</span></a></li>
<?php		endforeach; ?>
						</ul>
					</div>
					<div class="side_box">
						<h3 class="heading_side">category</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_taxonomy( 'cat_xxx' ) as $v ) : ?>
							<li class="sidenav_openclose_wrap">
								<a class="sidenav_openclose_handle plus"><span><?= $v[ 'name' ] ?></span></a>
								<ul class="child sidenav_openclose_target">
<?php			foreach( $v[ 'child' ] as $vv ) : ?>
									<li><a href="<?= $vv[ 'link' ] ?>"><span><?= $vv[ 'name' ] ?></span></a></li>
<?php			endforeach; ?>
								</ul>
							</li>
<?php		endforeach; ?>
						</ul>
					</div>
					<div class="side_box">
						<h3 class="heading_side">back number</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_backnumber( 'posttype_xxx', 'yearly' ) as $v ) : ?>
							<li><a href="<?= $v[ 'link' ] ?>"><span><?= $v[ 'name' ] ?>（<?= $v[ 'count' ] ?>）</span></a></li>
<?php		endforeach; ?>
						</ul>
					</div>
					<div class="side_box">
						<h3 class="heading_side">back number</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_backnumber( 'posttype_xxx', 'monthly' ) as $v ) : ?>
							<li><a href="<?= $v[ 'link' ] ?>"><span><?= $v[ 'name' ] ?>（<?= $v[ 'count' ] ?>）</span></a></li>
<?php		endforeach; ?>
						</ul>
					</div>
					<div class="side_box">
						<h3 class="heading_side">back number</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_backnumber( 'posttype_xxx', 'yearly_monthly' ) as $v ) : ?>
							<li class="sidenav_openclose_wrap">
								<a class="sidenav_openclose_handle plus"><span><?= $v[ 'name' ] ?></span></a>
								<ul class="child sidenav_openclose_target">
<?php		foreach( $v[ 'child' ] as $v ) : ?>
									<li><a href="<?= $vv[ 'link' ] ?>"><span><?= $vv[ 'name' ] ?></span></a></li>
<?php		endforeach; ?>
								</ul>
							</li>
<?php		endforeach; ?>
						</ul>
					</div>
					<div class="side_box">
						<h3 class="heading_side">recent</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_recent( 'posttype_xxx' ) as $v ) : ?>
							<li><a href="<?= $v[ 'link' ] ?>"><span><?= $v[ 'name' ] ?></span></a></li>
<?php		endforeach; ?>
						</ul>
					</div>
<?php	else : ?>
					<div class="side_box">
						<h3 class="heading_side">めにゅーみだし</h3>
						<ul class="sidenav">
							<li><a href="/xx/sample_markup.php"><span>sample_markup</span></a></li>
							<li class="sidenav_openclose_wrap">
								<a class="sidenav_openclose_handle plus"><span>メニュー開閉</span></a>
								<ul class="child sidenav_openclose_target">
									<li><a href="/menu/child/"><span>チャイルド</span></a></li>
									<!--
									<li class="sidenav_openclose_wrap">
										<a class="sidenav_openclose_handle plus"><span>チャイルド開閉</span></a>
										<ul class="child sidenav_openclose_target">
											<li><a href="/menu/"><span>まごメニュー</span></a></li>
										</ul>
									</li>
									-->
								</ul>
							</li>
						</ul>
					</div>
<?php	endif; ?>
				</nav>
