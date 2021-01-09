<?php
session_start();
require "../functions/functions.php";
if(isset($_POST['players'])){
	$arr = $_POST['players'];
	$player = $arr[0];
	$chsn = PickFor($player);
	$_SESSION["data"] = $chsn;
	header('location: ../index.php');
}
?>