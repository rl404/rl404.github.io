<?php
	include "../db.php";	
	include "../function.php";

	if(session_id() == '') {
	    session_start();
	}

	if(empty($_POST['month'])){

		$_POST['month'] = date('m');
		$_POST['year'] = date('Y');

		$day = date('d');
		
		$_POST['week'] = getWeeks("$_POST[year]-$_POST[month]-$day", "sunday");
		
	}

	$maxWeek = weeks($_POST['month'],$_POST['year']);

	echo "<form class='ui form' action='download.php' method='post'>		
				<div class='inline fields'>
					<div class='field'>
						<select id='jobweek'>";

				for($i = 1; $i <= $maxWeek; $i++){
					if($i == $_POST['week']){
						echo "<option value='$i' selected>Week $i</option>";
					}else{
						echo "<option value='$i'>Week $i</option>";
					}
				}

				echo "
						</select>
					</div>
					<label>-</label>
					<div class='field'>
						<select name='month' id='jobmonth'>";
						for($i=1;$i<13;$i++){
							$reqMonth = date("F",mktime(0,0,0,$i,1,2011));
							if($i==$_POST['month']){
								echo "<option value='$i' selected>$reqMonth</option>";
							}else{
								echo "<option value='$i'>$reqMonth</option>";
							}
						}
		echo "			</select>
					</div>
					<label>-</label>
					<div class='field'>
						<input id='jobyear' type='text' name='year' size=5 value='";
		echo 			$_POST['year'];
		echo 			"'>
					</div>
					<div class='field'>
						<img class='ui centered mini image' src='../images/loading.gif' id='ajaxloading' style='display:none;'>
					</div>";
				
				if($_SESSION['deptname'] == "EA"){
					echo "<div class='field'>
						<button class='ui inverted green labeled icon button' type='submit'>
							<i class='link file excel outline icon'></i>
							Download
						</button>
					</div>";
				}					
				echo "</div>
			</form>";

	$strwhere = '';
	if(intval($_SESSION['titlerank']) >= 4){
		$strwhere = "";
	}else{
		$strwhere = "WHERE deptCode='$_SESSION[deptname]'";
	}
	$selectSql = "SELECT * FROM staff ".$strwhere." order by staffName";

	echo "<table class='ui sortable selectable definition center aligned collapsing table'>
			<thead class='full-width'><tr>
				<th id='tableheader'>No</th>					
				<th id='tableheader'>Member Name</th>
				<th id='tableheader'>Title</th>";

		if($_SESSION['titlerank'] >= 4){
			echo "<th id='tableheader'>Dept.</td>";
		}

	$week = 1;
	for($i = 1; $i < 32; $i++){		
		$timestamp = strtotime("$_POST[year]-$_POST[month]-$i");
		$day = date('D', $timestamp);
		
		if($day == 'Sun') $week++;
		if($week == $_POST['week']){
			$i2 = ordinal((int)$i);
			if($day == 'Sun' || $day == 'Sat'){
				echo "<th class='one wide' id='weekendtext'>$i2".'<br>'."$day</th>";
			}else if($i == date('d') && $_POST['month'] == date('m') && $_POST['year'] == date('Y')){
				echo "<th class='one wide' id='todaytext'>$i2".'<br>'."$day</th>";
			}else{
				echo "<th class='one wide' id='tableheader'>$i2".'<br>'."$day</th>";
			}
		}
	}
	echo "	<th class='one wide' id='tableheader'>Total Week Hour</th>
		</tr></thead>";

	$no = 1;
	$staffCurrent = '';
	$staffIndex = 0;
	$jobRank = 0;
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['jobTitle'] == 'Div. Head' || $row['jobTitle'] == 'Admin'){
			$jobRank = 4;
		}else if($row['jobTitle'] == 'Dept. Head'){
			$jobRank = 3;
		}else if($row['jobTitle'] == 'Sect. Head'){
			$jobRank = 2;
		}else{
			$jobRank = 1;
		}

		if($jobRank <= $_SESSION['titlerank']){
			if($row['staffName'] != $staffCurrent){
				$staffCurrent = $row['staffName'];
				$row['staffName'] = strtoupper($row['staffName']);
				
				echo "<tr>
						<td>$no.</td>
						<td class='left aligned'>$row[staffName]</td>
						<td>$row[jobTitle]</td>";

				if($_SESSION['titlerank'] >= 4){
					echo "<td>$row[deptCode]</td>";
				}

				$week = 1;
				$weekHour = 0;
				for($i = 1; $i < 32; $i++){		
					$timestamp = strtotime("$_POST[year]-$_POST[month]-$i");
					$day = date('D', $timestamp);
					
					if($day == 'Sun') $week++;
					if($week == $_POST['week']){
						$dayHour = 0;
						$selectSql2 = "SELECT * FROM data WHERE staffName='$row[staffName]'
									AND DAY(jobDate)=$i AND MONTH(jobDate)=$_POST[month] AND YEAR(jobDate)=$_POST[year] 
									ORDER By jobHour+0 desc";
						$selectResult2 = $conn->query($selectSql2);

						$job = array();
						$jobIndex = 0;
						if($selectResult2->num_rows > 0){
							while($row2 = mysqli_fetch_assoc($selectResult2)) {
								$job[$jobIndex][0] = $row2['jobName'];
								$job[$jobIndex][1] = $row2['jobHour'];
								$job[$jobIndex][2] = $row2['projectCode'];

								$dayHour += $row2['jobHour'];
								$weekHour += $row2['jobHour'];

								$jobIndex++;
							}
						}

						$jobHourDetail = '';
						for($j = 0; $j < $jobIndex; $j++){
							$jobname = $job[$j][0];
							$jobhour = $job[$j][1];
							$projectcode = $job[$j][2];

							$jobHourDetail = $jobHourDetail."<b>$jobhour</b> - $jobname ($projectcode) <br>"; 
						}

						if($day == 'Sun' || $day == 'Sat'){
							echo "<td id='errortext'>";
						}else if($i == date('d') && $_POST['month'] == date('m') && $_POST['year'] == date('Y')){
							echo "<td id='todaytext2'>";
						}else{
							echo "<td>";
						}
						if($dayHour == 0) $dayHour = "-";
						
						// echo "<div class='detailjobview' data-html='$jobHourDetail' data-position='right center'>$dayHour</div></td>";
						echo "<div class='tooltip'>$dayHour<span class='tooltiptext'>$jobHourDetail</span></div></td>";
					}
				}
				echo "<td id='tabletotal'>$weekHour</td>";
				echo "</tr>";
				$no++;
			}
		}
	}

	echo "</table>";

?>