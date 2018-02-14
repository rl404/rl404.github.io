<?php
	include "../db.php";
	include "../function.php";

	// function compareOrder($a, $b){return $b[2] - $a[2];}

	if(session_id() == '') {
	    session_start();
	}


	$whereMonth = "";	
	if(empty($_POST['year'])){

		$_POST['month'] = date('m');
		$_POST['year'] = date('Y');

		$whereMonth = " and MONTH(proposerDate)=$_POST[month] ";
		
	}else{
		if($_POST['month'] == "all"){
			$whereMonth = "";
		}else{
			$whereMonth = " and MONTH(proposerDate)=$_POST[month] ";
		}
	}

	// echo $_POST['month'] ;
	
	$selectSql = "SELECT * FROM vave WHERE YEAR(proposerDate)=$_POST[year] ".$whereMonth." order by model";

	echo "<div id='reportgraph' style='height:75vh;'></div>";

	echo "<table class='ui selectable sortable center aligned table'>
			<thead><tr>
				<th id='tableheader'>Model</th>
				<th id='tableheader'>Send to TMC</th>
				<th id='tableheader'>Accepted by TMC</th>
			</tr></thead>";

	$modelCurrent = '';
	$model = array();
	$modelIndex = 0;
	$totalTMMIN = 0;
	$totalTMC = 0;

	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		while($row = mysqli_fetch_assoc($selectResult)) {

			if(empty($row['model'])){$row['model'] = "Unknown";}
			$row['model'] = str_replace(' ', '', $row['model']);

			if($row['model'] != $modelCurrent){
				$modelCurrent = $row['model'];
				$model[$modelIndex][0] = $modelCurrent;

				$selectSql2 = "SELECT * FROM vave 
					WHERE YEAR(proposerDate)=$_POST[year] ".$whereMonth." 
					AND model='$modelCurrent'";

				$model[$modelIndex][1] = 0;
				$model[$modelIndex][2] = 0;

				$selectResult2 = $conn->query($selectSql2);
				while($row2 = mysqli_fetch_assoc($selectResult2)) {
					
					if($row2['sendToEA'] != "0000-00-00"){
						$model[$modelIndex][1] += $row2['costReduction'];
					}

					if($row2['statusTMC'] == "O"){
						$model[$modelIndex][2] += $row2['costReduction'];
						$totalTMC++;
					}

					$totalTMMIN++;
				}

				$modelIndex++;
			}

		}

		// usort($model, 'compareOrder');
		
		for($i = 0; $i < $modelIndex; $i++){
			$modelcost = $model[$i][0];
			$eacost = number_format($model[$i][1]);
			$tmccost = number_format($model[$i][2]);
			echo "<tr>
					<td>$modelcost</td>
					<td>$eacost</td>
					<td>$tmccost</td>
				</tr>";
		}
	}else{
		echo "<tr>
				<td colspan=3>No result :(</td>
			</tr>";
	}
	echo "</table>";

	include "costgraph.php";

	echo "<script>
		$(document).ready(function() {
		  init_echarts();
		});
	</script>";	


?>