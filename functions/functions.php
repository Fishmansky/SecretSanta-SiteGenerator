<?php
session_start();
function noemaildbinit(){
    require '../db/connection.php';
    $stmt = $conn->prepare("CREATE OR REPLACE TABLE players ( id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, player_name varchar(50) NOT NULL COLLATE utf8_general_ci, gives_to int DEFAULT NULL);");
    if($stmt->execute()){
        return true;
    } else {
        return false;
    }
}

function emaildbinit(){
    require '../db/connection.php';
	$stmt = $conn->prepare("CREATE OR REPLACE TABLE players ( id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, player_name varchar(50) NOT NULL COLLATE utf8_general_ci, email varchar(40) NOT NULL COLLATE utf8_general_ci, gives_to int DEFAULT NULL);");
    if($stmt->execute()){
        return true;
    } else {
        return false;
	}
}


function getChosen($chosen){
	require '../db/connection.php';

	$sql = "SELECT * FROM players WHERE id = $chosen";
	$dbresult = $conn->query($sql);
	$row = $dbresult->fetch_assoc();
	$chosenName = $row['player_name'];
	return $chosenName;
}

function sendChosen($data){
	$url = 'https://dev.devorio.pl/index.php';

	//The data you want to send via POST
	$fields = [
		'data' => $data
	];

	//url-ify the data for the POST
	$fields_string = http_build_query($fields);

	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	//So that curl_exec returns the contents of the cURL; rather than echoing it
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

	//execute post
	$result = curl_exec($ch);
	echo $result;
	return $result;
}

function finishDrawing(){
	$url = 'https://dev.devorio.pl/index.php';

	//The data you want to send via POST
	$fields = [
		'message' => "Już losowałeś!"
	];

	//url-ify the data for the POST
	$fields_string = http_build_query($fields);

	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

	//So that curl_exec returns the contents of the cURL; rather than echoing it
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

	//execute post
	$result = curl_exec($ch);
	echo $result;
	return $result;
}

function IsChosen($p){
	require '../db/connection.php';

	$sql = "SELECT * FROM players WHERE gives_to = ? ";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $p);
	$stmt->execute();
	$dbres = $stmt->get_result();
	if($dbres->num_rows == 0){
		return false;
	} else {
		return true;
	}
}

//funkcja zwracająca tabelę graczy możliwych do wylosowania

function PlayersToChoose(){
	require '../db/connection.php';

	$allPlayers = array();
	$pickedPlayers = array();	
	$sql = "SELECT * FROM players";
	$dbresult = $conn->query($sql);
	while($row = $dbresult->fetch_assoc()){
		$allPlayers[] = $row['id'];
		$pickedPlayers[] = $row['gives_to'];
	}
	$arr = array_diff($allPlayers, $pickedPlayers);
	$result = array_values($arr);
	return $result;
}

//funkcja zwracająca graczy, którzy jeszcze nie losowali

function AwaitingForDraw(){
	require '../db/connection.php';
	$result = array();	
	$sql = "SELECT * FROM `players` WHERE gives_to IS NULL";
	$dbresult = $conn->query($sql);
	while($row = $dbresult->fetch_assoc()){
	$result[] = $row['id'];
	}
	return $result;
}

function IsLonely($giver, $Givers, $Takers){
	$giverIndex = array_search($giver, $Givers);
	if($giverIndex == 0){
		if(in_array($Givers[1],$Takers)){
			return true;
		}
	} else {
		if(in_array($Givers[0],$Takers)){
			return true;
		}
	}
}

function PickFor($giver){
	require '../db/connection.php';
	//pobierz liste graczy, którzy mogą losować
	$awaitingPlayers = AwaitingForDraw();
	//sprawdz czy obecny gracz znajduje się na liście osób, które nie losowały
	if(in_array($giver, $awaitingPlayers)){
		
		//pobierz liste graczy możliwych do wylosowania
		$availablePlayers = PlayersToChoose();
		if(count($availablePlayers) == 1){
			$chosen = reset($availablePlayers);
			$sql = "UPDATE players SET gives_to = ? WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ii", $chosen, $giver);
			$stmt->execute();
		} else if (count($availablePlayers) == 2){
			$chosen;
			if(IsLonely($giver, $awaitingPlayers, $availablePlayers)){
				$giverIndex = array_search($giver, $awaitingPlayers);
				if($giverIndex == 0){
					$chosen = $awaitingPlayers[1];
				} else {
					$chosen = $awaitingPlayers[0];
				}
			} else if(in_array($giver, $awaitingPlayers)){
				if($availablePlayers[0] == $giver){
					$chosen = $availablePlayers[1];
				} else {
					$chosen = $availablePlayers[0];
				}
			} else {
				$key = array_rand($availablePlayers);
				$chosen = $availablePlayers[$key];
			}
			$sql = "UPDATE players SET gives_to = ? WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ii", $chosen, $giver);
			$stmt->execute();
		} else if(count($availablePlayers) > 2){
			//check if drawing person has been chosen already
			if(IsChosen($giver)){
				$key = array_rand($availablePlayers);
				$chosen = $availablePlayers[$key];
				$sql = "UPDATE players SET gives_to = ? WHERE id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ii", $chosen, $giver);
				$stmt->execute();
			} else {
				$key = array_rand($availablePlayers);
				while($giver == $availablePlayers[$key]){
					$key = array_rand($availablePlayers);
				}
				$chosen = $availablePlayers[$key];
				$sql = "UPDATE players SET gives_to = ? WHERE id = ?";
				$stmt = $conn->prepare($sql);
				$stmt->bind_param("ii", $chosen, $giver);
				$stmt->execute();
			}
	
		}
		$chsN = getChosen($chosen);
		return $chsN;
	} else {
		finishDrawing();
	}
}

function ResetAll(){
	require '../db/connection.php';
	$conn->query("UPDATE players SET gives_to = NULL");
}


?>