<?php
session_start();
require '../functions/functions.php';

if(isset($_POST['dbhost']) && isset($_POST['dbuser']) && isset($_POST['dbpassword']) && isset($_POST['dbname']) && isset($_POST['option']) && isset($_POST['players'])){
    $config = '<?php 
    $host = "'.$_POST[dbhost].'";
    $user = "'.$_POST[dbuser].'";
    $password = "'.$_POST[dbpassword].'";
    $dbname = "'.$_POST[dbname].'";

    $conn = new mysqli($host, $user, $password, $dbname);
    ?>';

    $dbconfig = fopen("connection.php", "w");
    echo fwrite($dbconfig,$config);
    fclose($dbconfig);
	require 'connection.php';
    if(!$conn){
        $_SESSION['error'] = "Incorrect database login data. Please fill the form again.";
        header('location: ../install.php');
        exit();
    }
    switch($_POST['option']){
        case 'email-included':
            if(!emaildbinit()){
                $_SESSION['error'] = "Error while creating table - operation aborted";
                header('location: ../install.php');
                exit();
            } else {
                $_SESSION['players'] =$_POST['players'];
                header('location: ../install2.php');
                exit();
            }
            break;
        case 'no-email':
            if(!noemaildbinit()){
                $_SESSION['error'] = "Error while creating table - operation aborted";
                header('location: ../install.php');
                exit();
            } else {
                $_SESSION['players'] =$_POST['players'];
                header('location: ../install2.php');
                exit();
            }
            break;
        default:
            break;
    }
} else {
    $_SESSION['error'] = "Fill the formular with data and choose the way of communication with players";
    header('location: ../install.php');
    exit();
}

?>
