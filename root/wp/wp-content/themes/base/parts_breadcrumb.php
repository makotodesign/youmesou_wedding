<?php
/*--------------------------------------------------------------------------

	parts_footer

	@memo

---------------------------------------------------------------------------*/

##	setting

	/* reference

		breadcrumb が スクロールするかしないか
			スクロールさせる場合は「headeer」の下に配置。タブをひとつ減らす

		$breadcrumb_arr のキー
			current  : 現在のページ
			nolink.* : リンクなし

	*/

/*-------------------------------------------------------------------------*/
?>
<?php	if( isset( $breadcrumb_arr ) ) : ?>
<?php		if( defined( 'DIRCODE' ) && DIRCODE !== 'top' ) : ?>
			<div class="breadcrumb_wrap">
				<nav class="breadcrumb">
					<ul>
						<li><a href="/">HOME</a></li>
<?php			foreach( $breadcrumb_arr as  $k => $v ) : ?>
<?php				if( $k === 'current' ) : ?>
						<li class="current"><span><?= $v ?></span></li>
<?php				elseif( $k === 'nolink' ) : ?>
						<li><span><?= $v ?></span></li>
<?php				elseif( $v ) : ?>
						<li><a href="<?= $k ?>"><?= $v ?></a></li>
<?php				endif;?>
<?php			endforeach;?>
					</ul>
				</nav>
			</div>
<?php		endif;?>
<?php	endif;?>
