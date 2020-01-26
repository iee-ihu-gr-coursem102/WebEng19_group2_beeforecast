<?php 
// ξεκίνα το session του τρέχοντος χρήστη
	session_start();
//echo '<p>my first message has been sent!</p>';
// εισαγωγή στοιχείων σύνδεσης     
	include("conf.php");    
	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
//διαβάζω από τη μέθοδο session	τα στοιχεία σύνδεσης	
    $username = $_SESSION['username'];
	$password = $_SESSION['password'];
	
   
	mysqli_set_charset($conn,"utf8");				 	                                            
    $sqlcommand = "select * from users where username = '$username' and password= '$password'";
	$result = $conn->query($sqlcommand) or die($conn->error);
            
    $row = $result->fetch_assoc();
                                                      
	$user_id = $row['id'];
//με το id διαβάζω από τον πίνακα που έχει τις κυψέλες
	$sqlcommand2 = "select * from beehive where user_id = '$user_id'";
	$result2 = $conn->query($sqlcommand2) or die($conn->error);
	$result3= $result2;
           
    $row2 = $result2->fetch_assoc();

	if ($row2) {
		echo "The bee hives of: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
	} else {
		echo "Your bee hives were not found";
	}
	$conn->close();
	
	if (isset($_POST["submit1"])) {
		//echo '<p>My second message has been sent!</p>';
// πατήθηκε το submit
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
								
		if ($fname != '' && $lname != '' && $email != '') {
    
			$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
			mysqli_set_charset($conn,"utf8");				 	                                            
			
			$sql = "update users set first_name = '$fname', last_name = '$lname', email= '$email' where id='$user_id'";
			if ($conn->query($sql) === TRUE) {
				echo "Record updated successfully";
				$sqlcommand = "select * from users where username = '$username' and password= '$password'";
				$result = $conn->query($sqlcommand) or die($conn->error);
            
				$row = $result->fetch_assoc();
			} else {
				echo "Error updating record: " . $conn->error;
			}

			$conn->close();
			
		} else {
			echo '<p>You need to fill in all required fields!!</p>';
		}	
	} 
	
?>


<!DOCTYPE html>
<meta charset="UTF-8">
<!-- για responsive design -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<html>
<head>
    <title>Dashborad for Bee Hives</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
<div  style="position: relative; left: 0px; right: 0px; top:0px; bottom:0px;  width: 1263px; height: 315.75px;">
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
		
			<label><b>Your Personal Information</b></label>
			Personal information should include name and email. 
			<label>First Name*</label><span id="fname_error"></span>
			<input name="fname" placeholder="Enter your first name" value="<?php echo $row["first_name"]; ?>">
			
			<label>Last Name*</label><span id="lname_error"></span>
			<input name="lname" placeholder="Enter your last name" value="<?php echo $row["last_name"]; ?>">
			   
			<label>Email*</label><span id="email_error"></span>
			<input name="email" type="email" placeholder="Type your email here" value="<?php echo $row["email"]; ?>">
			
			<div align="center">
					<button type="submit" value = "submit1" name="submit1" class="myButton">Submit your Edited Personal Information</button>
			</div>

			
			<h2>The Bee Hives list</h2>
        
    	    
			<div id="wrapper">
			  <table >
				<thead>
				   <tr>
						<th>Τοποθεσία</th>
						<th>Δήμος</th>
						<th>Περιοχή</th>
						<th>Πλήθος Κυψελών</th>
						<th>Πληροφορίες</th>
						<th>Επεξεργασία</th>
						<th>Διαγραφή</th>
					</tr>
				</thead>
				<tbody>
					
					<!--Use of a while loop to make a table row for every DB row-->
					<?php 	$result3->data_seek(0);
							while( $row3 = $result3->fetch_assoc()) : ?>
					<tr>
						<td><?php echo $row3["location"]; ?></td>
						<td><?php echo $row3["muncipality"]; ?></td>
						<td><?php echo $row3["area"]; ?></td>
						<td><?php echo $row3["plithos_kipselwn"]; ?></td>
						<td><?php echo $row3["info"]; ?></td>
						<td><a href="update_user.php?id=<?php echo $row3["id"]; ?>
						&location=<?php echo $row3["location"]; ?>
						&muncipality=<?php echo $row3["muncipality"]; ?>
						&area=<?php echo $row3["area"]; ?>
						&plithos=<?php echo $row3["plithos_kipselwn"]; ?>
						&info=<?php echo $row3["info"]; ?> ">Επεξεργασία</a> </td>
						<td><a href="delete_beehive.php?id=<?php echo $row3["id"]; ?>">Διαγραφή</a></td>
						
						<!--Προσθήκη συνδέσμου για καιρό στην συγκεκριμένη τοποθεσία 
						που αντιστοιχεί το location των κυψελών, στη σελίδα μας forecast.php -->
						
						<td><a href="forecast.php?location=<?php echo $row3["location"]; ?>
						&muncipality=<?php echo $row3["muncipality"]; ?>">Καιρός</a> </td>
						
						
						
						<!--sending required information via url for get method -->
					</tr>
					<?php endwhile ?>
					
					
				</tbody>
			  </table>
		
				<div align="center">
					 <a href="dashboard.php"> <input type = button onclick="location.href = 'dashboard.php'" value = 'Create New Location' class="myButton"> </a>
				</div>		
			</div>
			
			
		</form>
	
    </div>
        
    </section>
    
    <footer class="body">
    	
    </footer>

</body>
</html>


