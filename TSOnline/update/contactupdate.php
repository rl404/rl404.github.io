<?php
	include "../db.php";

	// Insert query to db
	$insertSql = "INSERT INTO supplier (suppName,deptName,staffName,email) 
	VALUES ('$_POST[suppname]', '$_POST[deptname]','$_POST[staffname]','$_POST[email]')";

	if ($conn->query($insertSql) === TRUE) {
		echo "<script type='text/javascript'> document.location = 'contact.php?ok=1'; </script>";
		// If there is error, back to request page
	} else {
		echo "<script type='text/javascript'> document.location = 'request.php?ok=0'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}


?>