<?php
	/*

		Right side of export page

	*/

	include "../db.php";

	// Select selected request
	$selectSql = "SELECT * FROM ts WHERE suppName='$_POST[supplier]' and reqDate='$_POST[reqdate]' order by tsNo,rev+0 desc";

	// Get different ts
	$ts = array();
	$tsCurrent = "";
	$tsIndex = 0;

	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['tsNo'] != $tsCurrent){
			$tsCurrent = $row['tsNo'];
			$ts[$tsIndex][0] = $tsCurrent;
			$ts[$tsIndex][1] = $row['rev'];
			
			$tsIndex++;
		}
	}
	
	// Convert month to string
	$reqDate = strtotime( $_POST['reqdate'] );
	$reqDate = date( 'd-M-Y', $reqDate );

	echo "<h2 class='ui header' id='titleheader2'>
			$reqDate
			<div class='sub header' id='titleheader1'>$tsIndex TS</div>
		</h2>";	

	// Selected request detail table
	echo "<div id='listxlist'>
		<table class='ui center aligned sortable table'>
			<thead><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>TS Number</th>
				<th id='tableheader'>Requested Revision</th>
			</tr></thead>";

	$no = 1;
	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		for($i = 0; $i < count($ts); $i++){
			$tsNo =  $ts[$i][0];
			$tsRev =  $ts[$i][1];
			echo "<tr>
					<td>$no</td>
					<td><a href='../list/datats.php?search=$tsNo' target='_blank'>$tsNo</a></td>
					<td>$tsRev</td>
				</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td class='center aligned' colspan=3>0 result :(</td>
			</tr>";
	}
	echo "</table></div>

	<form method='post' action='export.php'>
		<input type='hidden' name='supplier' value='$_POST[supplier]'>
		<input type='hidden' name='reqdate' value='$_POST[reqdate]'>
		<button class='ui red inverted button'>Convert</button>
	</form>";
?>