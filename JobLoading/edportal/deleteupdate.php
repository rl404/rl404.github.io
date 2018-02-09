<?php

$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$covermaterial = '../edportal/cover/'.$_POST['docname'].'.png';
$filesmaterial = '../edportal/files/'.$_POST['docname'].'.pdf';

unlink($covermaterial);
unlink($filesmaterial);

$deleteSql = "DELETE from edportal where id='$_POST[docid]'";

if ($conn->query($deleteSql) === TRUE) {	
	echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
}else{
	echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
}
?>