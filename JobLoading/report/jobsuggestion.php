<?php
	include "../db.php";

	$selectSql = "SELECT * FROM job order by jobName";
	
	$selectResult = $conn->query($selectSql);

	$no = 1;
	$job = array();
	$jobcurr = "";
	$jobindex = 0;

	while($row = mysqli_fetch_assoc($selectResult)) {		
		if($row['jobName'] != $jobcurr){
			$jobcurr = $row['jobName'];
			$job[$jobindex] = $jobcurr;
			$jobindex++;
		}
	}

	echo "<option value='All'>";
	for($i = 0; $i < count($job); $i++){
		echo "<option value='$job[$i]'>";
	}
?>