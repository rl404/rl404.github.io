<?php
	include "db.php";
	
	if(empty($_POST['graphyear'])){
		$_POST['graphyear'] = date('Y');
	}

	$graphyear = $_POST['graphyear'];

	echo "<div class='ui one column grid'>";
		
		include "graph/graphcost.php"; 
	
	echo "<div class='column' id='graphcost'></div>
		</div>
		<h2 class='ui center aligned dividing header'>Monthly Proposal</h2>";

		
		// Select all supplier
		$selectSql = "SELECT distinct model FROM vave where YEAR(proposerDate)='$graphyear' order by model";
		$selectResult = $conn->query($selectSql);

		$column = 1;			

		while($row = mysqli_fetch_assoc($selectResult)) {

			if($column == 1){
				echo "<div class='ui two column grid'>";
			}

			$selectSql2 = "SELECT * FROM vave where model='$row[model]' and YEAR(proposerDate)='$graphyear' order by proposerDate";
			$selectResult2 = $conn->query($selectSql2);

			$month = array();
			$monthPP = array();
			$monthPUD = array();
			$monthEA = array();

			$currentMonth = '';
			$monthIndex = 0;
			$totalProposal = 0;

			while($row2 = mysqli_fetch_assoc($selectResult2)) {	

				if($currentMonth != date('m',strtotime($row2['proposerDate']))){

					$currentMonth = date('m',strtotime($row2['proposerDate']));
					$month[$monthIndex][0] = $currentMonth;
					$monthPP[$monthIndex][0] = $currentMonth;

					$selectSql3 = "SELECT * FROM vave where model='$row[model]' and YEAR(proposerDate)='$graphyear' and MONTH(proposerDate)='$currentMonth'";
					$selectResult3 = $conn->query($selectSql3);

					$month[$monthIndex][1] = 0;
					$monthPP[$monthIndex][1] = 0;
					$monthPUD[$monthIndex][1] = 0;
					$monthEA[$monthIndex][1] = 0;

					while($row3 = mysqli_fetch_assoc($selectResult3)) {	
						$month[$monthIndex][1]++;
						if($row3['receivedFromPE'] != "0000-00-00"){
							$monthPP[$monthIndex][1]++;							
						}

						if($row3['sendToPuD'] != "0000-00-00" && $row3['repliedFromPuD'] == "0000-00-00"){
							$monthPUD[$monthIndex][1]++;
						}

						if($row3['sendToEA'] != "0000-00-00"){
							$monthEA[$monthIndex][1]++;							
						}
						$totalProposal++;
					}
					
					$monthIndex++;
				}
			}

			include "graph/graphmonth.php";
			echo "<div class='column'>Model: $row[model] <br> Total Proposal: $totalProposal<div id='graph$row[model]'></div></div>";
			$column++;

			if($column == 3){
				echo "</div>";
				$column = 1;
			}

		}

	echo "</div><h2 class='ui center aligned dividing header'>Proposal Types</h2>";

		// Select all supplier
		$selectSql = "SELECT distinct model FROM vave where YEAR(proposerDate)='$graphyear' order by model";
		$selectResult = $conn->query($selectSql);

		$column = 1;			

		while($row = mysqli_fetch_assoc($selectResult)) {

			if($column == 1){
				echo "<div class='ui three column grid'>";
			}

			$selectSql2 = "SELECT * FROM vave where model='$row[model]' and YEAR(proposerDate)='$graphyear' order by ideaType";
			$selectResult2 = $conn->query($selectSql2);

			$typeP = array();
			$currentType = '';
			$typeIndex = 0;
			$totalProposal = 0;

			while($row2 = mysqli_fetch_assoc($selectResult2)) {	

				if($currentType != $row2['ideaType']){

					$currentType = $row2['ideaType'];
					$typeP[$typeIndex][0] = $currentType;

					$selectSql3 = "SELECT * FROM vave where model='$row[model]' and YEAR(proposerDate)='$graphyear' and ideaType='$currentType'";
					$selectResult3 = $conn->query($selectSql3);

					$typeP[$typeIndex][1] = 0;

					while($row3 = mysqli_fetch_assoc($selectResult3)) {	
						$typeP[$typeIndex][1]++;
						$totalProposal++;
					}
					
					$typeIndex++;
				}
			}

			include "graph/graphtype.php";
			echo "<div class='column'>Model: $row[model] <br> Total Proposal: $totalProposal<div id='graph2$row[model]'></div></div>";
			$column++;

			if($column == 4){
				echo "</div>";
				$column = 1;
			}

		}

		echo "</div>";
?>
