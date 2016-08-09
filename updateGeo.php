<?php

#var_dump(getGeo('2750', '135'));
#die();
$mysqli = new mysqli('localhost', 'ctt', 'dm9WYUEC64bEbFv6', 'CTT');

$qry = "select distinct CP4, CP3 from codigosPostais where LONGITUDE = '' AND LATITUDE = '' order by CP4 asc, CP3 asc limit 2500";
$qid = $mysqli->query($qry);
if($qid->num_rows == 0){
	echo "No results in database to update\n";
	die();
}

while($row = $qid->fetch_object()){

	$geo = getGeo($row->CP4, $row->CP3);
	if(!isset($geo->lat)){
		echo "$row->CP4-$row->CP3|error|$geo\n";
		continue;
	}
	$updQry = "update codigosPostais SET LONGITUDE=$geo->lat, LATITUDE=$geo->lng WHERE CP4=$row->CP4 AND CP3='$row->CP3'";
	$updQid = $mysqli->query($updQry);
	$aff = $mysqli->affected_rows;
	echo "$row->CP4-$row->CP3|$aff\n";
	#die();
}



function getGeo($cp4, $cp3){
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$cp4-$cp3&sensor=false&components=country:PT";

	//$data = json_decode(file_get_contents($url,false,$context));
	$data = @file_get_contents($url,false);
	if($data == false){
		return "error fetching $url";
	}
	$data = json_decode($data);
	if($data->status == 'OVER_QUERY_LIMIT'){
		// todo: use another IP if available?
		echo "Google returned over query limit\n";
		die();
	}
	//$geo = $data->results[0]->geometry->location;
	$maxKey = max(array_keys($data->results));
	$geo = $data->results[$maxKey]->geometry->location;

	return $geo;
}

?>
