<html>
	<?php include "../header.php"; ?>

	<div class="ui container">
	<div class="ui secondary menu">
		<div class="item">		

<?php
	// Connect to db
	include "../db.php";

	// Select all supplier
	$selectSql = "SELECT * FROM vave2";

	// Select searched supplier
	$query;	
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM vave2 ";
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

	<?php include "../graph/graph2.php"; ?>
	
	<div class='ui column grid'>
		<div class='row' id='vavegraph1'></div>
		<div class='row' id='vavegraph2'></div>
		<div class='row' id='vavegraph3'></div>
	</div>

<?php

	// Select all supplier
	$selectSql = "SELECT * FROM vave2 order by teardownNo";

	// Select searched supplier
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM vave2 order by teardownNo";
	}

	$selectResult = $conn->query($selectSql);

	// Table data
	if($selectResult->num_rows > 0){
		echo "<table class='ui celled table' id='30001list' cellspacing='0'>
			<thead><tr>
				<th id='tableheader' class='center aligned'>No</th>
				<th id='tableheader' class='center aligned'>TD Number</th>					
				<th id='tableheader' class='center aligned'>Model</th>	
				<th id='tableheader' class='center aligned'>Part No</th>
				<th id='tableheader' class='center aligned'>Part Name</th>
				<th id='tableheader' class='center aligned'>Current</th>
				<th id='tableheader' class='center aligned'>New</th>
				<th id='tableheader' class='center aligned'>Cost Reduction / Vehicle (IDR)</th>
				<th id='tableheader' class='center aligned'>Result</th>
				<th id='tableheader' class='center aligned'>Rejection</th>
				<th id='tableheader' class='center aligned'>Status</th>
			</tr></thead><tbody>";

		$no = 1;		
		while($row = mysqli_fetch_assoc($selectResult)) {

			// $row['costReduction'] = number_format($row['costReduction'],2,'.',',');
			
			echo "<tr>
					<td>$no.</td>
					<td>$row[teardownNo]</a></td>
					<td>$row[model]</td>
					<td>$row[partNo]</td>
					<td>$row[partName]</td>
					<td>$row[ideaOld]</td>
					<td>$row[ideaNew]</td>
					<td>$row[costReduction]</td>
					<td>$row[result]</td>
					<td>$row[rejection]</td>
					<td>$row[status]</td>";
			echo "</tr>";
			$no++;	
			
		}		
		echo "</tbody></table>";

	// If no result
	}else{
		echo "<h3 class='ui header center aligned'>No result :(</h3>";
	}
?>
	</div>
	<div class="ui divider"></div>
</body>
</html>