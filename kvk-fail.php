<?php
/*
 * Openkvk outputs lists of rowtypes, column names and data. This converts it to an array of key-value pairs.
 */
function get_clean($raw) {
    $results = json_decode($raw);

    $clean = array();

    foreach($results[0]->RESULT->ROWS AS $row) {
        $new = array();
        foreach($row AS $k => $v) {
            $new[$results[0]->RESULT->HEADER[$k]] = $v;
        }
        $clean[] = $new;
    }
	return $clean;
}

function debug($string) {
	if ($debug) {
		echo $string;
	}
}

$city = addslashes(ucwords(strtolower($_GET['city'])));
$debug = isset($_GET['debug']);

debug('<pre>');
debug("City:	{$city}\n");

$query = "SELECT f.* FROM faillissementen AS f WHERE f.plaats = '{$city}' ORDER BY f.datum DESC LIMIT 50;";
$url = 'http://api.openkvk.nl/json/' . rawurlencode($query);

debug("url: {$url}\n");

$a = get_clean(file_get_contents($url));

foreach($a AS $k => $item) {
	$kvks = $item['kvks'];
	$query = "SELECT adres, postcode FROM kvk WHERE kvks = {$kvks} LIMIT 1;";
	$url = 'http://api.openkvk.nl/json/' . rawurlencode($query);
	$extra = get_clean(file_get_contents($url));
	$a[$k]['adres'] = $extra[0]['adres'];
	$a[$k]['postcode'] = $extra[0]['postcode'];
}

debug(print_r($a, true));
debug('</pre>');

$json = json_encode($a);

echo $json;

?>