<?php
/*--------------------------------------------------------------------------

	Template Name: xx_facebook_like_btn
	
	@memo
		
---------------------------------------------------------------------------*/

##	page_setting
	
	/* page_option ( over write ) : title / meta / h1 / og_cullent_img */
	$HEAD->disp_facebook_like   = true;
	$HEAD->disp_twitter_tweet   = true;
	$HEAD->og_current_image_url = 'イメージURL';
	
/*---------------------------------------------------------------------------*/
?>
		<div class="contents_wrap">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents contents">
				<div class="mono_area">
					<section>
						
						<div class="box">
							<div class="part">
								<div class="fb-like" data-href="現在のURL" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="true"></div>
								<div class="tw_tweet"><a href="https://twitter.com/share" class="twitter-share-button" data-url="現在のURL" data-size="large">Tweet</a></div>
								<!--cf : <a href="https://twitter.com/share" class="twitter-share-button" data-url="【ページのURL】" data-text="【ツイート本文】" data-via="【ユーザ名】" data-size="【ボタンのサイズ】" data-related="【ユーザ名】" data-count="【カウント表示の種類】" data-hashtags="【ハッシュタグ】">Tweet</a>-->
							</div>
						</div>
						
					</section>
				</div>
			</div>
		</div>
