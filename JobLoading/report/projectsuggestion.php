<?php
	include "../db.php";

	$selectSql = "SELECT * FROM project order by projectCode";
	
	$selectResult = $conn->query($selectSql);

	$no = 1;
	$project = array();
	$projectcurr = "";
	$projectindex = 0;

	while($row = mysqli_fetch_assoc($selectResult)) {		
		$row['projectCode'] = strtoupper($row['projectCode']);
		if($row['projectCode'] != $projectcurr){
			$projectcurr = $row['projectCode'];
			$project[$projectindex][0] = $projectcurr;
			$project[$projectindex][1] = $row['projectName'];
			$projectindex++;
		}
	}

	echo "<option value='All'>";
	for($i = 0; $i < count($project); $i++){
		$projectname = $project[$i][1];
		$projectcode = $project[$i][0];
		echo "<option value='$projectcode'>$projectcode - $projectname</option>";
	}
?>