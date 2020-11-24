<?php


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Secret-Santa-Site - Installation</title>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<script>
    function generateList(){
        let items = [
            ul = document.createElement('ul');

        document.getElementById('myItemList').appendChild(ul);

        items.forEach(function (item) {
            let li = document.createElement('li');
            ul.appendChild(li);

            li.innerHTML += item;
        });
    }
</script>
</head>
<body>
    <div class="container">
        <div class="db-container">
			<h2>Click on your name to draw!</h2>
            <form action="scripts/drafting.php" method="POST">
                <script></script>
            </form>
        </div>
    </div>
    </body>
</html>