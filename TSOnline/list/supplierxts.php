<?php
	// Connect to db
	include "../db.php";
	session_start();

	// Select query from chosen supplier name
	$selectSql = "SELECT * FROM ts WHERE suppName='$_POST[supplier]' order by tsNo,rev+0 desc";

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
			$tsSql = "SELECT * FROM ts WHERE suppName='$_POST[supplier]' && tsNo='$tsCurrent' order by tsNo,reqId desc";
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
	
	// Supplier name title
	echo "<h2 class='ui header' id='titleheader2'>	
			<form method='POST' action='datasupplierxts.php' id='$_POST[supplier]xtsform'>
				<input type='hidden' name='suppname' value='$_POST[supplier]'>					
			</form>

			<i class='green link file excel outline icon' onclick='submitForm(&quot;$_POST[supplier]xtsform&quot;)';></i>
			
			<div class='content'>
				PT. $_POST[supplier]
			</div>		
		</h2>";	

	// SUpplier data table
	echo "<div id='listxlist'>
		<table class='ui center aligned sortable table'>
			<thead><tr>
				<th id='tableheader'>No</th>
				<th id='tableheader'>TS Number</th>
				<th id='tableheader'>Owned Rev.</th>
				<th id='tableheader'>Latest Rev.</th>
				<th id='tableheader'>Model</th>
				<th id='tableheader'>Part No.</th>
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
				$tsSendDate = "-";
			}

			$tsReqDate = date('Y-M-d',strtotime($tsReqDate));

			$dateDetail = "Request Date: $tsReqDate <br>Deliver Date: $tsSendDate <br>Receiver: $tsReceiver";

			echo "<tr>
					<td>$no";
					if($_SESSION['deptnamets'] == "EA" && $tsSendStatus == 0){
					echo "	<i class='link green large edit icon' onclick='editSend(&quot;$tsid&quot;);'></i>";
				}
			echo "</td>
					<td><a href='datats.php?search=$tsNo' target='_blank'>$tsNo</a></td>";
			
			// If there is newer rev
			if($tsSendStatus == 0){
				echo "<td class='datapopup' id='notsendts' data-html='$dateDetail' data-position='left center'>$tsRev</td>";
			}else if($tsRev < $tsLatestRev || $tsRev != $tsLatestRev){
				echo "<td class='datapopup' id='existedts' data-html='$dateDetail' data-position='left center'>$tsRev</td>";
			}else {
				echo "<td class='datapopup' data-html='$dateDetail' data-position='left center'>$tsRev</td>";
			}
				
				echo "<td data-tooltip='$tsLatestDate' data-position='right center'>$tsLatestRev</td>";
				echo "<td>$tsModel</td>";
				echo "<td>$tsPart</td>";				
				echo "</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td class='center aligned' colspan=3>0 result :(</td>
			</tr>";
	}
	echo "</table></div>";

	echo "<script>
		$(document).ready(function() {
			$('.datapopup').popup();
		});
	</script>"
?>