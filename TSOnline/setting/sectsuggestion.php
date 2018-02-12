<?php
	// Connect to db
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
 	if (mysqli_connect_errno()){
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Select all dept
	$selectSql = "SELECT * FROM dept order by sectName";
	
	$selectResult = $conn->query($selectSql);

	$no = 1;
	$sect = array();
	$sectcurr = "";
	$sectindex = 0;

	// Get distinct sectname and put into array
	while($row = mysqli_fetch_assoc($selectResult)) {		
		if($row['sectName'] != $sectcurr){
			$sectcurr = $row['sectName'];
			$sect[$sectindex] = $sectcurr;
			$sectindex++;
		}
	}

	// Put into datalist option
	for($i = 0; $i < count($sect); $i++){
		echo "<option value='$sect[$i]'>";
	}
?>