/* gmap */

/****************************************************

	[tools]
	http://www.geocoding.jp/

****************************************************/

jQuery(function($) {
	// 変数は基本的にページに直接記述

	var mapinfo = [
		{
			mapwrap: 'map01', // MAP表示タグのid属性
			map: {
				lat: 34.718067, // MAP中央緯度
				lng: 135.261194, // MAP中央経度
				zoom: 15
			},
			markers: [
				// marker01
				{
					open: true, // infowindow の初期状態
					title: 'TITLE01',
					address: '〒0010001<br>ADDRESSADDRESSADDRESSADDRESS',
					lat: false, // 中央以外の場合はlat値
					lng: false, // 中央以外の場合はlng値
					icon: {
						use: false
					}
				}
			]
		},
		// 複数マップの指定 * 同一ページでも別ページでも可
		{
			mapwrap: 'map02', // MAP表示タグのid属性
			map: {
				lat: 34.718067, // MAP中央緯度
				lng: 135.261194, // MAP中央経度
				zoom: 15
			},
			markers: [
				// marker01
				{
					open: true,
					title: 'TITLE02_01',
					address: '〒0020001<br>ADDRESSADDRESSADDRESSADDRESS',
					lat: false, // 中央以外の場合はlat値
					lng: false, // 中央以外の場合はlng値
					icon: {
						use: false
					}
				},
				// marker02
				{
					open: false,
					title: 'TITLE02_02',
					address: '〒0020002<br>ADDRESSADDRESSADDRESSADDRESS',
					lat: 34.719367,
					lng: 135.262394,
					icon: {
						use: true,
						url:
							'https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png', // パーキングのアイコン
						size: {
							w: 32,
							h: 32
						}
					}
				}
			]
		}
	];

	function gmap() {
		google.maps.event.addDomListener(window, 'load', function() {
			// map_base
			for (var i = 0; i < mapinfo.length; i++) {
				var mapdiv = document.getElementById(mapinfo[i].mapwrap);
				var mapOptions = {
					zoom: mapinfo[i].map.zoom,
					center: new google.maps.LatLng(
						mapinfo[i].map.lat,
						mapinfo[i].map.lng
					),
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					scaleControl: true
				};
				var map = new google.maps.Map(mapdiv, mapOptions);
				// markers
				mapinfo[i].markers.forEach(function(v, index, arr) {
					var markerOptions = {
						position: new google.maps.LatLng(
							v.lat ? v.lat : mapinfo[i].map.lat,
							v.lng ? v.lng : mapinfo[i].map.lng
						),
						map: map,
						title: v.title
					};
					// icon
					if (v.icon.use) {
						markerOptions.icon = new google.maps.MarkerImage(
							v.icon.url,
							new google.maps.Size(v.icon.size.w, v.icon.size.h)
						);
					}
					var marker = new google.maps.Marker(markerOptions);
					// infowindow
					var infoTag = '';
					infoTag += '<div class="info_window_wrap">';
					infoTag += v.title ? '<h4>' + v.title + '</h4>' : '';
					infoTag += v.title ? '<p>' + v.address + '</p>' : '';
					infoTag += '</div>';
					google.maps.event.addListener(marker, 'click', function(event) {
						new google.maps.InfoWindow({
							content: infoTag
						}).open(marker.getMap(), marker);
					});
					if (v.open) {
						google.maps.event.trigger(marker, 'click');
					}
				});
			}
		});
	}

	$(function() {
		gmap();
	});
});
