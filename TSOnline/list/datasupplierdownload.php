<?php
	// To put page content to excel file
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=AllSupplier.xls");

	// Connect to db
	include "../db.php";	

	// Select query from the selected ts number
	$selectSql0 = "SELECT * FROM ts order by suppName,tsNo";

	$no = 1;
	$suppCurrent = "";

	echo "<table border=1>
			<thead><tr>
				<th>No</th>
				<th>Supplier Name</th>
				<th>TS No</th>
				<th>Owned Rev.</th>
				<th>Request Date</th>
				<th>Delivery Date</th>
				<th>Supplier Receiver</th>
				<th>TMC Latest Rev.</th>
				<th>Issued Date</th>
			</tr></thead>";

	$selectResult0 = $conn->query($selectSql0);
	while($row0 = mysqli_fetch_assoc($selectResult0)) {

		if($suppCurrent != $row0['suppName']){
			$suppCurrent = $row0['suppName'];

			$selectSql = "SELECT * FROM ts  WHERE suppName='$suppCurrent' order by suppName,tsNo";

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
					$tsSql = "SELECT * FROM ts WHERE suppName='$suppCurrent' && tsNo='$tsCurrent' order by tsNo,rev+0 desc";
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

					$tsRev =  $ts[$tsIndex][1];
					$tsReqDate = $ts[$tsIndex][2];
					$tsLatestRev = $ts[$tsIndex][3];
					$tsLatestDate = $ts[$tsIndex][4];
					$tsSendDate = $ts[$tsIndex][7];
					$tsReceiver = $ts[$tsIndex][10];

					if($tsLatestDate != "-"){
						if($tsLatestDate != ""){
							$tsLatestDate = date('d-M-Y',strtotime($tsLatestDate));
						}else{
							$tsLatestDate = "-";
						}
					}

					if($tsSendDate != "0000-00-00"){
						$tsSendDate = date('d-M-Y',strtotime($tsSendDate));
					}else{
						$tsSendDate = "-";
					}

					$tsReqDate = date('d-M-Y',strtotime($tsReqDate));

					if($tsLatestRev == "No info"){
						echo "<tr style='background-color:#ffff5e;'>";
					}else if($tsRev < $tsLatestRev || $tsRev != $tsLatestRev){
						echo "<tr style='background-color:#ffd3d3;'>";
					}else{ 
						echo "<tr>";
					}
					echo "	<td style='text-align:center;'>$no.</td>
							<td>$suppCurrent</td>
							<td style='text-align:center;'>$tsCurrent</td>
							<td style='text-align:center;'>$tsRev</td>
							<td>$tsReqDate</td>
							<td>$tsSendDate</td>
							<td>$tsReceiver</td>
							<td style='text-align:center;'>$tsLatestRev</td>
							<td>$tsLatestDate</td>
						</tr>";

					$no++;
				}
			}
		}
	}

	echo "</table><br>
	<i>*Please deliver the latest revision to the suppliers that they still don't have it.</i>";
?>