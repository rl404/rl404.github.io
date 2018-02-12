<?php
	// Connect to db
	include "../db.php";

	// Supplier name title
	echo "<h2 class='ui header' id='titleheader2'>	
			<div class='content'>
				$_POST[partno]
			</div>		
		</h2>";

	// SUpplier data table
	echo "<div id='listxlist'>
		<table class='ui compact sortable selectable definition table center aligned'>
			<thead class='full-width'><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>TS Number</th>
			</tr></thead>";

	// Select all partno
	$no = 1;
	$selectSql = "SELECT * FROM partno where partNo='$_POST[partno]' order by tsNo";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		echo "<tr>
				<td>$no</td>
				<td>$row[tsNo]</td>
			</tr>";
		$no++;
	}

	echo "</div>";


?>