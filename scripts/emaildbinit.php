<?php

function emaildbinit(){
    require(dirname( __DIR__ ).'/db/connection.php');

    $stmt = $conn->prepare("CREATE TABLE players ( id int PRIMARY KEY NOT NULL, name varchar(20) NOT NULL COLLATE utf8_general_ci, surname varchar(30) NOT NULL COLLATE utf8_general_ci, email text NOT NULL COLLATE utf8_general_ci, gives_to int NOT NULL);");
    if($stmt->execute()){
        return true;
    } else {
        return false;
    }
}

?>