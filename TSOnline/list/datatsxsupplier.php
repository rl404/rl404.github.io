<?php
	// To put page content to excel file
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$_POST[tsno].xls");

	// Connect to db
	include "../db.php";	

	// Select query from the selected ts number
	$selectSql = "SELECT * FROM ts WHERE tsNo='$_POST[tsno]' order by suppName asc,reqId desc";

	// Convert month to string
	$_POST['issuedate'] = strtotime( $_POST['issuedate'] );
	$_POST['issuedate'] = date( 'd-M-Y', $_POST['issuedate'] );

	// TS number info
	echo "TS Number: <b>$_POST[tsno]</b><br>";
	echo "Revision: <b>$_POST[tsrev]</b><br>";
	echo "Content: <b>$_POST[content]</b><br>";
	echo "Issue Date: <b>$_POST[issuedate]</b><br>";
	echo "Supplier Information List:<br><br>";

	// Supplier data table list
	echo "<table border=1>
			<tr style='text-align:center;'>
				<td><b>No<b></td>
				<td><b>Supplier Name<b></td>
				<td><b>Owned Rev.<b></td>
				<td><b>Model<b></td>
				<td><b>Part Number<b></td>
				<td><b>Request Date<b></td>
				<td><b>PIC<b></td>
			</tr>";


	$supplier = array();
	$supplierCurrent = "";
	$supplierIndex=0;
	$no = 1;

	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		while($row = mysqli_fetch_assoc($selectResult)) {

			// Get distinct supplier name
			if($row['suppName'] != $supplierCurrent){
				$supplierCurrent = $row['suppName'];

				// Convert month to string
				$row['reqDate'] = strtotime( $row['reqDate'] );
				$row['reqDate'] = date( 'Y-M-d', $row['reqDate'] );

				echo"<tr>
						<td style='text-align:center;'>$no</td>
						<td>$row[suppName]</td>
						<td style='text-align:center;'>$row[rev]</td>
						<td style='text-align:center;'>$row[model]</td>
						<td style='text-align:center;'>$row[partNo]</td>
						<td>$row[reqDate]</td>
						<td>$row[pic]</td>
					</tr>";

				$no++;
			}
		}

	// If no supplier
	}else{
		echo "<tr><td colspan=7 style='text-align:center;'>Not Found</td></tr>";
	}

	echo "</table><br>
	<i>*Please deliver the latest revision to the suppliers who still don't have it.</i>";
?>