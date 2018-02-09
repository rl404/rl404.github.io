<?php
	include "../db.php";
	include "../function.php";

	function compareOrder($a, $b){return $b[1] - $a[1];}

	if(session_id() == '') {
	    session_start();
	}

	$whereSql = " ";
	if(empty($_POST['month'])){

		$_POST['month'] = date('m');
		$_POST['year'] = date('Y');

		$_POST['dept'] = '';
		
	}

	if(!notempty($_POST['dept']) || $_POST['dept'] == 'All'){
		$whereSql = '';
		$selectSql = "SELECT * FROM data WHERE MONTH(jobDate)=$_POST[month] 
				AND YEAR(jobDate)=$_POST[year]".$whereSql." 
				order by deptCode,jobName";

		echo "<div id='reportgraph'></div>";

		echo "<table class='ui selectable sortable center aligned table'>
				<thead><tr>
					<th id='tableheader'>Dept. Code</th>
					<th id='tableheader'><div data-tooltip='Average every member = Actual Hour / Inputted Member'>Member</div></th>
					<th id='tableheader'><div data-tooltip='8 Hours X 20 Days X Inputted Member'>Ideal Hour / Month</div></th>
					<th id='tableheader'>Actual Hour</th>
				</tr></thead>";

		$deptCurrent = '';
		$deptHour = 0;
		$totalHour = 0;
		$dept = array();
		$deptIndex = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {
				$deptHour = 0;
				if($row['deptCode'] != $deptCurrent){
					$deptCurrent = $row['deptCode'];
					$dept[$deptIndex][0] = $deptCurrent;

					$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND deptCode='$deptCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$deptHour += $row2['jobHour'];
						$totalHour += $row2['jobHour'];
					}

					$dept[$deptIndex][1] = $deptHour;
					$deptIndex++;
				}

			}

			usort($dept, 'compareOrder');

			for($i = 0; $i < $deptIndex; $i++){
				$deptCode = $dept[$i][0];
				$deptHour = number_format((float)$dept[$i][1], 1, '.', '');

				$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND deptCode='$deptCode'
						order by staffName";

				// count member
				$staffCurrent = '';
				$staffCount = 0;
				$selectResult2 = $conn->query($selectSql2);
				while($row2 = mysqli_fetch_assoc($selectResult2)) {
					if($row2['staffName'] != $staffCurrent){
						$staffCurrent = $row2['staffName'];
						$staffCount++;
					}
				}
				$staffActualHour = $staffCount*160;
				$staffAvgHour = $deptHour/$staffCount;
				$staffAvgHour = number_format((float)$staffAvgHour, 1, '.', '');

					echo "<tr>
							<td>$deptCode</td>
							<td><div data-tooltip='Average every member: $staffAvgHour' data-position='right center'>$staffCount</div></td>
							<td>$staffActualHour</td>";

				if($deptHour < (90/100*$staffActualHour)){
					echo "<td style='color:red;'>";
				}else{
					echo "<td>";
				}			
					echo "$deptHour</td>
						</tr>";
			}
			echo "<tfoot><tr>
					<th colspan=3 id='tablefooter'>Total</th>
					<th id='tablefooter'>$totalHour</th>
				</tr></tfoot>";
		}else{
			echo "<tr>
					<td colspan=4>No result :(</td>
				</tr>";
		}
		echo "</table>";

		include "staffgraph.php";

	}else{
		$whereSql = " AND deptCode='$_POST[dept]' ";
		$selectSql = "SELECT * FROM data WHERE MONTH(jobDate)=$_POST[month] 
				AND YEAR(jobDate)=$_POST[year]".$whereSql." 
				order by deptCode,staffName";

		echo "<div id='reportgraph'></div>";

		echo "<table class='ui selectable sortable center aligned table'>
				<thead><tr>
					<th id='tableheader'>Member Name</th>
					<th id='tableheader'><div data-tooltip='8 Hours X 20 Days'>Hours (Ideal / Month = 160)</div></th>
				</tr></thead>";

		$deptCurrent = '';
		$staffCurrent = '';
		$deptHour = 0;
		$totalHour = 0;
		$staff = array();
		$staffIndex = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {
				$deptHour = 0;
				if($row['deptCode'] != $deptCurrent || $row['staffName'] != $staffCurrent){
					$deptCurrent = $row['deptCode'];
					$staffCurrent = $row['staffName'];
					$staff[$staffIndex][0] = $row['staffName'];
					$row['staffName'] = strtoupper($row['staffName']);

					$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND staffName='$staffCurrent'
						AND deptCode='$deptCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$deptHour += $row2['jobHour'];
						$totalHour += $row2['jobHour'];
					}

					$deptHour = number_format((float)$deptHour, 1, '.', '');
					$staff[$staffIndex][1] = $deptHour;
					
					echo "<tr>
							<td class='left aligned'>$row[staffName]</td>";

					if($deptHour < (90/100*160)){
						echo "<td style='color:red;'>";
					}else{
						echo "<td>";
					}	
						echo "$deptHour</td>
						</tr>";
					$staffIndex++;
				}

			}
			echo "<tfoot><tr>
					<th id='tablefooter'>Total</th>
					<th id='tablefooter'>$totalHour</th>
				</tr></tfoot>";
		}else{
			echo "<tr>
					<td colspan=2>No result :(</td>
				</tr>";
		}
		echo "</table>";

		include "staffgraph2.php";
	}

	


?>