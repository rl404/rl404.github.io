<html>
	<?php include "../header.php"; ?>

	<div class="ui container">
	<div class="ui secondary menu">
		<div class="item">		

<?php
	// Connect to db
	include "../db.php";

	echo "<h1 id='titleheader2'>VAVE List</h1>";		
	echo "</div>
	</div>";

	// Select all supplier
	$selectSql = "SELECT * FROM vave order by id desc";


	$selectResult = $conn->query($selectSql);

	// Table data
	if($selectResult->num_rows > 0){
		echo "<table class='ui center aligned compact sortable selectable definition table' id='vavelist'>
			<thead class='full-width'><tr>
				<th id='tableheader' class='center aligned'>No</th>
				<th id='tableheader' class='center aligned'>Manuc No</th>
				<th id='tableheader' class='center aligned'>Proposer Number</th>
				<th id='tableheader' class='center aligned'>Model</th>

				<th id='tableheader' class='center aligned'>PE Process</th>
				<th id='tableheader' class='center aligned'>PP Process</th>
				<th id='tableheader' class='center aligned'>PuD Process</th>
				<th id='tableheader' class='center aligned'>EA Process</th>
				<th id='tableheader' class='center aligned'>TMC Approve</th>
			</tr></thead><tbody>";

		$currentManuc = '';
		$no = 1;		
		while($row = mysqli_fetch_assoc($selectResult)) {

			if($row['result'] == "O"){$peResult = "<div class='hiddenvalue'>4</div><i class='green checkmark icon'></i>";
	  		}else if($row['result'] == "U"){$peResult = "<div class='hiddenvalue'>3</div><i class='yellow edit icon'></i>";	  			
	  		}else if($row['result'] == "D"){$peResult = "<div class='hiddenvalue'>2</div><i class='orange clone icon'></i>";	  			
	  		}else if($row['result'] == "X"){$peResult = "<div class='hiddenvalue'>1</div><i class='red remove icon'></i>";	  			
	  		}else{$peResult = "<div class='hiddenvalue'>0</div><i class='help icon'></i>";}

	  		if($row['status'] == "O"){$ppResult = "<div class='hiddenvalue'>3</div><i class='green checkmark icon'></i>";
	  		}else if($row['status'] == "U"){$ppResult = "<div class='hiddenvalue'>2</div><i class='yellow edit icon'></i>";  			
	  		}else if($row['status'] == "X"){$ppResult = "<div class='hiddenvalue'>1</div><i class='red remove icon'></i>";	  			
	  		}else{$ppResult = "<div class='hiddenvalue'>0</div><i class='help icon'></i>";}

	  		if($row['costReduction'] != "0"){$pudResult = "<div class='hiddenvalue'>1</div><i class='green checkmark icon'></i>"; 			
	  		}else{$pudResult = "<div class='hiddenvalue'>0</div><i class='help icon'></i>";}

	  		if($row['uploadToTMC'] != "0000-00-00"){$eaResult = "<div class='hiddenvalue'>1</div><i class='green checkmark icon'></i>"; 	
	  		}else{$eaResult = "<div class='hiddenvalue'>0</div><i class='help icon'></i>";}

	  		if($row['statusTMC'] == "O"){$tmcResult = "<div class='hiddenvalue'>2</div><i class='green checkmark icon'></i>";			
	  		}else if($row['statusTMC'] == "X"){$tmcResult = "<div class='hiddenvalue'>1</div><i class='red remove icon'></i>";	  			
	  		}else{$tmcResult = "<div class='hiddenvalue'>0</div><i class='help icon'></i>";}

			echo "<tr>
					<td class='center aligned'>$no.</td>
					<td class='center aligned'><a href='../input/inputsearch.php?search=$row[id]' target='_target'>$row[manufacturerNo]</a></td>
					<td class='center aligned'><a href='../input/inputsearch.php?search=$row[id]' target='_target'>$row[teardownNo]</a></td>
					<td>$row[model]</td>
					<td>$peResult</td>
					<td>$ppResult</td>
					<td>$pudResult</td>
					<td>$eaResult</td>
					<td>$tmcResult</td>
					</tr>";
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