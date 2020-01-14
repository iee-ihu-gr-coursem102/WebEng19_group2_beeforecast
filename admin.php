<?php 

	session_start();



    include("conf.php");    

	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);



	mysqli_set_charset($conn,"utf8");				 	                                            

    $sqlcommand ="select * from users where role = 0 ORDER BY id;";

	$result = $conn->query($sqlcommand) or die($conn->error);



	if (isset($_GET["type"])) {

		$retype = $_GET['type'];

		$remessage = $_GET['message'];

		$response = array(

				"type" => $retype,

				"message" => $remessage

			);

	}

  

	// if (isset($_POST["submit1"])) {

	

		// $fname = $_POST['fname'];

		// $lname = $_POST['lname'];

		// $email = $_POST['email'];



		// $human = $_POST['human'];

				

		// if ($fname != '' && $lname != '' && $email != '' ) {

			// if ($human == '2') {				 

		

					// $sql = "update users set first_name = '$fname', last_name = '$lname', email='$email' where id='$id'";

					

					// if ($conn->query($sql) === TRUE) {

						// echo "Record updated successfully";

					// } else {

						// echo "Error updating record: " . $conn->error;

					// }

							

					// $conn->close();

				

			// } else  {

				// echo '<p>You answered the anti-spam question incorrectly!</p>';

			// }

		// } else {

			// echo '<p>You need to fill in all required fields!!</p>';

		// }

	// } 

	// else if (isset($_POST['submit2'])) {

		// $human = $_POST['human'];

		// if ($human == '2') {				 

								

					// $sql = "delete from users where id='$id'";



					// if ($conn->query($sql) === TRUE) {

						// echo "Record deleted successfully";

					// } else {

						// echo "Error deleting record: " . $conn->error;

					// }

							

					// $conn->close();

					

					// header('location: logout.php');

			

		// } else  {

				// echo '<p>You answered the anti-spam question incorrectly!</p>';

		// }

	// }

// ;

?>



<!DOCTYPE html>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<html>

<head>

    <title>Administrator access to users</title>

    <link rel="stylesheet" type="text/css" href="css/styles.css">

	<link type="text/css" rel="stylesheet" href="css/main.css">

</head>

<body>



<h2>Bee Hives Forecast</h2>

<p>Administrative operations</p>	



<div  style="overflow: hidden; position: relative; width: 1263px; height: 315.75px;">

<div  style="position: relative; left: 0px; width: 1263px; height: 315.75px;">

<img src="./img/Beehive.jpg" alt="Bee Hives"  style="position: absolute; top: 0px; left: 0px; width: 100%; z-index: 0; backface-visibility: hidden; display: block;">

</div></div>





<div class="demo-content">

    <div>

        Welcome System administrator: <?php echo $_SESSION['name']; ?>! Click to <a href="logout.php">Logout</a>.

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



   	

    <h2>The users list</h2>

        

    	    

    <div id="wrapper">

    <table >

    	<thead>

		   <tr>

				<th>ID</th>

				<th>First Name</th>

				<th>Last Name</th>

				<th>email</th>

				<th>Delete</th>

				<th>Reset Password</th>

			</tr>

        </thead>

        <tbody>

			<form action="" method="POST">

		

			<!--Use of a while loop to make a table row for every DB row-->

			<?php 	$result->data_seek(0);

					while( $row = $result->fetch_assoc()) : ?>

			<tr>

				<td><?php echo $row["id"]; ?></td>

				<td><?php echo $row["first_name"]; ?></td>

                <td><?php echo $row["last_name"]; ?></td>

                <td><?php echo $row["email"]; ?></td>

				<td><a href="delete_user.php?id=<?php echo $row["id"]; ?>

				&first_name=<?php echo $row["first_name"]; ?>

				&last_name=<?php echo $row["last_name"]; ?>

				&email=<?php echo $row["email"]; ?>">Delete</a></td>

				<td><a href="reset_password.php?id=<?php echo $row["id"]; ?>

				&first_name=<?php echo $row["first_name"]; ?>

				&last_name=<?php echo $row["last_name"]; ?>

				&email=<?php echo $row["email"]; ?>">Reset Password</a></td>

			</tr>

			<?php endwhile ?>

			

			

			</form>

        </tbody>

    </table>

			

	</form>

	

    </div>

        

    </section>

 

</body>

</html>

			
