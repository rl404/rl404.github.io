<?php
	// Connect to db
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
 	if (mysqli_connect_errno()){
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Start session if not started yet
	if(session_id() == '') {
	    session_start();
	}	

	// Convert name to upper case
	$_POST['staffname'] = strtoupper($_POST['staffname']);

	// If notification email is not checked
	if(empty($_POST['notifyemail'])) $_POST['notifyemail'] = 0;

	// Update query
	$insertSql = "UPDATE staff SET 
			noReg='$_POST[noreg]',
			password='$_POST[password]',
			staffName='$_POST[staffname]',
			deptName='$_POST[deptname]',
			deptCode='$_POST[deptcode]',
			sectName='$_POST[sectname]',
			jobTitle='$_POST[jobtitle]',
			email='$_POST[email]',
			notify='$_POST[notifyemail]'
			WHERE id='$_SESSION[useridts]'";

	if ($conn->query($insertSql) === TRUE) {
		
		// Update username + deptcode in case changed
		$_SESSION['usernamets'] = $_POST['staffname'];
		$_SESSION['deptname'] = $_POST['deptcode'];

		// Update job title rank in case changed
		if($_POST['jobtitle'] == 'Div. Head'){
			$_SESSION['title'] = 4;
		}else if($_POST['jobtitle'] == 'Dept. Head'){
			$_SESSION['title'] = 3;
		}else if($_POST['jobtitle'] == 'Sect. Head'){
			$_SESSION['title'] = 2;
		}else{
			$_SESSION['title'] = 1;
		}
		
		// Back to setting page with success message
		echo "<script type='text/javascript'> document.location = 'setting.php?ok=1'; </script>";
	}else{

		// Back to setting page with error message
		echo "<script type='text/javascript'> document.location = 'setting.php?ok=0'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}
?>