<?php

#var_dump(getGeo('2750', '135'));
#die();
$mysqli = new mysqli('localhost', 'ctt', 'dm9WYUEC64bEbFv6', 'CTT');

$qry = "select distinct CP4, CP3 from codigosPostais where LONGITUDE = '' AND LATITUDE = '' limit 1000";
$qid = $mysqli->query($qry);

while($row = $qid->fetch_object()){

	$geo = getGeo($row->CP4, $row->CP3);
	$updQry = "update codigosPostais SET LONGITUDE=$geo->lat, LATITUDE=$geo->lng WHERE CP4=$row->CP4 AND CP3='$row->CP3'";
	$updQid = $mysqli->query($updQry);
	$aff = $mysqli->affected_rows;
	echo "$row->CP4-$row->CP3|$aff\n";
	#die();
}



function getGeo($cp4, $cp3){
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$cp4-$cp3&sensor=false&components=country:PT";

	//$data = json_decode(file_get_contents($url,false,$context));
	$data = json_decode(file_get_contents($url,false));
	if($data->status == 'OVER_QUERY_LIMIT'){
		// todo: use another IP if available?
		die();
	}
	//$geo = $data->results[0]->geometry->location;
	$maxKey = max(array_keys($data->results));
	$geo = $data->results[$maxKey]->geometry->location;

	return $geo;
}

?>
