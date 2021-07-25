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
<?php		foreach( wp_oo_sidebar_backnumber( 'news', 'yearly' ) as $v ) : ?>
							<li><a href="<?= $v[ 'link' ] ?>"><span><?= $v[ 'name' ] ?>（<?= $v[ 'count' ] ?>）</span></a></li>
<?php		endforeach; ?>
						</ul>
					</div>
<?php	elseif( DIRCODE === 'weblog' ) : ?>
					<div class="side_box">
						<h3 class="heading_side">バックナンバー</h3>
						<ul class="sidenav">
<?php		foreach( wp_oo_sidebar_backnumber( 'weblog', 'yearly_monthly' ) as $v ) : ?>
							<li class="sidenav_openclose_wrap">
								<a class="sidenav_openclose_handle plus"><span><?= $v[ 'name' ] ?></span></a>
								<ul class="child sidenav_openclose_target">
<?php		foreach( $v[ 'child' ] as $vv ) : ?>
									<li><a href="<?= $vv[ 'link' ] ?>"><span><?= $vv[ 'name' ] ?></span></a></li>
<?php		endforeach; ?>
								</ul>
							</li>
<?php		endforeach; ?>

						</ul>
					</div>
<?php	endif; ?>
				</nav>
