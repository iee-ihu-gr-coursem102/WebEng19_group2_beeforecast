<?php 
	session_start();
    
	include("conf.php");    
	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
	
    $username = $_SESSION['username'];
	$password = $_SESSION['password'];
	
	mysqli_set_charset($conn,"utf8");				 	                                            
    $sqlcommand = "select * from users where username = '$username' and password= '$password'";
	$result = $conn->query($sqlcommand) or die($conn->error);      
    $row = $result->fetch_assoc();
	
	$fname = $row['first_name'];
	$lname = $row['last_name'];
    $email = $row['email'];

	$location = '';
	$area = '';
    $muncipality = '';
    $plithos = '';
    $info = '';
    $human = '';
	                                                        
	$user_id = $row['id'];
	$conn->close();


if (isset($_POST["submit"])) {
	//echo '<p>My second message has been sent!</p>';

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
    $email = $_POST['email'];
    $location = $_POST['location'];
	$area = $_POST['area'];
    $muncipality = $_POST['muncipality'];
    $plithos = $_POST['plithos'];
    $info = $_POST['info'];
    $human = $_POST['human'];
			
	if ($fname != '' && $lname != '' && $email != '' && $location != '' && $muncipality != '' && $area != '' && $plithos != '' ) {
		if ($human == '2') {				 
			//echo '<p>Correct antispam answer!</p>'; 
			
			$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
		
			mysqli_set_charset($conn,"utf8");				 	                                            
			$sqlcommand = "insert into beehive (id, location, muncipality, area, user_id, plithos_kipselwn, info) values (null, '$location','$muncipality','$area','$user_id','$plithos','$info')";

			if ($conn->query($sqlcommand) === TRUE) {
				echo "Record inserted successfully";
			} else {
				echo "Error inserting record: " . $conn->error . $sqlcommand;
			}

			$response = array(
				"type" => "success",
				"message" => "You have submitted your beehive information successfully.<br/>."
			);
			
			$conn->close();
			
			header('location: user.php');
	
		} else  {
			echo '<p>You answered the anti-spam question incorrectly!</p>';
		}
	} else {
		echo '<p>You need to fill in all required fields!!</p>';
		
	}
 }

?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<html>
<head>
    <title>Dashborad for BeeForecast users</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
	<link type="text/css" rel="stylesheet" href="css/main.css">
	<link type="text/css" rel="stylesheet" href="css/button.css">
</head>
<body>
<h2>Bee Forecast</h2>
<p>Submit your Information</p>	

<div  style="overflow: hidden; position: relative; width: 1263px; height: 315.75px;">
<div  style="position: relative; left: 0px; width: 1263px; height: 315.75px; ">
<img src="./img/beehive.jpg" alt="Bee Hives"  style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; backface-visibility: hidden; display: block;">
</div></div>

<div class="demo-content">
    <div>
        Welcome <?php echo $_SESSION['username']; ?>! Click to <a href="logout.php">Logout</a>.
    </div>

    <div>
	<?php
        if (! empty($response)) {
            ?>
        <div id="response" class="<?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
        <?php
        }
    ?>
	</div>
</div>

<header class="body">
    	
        <h2>Insert your Information </h2>
        
    </header>
	
    <section class="body">
    	    
        <form method="post" action="">
        
			<label><b>Your Personal Information</b></label>
			Personal information should include name and email. 
            <label><b>Όνομα/First Name*</b></label>
			<input name="fname" placeholder="Enter your first name" value="<?php echo $fname;  ?>">
            
			<label><b>Επίθετο/Last Name*</b></label>
            <input name="lname" placeholder="Enter your last name" value="<?php echo $lname; ?>">
			   
			<label><b>Ηλεκτρονικό Ταχυδρομείο/Email*</b></label>
            <input name="email" type="email" placeholder="Type your email here" value="<?php echo $email; ?>">

			<h2> Προσθήκη Νέας Περιοχής για τα μελίσσια/New Location for bee hives</h2>
			
			<label><b>Περιοχή/Location*</b></label>
            <input name="location" placeholder="Type the location here" value="<?php echo $location; ?>">
			
			<label><b>Δήμος/Muncipality*</b></label>
			<input name="muncipality" placeholder="Type the muncipality here"value="<?php echo $muncipality; ?>" >
			
			 <label><b>Είδος Φυτών - Περιγραφή περιοχής/Area*</b></label>
			<input name="area" placeholder="Type the area here" value="<?php echo $area; ?>">
            
			<label><b>Πλήθος Κυψελών/Number of Bee Hives*</b></label>
			<input name="plithos" placeholder="Type number of bee hives here" value="<?php echo $plithos; ?>">
			
			<label><b>Επιπρόσθετες Πληροφορίες/Information<br>
			List additional information to give you a good reference.</b></label>
            <textarea name="info" placeholder="Type additional information here"> <?php echo $info; ?></textarea>
            
			<label>*What is 1+1? (Anti-spam)</label>
			<input name="human" placeholder="Type your answer here">
			
			<div align="center">
                    <button type="submit" name="submit"
                        class="myButton">Submit your information</button>
            </div>
			
			 
        </form>
        
    </section>
    
    <footer class="body">
    	
    </footer>

</body>
</html>