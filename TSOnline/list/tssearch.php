<?php
	// Connect to db
	include "../db.php";

	// Select all TS including the ones have supplier and not
	$selectSql = "SELECT * FROM ts order by tsNo";
	$selectSql2 = "SELECT * FROM ts_rev order by tsNo";

	if(!empty($_POST['ts'])){
		$selectSql = "SELECT * FROM ts WHERE tsNo like '%$_POST[ts]%' order by tsNo";
		$selectSql2 = "SELECT * FROM ts_rev WHERE tsNo like '%$_POST[ts]%' order by tsNo";	
	}

	$ts = array();
	$tsCurrent = "";
	$tsCurrent2 = "";
	$tsIndex=0;

	// Put distinct TS from ts table into array
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['tsNo'] != $tsCurrent){
			$tsCurrent = $row['tsNo'];
			$ts[$tsIndex] = $tsCurrent;
			$tsIndex++;
		}
	}

	$tsIndexTmp = $tsIndex;

	// Put distinct TS from ts_rev table into array
	$selectResult2 = $conn->query($selectSql2);
	while($row2 = mysqli_fetch_assoc($selectResult2)) {
		if($row2['tsNo'] != $tsCurrent2){
			$tsCurrent2 = $row2['tsNo'];
			$ts[$tsIndex] = $tsCurrent2;
			$tsIndex++;
		}
	}

	// Remove duplicate TS
	$ts = array_unique($ts);

	// Sort TS
	sort($ts);

	// TS list table
	$no = 1;
	echo "<div id='listsearch'>
		<table class='ui compact sortable selectable definition table center aligned'>
			<thead class='full-width'><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>TS Number</th>
				<th id='tableheader' class='four wide'>Supplier List</th>
			</tr></thead>";

	$selectResult = $conn->query($selectSql);
	$selectResult2 = $conn->query($selectSql2);
	if($selectResult->num_rows > 0 || $selectResult2->num_rows > 0){
		for($i = 0; $i < count($ts); $i++){
			echo "<tr>
					<td>$no</td>
					<td><a href='datats.php?search=$ts[$i]' target='_blank'>$ts[$i]</a></td>
					<td><button class='ui red inverted button' onclick='showSupplier(&quot;$ts[$i]&quot;);'>Show >></button></td>
				</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td class='center aligned' colspan=3>0 result :(</td>
			</tr>";
	}
	echo "</table></div>";
?>