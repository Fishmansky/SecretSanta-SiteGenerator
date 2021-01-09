<?php
session_start();
if(!isset($_SESSION['players'])){
    $_SESSION['error'] = "Your request couldn't be processed - try again";
    header('location: ./install.php');
}
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
<title>Secret-Santa-Site - Config</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="installer">
            <form action="scripts/filldb.php" method="POST" class="installer-form">
            <h2>Fill the form with players names</h2>
                <?php
                    $players_count = $_SESSION['players'];
                    
                    for($i = 1; $i <= $players_count; $i++){
                        echo '<input class="installer-field" type="text" name="pl'.$i.'" placeholder="Player name" required /><br>';
                    }
                ?>
                <button class="form-button" type="submit" name="submit">Submit</button>
            </form>
    </div>
    </body>
</html>