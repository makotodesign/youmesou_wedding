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
					<p class="footer_name">COMPANYNAME</p>
					<p class="footer_address">〒000-0000<br>ADDRESS</p>
					<div class="footer_tel_set">
						<p class="footer_tel mark_title tel" title="TEL"><a href="tel:000-000-0000">000-000-0000</a></p>
						<p class="footer_fax mark_title fax" title="FAX"><a href="tel:000-000-0000">000-000-0000</a></p>
					</div>
				</address>
				<nav class="footer_sitenav">
					<div class="footer_sitenav_cont">
						<ul>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
						</ul>
					</div>
					<div class="footer_sitenav_cont">
						<ul>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
						</ul>
					</div>
					<div class="footer_sitenav_cont">
						<h4 class="footer_sitenav_heading">メニュータイトル</h4>
						<ul>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
							<li><a href="/xx/" class="icon_arrow">MENU</a></li>
						</ul>
					</div>
				</nav>
			</div>
			<div class="copyright_wrap">
				<p class="copyright"><small>&copy; Copyright . All Rights Reserved.</small></p>
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