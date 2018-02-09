<?php
	include "../db.php";

	if(session_id() == '') {
	    session_start();
	}	

	ob_start();

	$_POST['staffname'] = strtoupper($_POST['staffname']);

	if(empty($_POST['notifyemail'])) $_POST['notifyemail'] = 0;
	
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
			WHERE id='$_SESSION[userid]'";

	if ($conn->query($insertSql) === TRUE) {
		$_SESSION['username'] = $_POST['staffname'];
		$_SESSION['deptname'] = $_POST['deptcode'];

		if($_POST['jobtitle'] == 'Div. Head' || $_POST['jobtitle'] == 'Admin'){
			$_SESSION['titlerank'] = 4;
		}else if($_POST['jobtitle'] == 'Dept. Head'){
			$_SESSION['titlerank'] = 3;
		}else if($_POST['jobtitle'] == 'Sect. Head'){
			$_SESSION['titlerank'] = 2;
		}else{
			$_SESSION['titlerank'] = 1;
		}
		
		echo "<script type='text/javascript'> document.location = 'setting.php?ok=1'; </script>";
	}else{
		echo "<script type='text/javascript'> document.location = 'setting.php?ok=0'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}
?>