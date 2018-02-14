<?php
	
	$csvData = file_get_contents("testvave.csv");
	$lines = explode(PHP_EOL, $csvData);
	$data = array();

	for($i = 3; $i < count($lines); $i++){

		$lines2 = str_getcsv($lines[$i], ",", '"');
		// $lines2 = explode(",", $lines[$i]);
		for($j = 0;$j<count($lines2);$j++){
			$data[$i][$j] = $lines2[$j];
			echo "'$lines2[$j]', ";
		}

		echo "<br>";
	}	


?>