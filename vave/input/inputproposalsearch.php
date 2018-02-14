<?php
	include "../db.php";

	$result = mysqli_query($conn,"SELECT * FROM vave WHERE teardownNo='$_POST[search]' OR manufacturerNo='$_POST[search]'");
	$row = mysqli_fetch_array($result);
	
	if(!empty($row['id'])){
		echo "<script type='text/javascript'> document.location = 'inputproposal2.php?id=$row[id]&ok=1'; </script>";
	}else{
		echo "<script type='text/javascript'> document.location = 'inputproposal.php?ok=0'; </script>";	
	}
?>