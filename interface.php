<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>De grote Heinze en Roy falliete bedrijven kaart!</title>

	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

	<!-- Scripts -->

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="js/mootools-core.js" type="text/javascript"></script>
	<script src="js/mootools-more.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="js/opendata.js"></script>

	<script type="text/javascript">
		submit = $('submitbutton');
		window.addEvent('domready', function() {
			initialize();
		});
	</script>
</head>
<body id="loadingelement">
	<form id="interfaceform" method="GET" action="kvk-fail.php">
		<label>Stad: </label><input id="city" type="text" name="city" value="Enschede" />
		<input id="submitbutton" type="submit" name="submit" value="Do!" />
	</form>

	<div id="map_canvas" ></div>
</body>