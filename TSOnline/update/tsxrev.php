<?php
	// Connect to db
	include "../db.php";

	// Get the latest revision
	$revSql = "SELECT * FROM ts_rev WHERE tsNo='$_POST[ts]' order by tsNo,rev+0 desc";
	$revResult = $conn->query($revSql);

	$highestRev = 0;
	$latestRev;
	$latestDate;
	$latestContent = "";
	if($revResult->num_rows > 0){
		while($revrow = mysqli_fetch_assoc($revResult)){	
			
			// If already DISUSE
			if($revrow['rev'] == 'DISUSE'){
				$latestDate = $revrow['issueDate'];
				$highestRev = 100;
				break;	
			}

			// If still EST
			if(preg_match('/EST/',$revrow['rev']) && $highestRev == 0){
				$highestRev = -100;
			}

			// If there is newer revision
			if(is_numeric($revrow['rev']) && $revrow['rev'] > $highestRev ){
				$highestRev = $revrow['rev'];
				$latestDate = $revrow['issueDate'];
			}
		}

	// If not in db
	}else{
		$highestRev = 0;
	}	

	// If in db
	if($highestRev != 0){

		// If already DISUSE
		if($highestRev == 100){
			$latestRev = "DISUSE";

		// If still EST
		}else if($highestRev == -100){
			$latestRev = "EST.";
		
		// If not DISUSE or EST, get the highest rev
		}else{
			$latestRev = $highestRev;
		}

	// If not in db
	}else{
		$latestRev = "No info";
	}

	// Check if already in db
	$inDB = FALSE;
	$revResult = $conn->query($revSql);
	if($revResult->num_rows > 0){
		while($revrow = mysqli_fetch_assoc($revResult)){	
			if($_POST['rev'] == $revrow['rev']){
				$inDB = TRUE;
				break;
			}
		}
	}

	echo "<div class='two fields'>";
	
	// If already in db
	if($inDB){
		echo "<div class='field'>
				<label id='existedts'>Already in database. </label>
			</div>";
	}

	// Check the input
	echo "<div class='field'>";

	// If DISUSE
	if($latestRev == "DISUSE"){
		echo "<label id='existedts'>This TS is already DISUSE ($latestDate).</label>";
	
	// If EST
	}else if(preg_match('/EST/',$_POST['rev']) && $highestRev < 0){
		echo "<label id='okts'>OK <i class='green checkmark icon'></i></label>";
	
	// If there is newer rev
	}else if($_POST['rev'] < $highestRev){
		echo "<label id='existedts'>The latest revision is $latestRev ($latestDate).</label>";
	
	// If latest rev
	}else if($_POST['rev'] > $highestRev){
		echo "<label id='okts'>OK <i class='green checkmark icon'></i></label>";
	}else{}
	
	echo "</div>";

?>