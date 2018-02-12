<?php
	// Connect to db
	include "../db.php";
	
	// Start session if not started yet
	if(session_id() == '') {
	    session_start();
	}

	// Loop for every TS
	for($i = 0; $i < count($_POST['partno']); $i++){		
		
		$partno = $_POST['partno'][$i];

		$selectSql = "SELECT * FROM partno WHERE partNo='$partno' AND tsNo='$_POST[tsno]'";

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
		}else{

			// Insert query to db
			$insertSql = "INSERT INTO partno (partNo,tsNo,uploader) 
						VALUES ('$partno', '$_POST[tsno]','$_SESSION[usernamets]')";

			if(!empty($_POST['partno'][$i])){
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