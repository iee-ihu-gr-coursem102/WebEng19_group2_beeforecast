<?php

	session_start();
	
	include("conf.php");    
	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
	mysqli_set_charset($conn,"utf8");				 	                                            
		
	$id = ((int)$_GET['id']);

	$sql = "delete from beehive where id=$id";	
	if ($conn->query($sql) === TRUE) {
		echo "Beehive Record(s) deleted successfully";
	} else {
		echo "Error deleting a record: " . $conn->error;
	}

	$conn->close();
	
	header('location:user.php');

?>
