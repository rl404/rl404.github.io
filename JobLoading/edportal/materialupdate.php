<?php
// ini_set('display_errors',1);
// error_reporting(E_ALL);

$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(empty($_POST['docid'])){
	if(is_uploaded_file($_FILES["coverimage"]["tmp_name"])){

		$target_dir = '../edportal/cover/';
		$target_file = $target_dir . $_POST['docname'].".png";

		if (move_uploaded_file($_FILES["coverimage"]["tmp_name"], $target_file)) {
			imagepng(imagecreatefromstring(file_get_contents($target_file)), $target_file);
			echo "";
		} else {
			echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
			echo "";
		}	
	}

	if(is_uploaded_file($_FILES["materialpdf"]["tmp_name"])){

		$target_dir = '../edportal/files/';
		$target_file = $target_dir . $_POST['docname'].".PDF";

		if (move_uploaded_file($_FILES["materialpdf"]["tmp_name"], $target_file)) {
			echo "";
		} else {
			echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
			echo "";
		}	
	}

	$today = date("Y-m-d");

	$insertSql = "INSERT INTO edportal (docName,docDesc,dateAdded)
				VALUES ('$_POST[docname]', '$_POST[docdesc]','$today')";

	if ($conn->query($insertSql) === TRUE) {	
		echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
	}else{
		echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}
}else{

	if(is_uploaded_file($_FILES["coverimage"]["tmp_name"])){

		$target_dir = '../edportal/cover/';
		$target_file = $target_dir . $_POST['docname'].".png";

		if (move_uploaded_file($_FILES["coverimage"]["tmp_name"], $target_file)) {
			imagepng(imagecreatefromstring(file_get_contents($target_file)), $target_file);
			echo "";
		} else {
			echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
			echo "";
		}	
	}else{
		$fileName = '../edportal/cover/'.$_POST['olddocname'].'.png';
		$newName = '../edportal/cover/'.$_POST['docname'].'.png';
		rename($fileName, $newName);
	}

	if(is_uploaded_file($_FILES["materialpdf"]["tmp_name"])){

		$target_dir = '../edportal/files/';
		$target_file = $target_dir . $_POST['docname'].".PDF";

		if (move_uploaded_file($_FILES["materialpdf"]["tmp_name"], $target_file)) {
			echo "";
		} else {
			echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
			echo "";
		}	
	}else{
		$fileName = '../edportal/files/'.$_POST['olddocname'].'.pdf';
		$newName = '../edportal/files/'.$_POST['docname'].'.pdf';
		rename($fileName, $newName);
	}

	$today = date("Y-m-d");

	$updateSql = "UPDATE edportal set docName='$docname',docDesc='$docdesc',dateAdded='$today' where id='$_POST[docid]'";

	if ($conn->query($updateSql) === TRUE) {	
		echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
	}else{
		echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}
}

?> 