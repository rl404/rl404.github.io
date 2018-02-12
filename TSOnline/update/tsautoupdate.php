<?php	
	// Start session if not started yet
	if(session_id() == '') {
	    session_start();
	}

	// Send email to all subcriber 
	include "../email/send.php";
	
	// Connect to db
	include "../db.php";

	// Convert month to string
	$date = date_create("$_POST[reqdate]");
	$date = date_format($date,"Y-m-d");

	// Loop every TS
	for($i=0;$i<count($_POST['tsno']);$i++){

		$tsno = $_POST['tsno'][$i];
		$rev = $_POST['rev'][$i];
		$content = $_POST['content'][$i];

		// Insert query
		$insertSql = "INSERT INTO ts_rev (tsNo,rev,content,issueDate,pic) 
					VALUES ('$tsno', '$rev','$content','$date','$_SESSION[usernamets]')";

		// If success, back to tsauto with success message
		if ($conn->query($insertSql) === TRUE) {
			echo "<script type='text/javascript'> document.location = 'tsauto.php?ok=1'; </script>";
		
		// If error, back to tsauto with error message	
		}else{
			echo "<script type='text/javascript'> document.location = 'tsauto.php?ok=0'; </script>";
			// echo "Error: " . $insertSql . "<br>" . $conn->error;
		}
	}

?>