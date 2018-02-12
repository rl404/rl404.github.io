<?php
	/*

	Left side of convert page

	*/

	echo "
		<div class='ui two steps'>
		  <a class='completed step' href='export.php'>
		    <i class='search icon'></i>
		    <div class='content'>
		      <div class='title'>Search Request</div>
		    </div>
		  </a>
		  <div class='active step'>
		    <i class='file icon' id='titleheader2'></i>
		    <div class='content'>
		      <div class='title' id='titleheader2'>Convert to Cover Letter</div>
		    </div>
		  </div>
		</div>

		<div class='ui grid'>
			<div class='two column row'>
				<div class='column'>";
					
	include "../db.php";

	// Select selected request
	$selectSql = "SELECT * FROM ts WHERE suppName='$_POST[supplier]' and reqDate='$_POST[reqdate]' order by tsNo,rev+0 desc";

	// Get different ts + put into array
	$ts = array();
	$tsCurrent = "";
	$tsIndex = 0;

	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		if($row['tsNo'] != $tsCurrent){
			$tsCurrent = $row['tsNo'];
			$ts[$tsIndex][0] = $tsCurrent;
			$ts[$tsIndex][1] = $row['rev'];
			$ts[$tsIndex][2] = $row['model'];
			$ts[$tsIndex][3] = $row['partNo'];
			
			$tsIndex++;
		}
	}
	
	// Convert month to string
	$reqDate = strtotime( $_POST['reqdate'] );
	$reqDate = date( 'd-M-Y', $reqDate );

	echo "<h2 class='ui header' id='titleheader2'>
			PT. $_POST[supplier]
			<span id='titleheader1'>$reqDate</span>
			<input type='hidden' value='$_POST[supplier]' id='suppliername'>
			<input type='hidden' value='$_POST[reqdate]' id='reqdate'>
		</h2>";	

	// Editable table
	echo "<form class='ui form'>
		<div class='two fields'>
			<div class='field'>
				<label>PIC Division</label>
				<input type='text' name='suppdiv' id='inputdiv'>
			</div>
			<div class='field'>
				<label>PIC name</label>
				<input type='text' name='supppic' id='inputpic'>
			</div>
		</div>
		<div id='listxlist'>
		<table class='ui center aligned sortable table' id='newrow'>
			<thead><tr>
				<th id='tableheader'>TS Number</th>
				<th id='tableheader'>Revision</th>
				<th id='tableheader'>Model</th>
				<th id='tableheader'>Part No.</th>
			</tr></thead>";
			
	$no = 1;
	$selectResult = $conn->query($selectSql);
	if($selectResult->num_rows > 0){
		for($i = 0; $i < count($ts); $i++){
			$tsNo =  $ts[$i][0];
			$tsRev =  $ts[$i][1];
			$tsmodel = $ts[$i][2];
			$tspart = $ts[$i][3];

			echo "<tr>
					<td><input type='text' name='tsno' value='$tsNo' id='tsnoinput' class='inputtable' onkeydown='upperCaseF(this)' list='tsno'></td>
					<td><input type='text' name='rev' value='$tsRev' id='tsrevinput' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
					<td><input type='text' name='model' value='$tsmodel' id='modelinput' class='center aligned inputtable'></td>
					<td><input type='text' name='part' value='$tspart' id='partinput' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
				</tr>";
			$no++;
		}
	}else{
		echo "<tr>
				<td class='center aligned' colspan=3>0 result :(</td>
			</tr>";
	}

	echo "<tr id='emptyrow' style='display:none;'>
			<td><input type='text' name='tsno' value='' id='tsnoinput' class='inputtable' onkeydown='upperCaseF(this)' list='tsno'></td>
			<td><input type='text' name='rev' value='' id='tsrevinput' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
			<td><input type='text' name='model' value='-' id='modelinput' class='center aligned inputtable'></td>
			<td><input type='text' name='part' value='-' id='partinput' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
		</tr>";
	echo "</table>
		<div class='field'>	
			<div tabindex='0' class='ui fluid vertical basic animated button' onclick='addNewRow()'>
			  	<div class='visible content'><i class='plus icon'></i></div>
			  	<div class='hidden content'>Add new row</div>
		 	</div>
		 </div></div><br>
		<div class='field'>	
			<button class='ui red inverted button' id='coverletterconvertbutton'>Convert</button>
		</div>
	</form>

				</div>
				<div class='column'>
					<div id='requestconvert'></div>
				</div>
			</div>
		</div>
	<datalist id='tsno'>";
	include "../update/tssuggestion.php"; 
	echo "</datalist>";
?>