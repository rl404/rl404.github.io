<?php
	include "../db.php";
	include "../function.php";

	if(empty($_POST['model'])){
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
					<th id='tableheader'>TMMIN Proposal</th>
					<th id='tableheader'>Accepted by TMC</th>
				</tr></thead>";

		$modelCurrent = '';
		$model = array();
		$modelIndex = 0;
		$totalTMC = 0;
		$totalTMMIN = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {

				$row['model'] = str_replace(' ', '', $row['model']);
				
				if($row['model'] != $modelCurrent){
					$modelCurrent = $row['model'];
					$model[$modelIndex][0] = $modelCurrent;

					$selectSql2 = "SELECT * FROM vave 
						WHERE YEAR(proposerDate)=$_POST[year]".$whereMonth." 
						AND model='$modelCurrent'";

					$model[$modelIndex][1] = 0;
					$model[$modelIndex][2] = 0;

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						
						if($row2['proposerDate'] != "0000-00-00"){
							$model[$modelIndex][1] ++;
						}

						if($row2['statusTMC'] == "O"){
							$model[$modelIndex][2] ++;
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

		include "processgraph.php";
	}else{
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
		
		$selectSql = "SELECT * FROM vave WHERE model='$_POST[model]' AND YEAR(proposerDate)=$_POST[year] ".$whereMonth." order by proposerDate";

		echo "<div id='reportgraph' style='height:75vh;'></div>";

		echo "<table class='ui selectable sortable center aligned table'>
				<thead><tr>
					<th id='tableheader'>Month</th>
					<th id='tableheader'>TMMIN Proposal</th>";

					if($_POST['month'] != "all"){
						echo "<th id='tableheader'>PE Status</th>
							<th id='tableheader'>PP Status</th>
							<th id='tableheader'>PuD Approved</th>
							<th id='tableheader'>EA to TMC</th>";
					}

		echo "		<th id='tableheader'>TMC Status</th>
				</tr></thead>";

		$monthCurrent = '';
		$month = array();
		$monthIndex = 0;
		$totalTMC = 0;
		$totalTMMIN = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {
				if(date('m',strtotime($row['proposerDate'])) != $monthCurrent){
					$monthCurrent = date('m',strtotime($row['proposerDate']));

					$month[$monthIndex][0] = date('F', strtotime($row['proposerDate']));

					$selectSql2 = "SELECT * FROM vave 
						WHERE YEAR(proposerDate)=$_POST[year] AND MONTH(proposerDate)=$monthCurrent
						AND model='$_POST[model]'";

					$month[$monthIndex][1] = 0; // all
					$month[$monthIndex][2] = 0; // PE approve
					$month[$monthIndex][3] = 0; // PP approve
					$month[$monthIndex][4] = 0; // PuD approve
					$month[$monthIndex][5] = 0; // EA to TMC
					$month[$monthIndex][6] = 0; // TMC approve

					$month[$monthIndex][7] = 0; // PE understudy
					$month[$monthIndex][8] = 0; // PE duplicate
					$month[$monthIndex][9] = 0; // PE reject

					$month[$monthIndex][10] = 0; // PP understudy
					$month[$monthIndex][11] = 0; // PP reject

					$month[$monthIndex][12] = 0; // TMC reject

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						
						if($row2['proposerDate'] != "0000-00-00"){$month[$monthIndex][1] ++;}
						if($row2['result'] == "O"){$month[$monthIndex][2] ++;}
						if($row2['status'] == "O"){$month[$monthIndex][3] ++;}
						if($row2['costReduction'] != "0"){$month[$monthIndex][4] ++;}
						if($row2['sendToEA'] != "0000-00-00"){$month[$monthIndex][5] ++;}
						if($row2['statusTMC'] == "O"){
							$month[$monthIndex][6] ++;
							$totalTMC++;
						}

						if($row['result'] == "U"){$month[$monthIndex][7]++;}
						if($row['result'] == "D"){$month[$monthIndex][8]++;}
						if($row['result'] == "X"){$month[$monthIndex][9]++;}

						if($row2['status'] == "U"){$month[$monthIndex][10] ++;}
						if($row2['status'] == "X"){$month[$monthIndex][11] ++;}
						if($row2['statusTMC'] == "X"){$month[$monthIndex][12] ++;}

						$totalTMMIN++;
					}

					$monthIndex++;
				}

			}

			// usort($model, 'compareOrder');

			for($i = 0; $i < $monthIndex; $i++){
				$monthname = $month[$i][0];
				$tmminmonth = number_format($month[$i][1]);
				$pemonth = number_format($month[$i][2]);
				$ppmonth = number_format($month[$i][3]);
				$pudmonth = number_format($month[$i][4]);
				$eamonth = number_format($month[$i][5]);
				$tmcmonth = number_format($month[$i][6]);

				$pemonthu = number_format($month[$i][7]);
				$pemonthd = number_format($month[$i][8]);
				$pemonthx = number_format($month[$i][9]);

				$ppmonthu = number_format($month[$i][10]);
				$ppmonthx = number_format($month[$i][11]);
				$tmcmonthx = number_format($month[$i][12]);

				echo "<tr>
						<td>$monthname</td>
						<td>$tmminmonth</td>";

						if($_POST['month'] != "all"){
							echo "<td>O: $pemonth<br>
									U: $pemonthu<br>
									D: $pemonthd<br>
									X: $pemonthx</th>
								<td>O: $ppmonth<br>
									U: $ppmonthu<br>
									X: $ppmonthx</td>
								<td>$pudmonth</td>
								<td>$eamonth</td>";
						}

				echo "	<td>$tmcmonth</td>
					</tr>";
			}
		}else{
			echo "<tr>
					<td colspan=3>No result :(</td>
				</tr>";
		}
		echo "</table>";

		include "processgraph2.php";
	}

	echo "<script>
		$(document).ready(function() {
		  init_echarts();
		});
	</script>";	


?>