<?php
	ob_start(); 
	include "../db.php";

	$insertSql = "DELETE FROM vave WHERE id='$_POST[vaveid]'";

	if ($conn->query($insertSql) === TRUE) {
		header("Location: index.php?ok=1");
	}else{
		header("Location: index.php?ok=0");
		// echo "Error: " . $insertSql . "<br>" . $conn->error;
	}
?>