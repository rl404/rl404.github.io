<?php
	// Start session if not started yet
	if(session_id() == '') {
	    session_start();
	}

	// Send email to all subcriber
	include "../email/send.php";

	// Connect to db
	include "../db.php";
	
	// Convert to date format
	$date = date_create("$_POST[reqdate]");
	$date = date_format($date,"Y-m-d");
	
	// Insert query
	$insertSql = "INSERT INTO ts_rev (tsNo,rev,content,issueDate,pic) 
					VALUES ('$_POST[tsno]', '$_POST[rev]','$_POST[content]','$date','$_SESSION[usernamets]')";

	// If success, back to tsauto with success message
	if ($conn->query($insertSql) === TRUE) {
		echo "<script type='text/javascript'> document.location = 'tsmanual.php?ok=1'; </script>";		
	
	// If error, back to tsauto with error message	
	}else{
		echo "<script type='text/javascript'> document.location = 'tsmanual.php?ok=0'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}
?>