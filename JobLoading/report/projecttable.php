<?php
	include "../db.php";
	include "../function.php";

	function compareOrder($a, $b){return $b[2] - $a[2];}

	if(session_id() == '') {
	    session_start();
	}

	if(empty($_POST['month'])){

		$_POST['month'] = date('m');
		$_POST['year'] = date('Y');

		$_POST['project'] = '';
		
	}

	if(!notempty($_POST['project']) || $_POST['project'] == 'All'){
		$whereSql = '';
		$selectSql = "SELECT * FROM data WHERE MONTH(jobDate)=$_POST[month] 
				AND YEAR(jobDate)=$_POST[year]".$whereSql." 
				order by projectCode,jobName";

		echo "<div id='reportgraph'></div>";

		echo "<table class='ui selectable sortable center aligned table'>
				<thead><tr>
					<th id='tableheader'>Proj. Code</th>
					<th id='tableheader'>Proj. Name</th>
					<th id='tableheader'>Hours</th>
				</tr></thead>";

		$projectCurrent = '';
		$jobHour = 0;
		$totalHour = 0;
		$project = array();
		$projectIndex = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {
				$jobHour = 0;
				$row['projectCode'] = strtoupper($row['projectCode']);
				if($row['projectCode'] != $projectCurrent){
					$projectCurrent = $row['projectCode'];
					$project[$projectIndex][0] = $projectCurrent;

					// get proj name
					$selectSql2 = "SELECT * FROM project 
						WHERE projectCode='$projectCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					if($selectResult2->num_rows > 0){
						while($row2 = mysqli_fetch_assoc($selectResult2)) {
							$project[$projectIndex][1] = $row2['projectName'];
							break;
						}
					}else{
						$project[$projectIndex][1] = 'Unknown';
					}

					// count hour
					$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND projectCode='$projectCurrent'";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$jobHour += $row2['jobHour'];
						$totalHour += $row2['jobHour'];
					}
					
					$project[$projectIndex][2] = $jobHour;
					$projectIndex++;					
				}
			}

			usort($project, 'compareOrder');

			for($i = 0; $i < $projectIndex; $i++){
				$projectCode = $project[$i][0];
				$projectName = $project[$i][1];
				$projectHour = number_format((float)$project[$i][2], 1, '.', '');
				echo "<tr>
						<td>$projectCode</td>
						<td class='left aligned'>$projectName</td>
						<td>$projectHour</td>
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

		include "projectgraph.php";

	}else{

		$whereSql = " AND projectCode='$_POST[project]' ";
		$selectSql = "SELECT * FROM data WHERE MONTH(jobDate)=$_POST[month] 
				AND YEAR(jobDate)=$_POST[year]".$whereSql." 
				order by projectCode,jobName";

		echo "<div id='reportgraph'></div>";

		echo "<table class='ui selectable sortable center aligned table'>
				<thead><tr>
					<th id='tableheader'>Job Name</th>
					<th id='tableheader'>Hours</th>
				</tr></thead>";

		$jobCurrent = '';
		$projectCurrent = '';
		$jobHour = 0;
		$totalHour = 0;
		$job = array();
		$jobIndex = 0;

		$selectResult = $conn->query($selectSql);
		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {
				$jobHour = 0;
				$row['projectCode'] = strtoupper($row['projectCode']);
				if($row['jobName'] != $jobCurrent || $row['projectCode'] != $projectCurrent){
					$jobCurrent = $row['jobName'];
					$projectCurrent = $row['projectCode'];
					$job[$jobIndex][0] = $row['jobName'];

					$selectSql2 = "SELECT * FROM data 
						WHERE MONTH(jobDate)=$_POST[month] 
						AND YEAR(jobDate)=$_POST[year]
						AND jobName='$jobCurrent'
						AND projectCode='$projectCurrent'
						order by projectCode,jobName";

					$selectResult2 = $conn->query($selectSql2);
					while($row2 = mysqli_fetch_assoc($selectResult2)) {
						$jobHour += $row2['jobHour'];
						$totalHour += $row2['jobHour'];
					}
					
					$jobHour = number_format((float)$jobHour, 1, '.', '');
					$job[$jobIndex][1] = $jobHour;

					echo "<tr>
							<td class='left aligned'>$jobCurrent</td>
							<td>$jobHour</td>
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

		include "projectgraph2.php";
	}


?>