<?php
$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
if (mysqli_connect_errno()){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$docname = "";

$selectSql = "SELECT * from edportal where id='$_POST[docid]'";
$selectResult = $conn->query($selectSql);
while($row = mysqli_fetch_assoc($selectResult)) {
	$docname = $row['docName'];
}

echo "
	<form class='ui form' action='deleteupdate.php' method='post' id='deletematerialform'> 
		<input type='hidden' name='docid' value='$_POST[docid]'>
		<input type='hidden' name='docname' value='$docname'>
	</form>";
?>