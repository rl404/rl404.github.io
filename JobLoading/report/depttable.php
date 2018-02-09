<?php
	include "../db.php";
	include "../function.php";

	function compareOrder($a, $b){return $b[2] - $a[2];}

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
					<th id='tableheader'>Dept. Name</th>
					<th id='tableheader'>Hours</th>
				</tr></thead>";

		$deptCurrent = '';
		$jobCurrent = '';
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

					// get dept name
					$selectSql2 = "SELECT * FROM dept 
						WHERE deptCode='$deptCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$dept[$deptIndex][1] = $row2['deptName'];
						break;
					}

					// get hour
					$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND deptCode='$deptCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$deptHour += $row2['jobHour'];
						$totalHour += $row2['jobHour'];
					}

					$dept[$deptIndex][2] = $deptHour;
					$deptIndex++;
				}

			}

			usort($dept, 'compareOrder');

			for($i = 0; $i < $deptIndex; $i++){
				$deptCode = $dept[$i][0];
				$deptName = $dept[$i][1];
				$deptHour = number_format((float)$dept[$i][2], 1, '.', '');
				echo "<tr>
						<td>$deptCode</td>
						<td class='left aligned'>$deptName</td>
						<td>$deptHour</td>
					</tr>";
			}
			echo "<tfoot><tr>
					<th colspan=2 id='tablefooter'>Total</th>
					<th id='tablefooter'>$totalHour</th>
				</tr></tfoot>";
		}else{
			echo "<tr>
					<td colspan=3>No result :(</td>
				</tr>";
		}
		echo "</table>";

		include "deptgraph.php";

	}else{
		$whereSql = " AND deptCode='$_POST[dept]' ";
		$selectSql = "SELECT * FROM data WHERE MONTH(jobDate)=$_POST[month] 
				AND YEAR(jobDate)=$_POST[year]".$whereSql." 
				order by deptCode,jobName";

		echo "<div id='reportgraph'></div>";

		echo "<table class='ui selectable sortable center aligned table'>
				<thead><tr>
					<th id='tableheader'>Job Name</th>
					<th id='tableheader'>Hours</th>
				</tr></thead>";

		$deptCurrent = '';
		$jobCurrent = '';
		$deptHour = 0;
		$totalHour = 0;
		$job = array();
		$jobIndex = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {
				$deptHour = 0;
				if($row['deptCode'] != $deptCurrent || $row['jobName'] != $jobCurrent){
					$deptCurrent = $row['deptCode'];
					$jobCurrent = $row['jobName'];
					$job[$jobIndex][0] = $row['jobName'];

					$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND jobName='$jobCurrent'
						AND deptCode='$deptCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$deptHour += $row2['jobHour'];
						$totalHour += $row2['jobHour'];
					}

					$deptHour = number_format((float)$deptHour, 1, '.', '');
					$job[$jobIndex][1] = $deptHour;

					echo "<tr>
							<td class='left aligned'>$row[jobName]</td>
							<td>$deptHour</td>
						</tr>";
					$jobIndex++;
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

		include "deptgraph2.php";
	}

	


?>