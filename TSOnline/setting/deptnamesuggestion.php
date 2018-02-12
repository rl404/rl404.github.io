<?php
	// Connect to db
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
 	if (mysqli_connect_errno()){
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Select all dept
	$selectSql = "SELECT * FROM dept order by deptName";
	
	$selectResult = $conn->query($selectSql);

	$no = 1;
	$dept = array();
	$deptcurr = "";
	$deptindex = 0;

	// Get distinct deptname and put into array
	while($row = mysqli_fetch_assoc($selectResult)) {		
		if($row['deptName'] != $deptcurr){
			$deptcurr = $row['deptName'];
			$dept[$deptindex] = $deptcurr;
			$deptindex++;
		}
	}

	// Put into datalist option
	for($i = 0; $i < count($dept); $i++){
		echo "<option value='$dept[$i]'>";
	}
?>