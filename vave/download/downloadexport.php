<?php
	// To put page content to excel file
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$_POST[model].xls");

	include "../db.php";

	$whereQuery = '';

	$whereModel = '';
	$whereMonth = '';
	$whereYear = '';

	if($_POST['model'] == "all" || empty($_POST['model'])){
		$whereModel = "";
	}else{
		$whereModel = "model='$_POST[model]' ";
	}

	if($_POST['month'] == "all" || empty($_POST['month'])){
		$whereMonth = "";
	}else{
		if($whereModel == ""){
			$whereMonth = "MONTH(proposerDate)='$_POST[month]' ";
		}else{
			$whereMonth = "AND MONTH(proposerDate)='$_POST[month]' ";
		}
	}

	if(empty($_POST['year'])){
		$whereYear = "";
	}else{
		if($whereModel == "" && $whereMonth == ""){
			$whereYear = "YEAR(proposerDate)='$_POST[year]' ";
		}else{
			$whereYear = "AND YEAR(proposerDate)='$_POST[year]' ";
		}
	}

	$whereQuery = $whereModel.$whereMonth.$whereYear;

	if($whereQuery != ""){
		$whereQuery = "WHERE ".$whereQuery;
	}

	$selectSql = "SELECT * FROM vave ".$whereQuery;

	$selectResult = $conn->query($selectSql);

	echo "Model: <b>$_POST[model]</b><br>
		Month: <b>$_POST[month]</b><br>
		Year: <b>$_POST[year]</b><br><br>";

	echo "<table border=1>
			<thead><tr>
				<th rowspan=2>No</th>
				<th colspan=15>PE</th>
				<th colspan=9>PPEQ + PuD</th>
				<th colspan=2>TMC</th>
				<th colspan=2>EA</th>
				<th colspan=5>Status</th>
			</tr></thead>
			<thead><tr>
				<th>Manuc No</th>
				<th>TD No</th>

				<th>Model</th>
				<th>Part No</th>
				<th>Part Name</th>

				<th>Old Design</th>
				<th>New Design</th>
				<th>Photo Number</th>

				<th>Proposer Name</th>
				<th>Proposer Div.</th>
				<th>Proposed Date</th>

				<th>Rank</th>
				<th>PIC</th>
				<th>Result</th>
				<th>Rejection</th>

				<th>Status</th>
				<th>Received from PE-ED</th>
				<th>Send to PuD</th>
				<th>Replied from PuD</th>
				<th>Send to EA-ED</th>

				<th>Cost Reduction / PC </th>
				<th>Cost Reduction / Vehicle (IDR)</th>
				<th>Piece / Month</th>
				<th>Cost Impact / Year (IDR)</th>

				<th>Status</th>
				<th>Date</th>

				<th>ECI Number</th>
				<th>ECI Date</th>

				<th>PE Process</th>
				<th>PP Process</th>
				<th>PuD Process</th>
				<th>EA Process</th>
				<th>TMC Approve</th>
			</tr></thead>";
	$no = 1;
	while($row = mysqli_fetch_assoc($selectResult)) {

		if($row['proposerDate'] == "0000-00-00"){
			$row['proposerDate'] = "-";
		}else{
			$row['proposerDate'] = strtotime( $row['proposerDate'] );
			$row['proposerDate'] = date( 'Y-M-d', $row['proposerDate'] );
		}

		if($row['receivedFromPE'] == "0000-00-00"){
			$row['receivedFromPE'] = "-";
		}else{
			$row['receivedFromPE'] = strtotime( $row['receivedFromPE'] );
			$row['receivedFromPE'] = date( 'Y-M-d', $row['receivedFromPE'] );
		}

		if($row['sendToPuD'] == "0000-00-00"){
			$row['sendToPuD'] = "-";
		}else{
			$row['sendToPuD'] = strtotime( $row['sendToPuD'] );
			$row['sendToPuD'] = date( 'Y-M-d', $row['sendToPuD'] );
		}

		if($row['repliedFromPuD'] == "0000-00-00"){
			$row['repliedFromPuD'] = "-";
		}else{
			$row['repliedFromPuD'] = strtotime( $row['repliedFromPuD'] );
			$row['repliedFromPuD'] = date( 'Y-M-d', $row['repliedFromPuD'] );
		}

		if($row['sendToEA'] == "0000-00-00"){
			$row['sendToEA'] = "-";
		}else{
			$row['sendToEA'] = strtotime( $row['sendToEA'] );
			$row['sendToEA'] = date( 'Y-M-d', $row['sendToEA'] );
		}

		if($row['repliedFromTMC'] == "0000-00-00"){
			$row['repliedFromTMC'] = "-";
		}else{
			$row['repliedFromTMC'] = strtotime( $row['repliedFromTMC'] );
			$row['repliedFromTMC'] = date( 'Y-M-d', $row['repliedFromTMC'] );
		}

		if($row['ECIDate'] == "0000-00-00"){
			$row['ECIDate'] = "-";
		}else{
			$row['ECIDate'] = strtotime( $row['ECIDate'] );
			$row['ECIDate'] = date( 'Y-M-d', $row['ECIDate'] );
		}

		$row['costReduction'] = number_format($row['costReduction'],2,'.',',');
		$row['costPerPc'] = number_format($row['costPerPc'],2,'.',',');
		$row['piece'] = number_format($row['piece'],0,'.',',');
		$row['costImpact'] = number_format($row['costImpact'],2,'.',',');

		echo "<tr>
			<td style='text-align:center;'>$no</td>
			<td style='text-align:center;'>$row[manufacturerNo]</td>
			<td style='text-align:center;'>$row[teardownNo]</td>
			<td style='text-align:center;'>$row[model]</td>
			<td style='text-align:center;'>$row[partNo]</td>
			<td>$row[partName]</td>

			<td>$row[ideaOld]</td>
			<td>$row[ideaNew]</td>
			<td style='text-align:center;'>$row[photoNo]</td>

			<td>$row[proposerName]</td>
			<td style='text-align:center;'>$row[proposerDiv]</td>
			<td style='text-align:center;'>$row[proposerDate]</td>

			<td style='text-align:center;'>$row[proposalRank]</td>
			<td style='text-align:center;'>$row[pic]</td>
			<td style='text-align:center;'>$row[result]</td>
			<td style='text-align:center;'>$row[rejection]</td>

			<td style='text-align:center;'>$row[status]</td>
			<td style='text-align:center;'>$row[receivedFromPE]</td>
			<td style='text-align:center;'>$row[sendToPuD]</td>
			<td style='text-align:center;'>$row[repliedFromPuD]</td>
			<td style='text-align:center;'>$row[sendToEA]</td>

			<td>$row[costPerPc]</td>
			<td>$row[costReduction]</td>
			<td>$row[piece]</td>
			<td>$row[costImpact]</td>

			<td style='text-align:center;'>$row[statusTMC]</td>
			<td style='text-align:center;'>$row[repliedFromTMC]</td>

			<td style='text-align:center;'>$row[ECINo]</td>
			<td style='text-align:center;'>$row[ECIDate]</td>";

			$pudStatus = "";
			if($row['costReduction'] != 0){
				$pudStatus = "O";
			}

			$eaStatus = "";
			if($row['uploadToTMC'] != "0000-00-00"){
				$eaStatus = "O";
			}

	echo "	<td style='text-align:center;'>$row[result]</td>
			<td style='text-align:center;'>$row[status]</td>
			<td style='text-align:center;'>$pudStatus</td>
			<td style='text-align:center;'>$eaStatus</td>
			<td style='text-align:center;'>$row[statusTMC]</td>
		</tr>";

		$no++;
	}

	echo "</table>";
?>