<?php
	include "../db.php";

	$manufacturerno = '';
	$teardownno = '';

	$selectSql = "SELECT * FROM vave WHERE id=$_POST[vaveid]";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		$manufacturerno = $row['manufacturerNo'];
		$teardownno = $row['teardownNo'];
	}

	echo "<h3 class='ui header' id='titleheader3'>Manufacturer No : <span style='color:white;'>".$manufacturerno."</span><br>";
	echo "Proposer No : <span style='color:white;'>".$teardownno."</span></div>";

	echo "<form action='vavedelete2.php' method='post' id='deletevaveform'>	
			<input type='hidden' name='vaveid' value='$_POST[vaveid]'>
		</form>	";

?>