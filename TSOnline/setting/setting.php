<html>
	<?php 

	// Header
	include "../header.php";

	// Function
	include "../function.php";

	// Connect to db
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
 	if (mysqli_connect_errno()){
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Select logged in staff
	$selectSql = "SELECT * FROM staff WHERE id='$_SESSION[useridts]'";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		$noReg = $row['noReg'];
		$password = $row['password'];
		$staffName = $row['staffName'];
		$deptName = $row['deptName'];
		$deptCode = $row['deptCode'];
		$sectName = $row['sectName'];
		$jobTitle = $row['jobTitle'];
		$email = $row['email'];
		$notify = $row['notify'];
		break;
	}

	?>

	<div class="ui container" id="input1form">
		<?php
		if(notempty($_GET['ok'])){

			// If setting updated successfully
			if($_GET['ok'] == 1){
				echo "<div class='ui green message'>
			  		<i class='close icon'></i>
			  		<div class='header'>
			   			Updated successfully. 
			  		</div>
			  	</div>";

			// If something wrong
			}else{
			  	echo "<div class='ui red message'>
			  		<i class='close icon'></i>
			  		<div class='header'>
			   			Something wrong. 
			  		</div>
			  	</div>";
			}
		}
	  	?>

	<div class="ui segment">

		<!-- Title -->
		<h1 class="ui header" id='titleheader2'>Setting</h1>
		<form action="settingupdate.php" method="post" class="ui form">
			
			<div class="two fields">

				<!-- No reg -->
				<div class="required field">
					<label id='titleheader'>Registration Number</label>
					<input type="text" name="noreg" value='<?=$noReg?>' required>
				</div>		

				<!-- Password -->
				<div class="required field">
					<label id='titleheader'>Password</label>
					<input type="text" name="password" value='<?=$password?>' required>
				</div>		
			</div>	

			<!-- Name -->
			<div class="required field">
				<label id='titleheader'>Full Name</label>
				<input type="text" name="staffname" value='<?=$staffName?>' required>
			</div>

			<!-- Email -->
			<div class="field">
				<label id='titleheader'>Email</label>
				<input type="text" name="email" value='<?=$email?>'>
			</div>	

			<div class='fields'>
				
				<!-- Dept name -->
				<div class="thirteen wide field">
					<label id='titleheader'>Department Name</label>
					<input type="text" name="deptname" list='deptnamelist' value='<?=$deptName?>'>
					<datalist id='deptnamelist'><?php include 'deptnamesuggestion.php'; ?></datalist>
				</div>

				<!-- Dept code -->
				<div class="three wide field">
					<label id='titleheader'>Dept. Code</label>
					<input type="text" name="deptcode" list='deptlist' value='<?=$deptCode?>' onkeydown="upperCaseF(this)"/>
					<datalist id='deptlist'><?php include 'deptcodesuggestion.php'; ?></datalist>
				</div>
			</div>

			<!-- Sect name -->
			<div class="field">
				<label id='titleheader'>Section Name</label>
				<input type="text" name="sectname" list='sectlist' value='<?=$sectName?>'>
				<datalist id='sectlist'><?php include 'sectsuggestion.php'; ?></datalist>
			</div>

			<!-- Job title -->
			<div class="field">
				<label id='titleheader'>Job Title</label>
				<input type="text" name="jobtitle" list='titlelist' value='<?=$jobTitle?>'>
				<datalist id='titlelist'><?php include 'titlesuggestion.php'; ?></datalist>
			</div>

			<!-- Notification email -->
			<div class='field'>
				<div class="ui checkbox">						
			      	<input type="checkbox" name='notifyemail' value='1' <?php if($notify==1)echo "checked"; ?>>
			      	<label>Notified when there is new TS update.</label>
			    </div>
			</div>
			
			<!-- Submit button -->
			<button class="ui inverted red button" type="submit">Update</button>
		</form>	
	</div>
	</div>
	<div class="ui divider"></div>
</body>
</html>