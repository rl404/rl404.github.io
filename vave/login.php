<?php
	ob_start();
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
	 if (mysqli_connect_errno())
	   {
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	   }

	// Check matching username & password
	$selectSql = "SELECT * FROM staff WHERE (staffName='$_POST[username]' OR noReg='$_POST[username]') AND password='$_POST[password]'";
	
	$selectResult = $conn->query($selectSql);

	if($selectResult->num_rows > 0){

		// Start session + declare all session variable
		session_start();
		$_SESSION['usernameva'];
		$_SESSION['useridva'];
		$_SESSION['deptva'];
		$_SESSION['divva'];
		while($row = mysqli_fetch_assoc($selectResult)) {
			$_SESSION['usernameva'] = $row['staffName'];
			$_SESSION['useridva'] = $row['id'];
			$_SESSION['deptva'] = $row['deptCode'];
			$_SESSION['divva'] = $row['divCode'];
			break;
		}

		// Redirect to homepage
		header("Location: homepage.php");
	}else{	
		
		// Wrong username or password
		header("Location: index.php?error=1");
	}
?>