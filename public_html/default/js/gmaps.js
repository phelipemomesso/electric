google.maps.visualRefresh = true;
	
var map;
var myLatlng = new google.maps.LatLng(-19.765978,-47.939899);

function initialize() {

	var mapOptions = {
			zoom: 15,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

	map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

	var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Hello World!'
	});
}
	
google.maps.event.addDomListener(window, 'load', initialize);