<?php
session_start();
/*
if(file_exists('/db/connection.php')){
    clearstatcache();
    header('location: ./index.php');
    exit();
}
*/
if(isset($_SESSION['error'])){
    $message = $_SESSION['error'];
   echo '<script type="text/javascript">alert("'.$message.'");</script>';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
<title>Secret-Santa-Site - Installation</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container">
        <div class="db-form">
        <h2>Set database connection for your site</h2>
            <form action="db/init-db.php" method="POST">
                <input class="field" type="text" name="dbuser" placeholder="Database User" required />
                <input class="field" type="text" name="dbpassword" placeholder="Database User Password" required />
                <input class="field" type="text" name="dbname" placeholder="Database name" required />
                <input class="field" type="text" name="dbhost" placeholder="Database host" required />
                <input class="field" type="text" name="players" placeholder="Number of players" required /><br>
                <input type="radio" id="email-included" name="option" value="email-included"><label for="email-included"> Send emails with drafted names</label><br>
                <input type="radio" id="no-email" name="option" value="no-email"><label for="no-email"> Display drafted names on the screen</label><br>
                <button class="form-button" type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
    </body>
</html>