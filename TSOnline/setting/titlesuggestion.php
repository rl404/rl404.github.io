<?php
	// Connect to db
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
 	if (mysqli_connect_errno()){
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Select all staff
	$selectSql = "SELECT * FROM staff order by jobTitle";
	
	$selectResult = $conn->query($selectSql);

	$no = 1;
	$title = array();
	$titlecurr = "";
	$titleindex = 0;

	// Get distinct job title and put into array
	while($row = mysqli_fetch_assoc($selectResult)) {		
		if($row['jobTitle'] != $titlecurr){
			$titlecurr = $row['jobTitle'];
			$title[$titleindex] = $titlecurr;
			$titleindex++;
		}
	}

	// Put into datalist option
	for($i = 0; $i < count($title); $i++){
		echo "<option value='$title[$i]'>";
	}
?>