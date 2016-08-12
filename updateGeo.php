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
	#$url = "http://ditu.google.cn//maps/api/geocode/json?address=$cp4-$cp3&sensor=false&components=country:PT";

	/* IP CHANGING STUFF
	 *
	 * Uncomment this and the comment block a few lines below
	 * only if you understand what it does, and after reading
	 * changeIp() function comments
	 *

	$i = 0;
	if(!file_exists('/ramdrive/googleip.txt')){
		file_put_contents('/ramdrive/googleip.txt','10.100.100.15');
		$currentIp = '10.100.100.16';	// default IP
	}else{
		$currentIp = file_get_contents('/ramdrive/googleip.txt');
	}
	$opts = array(
		'socket' => array(
			'bindto' => "$currentIp:0",
		),
	);
	$context = stream_context_create($opts);
	again:
	$data = json_decode(file_get_contents($url,false,$context));
	*/

	$data = @file_get_contents($url,false);
	if($data == false){
		return "error fetching $url";
	}
	$data = json_decode($data);
	if($data->status == 'OVER_QUERY_LIMIT'){
		/* IP Changing stuff
		if($i > 6){
			die('OVER_QUERY_LIMIT');
		}
		$i++;
		$context = stream_context_create(changeIp());
		goto again:
		*/
		echo "Google returned over query limit\n";
		die();
	}
	//$geo = $data->results[0]->geometry->location;
	$maxKey = max(array_keys($data->results));
	$geo = $data->results[$maxKey]->geometry->location;

	return $geo;
}

function changeIp(){
	/*
	 * This will return context options for file_get_contents
	 * the following IP list will basically be bound by the router
	 * with a netmap rule, NATing to different external IP's
	 * thus, allowing to increase google's limit of 2500 requests
	 * per IP per day.
	 *
	 * IP List
	 *
	 * 10.100.101.10
	 * 192.168.3.210
	 * 192.168.3.211
	 * 192.168.3.212
	 * 192.168.3.213
	 * 192.168.3.214
	 */
	$lastIp = trim(file_get_contents('/ramdrive/googleip.txt'));        // get last
	$newIp = $lastIp; // in case for some reason it remains unchanged
	switch($lastIp){
		case '10.100.101.10':
		$newIp = '192.168.3.210';
		break;
		case '192.168.3.210':
		$newIp = '192.168.3.211';
		break;
		case '192.168.3.211':
		$newIp = '192.168.3.212';
		break;
		case '192.168.3.212':
		$newIp = '192.168.3.213';
		break;
		case '192.168.3.213':
		$newIp = '192.168.3.214';
		break;
		case '192.168.3.214':
		$newIp = '10.100.101.10';
		break;
	}
	file_put_contents('/ramdrive/googleip.txt',$newIp);
	$opts = array(
		'socket' => array(
			'bindto' => "$newIp:0",
		),
	);
	return $opts;
}

?>
