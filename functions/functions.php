<?php

function noemaildbinit(){
    require(dirname( __DIR__ ).'/db/connection.php');

    $stmt = $conn->prepare("CREATE TABLE players ( id int PRIMARY KEY NOT NULL, name varchar(20) NOT NULL COLLATE utf8_general_ci, surname varchar(30) NOT NULL COLLATE utf8_general_ci, gives_to int NOT NULL);");
    if($stmt->execute()){
        return true;
    } else {
        return false;
    }
}

function emaildbinit(){
    require(dirname( __DIR__ ).'/db/connection.php');

    $stmt = $conn->prepare("CREATE TABLE players ( id int PRIMARY KEY NOT NULL, name varchar(20) NOT NULL COLLATE utf8_general_ci, surname varchar(30) NOT NULL COLLATE utf8_general_ci, email text NOT NULL COLLATE utf8_general_ci, gives_to int NOT NULL);");
    if($stmt->execute()){
        return true;
    } else {
        return false;
    }
}


function GetAvailable(){
	require(dirname( __DIR__ ).'/db/connection.php');
	$result = array();	
	$sql = "SELECT * FROM `players` WHERE gives_to IS NULL";
	$dbresult = $conn->query($sql);
	while($row = $dbresult->fetch_assoc()){
	$result[] = $row['id'];
	}
	return $result;
}

function PickFor($p, $availables){
	require(dirname( __DIR__ ).'/db/connection.php');
	if(count($availables)>1){
		$find = true;
		while($find){
			$rndindex = array_rand($availables);
			if($p != $availables[$rndindex] && !IsChosen($availables[$rndindex])){
				$find = false;
			}
			
		}
		$sql = "UPDATE players SET gives_to = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ii",$availables[$rndindex], $p);
		if($stmt->execute()){
			echo "Succes!";
		} else {
			echo "Error with sql statement!";
		}
	} else {
		$sql = "UPDATE players SET gives_to = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ii",$availables[0], $p);
		if($stmt->execute()){
			echo "Succes!";
		} else {
			echo "Error with sql statement!";
		}
	}
}

//funkcja sprawdzająca czy dana osoba została juz wylosowała

function IsChosen($p){
	require(dirname( __DIR__ ).'/db/connection.php');

$sql = "SELECT * FROM players WHERE gives_to = ? ";
    $result = bool;
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $p);
    $stmt->execute();
    $dbres = $stmt->get_result();
    $row = $dbres->fetch_assoc();
    if(empty($row)){
        $result = false;
        return $result;
    } else {
        $result = true;
        return $result;
    }
}


//funkcja sprawdzająca czy gracz juz losowal

function CheckPlayer($p){
	require(dirname( __DIR__ ).'/db/connection.php');

$sql = "SELECT * FROM players WHERE id = ? AND gives_to IS NULL";
    $result = bool;
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $p);
    $stmt->execute();
    $dbres = $stmt->get_result();
    $row = $dbres->fetch_assoc();
    if(empty($row)){
        $result = false;
        return $result;
    } else {
        $result = true;
        return $result;
    }
}

?>