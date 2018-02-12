<?php
	// Connect to db
	include "../db.php";
	
	// Select all TS
	$selectSql = "SELECT * FROM ts_rev order by tsNo";
	$selectResult = $conn->query($selectSql);

	$no = 1;
	$ts = array();
	$tscurr = "";
	$tsindex = 0;

	// Get different TS and put into array
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['tsNo'] != $tscurr){
			$tscurr = $row['tsNo'];
			$ts[$tsindex] = $tscurr;
			$tsindex++;
		}
	}

	// Put into datalist option
	for($i = 0; $i < count($ts); $i++){
		echo "<option value='$ts[$i]'>";
	}
?>