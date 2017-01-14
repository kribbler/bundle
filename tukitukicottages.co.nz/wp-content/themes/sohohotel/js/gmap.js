var map = null;

function initialize(Lat,Lng) {
	var latlng = new google.maps.LatLng(Lat,Lng);
	var myOptions = {
		zoom: 15,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: true,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
		}
	};

	map = new google.maps.Map(document.getElementById("map-canvas"),myOptions);
	var contentString = googlemapMarker;
	var infowindow = new google.maps.InfoWindow({
		content: contentString
	});

	var marker = new google.maps.Marker({
		position: latlng, 
		map: map
	});

	google.maps.event.addListener(marker, 'click', function() {
		infowindow.open(map,marker);
	});

}