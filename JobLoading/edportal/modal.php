<?php

	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$docid = "";
	$docname = "";
	$docdesc = "";

	$selectSql = "SELECT * from edportal where id='$_POST[docid]'";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		$docid = $row['id'];
		$docname = $row['docName'];
		$docdesc = $row['docDesc'];
	}

	echo "
		<div class='column'>
			<img class='ui centered image' id='output' alt='No uploaded image' src='cover/$docname.png'>
		</div>
		<div class='column'>
			<form class='ui form' action='materialupdate.php' method='post' id='newmaterialform' enctype='multipart/form-data'>
				<input type='hidden' name='docid' value='$docid'>
				<input type='hidden' name='olddocname' value='$docname'>
				<div class='required field'>
					<label>Title</label>
					<input type='text' name='docname' value='$docname' required>
				</div>
				<div class='field'>
					<label>Description</label>
					<textarea name='docdesc'>$docdesc</textarea>
				</div>
				<div class='two fields'>
					<div class='field'>
						<label>Upload Cover Image</label>
						<input type='file' accept='image/*' onchange='loadFile(event)' name='coverimage'>	
					</div>
					<div class='required field'>
						<label>Upload PDF Material</label>
						<input type='file' accept='application/pdf' name='materialpdf' required>	
					</div>
				</div>
			</form>
		</div>";


?>