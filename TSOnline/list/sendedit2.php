<?php
	include "../db.php";

	$date = date_create("$_POST[reqdate]");
	$date = date_format($date,"Y-m-d");

	$updateSql = "UPDATE TS SET sendDate='$date',sendStatus='1',receiver='$_POST[receiver]' where reqId='$_POST[tsid]'";

	if ($conn->query($updateSql) === TRUE) {

	}else{
		// echo "fail";
	}

?>