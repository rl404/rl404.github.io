<?php 

	$imageurl = explode("/",$_POST['image']);

	$deleteurl = "../images/design/".$imageurl[count($imageurl)-1];

	unlink($deleteurl);
?>