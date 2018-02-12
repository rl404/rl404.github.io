<?php
	// Connect to db
	include "../db.php";

	// Select all supplier
	$selectSql = "SELECT * FROM ts order by suppName";

	// Select searched supplier
	if(!empty($_POST['supplier'])){
		$selectSql = "SELECT * FROM ts WHERE suppName like '%$_POST[supplier]%' order by suppName";
	}

	$supplier = array();
	$supplierCurrent = "";
	$supplierIndex=0;

	// Put distinct supplier name into array
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['suppName'] != $supplierCurrent){
			$supplierCurrent = $row['suppName'];
			$supplier[$supplierIndex] = $supplierCurrent;
			$supplierIndex++;
		}
	}

	// Supplier list table
	$no = 1;
	echo "<div id='listsearch'>
		<table class='ui compact sortable selectable definition table center aligned'>
			<thead class='full-width'><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>Supplier Name</th>
				<th id='tableheader'>TS Number</th>
			</tr></thead>";

	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		for($i = 0; $i < count($supplier); $i++){
			echo "<tr>
					<td>$no</td>
					<td class='left aligned'><a href='contact.php?search=$supplier[$i]' target='_blank'>PT. $supplier[$i]</a></td>
					<td><button class='ui red inverted tiny button' onclick='showPartNo(&quot;$supplier[$i]&quot;);'>Show</button></td>
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