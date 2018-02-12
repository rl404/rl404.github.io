<?php
	// Connect to db
	include "../db.php";
	
	// Start session if not started yet
	if(session_id() == '') {
	    session_start();
	}

	// Loop for every TS
	for($i = 0; $i < count($_POST['tsno']); $i++){		
		
		$tsnumber = $_POST['tsno'][$i];

		$selectSql = "SELECT * FROM partno WHERE partNo='$_POST[partno]' AND tsNo='$tsnumber'";

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
		}else{

			// Insert query to db
			$insertSql = "INSERT INTO partno (partNo,tsNo,uploader) 
						VALUES ('$_POST[partno]', '$tsnumber','$_SESSION[usernamets]')";

			if(!empty($_POST['tsno'][$i])){
				if ($conn->query($insertSql) === TRUE) {
				
					// If there is error, back to request page
				} else {
					// echo "<script type='text/javascript'> document.location = 'partno.php?ok=0'; </script>";
				    echo "Error: " . $insertSql . "<br>" . $conn->error;
				}
			}
		}
	}

	echo "<script type='text/javascript'> document.location = 'partno.php?ok=1'; </script>";
?>