<?php 
session_start();
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<html>
<head>
    <title>Retry to login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h2>BeeForecast</h2>
<p>Enter your Information</p>	

<div  style="overflow: hidden; position: relative; width: 1263px; height: 315.75px;">
<div  style="position: relative; left: 0px; width: 1263px; height: 315.75px;">
<img src="./img/Beehive.jpg" alt="Bee Hives"  style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; backface-visibility: hidden; display: block;">
</div></div>

<div class="demo-content">
    <div>
        Sorry, <?php echo $_SESSION['name']; ?>! Please try to <a href="login.php">Login</a> again.
    </div>

    <div></div>
</div>
</body>
</html>