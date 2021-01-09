<?php
    session_start();
    if(!file_exists('./db/connection.php')){
        header('location: install.php');
    }
    if(isset($_SESSION['data'])){
        echo "<script type='text/javascript'>alert('Osoba, którą wylosowałeś to {$_SESSION["data"]}');</script>";
     unset($_SESSION["data"]);
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Secret-Santa-Site</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
    	<div class="container">
        <div class="db-form">
        <form action="scripts/drafting.php" method="POST">
		<?php
            require 'db/connection.php';
            $sql = "SELECT * FROM players WHERE gives_to IS NULL";
            $result = $conn->query($sql);
            
            if($result->num_rows == 0){
                echo '<h2>Santa is coming! :)</h2>';
            } else {
                echo '<h2>Click on your name to draw!</h2>';
                while($row = $result->fetch_row()){
                    echo '<button class="draw-button" name="players[]" value="'.$row[0].'">'.$row[1]." ".$row[2].'</button> <br />';
                }
            }
            $conn->close();
        ?>
        </form>
        </div>
	</div>
    </body>
</html>
