<?php

	if(session_id() == '') {
	    session_start();
	}
	
	echo 
	"<head>
		<title>VAVE</title>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
		<link href='http://".$_SERVER['HTTP_HOST']."/VAVE/css/semantic.min.css' rel='stylesheet'>
		<link href='http://".$_SERVER['HTTP_HOST']."/VAVE/css/main.css' rel='stylesheet'>
		<link href='http://".$_SERVER['HTTP_HOST']."/VAVE/css/pagination.css' rel='stylesheet'>
		<link href='http://".$_SERVER['HTTP_HOST']."/VAVE/css/calendar.css' rel='stylesheet'>

		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/jquery.min.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/semantic.min.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/sortable.js'></script>

		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/pagination.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/pagination2.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/natural.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/calendar.js'></script>
		
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/main.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/loader.js'></script>

		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/fixedheader.js'></script>
		<script src='http://".$_SERVER['HTTP_HOST']."/VAVE/scripts/echarts/dist/echarts.min.js'></script>		
	</head>
	<body>";

	if(empty($_GET['header'])){
		echo "<div class='ui inverted menu' id='superheader'>
			<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/index.php' class='item'>
				Homepage
			</a>
			<div class='ui simple dropdown item'>
				Proposal Process
				<i class='dropdown icon'></i>
				<div class='menu'>
			 		<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/input/inputproposal.php' class='item'>New/Edit Idea</a>
			 		<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/input/input.php' class='item'>Process Proposal</a>
			 	</div>
			</div>
			<div class='ui simple dropdown item'>
				List
				<i class='dropdown icon'></i>
				<div class='menu'>
			 		<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/list/index.php' class='item'>Proposal Detail</a>
			 		<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/list/list.php' class='item'>Process</a>
			 	</div>
			</div>
			<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/download/download.php' class='item'>
				Download
			</a>
			<div class='ui simple dropdown item'>
				Report
				<i class='dropdown icon'></i>
				<div class='menu'>
			 		<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/report/cost.php' class='item'>Cost Reduction Report</a>
			 		<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/report/process.php' class='item'>Process Report</a>
			 	</div>
			</div>";

			// If logged in
			if(!empty($_SESSION['usernameva'])){
				echo "<div class='right menu'>
						<div class='header item'>Welcome, $_SESSION[usernameva]</div>
						<a href='http://".$_SERVER['HTTP_HOST']."/VAVE/logout.php' class='item'>Logout</a>
					</div>";
			
			// If not logged in, redirect to login page
			}else{
				echo "<script type='text/javascript'> 
						document.location = 'http://".$_SERVER['HTTP_HOST']."/VAVE/index.php?error=2'; 
					</script>";
				die();			
			}
			
		echo "</div>";
	}
?>