<?php
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

	echo "
		<table class='ui very compact sortable selectable definition table'>
			<thead class='full-width'><tr>
				<th id='tableheader' class='center aligned'>No</th>
				<th id='tableheader' class='center aligned'>Manuc No</th>
				<th id='tableheader' class='center aligned'>TD No</th>
				<th id='tableheader' class='center aligned'>Model</th>
				<th id='tableheader' class='center aligned'>Part No</th>
				<th id='tableheader' class='center aligned'>Part Name</th>
				<th id='tableheader' class='center aligned'>Proposal</th>
				<th id='tableheader' class='center aligned'>Cost Reduction / Vehicle (IDR)</th>
				<th id='tableheader' class='center aligned'>Proposer Date</th>
			</tr></thead>";
	$no = 1;
	while($row = mysqli_fetch_assoc($selectResult)) {

		$row['proposerDate'] = strtotime( $row['proposerDate'] );
		$row['proposerDate'] = date( 'Y-M-d', $row['proposerDate'] );

		$row['costReduction'] = number_format($row['costReduction'],2,'.',',');

		echo "<tr>
			<td class='center aligned'>$no</td>
			<td class='center aligned'>$row[manufacturerNo]</td>
			<td class='center aligned'>$row[teardownNo]</td>
			<td class='center aligned'>$row[model]</td>";

			if($row['partNo'] == 'See Attachment'){
				echo "<td class='center aligned'>
						<a onclick='window.open(&quot;../list/attachment.php?header=no&search=$row[id]&quot;, 
							&quot;newwindow&quot;, &quot;width=800,height=500&quot;);return false;'>			
							$row[partNo]
						</a>
					</td>";
			}else{
				echo "<td class='center aligned'>$row[partNo]</td>";
			}

			if($row['partName'] == "See Attachment"){
				echo "<td class='center aligned'>
						<a onclick='window.open(&quot;../list/attachment.php?header=no&search=$row[id]&quot;, 
							&quot;newwindow&quot;, &quot;width=800,height=500&quot;);return false;'>			
							$row[partName]
						</a>
					</td>";
			}else{
				echo "<td class='left aligned'>$row[partName]</td>";
			}

			$designDetail = "<b>Old Design:</b><br>$row[ideaOld]<br><br><b>New Design:</b><br>$row[ideaNew]";					

		echo "
			<td class='center aligned tooltip'>$row[ideaType]<span class='tooltiptext'>$designDetail</span></td>
			<td class='right aligned'>$row[costReduction]</td>
			<td class='center aligned'>$row[proposerDate]</td>
		</tr>";

		$no++;
	}

	echo "</table>";

	echo "<script>
		$(document).ready(function() {
			$('.resultdetail').popup();
		});
	</script>"
?>