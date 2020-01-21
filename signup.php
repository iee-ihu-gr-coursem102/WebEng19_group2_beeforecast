<?php
if (isset($_POST["submit"])) {
//διαβάζω από τη μέθοδο post και τα αντιγράφω στο session
	$username = $_POST['username'];
	$password = $_POST['password'];
	$_SESSION['username'] = $username;
	$_SESSION['password'] = $password;

// τα στοιχεία της σύνδεσης με την βάση δεδομένων
    include("conf.php");    
	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);

	mysqli_set_charset($conn,"utf8");				 	                                            
	$sqlcommand = "select * from users where username = '$username' and password= '$password'";
	$result = $conn->query($sqlcommand) or die($conn->error);
	$row = $result->fetch_assoc();
    
//συνεχίζω να διαβάζω από τη μέθοδο post τα στοιχεία της φόρμας
     $fname = $_POST['fname'];
	 $lname = $_POST['lname'];
	 $email = $_POST['email'];
	 $username2 = $_POST['username'];
	 $password2 = md5($_POST['password']); // calculates the MD5 hash of a string
//     $password2 = $_POST['password'];
	  
// αν βρεθεί ο χρήστης αποθηκεύω το μέηλ του στο session
	if ($row) {
		$_SESSION['emailname'] = $row['email'];
	}	
// αν δεν βρέθηκε ο χρήστης γύρισε δηλαδή άδειο recordset η sql 
// θα πρέπει να εισάγω στη βάση τα δεδομένα που έγραψε ο χρήστης στα πεδία της φόρμας
	if (empty($row)) {
		$sql = "insert into users (id, username, first_name,last_name, password, email) values(null,'$username2', '$fname','$lname','$password2', '$email')";
		
		if ($conn->query($sql) === TRUE) {
			echo "Record inserted successfully";
		} else {
			echo "Error inserting record: " . $conn->error;
		}

// αποθηκεύω σε μια μεταβλητή τύπου array μήνυμα ότι όλα ΟΚ ή το μήνυμα λάθους	
// αν είναι ΟΚ εμφανίζεται σύνδεσμος και μήνυμα στον χρήστη να κάνει login 	
		$response = array(
			"type" => "success",
			"message" => "You have registered successfully.<br/><a href='login.php'>Now Login</a>."
		);
	} else {
		$response = array(
			"type" => "error",
			"message" => "username already in use."
		);
	}
}
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<!-- για responsive design -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<html>
<head>
<title>Sign Up</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="css/main.css">
<script>
    function signupvalidation(){
        var fname = document.getElementById('fname').value;
        var lname = document.getElementById('lname').value;
        var email = document.getElementById('email').value;
        var username = document.getElementById('username').value;		
        var password = document.getElementById('password').value;
        var confirm_pasword = document.getElementById('confirm_pasword').value;
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

        if(username == ""){
            valid = false;
            document.getElementById('username_error').innerHTML = "required.";
        }


        if(password == "" ){
            valid = false;
            document.getElementById('password_error').innerHTML = "required.";
        }
        if(confirm_pasword == "" ){
            valid = false;
            document.getElementById('confirm_password_error').innerHTML = "required.";
        }

        if(password != confirm_pasword){
            valid = false;
            document.getElementById('confirm_password_error').innerHTML = "Both passwords must be same.";
        }

        return valid;
    }
    </script>
</head>
<body>
<h2>Bee Forecast</h2>
<p>Submit your Bee Hives Information</p>	

<div  style="overflow: hidden; position: relative; width: 1263px; height: 315.75px;">
<div  style="position: relative; left: 0px; width: 1263px; height: 315.75px;">
<img src="./img/beehive.jpg" alt="Bee Hives"  style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; backface-visibility: hidden; display: block;">
</div></div>

    <div class="demo-content">
        <?php
        if (! empty($response)) {
            ?>
        <div id="response" class="<?php echo $response["type"]; ?>"><?php echo $response["message"]; ?></div>
        <?php
        }
        ?>
        <form action="" method="POST"
            onsubmit="return signupvalidation()">
            <div class="row">
                <label>First Name</label><span id="fname_error"></span>
                <div>
                    <input type="text" class="form-control" name="fname"
                        id="fname" placeholder="Enter your first name">

                </div>
            </div>
			
			<div class="row">
                <label>Last Name</label><span id="lname_error"></span>
                <div>
                    <input type="text" class="form-control" name="lname"
                        id="lname" placeholder="Enter your last name">

                </div>
            </div>



            <div class="row">
                <label>Email</label><span id="email_error"></span>
                <div>
                    <input type="email" name="email" id="email"
                        class="form-control"
                        placeholder="Enter your Email">

                </div>
            </div>

			<div class="row">
                <label>Username</label><span id="username_error"></span>
                <div>
                    <input type="text" class="form-control" name="username"
                        id="username" placeholder="Enter your username">

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
                <label>Confirm Password</label><span id="confirm_password_error"></span>
                <div>
                    <input type="password" name="confirm_pasword"
                        id="confirm_pasword" class="form-control"
                        placeholder="Re-enter your password">

                </div>
            </div>

<!-- ένας απλοϊκός τρόπος ελέγχου ότι τα δεδομένα εισάγονται από άνθρωπο κι όχι από πρόγραμμα, απλά για επίδειξη θα έπρεπε να αλλάζει-->
			<div class="row">
				<label>*What is 1+1? (Anti-spam)</label>	
				<div>
					<input name="human" placeholder="Type your answer here">
				</div>
			</div>

            <div class="row">
                <div align="center">
                    <button type="submit" name="submit"
                        class="btn signup">Sign Up</button>
                </div>
            </div>

            <div class="row">
                <div>
                    <a href="login.php"><button type="button" name="submit"
                        class="btn login">Login</button></a>
                </div>
            </div>
    
    </div>

    </form>
    </div>
</body>
</html>