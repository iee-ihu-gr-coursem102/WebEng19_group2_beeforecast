<?php
// ξεκίνα το session του τρέχοντος χρήστη
	session_start();
// εισαγωγή στοιχείων σύνδεσης 	
	include("conf.php");    
	$conn = new mysqli(HOST,USERNAME,DB_PWD,DATABASE);
	mysqli_set_charset($conn,"utf8");				 	                                            
//διαβάζω από τη μέθοδο get	το id που των κυψελών προς διαγραφή		
	$id = ((int)$_GET['id']);

	$sql = "delete from beehive where id=$id";	
	if ($conn->query($sql) === TRUE) {
		echo "Beehive Record(s) deleted successfully";
	} else {
		echo "Error deleting a record: " . $conn->error;
	}

	$conn->close();
//επιστρέφουμε στην σελίδα user	
	header('location:user.php');

?>
