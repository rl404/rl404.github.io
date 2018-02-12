<?php
	// To put page content to excel file
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$_POST[suppname].xls");

	// Connect to db
	include "../db.php";	

	// Select query from the selected ts number
	$selectSql = "SELECT * FROM ts WHERE suppName='$_POST[suppname]' order by tsNo,rev+0 desc";

	$ts = array();
	$tsCurrent = "";
	$tsIndex = 0;

	// Get distinct TS number
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['tsNo'] != $tsCurrent){
			$tsCurrent = $row['tsNo'];
			$ts[$tsIndex][0] = $tsCurrent;

			// Get latest rev ts
			$latestTs = 0;
			$tsSql = "SELECT * FROM ts WHERE suppName='$_POST[suppname]' && tsNo='$tsCurrent' order by tsNo,rev+0 desc";
			$tsSqlResult = $conn->query($tsSql);
			while($tsrow = mysqli_fetch_assoc($tsSqlResult)) {
				$ts[$tsIndex][1] = $tsrow['rev'];
				$ts[$tsIndex][2] = $tsrow['reqDate'];
				$ts[$tsIndex][5] = $tsrow['model'];
				$ts[$tsIndex][6] = $tsrow['partNo'];
				$ts[$tsIndex][7] = $tsrow['sendDate'];
				$ts[$tsIndex][8] = $tsrow['sendStatus'];
				$ts[$tsIndex][9] = $tsrow['reqId'];
				$ts[$tsIndex][10] = $tsrow['receiver'];
				break;
			}

			// Check latest rev
			$revSql = "SELECT * FROM ts_rev WHERE tsNo='$tsCurrent' order by rev+0 desc";
			$revResult = $conn->query($revSql);

			$highestRev = 0;
			$latestRev;
			$latestDate;
			$latestContent = "";
			if($revResult->num_rows > 0){
				while($revrow = mysqli_fetch_assoc($revResult)){			
					
					// If already DISUSE, end loop
					if($revrow['rev'] == 'DISUSE'){
						$ts[$tsIndex][4] = $revrow['issueDate'];
						$highestRev = 100;
						break;	
					}

					// If still EST, continue search
					if(preg_match('/EST/',$revrow['rev']) && $highestRev == 0){
						$ts[$tsIndex][4] = $revrow['issueDate'];
						$highestRev = -100;
					}

					// If found newer rev, that will be the highest rev
					if(is_numeric($revrow['rev']) && $revrow['rev'] > $highestRev ){
						$highestRev = $revrow['rev'];
						$ts[$tsIndex][4] = $revrow['issueDate'];
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
					$ts[$tsIndex][3] = "DISUSE";
				
				// I still EST
				}else if($highestRev == -100){
					$ts[$tsIndex][3] = "EST.";
					$ts[$tsIndex][4] = $row['issueDate'];
				
				// If not DISUSE or EST, get the highest rev
				}else{
					$ts[$tsIndex][3] = $highestRev;
				}
			
			// If ts number not in db
			}else{
				$ts[$tsIndex][3] = "No info";
				$ts[$tsIndex][4] = "-";
			}

			$tsIndex++;
		}
	}

	
	// TS number info
	echo "Supplier name: <b>$_POST[suppname]</b><br><br>";

	// Supplier data table list
	echo "<table border=1>
			<thead><tr>
				<td><b>No<b></td>
				<td><b>TS Number<b></td>
				<td><b>Owned Rev. (Supplier)<b></td>
				<td><b>Request Date<b></td>
				<td><b>Deliver Date<b></td>
				<td><b>Supplier Receiver</b></td>
				<td><b>Latest Rev. (TMC)<b></td>
				<td><b>Issued Date<b></td>
			</tr></thead>";

	$no = 1;
	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		for($i = 0; $i < count($ts); $i++){
			$tsNo =  $ts[$i][0];
			$tsRev =  $ts[$i][1];
			$tsReqDate = $ts[$i][2];
			$tsLatestRev = $ts[$i][3];
			$tsLatestDate = $ts[$i][4];
			$tsModel = $ts[$i][5];
			$tsPart = $ts[$i][6];
			$tsSendDate = $ts[$i][7];
			$tsSendStatus = $ts[$i][8];
			$tsid = $ts[$i][9];
			$tsReceiver = $ts[$i][10];

			if($tsLatestDate != "-"){
				if($tsLatestDate != ""){
					$tsLatestDate = date('Y-M-d',strtotime($tsLatestDate));
				}else{
					$tsLatestDate = "-";
				}
			}

			if($tsSendDate != "0000-00-00"){
				$tsSendDate = date('Y-M-d',strtotime($tsSendDate));
			}else{
				$tsSendDate = "Not Yet";
			}

			$tsReqDate = date('Y-M-d',strtotime($tsReqDate));

			echo "<tr>
					<td style='text-align:center;'>$no</td>
					<td>$tsNo</td>
					<td style='text-align:center;'>$tsRev</td>
					<td style='text-align:center;'>$tsReqDate</td>
					<td style='text-align:center;'>$tsSendDate</td>
					<td style='text-align:center;'>$tsReceiver</td>
					<td style='text-align:center;'>$tsLatestRev</td>
					<td style='text-align:center;'>$tsLatestDate</td>
				</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td class='center aligned' colspan=7>0 result :(</td>
			</tr>";
	}
	echo "</table><br>
	<i>*Please deliver the latest revision to the suppliers that they still don't have it.</i>";
?>