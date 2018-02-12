<?php 
	// Connect to db
	include "../db.php";

	// Separate each line to different TS
	$separatedTSRev = array_filter(explode("*",$_POST['ts']));

	// Form 
	echo "<form action='tsautoupdate.php' method='post' class='ui form' id='tsautoupdate'>
		<input type='hidden' value='1' name='type'>";

	// Day input
	echo "<div class='inline fields'>
			<label>Issue Date:</label>
			
			<div class='ui calendar calendarinput'>						
				<div class='ui input left icon'>
					<i class='calendar icon'></i>
					<input type='text' name='reqdate' placeholder='date' value='". date('Y-M-d')."'>
				</div>
			</div>
				
		</div>";

	// Converted TS result table
	echo "<table class='ui celled table'>
			<thead><tr>
				<th class='center aligned' id='tableheader'>TS No</th>
				<th class='center aligned' id='tableheader'>Rev.</th>
				<th class='center aligned' id='tableheader'>Content</th>
			</tr></thead>";
			
	for($i=0;$i<count($separatedTSRev);$i++){

		// Remove the ･ symbol in front
		$editedTS1 = substr($separatedTSRev[$i], 3, strlen($separatedTSRev[$i]));

		// Separate into ts, rev, content
		$editedTS2 = explode("　",$editedTS1);

		// Separate Rev.x
		$editedRev = explode(".",$editedTS2[1]);

		// Check latest revision
		$selectSql = "SELECT * FROM ts_rev WHERE tsNo='$editedTS2[0]'";
		$selectResult = $conn->query($selectSql);

		$existts = false;
		$isoldrev = false;
		$latestrev = 0;

		$revcount = count($editedRev)-1;

		$highestRev = 0;
		$latestRev;

		if($selectResult->num_rows > 0){
			while($row = mysqli_fetch_assoc($selectResult)) {

				// If already in database
				if($row['rev'] == $editedTS2[1] || $row['rev'] == $editedRev[$revcount]){
					$existts = true;
				}
				
				// If already DISUSE
				if($row['rev'] == 'DISUSE'){
					$highestRev = 100;
					break;	
				}

				// If still EST
				if(preg_match('/EST/',$row['rev']) && $highestRev == 0){
					$highestRev = -100;
				}

				// If there is newer revision
				if(is_numeric($row['rev']) && $row['rev'] > $highestRev ){
					$highestRev = $row['rev'];
				}		
			}

		// If not in db
		}else{
			$highestRev = 0;
		}

		// If in db
		if($highestRev != 0){

			// If already DISUSE
			if($highestRev == 100){
				$latestRev = "DISUSE";

			// If still EST
			}else if($highestRev == -100){
				$latestRev = "EST.";

			// If not DISUSE or EST, get highest rev
			}else{
				$latestRev = $highestRev;
			}

		// If not in db
		}else{
			$latestRev = "No info";
		}

		echo "<tr>";
		
		// If already in db
		if($existts){
			echo "<td class='center aligned' id='existedts' colspan=3>Already in Database</td>";
		
		// If not
		}else{	
			echo "	<td><input type='text' name='tsno[]' value='$editedTS2[0]' class='center aligned' required></td>
					<td>";

			// If there is newer revision, color the text red
			if((preg_match('/EST/',$editedRev[0]) && $highestRev > 0)
			|| (is_numeric($editedRev[1]) && $editedRev[1] < $highestRev)){
				echo "<div data-tooltip='Newer revision found. (Rev.$latestRev)' data-position='right center'>
					<input type='text' name='rev[]' value='$editedRev[$revcount]' class='center aligned' id='existedts' required></div>";
			
			// If already latest
			}else{
				echo "<input type='text' name='rev[]' value='$editedRev[$revcount]' class='center aligned' required>";
			}

			echo "	</td>
					<td><textarea name='content[]' rows=2>$editedTS2[2]</textarea></td>";
		}
		
		echo "</tr>";
	}
echo "</table>
	<button class='ui red inverted button' type='submit' form='tsautoupdate'>Submit</button>
	</form>

	<script>
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
?>