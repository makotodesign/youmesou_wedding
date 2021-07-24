<?php
/*--------------------------------------------------------------------------

	parts_footer

	@memo

---------------------------------------------------------------------------*/

##	footer_mod

	/* xx */

/*-------------------------------------------------------------------------*/
?>
		<footer class="footer_wrap">
			<div class="footer">
				<address class="footer_profile">
					<p class="footer_name"><img src="/images/common/ci.png" alt="結水荘（ゆうみそう）" width="40px">結水荘<span class="supple">（ゆうみそう）</span></p>
					<p class="footer_address">〒655-0033<br>兵庫県神戸市垂水区旭が丘1丁目5-26 </p>
					<p class="footer_link"><a href="https://youmeso.ts-network.co.jp/" target="_blank"><span>https://youmeso.ts-network.co.jp/</span></a></p>
					<div class="footer_tel_set">
						<p class="footer_tel mark_title tel" title="TEL"><a href="tel:080-7037-4947">080-7037-4947</a></p>
					</div>
				</address>
				<nav class="footer_sitenav">
					<div class="footer_sitenav_cont">
						<ul>
							<li><a href="/" class="icon_arrow">HOME</a></li>
							<li><a href="/plan/" class="icon_arrow">プラン</a></li>
							<li><a href="/weblog/" class="icon_arrow">結水荘日記</a></li>
							<li><a href="/member/" class="icon_arrow">メンバー紹介</a></li>
							<li><a href="/english/" class="icon_arrow">English</a></li>
							<li><a href="/contact/" class="icon_arrow">お問い合わせ</a></li>
						</ul>
					</div>
				</nav>
			</div>
			<div class="copyright_wrap">
				<p class="copyright"><small>&copy; Copyright . Youmeso All Rights Reserved.</small></p>
			</div>
		</footer>
		<div class="pagetop">
			<a href="#top"><span></span></a>
		</div>
	</div>
	<div id="loading_wrap" class="loading_wrap"><img src="/images/lib/parts/loading.svg" alt="loading"></div>
<?php
	if( isset( $HEAD ) ) {
		echo $HEAD->res_tag_modal();
		echo $HEAD->res_tag_foot();
	}
	if( isset( $conversion_tag ) && $conversion_tag ){
		echo $conversion_tag;
	}
	if( isset( $debug_report ) && $debug_report ) {
		echo '<!--' . "\n" .  $debug_report . "\n" . '-->' . "\n";
	}
?>
</body>
</html>