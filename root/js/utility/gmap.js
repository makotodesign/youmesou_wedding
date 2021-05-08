/*===============================================

	gmap

	@author		oldoffice.com
	@since		2010-05-25
	@ver		2.1.1
	@tools
		http://www.geocoding.jp/
	@memo
		2.1.1	rewrite [ 180116 N ]
		2.2.1	ie11に対応 [ 180116 N ]

===============================================*/

function gmap(mapinfo) {
	google.maps.event.addDomListener(window, 'load', function() {
		// map_base
		for (var i = 0; i < mapinfo.length; i++) {
			var mapdiv = document.getElementById(mapinfo[i].mapID);
			var mapOptions = {
				zoom: mapinfo[i].map.zoom,
				center: new google.maps.LatLng(mapinfo[i].map.lat, mapinfo[i].map.lng),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scaleControl: true
			};
			var map = new google.maps.Map(mapdiv, mapOptions);
			// markers
			mapinfo[i].markers.forEach(function(v, index, arr) {
				// eslint-disable-line no-unused-vars
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
				infoTag += v.address ? '<p>' + v.address + '</p>' : '';
				infoTag += '</div>';
				google.maps.event.addListener(marker, 'click', function(e) {
					// eslint-disable-line no-unused-vars
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

gmap(mapinfo); // eslint-disable-line no-undef
