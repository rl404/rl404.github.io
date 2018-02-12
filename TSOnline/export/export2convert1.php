<?php
	/*

		Link to call pdf frame

	*/

	// Start session if not started yet
	if(session_id() == '') {
	    session_start();
	}

	include "../db.php";
	
	// Get today date
	$date = date("Y-m-d");

	// Loop for every TS
	for($i = 0; $i < count($_POST['ts']); $i++){		
		
		$tsno = $_POST['ts'][$i];
		$rev = $_POST['rev'][$i];

		$selectSql = "SELECT * FROM TS WHERE suppName='$_POST[supplier]' and tsNo='$tsno' and rev='$rev'";
		$selectResult = $conn->query($selectSql);

		if($selectResult->num_rows > 0){
			$updateSql = "UPDATE TS SET sendDate='0000-00-00', sendStatus='0' where suppName='$_POST[supplier]' and tsNo='$tsno' and rev='$rev'";

			if ($conn->query($updateSql) === TRUE) {
			
				// If there is error, back to request page
			} else {
				// echo "<script type='text/javascript'> document.location = 'deliver.php?ok=0'; </script>";
			    echo "Error: " . $updateSql . "<br>" . $conn->error;
			}

		}else{
			// Insert query to db
			$insertSql = "INSERT INTO ts (tsNo,rev,suppName, reqDate,  pic) 
						VALUES ('$tsno', '$rev', '$_POST[supplier]', '$date', '$_SESSION[usernamets]')";

			if(!empty($_POST['ts'][$i])){
				if ($conn->query($insertSql) === TRUE) {
				
					// If there is error, back to request page
				} else {
					// echo "<script type='text/javascript'> document.location = 'deliver.php?ok=0'; </script>";
				    echo "Error: " . $insertSql . "<br>" . $conn->error;
				}
			}
		}
	}

	echo "<iframe height=100% width=100%
	src='export2pdf.php?supplier=".$_POST['supplier']."&suppdiv=".$_POST['div']."&supppic=".$_POST['pic']."&";

	// Combine submitted value to comma delimiter string
	$tsstring = "ts=";
	$revstring = "rev=";
	$modelstring = "model=";
	$partstring = "part=";

	for($i = 0; $i < count($_POST['ts']); $i++){
		$tsstring = $tsstring.",".$_POST['ts'][$i];

		if(empty($_POST['rev'][$i])){
			$_POST['rev'][$i] = "-";
		}
		$revstring = $revstring.",".$_POST['rev'][$i];

		if(empty($_POST['model'][$i])){
			$_POST['model'][$i] = "-";
		}
		$modelstring = $modelstring.",".$_POST['model'][$i];

		if(empty($_POST['part'][$i])){
			$_POST['part'][$i] = "-";
		}
		$partstring = $partstring.",".$_POST['part'][$i];
	}

	echo "$tsstring&$revstring&$modelstring&$partstring";

	if(!empty($_POST['day'])){
		echo "&day=".$_POST['day'];
	}

	echo "'></iframe>";

?>