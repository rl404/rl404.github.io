<html>
	<?php include "../header.php"; ?>

	<div class="ui container">
	<div class="ui secondary menu">
		<div class="item">		

<?php
	// Connect to db
	include "../db.php";

	$query;	
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM attachment where proposerId like '%$query%'";
		echo "<h2 id='titleheader2'>Search: $query</h2>";		
	}else{
		echo "<h1 id='titleheader2'>VAVE List</h1>";		
	}

	// Count data total
	$dataCountTotal = 0;
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		$dataCountTotal++;
	}
	echo "
		</div>
		<div class='item' id='titleheader1'>
			$dataCountTotal results
		</div>";
?>		
	</div>

<?php

	// Select searched supplier
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM attachment where proposerId like '%$query%' order by manufacturerNo";
	}

	$selectResult = $conn->query($selectSql);

	// Table data
	if($selectResult->num_rows > 0){
		echo "<table class='ui compact sortable selectable definition table'>
			<thead class='full-width'><tr>
				<th id='tableheader' class='center aligned'>No</th>
				<th id='tableheader' class='center aligned'>Manuc No</th>
				<th id='tableheader' class='center aligned'>TD Number</th>
				<th id='tableheader' class='center aligned'>Part No</th>
				<th id='tableheader' class='center aligned'>Part Name</th>
			</tr></thead>";

		$currentManuc = '';
		$no = 1;		
		while($row = mysqli_fetch_assoc($selectResult)) {

			echo "<tr>
					<td class='center aligned'>$no.</td>
					<td class='center aligned'>$row[manufacturerNo]</td>
					<td class='center aligned'>$row[teardownNo]</td>
					<td class='center aligned'>$row[partNo]</td>
					<td>$row[partName]</td>
				</tr>";
			$no++;	
			
		}		
		echo "</table>";

	// If no result
	}else{
		echo "<h3 class='ui header center aligned'>No result :(</h3>";
	}
?>
	</div>
	<div class="ui divider"></div>
</body>
</html>