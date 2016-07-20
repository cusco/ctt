<?php

require_once('bar.php');

$mysqli = new mysqli('localhost', 'ctt', 'dm9WYUEC64bEbFv6', 'CTT');

$dbName = 'CTT';

echo date('Y-m-d H:i:s')."|Importing Distritos...\n";
var_dump(importDistritos('external/distritos.txt', 'CTT', 'distritos', $mysqli));
echo date('Y-m-d H:i:s')."|Importing Concelhos...\n";
var_dump(importConcelhos('external/concelhos.txt', 'CTT', 'concelhos', $mysqli));
echo date('Y-m-d H:i:s')."|Importing post codes...\n";
var_dump(importCodigosPostais('external/todos_cp.txt', 'CTT', 'codigosPostais', $mysqli));

echo date('Y-m-d H:i:s')."|Done!\n";

function importDistritos($fileName, $dbName, $tableName, $mysqli){
	$distritos = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	$insQry = "INSERT INTO $dbName.$tableName (Codigo_Distrito, Designacao_Distrito) VALUES\n";
	foreach($distritos as $line){
		$fields = explode(';', $line);
		$cod = $fields[0];
		$desig = $fields[1];

		$insQry .= "('$cod', '$desig'),\n";

	}
	// remove last ,\n
	$insQry = substr($insQry,0,-2);
	#var_dump($insQry);

	$qid = $mysqli->query($insQry);
	if(!$qid){
		var_dump($mysqli->error);
	}else{
		var_dump($qid);
	}
}

function importConcelhos($fileName, $dbName, $tableName, $mysqli){
	$concelhos = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	$insQry = "INSERT INTO $dbName.$tableName (Codigo_Distrito, Codigo_Concelho, Designacao_Concelho) VALUES\n";

	foreach($concelhos as $line){
		$fields = explode(';', $line);
		$cod_d = $fields[0];
		$cod_c = $fields[1];
		$desig = $fields[2];

		$insQry .= "('$cod_d', '$cod_c', '$desig'),\n";
	}

	// remove last ,\n
	$insQry = substr($insQry,0,-2);

	// Insert
	$qid = $mysqli->query($insQry);
	if(!$qid){
		var_dump($mysqli->error);
	}else{
		var_dump($qid);
	}

}


function importCodigosPostais($fileName, $dbName, $tableName, $mysqli){
	$codigosPostais = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$total = count($codigosPostais);

	$insQry = "
		INSERT INTO $dbName.$tableName (
			Codigo_Distrito
			,Codigo_Concelho
			,Codigo_Localidade
			,LOCALIDADE
			,ART_COD
			,ART_TIPO
			,PRI_PREP
			,ART_TITULO
			,SEG_PREP
			,ART_DESIG
			,ART_LOCAL
			,TROCO
			,PORTA
			,CLIENTE
			,CP4
			,CP3
			,CPALF
		) VALUES
	";
	$initialInsQry = $insQry;

	foreach($codigosPostais as $key => $line){
		$fields = explode(';', $line);

		$cod_di	= $mysqli->real_escape_string($fields[0]);
		$cod_co	= $mysqli->real_escape_string($fields[1]);
		$cod_lo	= $mysqli->real_escape_string($fields[2]);
		$locali	= $mysqli->real_escape_string($fields[3]);
		$art_co	= $mysqli->real_escape_string($fields[4]);
		$art_ty	= $mysqli->real_escape_string($fields[5]);
		$pri_pr	= $mysqli->real_escape_string($fields[6]);
		$art_ti	= $mysqli->real_escape_string($fields[7]);
		$seg_pr	= $mysqli->real_escape_string($fields[8]);
		$art_de	= $mysqli->real_escape_string($fields[9]);
		$art_lo	= $mysqli->real_escape_string($fields[10]);
		$troco	= $mysqli->real_escape_string($fields[11]);
		$porta	= $mysqli->real_escape_string($fields[12]);
		$client	= $mysqli->real_escape_string($fields[13]);
		$cp4	= $mysqli->real_escape_string($fields[14]);
		$cp3	= $mysqli->real_escape_string($fields[15]);
		$cpalf	= $mysqli->real_escape_string($fields[16]);

		$insQry .= "(
			'$cod_di'
			,'$cod_co'
			,'$cod_lo'
			,'$locali'
			,'$art_co'
			,'$art_ty'
			,'$pri_pr'
			,'$art_ti'
			,'$seg_pr'
			,'$art_de'
			,'$art_lo'
			,'$troco'
			,'$porta'
			,'$client'
			,'$cp4'
			,'$cp3'
			,'$cpalf'
		),\n";

		// seek bar
		show_status($key, $total-1);

		if($key % 999 == 0 && $key > 1){ // proccess 900 at a time
			#echo "$key\n";
			$insQry = substr($insQry,0,-2);
			$qid = $mysqli->query($insQry);
			if(!$qid){
				var_dump($insQry);
				var_dump($mysqli->error);
				die();
			}else{
			#	echo "$key|";
			#	var_dump($qid);
			}

			$insQry = $initialInsQry;
		}

	}


	// remove last ,\n
	$insQry = substr($insQry,0,-2);

	// Insert
	$qid = $mysqli->query($insQry);
	if(!$qid){
		var_dump($mysqli->error);
	}else{
		var_dump($qid);
	}

}

