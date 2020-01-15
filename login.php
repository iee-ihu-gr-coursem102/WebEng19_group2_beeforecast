<?php
session_start();
if (isset($_POST["submit"])) {
//	echo '<p>my first login message has been sent!</p>';
    
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);
    $password = md5($password);

    include("conf.php");    
	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
	 
	mysqli_set_charset($conn,"utf8");				 	                                            
	$sqlcommand = "select * from users where username = '$username' and password= '$password'";
    
	$result = $conn->query($sqlcommand) or die($conn->error);
                                                  
	$row = $result->fetch_assoc();
	
	
	if ($row) {
		
		$id = $row['id'];
		$fname = $row['first_name'];
		$lname = $row['last_name'];

		$_SESSION['name'] = $fname . ' ' . $lname;
		$_SESSION['id'] = $id;
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		
		$sqlcommand = "SELECT * FROM beehive WHERE user_id = '$id'";
		
		$result = $conn->query($sqlcommand) or die($conn->error);
		$row = $result->fetch_assoc();
		
		if ($username == 'admin'){ 
			$conn->close(); 
			header('location: admin.php');
		
		} else if ($row) {
			//if the user is registered  
			$conn->close(); 
			header('location: user.php');
		} else { 
		// its a new user
			$conn->close(); 
			header('location: dashboard.php');
		}
	}    else {
		//echo '<html><meta charset="UTF-8"><script>alert("Ο χρήστης δεν βρέθηκε!"); </script></html>';
		$_SESSION['name'] = "The user was not found or password was incorrect!";
		$conn->close(); 
		header('location: retry.php');

	}

}
// for preventing login to be hacked
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<html>
<head>
<title>Login to BeeForecast</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<script>
    function loginvalidation(){
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;

        var valid = true;

        if(username == ""){
        	   valid = false;
            document.getElementById('username_error').innerHTML = "required.";
        }

        if(password == ""){
        	   valid = false;
            document.getElementById('password_error').innerHTML = "required.";
        }
        return valid;
    }
    </script>
</head>
<body>
<h2>Bee Forecast</h2>
<p>Store your information and get the weather data for your bee hives</p>	

<div  style="overflow: hidden; position: relative; width: 1263px; height: 315.75px;">
<div  style="position: relative; left: 0px; width: 1263px; height: 315.75px;">
<img src="./img/Beehive.jpg" alt="Bee Hives"  style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; backface-visibility: hidden; display: block;">
</div></div>

    <div class="demo-content">
        <form action="" method="POST"
            onsubmit="return loginvalidation();">


            <div class="row">
                <label>Username</label> <span id="username_error"></span>
                <div>
                    <input type="text" name="username" id="username"
                        class="form-control"
                        placeholder="Enter your username ID">
                </div>
            </div>

            <div class="row">
                <label>Password</label><span id="password_error"></span>
                <div>
                    <input type="Password" name="password" id="password"
                        class="form-control"
                        placeholder="Enter your password">

                </div>
            </div>

            <div class="row">
                <div>
                    <button type="submit" name="submit"
                        class="btn login">Login</button>
                </div>
            </div>
            <div class="row">
                <div>
                    <a href="signup.php"><button type="button"
                            name="submit" class="btn signup">Signup</button></a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>