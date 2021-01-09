<?php

function emaildbinit(){
    require '../db/connection.php';
	$stmt = $conn->prepare("CREATE OR REPLACE TABLE players ( id int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, player_name varchar(20) NOT NULL COLLATE utf8_general_ci, email varchar(40) NOT NULL COLLATE utf8_general_ci, gives_to int DEFAULT NULL);");
    if($stmt->execute()){
        return true;
    } else {
        return false;
    }
}

?>
