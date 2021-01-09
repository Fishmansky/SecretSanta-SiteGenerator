<?php
session_start();
require '../db/connection.php';
$i = 1;
$pl = "pl";
while(isset($_POST[$pl.$i])){
    $player = $_POST[$pl.$i];
    $sql = "INSERT INTO players (player_name) VALUE (?);";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$player);
    if(!$stmt->execute()){
        $_SESSION['error'] = "Problem with INSERT - check your database.";
        header('location: ../install.php');
        exit();
    }
    $i++;
}
header('location: ../index.php');
exit();
?>