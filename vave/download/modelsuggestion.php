<?php
	include "../db.php";

	$selectSql = "SELECT distinct model FROM vave";

	$selectResult = $conn->query($selectSql);

	echo "<option value='all'>All Model</option>";
	while($row = mysqli_fetch_assoc($selectResult)) {
		echo "<option value='$row[model]'>$row[model]</option>";
	}

?>