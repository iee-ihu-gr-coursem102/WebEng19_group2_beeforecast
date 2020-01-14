<?php



	session_start();

	

	include("conf.php");    

	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);

	mysqli_set_charset($conn,"utf8");				 	                                            

	

	$password = rand(999, 99999);

	$password_hash = md5($password);



	$id = ((int)$_GET['id']);



	$sql = "update users set password= '$password_hash' where id='$id'";

	

	if ($conn->query($sql) === TRUE) {

		//echo "Your password was Reseted - Your new password is: " . $password;

		$type = "success";

		$message = "Your password was Reseted - Your new password is: " . $password . "<br/>";	

	} else {

		//echo "Error reseting your password: " . $conn->error;

		$type =  "Error";

		$message = "Error reseting your password: " . $conn->error ."<br/>";

	}





	$conn->close();

	

	header("location:admin.php?type=$response&message=$message");



?>

