<?php
	// Connect to db
	include "../db.php";

	// Supplier name title
	echo "<h2 class='ui header' id='titleheader2'>	
			<div class='content'>
				PT. $_POST[supplier]
			</div>		
		</h2>";	

	// SUpplier data table
	echo "<div id='listxlist'>
		<table class='ui compact sortable selectable definition table center aligned'>
			<thead class='full-width'><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>Part Number</th>
				<th id='tableheader'>TS Number</th>
			</tr></thead>";

	// Select all partno
	$no = 1;
	$selectSql = "SELECT * FROM supplier_partno where suppName='$_POST[supplier]' order by partNo";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		echo "<tr>
				<td>$no</td>
				<td>$row[partNo]</td>
				<td><button class='ui red tiny inverted button' onclick='showPartNoTS(&quot;$row[partNo]&quot;&#44;&quot;$_POST[supplier]&quot;);'>Show</button></td>
			</tr>";
		$no++;
	}

	echo "</div>";

?>