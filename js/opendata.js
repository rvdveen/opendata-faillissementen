var geocoder;
var map;
  
function initialize() {
	geocoder = new google.maps.Geocoder();
	//Hier de keuze van de stad in voeren
	var latlng = new google.maps.LatLng(52.217538741, 6.83957096134);
	var myOptions = {
		zoom: 12,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

}
 
function createMarkerList(JSONObject){
	//For alle entry's maakt een marker aan
	Array.each(JSONObject, function(item, index) {
		var marker = new google.maps.Marker({
			map: map,
			title: item.bedrijfsnaam
		});
		codeAddress(marker, item.adres +", "+ item.postcode +", "+ item.plaats);
	});
}
 
function codeAddress(marker, address) {
	console.log('codeAddress for ' + address);
	var latlong;
	//Hier gaan we geocoden
	geocoder.geocode( {
		'address': address
	}, function(results, status) {
		console.log('this:');
		console.log(this);
		if (status == google.maps.GeocoderStatus.OK) {
			console.log(results);
			latlong = results[0].geometry.location;
			this.setPosition(latlong);
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	}.bind(marker));
	return latlong;
}

 