<?php

// http://maps.googleapis.com/maps/api/directions/json?origin=39.8575017,-7.5680595&destination=40.1398428,-7.511005&waypoints=optimize:true|40.1567674,-7.4992841|40.0942571,-7.4548667&sensor=false

$qryStr = $_SERVER['QUERY_STRING'];

if( strlen($qryStr) < 3 ){
	die('no parameters');
}

$url = "https://maps.googleapis.com/maps/api/geocode/json?$qryStr";

/* Choose the IP */
/*
 * uncomment this to rotate IPs

	if(!file_exists('/ramdrive/googleip.txt')){
		file_put_contents('/ramdrive/googleip.txt','10.100.100.15');
		$currentIp = '10.100.100.15';
	}else{
		$currentIp = file_get_contents('/ramdrive/googleip.txt');
                if(!filter_var($ip, FILTER_VALIDATE_IP)) {      // if file is empty or wrong IP
                        $currentIp = '10.100.100.15';
                        file_put_contents('/ramdrive/googleip.txt','10.100.100.15');
                }

	}

	$key = getKey($currentIp);
	$opts = array(
		'socket' => array(
			'bindto' => "$currentIp:0",
		),
	);
	$context = stream_context_create($opts);
*/
$debug = Array();
$i=0;
again:


/* Make HTTP Request to $url */
    $timeTaken = microtime(true);
    #$feed = file_get_contents($url . "&key=$key", false, $context) or die("ERROR: Can't open $url");
    $feed = file_get_contents($url, false) or die("ERROR: Can't open $url");
    $debug["$i"] = (microtime(true) - $timeTaken);
    $obj = json_decode($feed);	// Parse JSON

// log debug
#if($obj->{'status'} != "OK" ){
#	$log = date('Y-m-d H:i:s') . "|$currentIp|" . $_SERVER['REMOTE_ADDR'] . '|' . $obj->{'status'} . '|' . $url . "&key=$key\n";
#	file_put_contents( __DIR__ . '/logXpto.txt', $log, FILE_APPEND);
#}

if($obj->{'status'} == "OVER_QUERY_LIMIT" ){

		//$log = date('Y-m-d H:i:s') . "|$currentIp|" . $_SERVER['REMOTE_ADDR'] . '|OVER_QUERY_LIMIT|' . $url . "&key=$key\n";
		//file_put_contents( __DIR__ . '/logXpto.txt', $log, FILE_APPEND);
		if($i > 11){
			#var_dump($debug);
			#var_dump($url . "&key=$key");
			#die($obj->{'status'});
			header('Content-Type: application/json');
			echo "$feed";
			die();

		}
		$i++;
/*
 * uncomment this to rotate IPs
		$chIp = changeIp();

		$context = stream_context_create($chIp['opts']);
		$key = $chIp['key'];
		$currentIp = $chIp['opts']['socket']['bindto'];
		$currentIp = explode(':', $currentIp);
		$currentIp = $currentIp[0];
*/
		goto again;
};

echo "$feed";


/* not used here, but useful
 * when we have several IPs
 * being NATed to public IPs
 */
function changeIp(){
	/*
	 * IP List
	 *
	 * 10.100.100.15
	 * 10.100.100.16
	 * 10.100.100.17
	 * 10.100.100.18
	 * 10.100.100.19
	 * 10.100.100.61
	 * 10.100.100.62
	 * 10.100.100.63
	 * 10.100.100.64
	 */
	$lastIp = trim(file_get_contents('/ramdrive/googleip.txt'));        // get last
	$newIp = $lastIp; // in case for some reason it remains unchanged
	switch($lastIp){
		case '10.100.100.15':
		$newIp = '10.100.100.16';
		break;
		case '10.100.100.16':
		$newIp = '10.100.100.17';
		break;
		case '10.100.100.17':
		$newIp = '10.100.100.18';
		break;
		case '10.100.100.18':
		$newIp = '10.100.100.19';
		break;
		case '10.100.100.19':
		$newIp = '10.100.100.61';
		break;
		case '10.100.100.61':
		$newIp = '10.100.100.62';
		break;
		case '10.100.100.62':
		$newIp = '10.100.100.63';
		break;
		case '10.100.100.63':
		$newIp = '10.100.100.64';
		break;
		case '10.100.100.64':
		$newIp = '10.100.100.15';
		break;
	}
	file_put_contents('/ramdrive/googleip.txt',$newIp);
	$opts = array(
		'socket' => array(
			'bindto' => "$newIp:0",
		),
	);

	$key = getKey($newIp);

	$result = Array(
		'opts' => $opts
		,'key' => $key
	);

	return $result;
}

// to associate a key to a IP
function getKey($ip){
	$list = Array(
		'10.100.100.15'	 => 'keyXSyDbNysK0K-0Qlx5xKUp123CDcSkBqW8Vm0'
		,'10.100.100.16' => 'keyXSyDvDOimn12380qyToxGkguFXA9I8EC3ceE'
		,'10.100.100.17' => 'keyXSyCK123U4qjZrGTxRWv0DCHJN2vIUQZRiaM'
		,'10.100.100.18' => 'keyX123M5LWCrMtor9mfylh8ILDtqYT7N3wxCyc'
		,'10.100.100.19' => 'keyXSyAWRJ4kn56LSAJot2HVezFIQLyGLLHXfXY'
		,'10.100.100.61' => 'keyXSyCbX_pO8UU-NDgeKYfr4QDOEJ123n4qJ5I'
		,'10.100.100.62' => 'keyXSyCk3rAXwK7NdxPF-n9aBRPsBEvXjC123yY'
		,'10.100.100.63' => 'keyXSyBnUjX4ul5RzwDvwOW123seB9nF9KvZy0U'
		,'10.100.100.64' => 'keyXSyCLdgTBxTH7tsp123XR42VwzpvAjOYezpU'

	);

	$key = false;

	if(array_key_exists($ip, $list)){
		$key = $list["$ip"];
	}

	return $key;
}

?>
