<?php
$city = $_GET['city'];
$debug = isset($_GET['debug']);
if ($debug) {
	echo '<pre>';
	echo "City:	{$city}\n";
}
function get_clean($raw) {
    $results = json_decode($raw);

    //print_r($results[0]->RESULT->ROWS);

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

$query = "SELECT f.* FROM faillissementen AS f WHERE f.plaats = '{$city}' ORDER BY f.datum DESC LIMIT 50;";
$url = 'http://api.openkvk.nl/json/' . rawurlencode($query);
if ($debug) {
	echo "url: {$url}\n";
}
$a = get_clean(file_get_contents($url));

foreach($a AS $k => $item) {
	$kvks = $item['kvks'];
	$query = "SELECT adres, postcode FROM kvk WHERE kvks = {$kvks} LIMIT 1;";
	$url = 'http://api.openkvk.nl/json/' . rawurlencode($query);
	$extra = get_clean(file_get_contents($url));
	$a[$k]['adres'] = $extra[0]['adres'];
	$a[$k]['postcode'] = $extra[0]['postcode'];
}
//$example = '[{"RESULT":{"TYPES":["bigint","varchar","int","int","varchar","varchar","varchar","varchar","varchar"],"HEADER":["kvk","bedrijfsnaam","kvks","sub","adres","postcode","plaats","type","website"],"ROWS":[["10000400000","C.H. van Duijsen Bouwmaterialenhandel B.V.","1000040","0","Tijnjedyk 87 B","8936AC","Leeuwarden","Hoofdvestiging",null],["10000650000","Drogisterij Helfrich B.V.","1000065","0","De Kolk 16","9231CW","Surhuisterveen","Hoofdvestiging",null],["10000650000","Drogisterij Helfrich B.V.","1000065","0","Postbus 5","9230AA","Surhuisterveen","Hoofdvestiging",null],["10000680000","B. Mohrmann en Co. Holding B.V.","1000068","0","Postbus 862","8901BR","Leeuwarden","Hoofdvestiging",null],["10000680000","B. Mohrmann en Co. Holding B.V.","1000068","0","Vestaweg 1","8938AV","Leeuwarden","Hoofdvestiging",null],["10000900000","Banda Beheer B.V.","1000090","0","De Kuinder 1","8444DC","Heerenveen","Hoofdvestiging",null],["10000900000","Banda Beheer B.V.","1000090","0","Postbus 346","8440AH","Heerenveen","Hoofdvestiging",null],["10001000000","Fa. P. Gerbenzon & Zn.","1000100","0","Weerd 17","8911HL","Leeuwarden","Hoofdvestiging",null],["10001010000","Sigarenmagazijn Sipma","1000101","0","Schaapmarktplein 13","8601CE","Sneek","Hoofdvestiging",null],["10001030000","C.J. van der Meer Beheer B.V.","1000103","0","Noordooster Singel 31","8861HM","Harlingen","Hoofdvestiging",null]]}}]';
//$a = get_clean($example);
if ($debug) {
	print_r($a);
	echo '</pre>';
}

$json = json_encode($a);

echo $json;

/*
http://api.openkvk.nl/json/SELECT f.* FROM kvk  WHERE kvks LIMIT 100;
http://api.openkvk.nl/json/SELECT f.* FROM faillissementen AS f WHERE 1 ORDER BY f.datum DESC LIMIT 10;
http://api.openkvk.nl/json/SELECT f.* FROM faillissementen AS f WHERE f.plaats = 'Enschede' ORDER BY f.datum DESC LIMIT 10;
 */
?>