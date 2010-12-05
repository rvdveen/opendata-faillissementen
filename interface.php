<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Faillissementen</title>

	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

	<!-- Scripts -->

	<script src="mootools-core-1.3-full-nocompat.js" type="text/javascript"></script>
	<script src="mootools-more.js" type="text/javascript"></script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="js/opendata.js"></script>

	<script type="text/javascript">
		submit = $('submitbutton');
		window.addEvent('domready', function() {
			initialize();

			$('interfaceform').addEvent('submit', function(e) {
				//Prevents the default submit event from loading a new page.
				e.stop();
				$('submitbutton').set('disabled', 'disabled');
				$('loadingelement').addClass('ajax-loading');
				//Set the options of the form's Request handler.
				//("this" refers to the $('myForm') element).
				this.set('send', {onComplete: function(response) {
					console.log('Request complete');
					var jsonObject = JSON.decode(response);
					console.log(jsonObject);
					$('submitbutton').set('disabled', false);
					$('loadingelement').removeClass('ajax-loading');

					createMarkerList(jsonObject);
				}});
				//Send the form.
				console.log('Sending request');
				this.send();
			});
		});
	</script>
</head>
<body id="loadingelement">
	<form id="interfaceform" method="GET" action="kvk-fail.php">
		<label>Stad: </label><input type="text" name="city" value="Enschede" />
		<input id="submitbutton" type="submit" name="submit" value="Do!" />
	</form>

	<div id="map_canvas" ></div>
</body>