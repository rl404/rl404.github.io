<?php
	include "../db.php";

	echo "<script>
			$(document).ready(function() {
				var calendarOpts = {
			      maxDate: new Date(),
			      type: 'date',
			      formatter: {
			         date: function (date, settings) {
			            if (!date) return '';
			            var day = date.getDate() + '';
			            if (day.length < 2) {
			               day = '0' + day;
			            }
			            var month = settings.text.monthsShort[date.getMonth()];
			            var year = date.getFullYear();
			            return year + '-' + month + '-' + day;
			         }
			      }
			   };

			   $('.calendarinput').calendar(calendarOpts);
			});
		</script>";

	$suppliername = '';
	$tsno = '';
	$rev = '';

	// echo $_POST['tsid'];

	$selectSql = "SELECT * FROM ts WHERE reqId='$_POST[tsid]'";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		$suppliername = $row['suppName'];
		$tsno = $row['tsNo'];
		$rev = $row['rev'];
	}

	echo "<form action='' method='post' class='ui form' id='editsendform'>
			<b>Supplier Name:</b> $suppliername<br>
			<input type='hidden' name='suppname' id='suppname' value='$suppliername'>
						
			<b>TS Number:</b> $tsno<br>
			<input type='hidden' name='tsno' value='$dtsno'>
			
			<b>Rev:</b> $rev
			<input type='hidden' name='rev' value='$rev'>

			<div class='field'>
				<label>Date</label>
				<div class='ui calendar calendarinput'>						
					<div class='ui input left icon'>
						<i class='calendar icon'></i>
						<input type='text' name='reqdate' id='reqdate' placeholder='date' value="; echo date('Y-M-d'); echo ">
					</div>
				</div>
			</div>	
			<div class='field'>
				<label>Receiver</label>
				<input type='text' name='receiver'>
			</div>
			
			<input type='hidden' name='tsid' value='$_POST[tsid]' id='tsid'>
		</form>";

		echo "<div id='hiddensend'></div>";

		


?>