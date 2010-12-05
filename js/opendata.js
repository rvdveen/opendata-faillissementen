var geocoder;
var map;
var form;
  
function initialize() {
	form = $('interfaceform');
	form.addEvent('submit', function(e) {
		doRequest(e);
	});
	
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

function doRequest(e) {
	e.stop();
	$('submitbutton').set('disabled', 'disabled');
	$('city').addClass('ajax-loading');

	form.set('send', {onComplete: function(response) {
		//console.log('Request complete');
		var jsonObject = JSON.decode(response);
		//console.log(jsonObject);
		$('submitbutton').set('disabled', false);
		$('city').removeClass('ajax-loading');
		processList(jsonObject);
	}});

	//console.log('Sending request');
	form.send();
}
 
function processList(JSONObject){
	var lastAddress;
	Array.each(JSONObject, function(item, index) {
		if (item.adres == null) {
			//console.log("No address, skipping");
		} else if (item.adres == lastAddress) {
			//console.log("Duplicate address, skipping");
		} else {
			// Throttle the codeAddress calls to prevent gmap's OVER_QUERY_LIMIT
			createMarker.delay(index * 200, item, item.adres +", "+ item.postcode +", "+ item.plaats);
			lastAddress = item.adres;
		}

	});
}

function createMarker(address) {
	//console.log('codeAddress for ' + address);
	var latlong;
	//Hier gaan we geocoden
	geocoder.geocode( {
		'address': address
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			//console.log(results);
			var marker = new google.maps.Marker({
				position: results[0].geometry.location,
				map: map,
				title: this.bedrijfsnaam
			});
		} else {
			alert("Geocode was not successful for the following reason: " + status);
		}
	}.bind(this));
	return latlong;
}

 