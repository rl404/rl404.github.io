<html>
	<?php include "../header.php"; include "../function.php"; ?>

	<div class="ui container">
		<?php
			if(notempty($_GET['ok'])){
				if($_GET['ok'] == 1){
					echo "<div class='ui green message'>
				  		<i class='close icon'></i>
				  		<div class='header'>
				   			Delete successfully. 
				  		</div>
				  	</div>";
				}else{
				  	echo "<div class='ui red message'>
				  		<i class='close icon'></i>
				  		<div class='header'>
				   			Something wrong. 
				  		</div>
				  	</div>";
				}
			}
	  	?>
	<div class="ui secondary menu">
		<div class="item">		

<?php
	// Connect to db
	include "../db.php";
	echo "<h1 id='titleheader2'>VAVE List</h1>";

?>		
		</div>
	</div>

<?php

	// Select all proposal
	$selectSql = "SELECT * FROM vave order by id desc";

	// Select searched proposal
	if(!empty($_GET['search'])){
		$query = $_GET['search'];
		$selectSql = "SELECT * FROM vave where manufacturerNo like '%$query%' or teardownNo like '%$query%' or partNo like'$query%' order by id desc";
	}

	$selectResult = $conn->query($selectSql);

	// Table data
	if($selectResult->num_rows > 0){
		// echo "<table class='ui compact sortable selectable definition table'>
		echo "<table class='ui compact selectable celled table' id='3000list' cellspacing='0'>
			<thead><tr>
				<th id='tableheader' class='center aligned'>No</th>
				<th id='tableheader' class='center aligned'>Proposer No</th>	
				<th id='tableheader' class='center aligned'>Manufacturer No</th>				
				<th id='tableheader' class='center aligned'>Designer</th>					
				<th id='tableheader' class='center aligned'>Model</th>	
				<th id='tableheader' class='center aligned'>Part No</th>
				<th id='tableheader' class='center aligned'>Part Name</th>
				<th id='tableheader' class='center aligned'>Proposal</th>
				<th id='tableheader' class='center aligned'>Proposal2</th>
				<th id='tableheader' class='center aligned'>Cost Reduction / Vehicle (IDR)</th>
				<th id='tableheader' class='center aligned'>Proposer Date</th>
				<th id='tableheader' class='center aligned'>TMC Status</th>
			</tr></thead>";

		$currentManuc = '';
		$no = 1;		
		while($row = mysqli_fetch_assoc($selectResult)) {

			// Convert month to string
			if($row['proposerDate'] != "0000-00-00"){
				$row['proposerDate'] = date( 'Y-M-d', strtotime($row['proposerDate']) );
			}else{
				$row['proposerDate'] = "-";
			}

			if($row['receivedFromPE'] != "0000-00-00"){
				$row['receivedFromPE'] = date( 'Y-M-d', strtotime($row['receivedFromPE']) );
			}else{
				$row['receivedFromPE'] = "-";
			}

			if($row['sendToEA'] != "0000-00-00"){
				$row['sendToEA'] = date( 'Y-M-d', strtotime($row['sendToEA']) );
			}else{
				$row['sendToEA'] = "-";
			}

			if($row['repliedFromTMC'] != "0000-00-00"){
				$row['repliedFromTMC'] = date( 'Y-M-d', strtotime($row['repliedFromTMC']) );
			}else{
				$row['repliedFromTMC'] = "-";
			}


			$row['costReduction'] = number_format($row['costReduction'],2,'.',',');
			$row['costPerPc'] = number_format($row['costPerPc'],2,'.',',');
			$row['piece'] = number_format($row['piece'],0,'.',',');
			$row['costImpact'] = number_format($row['costImpact'],2,'.',',');
			
			$peResult = "";
			$ppResult = "";
			$pudResult = "";
			$eaResult = "";
			$tmcResult = "";

			if($row['result'] == "O"){$peResult = "<i class='green checkmark icon'></i>";
	  		}else if($row['result'] == "U"){$peResult = "<i class='yellow edit icon'></i>";	  			
	  		}else if($row['result'] == "D"){$peResult = "<i class='orange clone icon'></i>";	  			
	  		}else if($row['result'] == "X"){$peResult = "<i class='red remove icon'></i>";	  			
	  		}else{$peResult = "<i class='help icon'></i>";}

	  		if($row['status'] == "O"){$ppResult = "<i class='green checkmark icon'></i>";
	  		}else if($row['status'] == "U"){$ppResult = "<i class='yellow edit icon'></i>";  			
	  		}else if($row['status'] == "X"){$ppResult = "<i class='red remove icon'></i>";	  			
	  		}else{$ppResult = "<i class='help icon'></i>";}

	  		if($row['costReduction'] != "0"){$pudResult = "<i class='green checkmark icon'></i>"; 			
	  		}else{$pudResult = "<i class='help icon'></i>";}

	  		if($row['uploadToTMC'] != "0000-00-00"){$eaResult = "<i class='green checkmark icon'></i>"; 	
	  		}else{$eaResult = "<i class='help icon'></i>";}

	  		if($row['statusTMC'] == "O"){$tmcResult = "<i class='green checkmark icon'></i>";			
	  		}else if($row['statusTMC'] == "X"){$tmcResult = "<i class='red remove icon'></i>";	  			
	  		}else{$tmcResult = "<i class='help icon'></i>";}

			$allStatus = "Status:<br>
							<b>-PE</b>: $peResult<br>
							<b>-PPEQ</b>: $ppResult<br>
							<b>-PuD</b>: $pudResult<br>
							<b>-EA</b>: $eaResult<br>
							<b>-TMC</b>: $tmcResult";

			echo "<tr>";

			echo "	<td class='center aligned tooltip'><a href='../input/inputsearch.php?search=$row[id]' target='_blank'>$no.</a><span class='tooltiptext'>$allStatus</span>";

			if(!empty($row['manufacturerNo'])){
				$filename = "../images/proposal/$row[manufacturerNo].pdf";
				if (file_exists($filename)) {
					echo "	<a onclick='window.open(&quot;../images/proposal/$row[manufacturerNo].pdf&quot;, 
							&quot;newwindow&quot;, &quot;width=800,height=500&quot;);return false;'>	
						<i class='link red large file pdf outline icon' style='position:absolute;margin-left:-60px;margin-top:-20px;'></i></a>";
				}
			}

			echo "		</td>					
					<td class='center aligned tooltip'><a href='../input/inputsearch.php?search=$row[id]' target='_blank'>$row[teardownNo]"; if(!empty($row['manufacturerNo'])) echo "<span class='tooltiptext'>$row[manufacturerNo]</span>"; echo "</a></td>
					<td class='center aligned'>$row[manufacturerNo]</td>
					<td class='center aligned'>$row[designer]</td>
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

			if(!empty($row['ideaType2'])){
				$designDetail = "<b>Detail:</b><br>$row[ideaType2]<br><br>".$designDetail;
			}

			$costDetail = "<b>Cost Reduction / PC:</b> $row[costPerPc]<br>
							<b>Piece / Month:</b> $row[piece]<br>
							<b>Cost Impact / Year:</b> $row[costImpact]";
			
			// echo "	<td class='center aligned resultdetail' data-tooltip='$designDetail' data-position='right center'>$row[ideaType]<div </td>
			echo "
					<td class='center aligned tooltip'>$row[ideaType]<span class='tooltiptext'>$designDetail</span></td>
					<td>$row[ideaOld] $row[ideaNew]</td>
					<td class='right aligned tooltip'>$row[costReduction]<span class='tooltiptext'>$costDetail</span></td>
					<td class='center aligned tooltip'>$row[proposerDate]<span class='tooltiptext'>
						<b>Proposed Date:</b> $row[proposerDate]<br>
						<b>PPEQ Received Date:</b> $row[receivedFromPE]<br>
						<b>EA Received Date:</b> $row[sendToEA]<br>
						<b>TMC Replied Date:</b> $row[repliedFromTMC]<br>
						</span></td>
					<td class='center aligned tooltip'>$row[statusTMC]<span class='tooltiptext'>Date: $row[repliedFromTMC]";

					if(!empty($row['ECINo'])){
						$filename = "http://10.16.22.11/ECIPackage/$row[ECINo]/$row[ECINo].pdf";
						$AgetHeaders = @get_headers($filename);
						if (preg_match("|200|", $AgetHeaders[0])) {
							echo "<br><br>ECI No: $row[ECINo]<br>
								<a onclick='window.open(&quot;http://10.16.22.11/ECIPackage/$row[ECINo]/$row[ECINo].pdf&quot;, 
								&quot;newwindow&quot;, &quot;width=800,height=500&quot;);return false;'>	
								<i class='link green large file pdf outline icon'></i></a>";
						}
					}

			echo "</span>";

			if($_SESSION['deptva'] == "EA"){
				echo "<div class='vaveedit'>
					<i class='large link red remove icon' onclick='deletevave(&quot;$row[id]&quot;);' style='position:absolute;margin-left:50px;margin-top:-10px;z-index:10;'></i>
				</div>";
			}

			echo "</td>";
			echo "</tr>";
			$no++;	
			
		}		
		echo "</table>";

	// If no result
	}else{
		echo "<h3 class='ui header center aligned'>No result :(</h3>";
	}
?>
	</div>
	<div class="ui divider"></div>

	<div class="ui basic modal deletemodal">
	  	<div class="header" id='titleheader2'>Are you sure you want to delete this proposal?</div>
	  	<div class="content" id='deletevavecontent'></div>
	  	<div class="actions">		   
		    <div class="ui green button" onclick="submitForm('deletevaveform');">Yes</div>
		    <div class="ui red cancel button">No</div>
  		</div>
	</div>

	<script>
		var letter = {e: 69};
		var visible = false;

	 	$(document).ready(function() {
	        $("body").keydown(function(event) {
	            if(!visible && event.shiftKey && event.which === letter.e) {
		            visible = true;
		            $(".vaveedit").slideDown("fast");
		        } else if(visible && event.shiftKey && event.which === letter.e) {
		            visible = false;
		            $(".vaveedit").slideUp("fast");
		        }
	        });
	    });
	</script>
</body>
</html>