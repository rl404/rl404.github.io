<?php
	session_start();

	include "../db.php";

	$result = "";
	if(!empty($_GET['search'])){
		$result = mysqli_query($conn,"SELECT * FROM vave WHERE id='$_GET[search]'");
	}else{
		$result = mysqli_query($conn,"SELECT * FROM vave WHERE teardownNo='$_POST[search]' OR manufacturerNo='$_POST[search]'");
	}
	
	$row = mysqli_fetch_array($result);
	
	if(!empty($row['id'])){
		if($_SESSION['divva'] =="PUD"){
			echo "<script type='text/javascript'> document.location = 'inputstep4.php?id=$row[id]&ok=1'; </script>";
		}else if($_SESSION['deptva'] == "PPEQ"){
			echo "<script type='text/javascript'> document.location = 'inputstep3.php?id=$row[id]&ok=1'; </script>";
		}else if(preg_match('/PE/',$_SESSION['deptva'])){
			echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$row[id]&ok=1'; </script>";
		}else if($_SESSION['deptva'] == "EA"){
			echo "<script type='text/javascript'> document.location = 'inputstep5.php?id=$row[id]&ok=1'; </script>";
		}else{
			echo "<script type='text/javascript'> document.location = 'inputresult.php?id=$row[id]&ok=1'; </script>";
		}
	}else{
		echo "<script type='text/javascript'> document.location = 'input.php?ok=0'; </script>";	
	}
?>