<?php
	// Connect to db
	include "../db.php";

	// Select supplier from selected TS
	$selectSql = "SELECT * FROM ts WHERE tsNo='$_POST[ts]' order by suppName";

	$supp = array();
	$suppCurrent = "";
	$suppIndex=0;

	// Get distinct supplier	
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['suppName'] != $suppCurrent){
			$suppCurrent = $row['suppName'];
			$supp[$suppIndex][0] = $suppCurrent;

			// Get latest rev owned by supplier
			$suppSql = "SELECT * FROM ts WHERE suppName='$suppCurrent' AND tsNo='$_POST[ts]' order by suppName,rev+0 desc";
			$suppSqlResult = $conn->query($suppSql);
			while($supprow = mysqli_fetch_assoc($suppSqlResult)) {
				$supp[$suppIndex][1] = $supprow['rev'];
				$supp[$suppIndex][2] = $supprow['reqDate'];
				$supp[$suppIndex][3] = $supprow['model'];
				$supp[$suppIndex][4] = $supprow['partNo'];
				break;
			}

			$suppIndex++;
		}
	}

	// Check latest rev
	$revSql = "SELECT * FROM ts_rev WHERE tsNo='$_POST[ts]' order by rev+0 desc";
	$revResult = $conn->query($revSql);

	$highestRev = 0;
	$latestRev;
	$latestDate;
	$latestContent = "";
	if($revResult->num_rows > 0){
		while($revrow = mysqli_fetch_assoc($revResult)){			
			
			// If already DISUSE, end loop
			if($revrow['rev'] == 'DISUSE'){
				$latestDate = $revrow['issueDate'];
				$latestContent = $revrow['content'];
				$highestRev = 100;
				break;	
			}

			// If still EST, continue search
			if(preg_match('/EST/',$revrow['rev']) && $highestRev == 0){
				$highestRev = -100;
			}

			// If found newer rev, that will be the highest rev
			if(is_numeric($revrow['rev']) && $revrow['rev'] > $highestRev ){
				$highestRev = $revrow['rev'];
				$latestDate = $revrow['issueDate'];
				$latestContent = $revrow['content'];
			}
		}
	
	// If ts number not in db
	}else{
		$highestRev = 0;
	}	

	// If ts number is in db
	if($highestRev != 0){
		
		// If already DISUSE
		if($highestRev == 100){
			$latestRev = "DISUSE";
		
		// I still EST
		}else if($highestRev == -100){
			$latestRev = "EST.";
			$latestDate = $row['issueDate'];
			$latestContent = $row['content'];
		
		// If not DISUSE or EST, get the highest rev
		}else{
			$latestRev = $highestRev;
		}
	
	// If ts number not in db
	}else{
		$latestRev = "No info";
		$latestDate = "-";
		$latestContent = "-";
	}

	// TS + detail title
	echo "<h2 class='ui header' id='titleheader2'>			
			$_POST[ts]		
			<div class='ui right floated header'>
				<form method='POST' action='datatsxsupplier.php' id='$_POST[ts]xsupplierform'>
					<input type='hidden' name='tsno' value='$_POST[ts]'>
					<input type='hidden' name='tsrev' value='$latestRev'>
					<input type='hidden' name='content' value='$latestContent'>
					<input type='hidden' name='issuedate' value='$latestDate'>
					<i class='green link file excel outline icon' onclick='submitForm(&quot;$_POST[ts]xsupplierform&quot;)';></i>
				</form>
			</div>	
			<div class='sub header' id='titleheader1'>
				Latest revision: <span id='titleheader2'>$latestRev</span> ($latestDate)				
			</div>
			<div class='sub header' id='titleheader1'>
				Content: $latestContent
			</div>			
		</h2>";
	
	echo "<div class='ui top attached tabular menu'>
			<a class='item active' data-tab='suppliertab'>Supplier</a>
			<a class='item' data-tab='partnotab'>Part No</a>
		</div>";

	// Supplier from selected ts list table
	echo "
		<div class='ui basic bottom attached tab segment active' data-tab='suppliertab'>

		<div id='listxlist'>
		<table class='ui center aligned sortable table'>
			<thead><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>Supplier Name</th>
				<th id='tableheader'>Rev.</th>
				<th id='tableheader'>Model</th>
				<th id='tableheader'>Part No.</th>
				<th id='tableheader'>Request Date</th>
			</tr></thead>";
	$no = 1;
	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		for($i = 0; $i < count($supp); $i++){
			$suppName =  $supp[$i][0];
			$suppRev =  $supp[$i][1];
			$suppDate = $supp[$i][2];
			$suppModel = $supp[$i][3];
			$suppPart = $supp[$i][4];
			echo "<tr>
					<td>$no</td>
					<td class='left aligned'><a href='contact.php?search=$suppName' target='_blank'>PT. $suppName</a></td>";
			
			// If there is newer ts, color the text
			if($suppRev < $latestRev){
				echo "<td id='existedts'>$suppRev</td>";
			}else{
				echo "<td>$suppRev</td>";
			}			

			// Convert month to string
			$suppDate = strtotime( $suppDate );
			$suppDate = date( 'Y-M-d', $suppDate );

				echo "<td>$suppModel</td>
						<td>$suppPart</td>
						<td>$suppDate</td>
					</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td class='center aligned' colspan=6>0 result :(</td>
			</tr>";
	}
	echo "</table>
		</div>
		</div>";	


	echo "<div class='ui basic bottom attached tab segment' data-tab='partnotab'>
		<div id='listxlist'>
		<table class='ui center aligned sortable table'>
			<thead><tr>
				<th id='tableheader' class='two wide'>No</th>
				<th id='tableheader'>Part No</th>
			</tr></thead>";
	
	$selectSql = "SELECT * FROM partno WHERE tsNo='$_POST[ts]' order by partNo";

	$no = 1;
	$selectResult = $conn->query($selectSql);

	if($selectResult->num_rows > 0){
		while($row = mysqli_fetch_assoc($selectResult)) {
			echo "<tr>
					<td>$no</td>
					<td>$row[partNo]</td>
				</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td colspan=2>No result :(</td>
			</tr>";
	}

	echo "</table></div>";

	echo "<script>
			$(document).ready(function() {
				$('.menu .item').tab();
			});
		</script>";

?>