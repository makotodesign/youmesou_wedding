<?php
/*--------------------------------------------------------------------------

	Template Name: youtube
	
	@memo
		
---------------------------------------------------------------------------*/

##	page setting
	
	/* contents_module */
	include_once ROOTREALPATH . '/mod/lib/google_api/autoload.php';
	include_once ROOTREALPATH . '/mod/lib/google_api/Client.php';
	include_once ROOTREALPATH . '/mod/lib/google_api/Service/YouTube.php';

	$youtube_api_key = 'AIzaSyCCJQV2xiukYNzU4320Hi9skjk1D3UjyXY';
	/* memo
		https://code.google.com/apis/console/  											 // API取得先 （要gmail）
		http://oldoffice.org/memo/2015/06/19/youtube-v3-%e4%bd%bf%e3%81%84%e6%96%b9/     // 設定用メモ
	*/
	
	// thumbnails array
	/* ref
	 ["thumbnails"]=>
	  array(3) {
		["default"]=> array(3) {
		  ["url"]=> string(46) "https://i.ytimg.com/vi/Ts7zZGU35JA/default.jpg"
		  ["width"]=> int(120)
		  ["height"]=> int(90)
		}
		["medium"]=> array(3) {
		  ["url"]=>    string(48) "https://i.ytimg.com/vi/Ts7zZGU35JA/mqdefault.jpg"
		  ["width"]=>  int(320)
		  ["height"]=> int(180)
		}
		["high"]=> 	array(3) {
		  ["url"]=>    string(48) "https://i.ytimg.com/vi/Ts7zZGU35JA/hqdefault.jpg"
		  ["width"]=>  int(480)
		  ["height"]=> int(360)
		}
	  }
	*/
	
	## function
	// 時間変換function
	function convert_youtube_time( $youtube_time ) {
		preg_match_all('/(\d+)/', $youtube_time, $parts );
	
		if ( count( $parts[ 0 ]) == 1 ) {
			array_unshift( $parts[ 0 ], "0", "0" );
		} elseif ( count( $parts[ 0 ] ) == 2 ) {
			array_unshift( $parts[ 0 ], "0" );
		}
	
		$sec_init = $parts[ 0 ][ 2 ];
		$seconds = $sec_init % 60;
		$seconds_overflow = floor( $sec_init / 60 );
	
		$min_init = $parts[ 0 ][ 1 ] + $seconds_overflow;
		$minutes = ( $min_init ) % 60;
		$minutes_overflow = floor( ( $min_init ) / 60 );
	
		$hours = $parts[ 0 ][ 0 ] + $minutes_overflow;
	
		if( $hours != 0 ){
			return $hours.':'.$minutes.':'.$seconds;
		} else {
			return $minutes.':'.$seconds;
		}
	}
	
/*---------------------------------------------------------------------------*/
?>
	<div class="contents_wrap">
		<div class="contents">
			<div class="<?= DIRCODE ?>_<?= PAGECODE ?>_contents main_contents">
				<div class="area">
					<section>
						<div class="hgroup">
							<h2 class="heading02">***</h2>
						</div>
						<div class="box">
							<div class="part texts">
								<p><?php $SENDMAIL->disp_message();?></p>
<?php
	// 動画の取得
	$video_id = "xxxxxxxx";
	$client = new Google_Client();
	$client->setDeveloperKey( $youtube_api_key );
	$youtube = new Google_Service_YouTube( $client );
	$video_data_arr = $youtube->videos->listVideos( 'snippet,contentDetails', array(
		'id' => $video_id
	));	
	$video_data = $video_data_arr[ 0 ];
	$video_id           = $video_id;
	$video_title        = $video_data[ "snippet" ]->title;
	$video_description  = $video_data["snippet"]["description"];
	$video_publish_date = date_oo( 'Y-m-d H:i:s', strtotime( $video_data[ "snippet" ]->publishedAt ) );
	$video_thumbnail    = $video_data[ "snippet" ][ "thumbnails" ][ "high" ][ "url" ];
	$video_time         = convert_youtube_time( $video_data[ "contentDetails" ][ 'duration' ] );
		
	// プレイリストの動画を取得
	$playlist_id = "xxxxxxxxxxx";
	$client = new Google_Client();
	$client->setDeveloperKey( $youtube_api_key );
	$youtube = new Google_Service_YouTube( $client );
	$playListItems = $youtube->playlistItems->listPlaylistItems( 'snippet,contentDetails', array(
		'playlistId' => $playlist_id,
		'maxResults' => 1
	));
	$video = [];
	foreach( $playListItems[ 'items' ] as $item ){
		$video[ "video_id" ]      = $item[ "contentDetails" ][ "videoId" ];
		$video[ "title" ]         = $item[ "snippet" ]->title; 
		$video[ "published" ]     = date_oo( 'Y-m-d H:i:s',strtotime( $item[ "snippet" ]->publishedAt ) );
		$video[ "thumbnail_url" ] = $item[ "snippet" ][ "thumbnails" ][ "high" ][ "url" ];
		$video[ "description" ]   = $item[ "snippet" ][ "description" ];
	}
	
?>
							</div>
						</div>
					</section>
				</div>
			</div>				
		</div>
	</div>
<?php	include_once ROOTREALPATH . "/data/includes/footer_mod.php";?>