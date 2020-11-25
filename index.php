<?php
    session_start();
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
        <h2>Click on your name to draw!</h2>
		<?php
            require './db/connection.php';
            $sql = "SELECT * FROM players WHERE gives_to IS NULL";
            $result = $conn->query($sql);
            while($row = $result->fetch_row()){
                echo '<button class="draw-button">'.$row[1]." ".$row[2].'</button> <br />';
            }
            
		?>
        </div>
	</div>
    </body>
</html>
