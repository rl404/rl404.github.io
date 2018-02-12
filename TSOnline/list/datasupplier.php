<html>
	<?php include "../header.php" ?>
	<div class="ui container">

	<div class="ui secondary menu">
		<div class="item">		

<?php
	// Connect to db
	include "../db.php";
	
	$selectSql = "SELECT * FROM ts order by tsNo,suppName,rev";	

	// Search query
	$query;	
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM ts WHERE (tsNo LIKE '%$query%') OR (suppName LIKE '%$query%') OR (model LIKE '%$query%') OR (partNo LIKE '%$query%')
					order by tsNo,rev";
		echo "<h2 id='titleheader2'>Search: $query</h2>";		
	
	// All request data
	}else{
		echo "<h1 id='titleheader2'>Request Data List</h1>";		
	}

	// Count request data total
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
		<div class="right menu">
			<div class="item">

				<!-- Search box -->
				<form action="datasupplier.php" method="GET" id="datasearchform">
					<div class="ui icon input">					
					    <input type="text" name="search" placeholder="Search TS or Supplier...">
					    <i class="search link icon" onclick="submitForm('datasearchform');"></i>					
					</div>
					<button type="submit" style="display: none;">a</button>
				</form>
			</div>
		</div>
	</div>

<?php
	
	// Select all data
	$selectSql = "SELECT * FROM ts order by reqDate desc,suppName";

	// Select searched data
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM ts WHERE (tsNo LIKE '%$query%') OR (suppName LIKE '%$query%') OR (model LIKE '%$query%') OR (partNo LIKE '%$query%')
					order by reqDate desc,suppName";
	}
	
	// Run query
	$selectResult = $conn->query($selectSql);

	// Count total page number
	$pageCount = ceil(1+$dataCountTotal/50);

	// Top page number
	echo "<table class='ui collapsing table'><tr>";
	for($i = 1; $i < $pageCount; $i++){

		// Color the page number if in current page
		if(!empty($_GET['page']) && $_GET['page'] == $i){
			echo "<td onclick='submitForm(&quot;searchpage$i&quot;);' id='selected-tdpage'>$i</td>";
		
		// Other page number
		}else{
			echo "<td onclick='submitForm(&quot;searchpage$i&quot;);' id='tdpage'>$i</td>";		
		}
	}
	echo "</tr></table>";
	
	// Table data	
	if($selectResult->num_rows > 0){
		echo "<table class='ui compact sortable selectable definition table center aligned'>
			<thead class='full-width'><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>Supplier Name</th>
				<th id='tableheader'>TS No</th>
				<th id='tableheader'>Rev.</th>		
				<th id='tableheader'>Model</th>
				<th id='tableheader'>Part Number</th>		
				<th id='tableheader'>Request Date</th>	
				<th id='tableheader'>Delivery Date</th>	
				<th id='tableheader'>Receiver</th>					
				<th id='tableheader'>PIC</th>		
			</tr></thead>";
	}

	$ts=0;
	if($selectResult->num_rows > 0){	
		
		// Selected page number
		$dataCount = 0;
		$page = 1;
		if(!empty($_GET['page'])){
			$page = $_GET['page'];
		}

		// Starting data number
		$no = 1+50*($page-1);

		// Show appropriate data on selected page
		$ts = 50*($page-1); 		

		while($row = mysqli_fetch_assoc($selectResult)) {
			
			// Increase data count
			$dataCount++;

			// Show the correct data on the selected page
			if($dataCount<=$page*50 && $dataCount>($page-1)*50){

				// Check latest rev
				$revSql = "SELECT * FROM ts_rev WHERE tsNo='$row[tsNo]' order by rev+0 desc";
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

					// If still EST
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

				// Show data + link
				echo "<tr>
						<td>$no</td>
						<td class='left aligned'><a href='datasupplier.php?search=$row[suppName]'>PT. $row[suppName]</a></td>
						<td><div class='tdtsno'><a href='datats.php?search=$row[tsNo]'>$row[tsNo]</a></div></td>";

				// If there is newer rev, color the text
				if((preg_match('/EST/',$row['rev']) && $highestRev > 0)
					|| (is_numeric($row['rev']) && (int)$row['rev'] < $highestRev)){
					echo "<td id='existedts' data-tooltip='Latest rev is $latestRev ($latestDate)' data-position='right center'>$row[rev]</td>";
				
				// If already the latest
				}else{
					echo "<td>$row[rev]</td>";
				}
				
				// Convert month to string
				$row['reqDate'] = strtotime( $row['reqDate'] );
				$row['reqDate'] = date( 'Y-M-d', $row['reqDate'] );

				if($row['sendDate'] != "0000-00-00" ){
					$row['sendDate'] = strtotime( $row['sendDate'] );
					$row['sendDate'] = date( 'Y-M-d', $row['sendDate'] );
				}else{
					$row['sendDate'] = "-";
				}

				echo "	<td>$row[model]</td>
						<td>$row[partNo]</td>
						<td>$row[reqDate]</td>
						<td>$row[sendDate]</td>
						<td>$row[receiver]</td>
						<td>$row[pic]</td>";
				echo "</tr>";
				$no++;
			}
			
			// Out of loop if already 50 data in the page
			if($dataCount >= $page*50)break;
			
		}
		
		echo "</table>";

		// Bottom page number
		echo "<table class='ui table collapsing'><tr>";

		for($i = 1; $i < $pageCount; $i++){
			echo "<form action='datasupplier.php' method='GET' id='searchpage$i'>";
			echo "<input type='hidden' value='$i' name='page'>";

			// Dont forget the search query when go to other page
			if(!empty($query)){
				echo "<input type='hidden' value='$query' name='search'>";
			}
			echo "</form>";

			if(!empty($_GET['page']) && $_GET['page'] == $i){
				echo "<td onclick='submitForm(&quot;searchpage$i&quot;);' id='selected-tdpage'>$i</td>";
			}else{
				echo "<td onclick='submitForm(&quot;searchpage$i&quot;);' id='tdpage'>$i</td>";		
			}
		}
		echo "</tr></table>";
	}else{
		echo "<h3 class='ui header center aligned'>No result :(</h3>";
	}
?>
	</div>
	<div class="ui divider"></div>
</body>
</html>