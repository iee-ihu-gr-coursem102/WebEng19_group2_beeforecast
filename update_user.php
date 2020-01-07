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

	$id = ((int)$_GET['id']);
	$location=$_GET["location"]; 
	$muncipality=$_GET["muncipality"]; 
	$area=$_GET["area"];
	$plithos=((int)$_GET["plithos"]); 
	$info=$_GET["info"]; 
	
	if (isset($_POST["submit"])) {
	//echo '<p>My second message has been sent!</p>';				 
		
		$location = $_POST['location'];
		$muncipality = $_POST['muncipality'];
		$area = $_POST['area'];
		$plithos = $_POST['plithos'];
		$info = $_POST['info'];
		$human = $_POST['human'];		
		
		if ($location != '' && $muncipality != '' && $area != '' && $plithos != '' ) {
		  if ($human == '2') {
			$sql = "update beehive set  location='$location', muncipality='$muncipality',area ='$area', plithos_kipselwn=$plithos,info='$info'  where id=$id";
			//echo $sql;
			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
			} else {
				echo "Error updating record: " . $conn->error;
			}
			
			$response = array(
				"type" => "success",
				"message" => "You have updated successfully the beehive information.<br/>."
			);
			
			$conn->close();
			header('location:user.php');
		
		  } else  {
			echo '<p>You answered the anti-spam question incorrectly!</p>';
		  }
		
		} else {
				echo '<p>You need to fill in all required fields!!</p>';
		}	
		 
	}
	

?>

<!DOCTYPE html>
<!<meta charset="UTF-8">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<html>
<head>
    <title>Dashboard for Users Bee Hives</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
	<link type="text/css" rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/button.css">

<script>
    function signupvalidation(){
        var fname = document.getElementById('fname').value;
        var lname = document.getElementById('lname').value;
		var email = document.getElementById('email').value;

        var emailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
    	
        var valid=true;

        if(fname == ""){
            valid = false;
            document.getElementById('fname_error').innerHTML = "required.";
        }
		
        if(lname == ""){
            valid = false;
            document.getElementById('lname_error').innerHTML = "required.";
        }
		
        if(email == ""){
            valid = false;
            document.getElementById('email_error').innerHTML = "required.";
        } else {
            if(!emailRegex.test(email)){
                valid = false;
                document.getElementById('email_error').innerHTML = "invalid.";
            }
        }

        return valid;
    }
</script>	

</head>
<body>
<h2>Bee Hives information</h2>
	

<div  style="overflow: hidden; position: relative; width: 1263px; height: 315.75px;">
<div  style="position: relative; left: 0px; width: 1263px; height: 315.75px;">
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
    	
        <h2>Insert your Bee Hives Information </h2>
        
    </header>
	
    <section class="body">
    	    
	<div id="wrapper">
		
		
		 <form action="" method="POST"
				onsubmit="return signupvalidation();">
			<!--storing to input fields any values read from get method using php echo -->
			<h2>Update Bee Hives Location</h2>
        			
			<label><b>Περιοχή/Location*</b></label>
            <input name="location" placeholder="Type the location here" value="<?php echo $location; ?>"> 
			
			<label><b>Δήμος/Muncipality*</b></label>
			<input name="muncipality" placeholder="Type the muncipality here"value="<?php echo $muncipality; ?>" >
			
			 <label><b>Είδος Φυτών - Περιγραφή περιοχής/Area*</b></label>
			<input name="area" placeholder="Type the area here" value="<?php echo $area; ?>">
            
			<label><b>Πλήθος Κυψελών/Number of Bee Hives*</b></label>
			<input name="plithos" placeholder="Type the number of bee hives here" value="<?php echo $plithos; ?>">
			
			<label><b>Επιπρόσθετες Πληροφορίες/Information<br>
			List additional information to give you a good reference.</b></label>
            <textarea name="info" placeholder="Type additional information here"> <?php echo $info; ?> </textarea>
            
			<label>*What is 1+1? (Anti-spam)</label>
			<input name="human" placeholder="Type your answer here">
			
			<div align="center">
                    <button type="submit" name="submit"
                        class="myButton">Submit your information</button>
            </div>
			 
        </form>
        
	
    </div>
        
    </section>
    
    <footer class="body">
    	
    </footer>

</body>
</html>

