<?php
	include "../db.php";

	$selectSql = "SELECT * from vave where manufacturerNo='$_POST[manufacturerno]'";
	$selectResult = $conn->query($selectSql);

	if($selectResult->num_rows > 0){
		echo "Already in Database";
	}

?>