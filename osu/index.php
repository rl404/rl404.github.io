<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/index.css">
	</head>
	<body>
		<?php
			$json_str = file_get_contents("osu.ppy.sh/api/get_user?k=270c5c3195f243df0696fde15864b12f56db030e&u=50265");
			$parsed_json = json_decode($json_str);
			echo $parsed_json;
		?>
	</body>
</html>
