var geocoder;
  var map;
  var marker;
  
  function initialize() {
    geocoder = new google.maps.Geocoder();
    //Hier de keuze van de stad in voeren
	var latlng = new google.maps.LatLng(52.217538741, 6.83957096134);
    var myOptions = {
      zoom: 12,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
//	google.maps.event.addListener(map, 'idle', function() {
//  var bounds = map.getBounds();
//  alert("aangeroepen");
//  // update depending on bounds
//	});

  }
 
 function createMarkerList(JSONObject){
 	//For alle entry's maakt een marker aan
	console.log(JSONObject);
	
	Array.each(JSONObject, function(element, index) {
		alert('WAAROM IS DIT STUK');
		console.log('hier dan?');
	});
	var Adres = JSONObject.bedrijven.adres +", "+ JSONObject.bedrijven.postcode +", "+ JSONObject.bedrijven.stad;
	 
	marker[i]= new google.maps.Marker({
            map: map, 
            position: codeAddress(Adres),
			title: JSONObject.bedrijven.bedrijfsnaam 
        });
 }
 
  function codeAddress(address) {
	
	//Hier gaan we geocoden
	geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        var latlong = results[0].geometry.location;
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
	return latlong
  }

 