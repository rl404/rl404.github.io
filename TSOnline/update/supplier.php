<html>
	<?php include "../header.php";
	include "../function.php"; ?>
	<div class="ui container">
		<?php
			// If added successfully
			if(notempty($_GET['ok'])){
				if($_GET['ok'] == 1){
					echo "<div class='ui green message'>
				  		<i class='close icon'></i>
				  		<div class='header'>
				   			Added successfully. 
				  		</div>
				  	</div>";

				// If there is error
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

		<!-- Title -->
		<h1 class='ui center aligned header' id='titleheader2'>UPDATE PART NUMBER INFO</h1>
		<div class="ui divider"></div>
		<div class='ui very relaxed grid'>
			<div class='two column row'>
				<div class='column'>
					<h3 class='ui header'>Part No X TS No</h3>
					<!-- Form -->
					<form class='ui form' method='post' action='partnoupdate1.php' id='partnoform1'>
						
						<div class="field">
							<label>Part Number</label>
							<input type="text" name="partno" id="partno" form='partnoform1' onkeydown="upperCaseF(this)" required>
						</div>

						<!-- TS input table -->
						<div class="field">
							<table class='ui compact sortable selectable definition center aligned table' id='newrow'>
								
								<!-- Table header -->
								<thead class='full-width'><tr>
									<th class='center aligned' id='tableheader'>TS Number</th>
								</tr></thead>							
								
								<!-- Empty input -->
								<tr>
									<td><input class='inputtable' name='tsno[]' id='tsno' type='text' list="tsno" form='partnoform1' onkeydown="upperCaseF(this)" required></td>
									<datalist id="tsno"><?php include "tssuggestion.php"; ?></datalist>	
								</tr>	

								<!-- For cloning -->
								<tr id='emptyrow' style="display:none;">
									<td><input class='inputtable' name='tsno[]' id='tsno' type='text' list="tsno" form='partnoform1' onkeydown="upperCaseF(this)"></td>
									<datalist id="tsno"><?php include "tssuggestion.php"; ?></datalist>	
								</tr>						
							</table>		
						</div>

						<!-- Button to add new row -->
						<div class='field'>	<div tabindex="0" class="ui fluid vertical basic animated button" onclick="addNewRow()">
							  	<div class="visible content"><i class='plus icon'></i></div>
							  	<div class="hidden content">
							    	Add new row
							 	</div>
						 	</div>
						</div>
			
						<button type='submit' class='ui inverted red button' form='partnoform1'>Update</button>
					</form>					
				</div>

				<div class="ui vertical divider">or</div>


				<div class='column'>	
					<h3 class='ui header'>TS No X Part No</h3>			
					<!-- Form -->
					<form class='ui form' method='post' action='partnoupdate2.php' id='partnoform2'>
						
						<!-- Supplier name textbox + datalist -->
						<div class="field">
							<label>TS Number</label>
							<input type="text" name="tsno" id="tsno" form='partnoform2' list="tsno" onkeydown="upperCaseF(this)" required>
							<datalist id="tsno"><?php include "tssuggestion.php"; ?></datalist>	
						</div>

						<!-- TS input table -->
						<div class="field">
							<table class='ui compact sortable selectable definition center aligned table' id='newrow2'>
								
								<!-- Table header -->
								<thead class='full-width'><tr>
									<th class='center aligned' id='tableheader'>Part Number</th>
								</tr></thead>							
								
								<!-- Empty input -->
								<tr>
									<td><input class='inputtable' name='partno[]' id='partno' type='text' form='partnoform2' onkeydown="upperCaseF(this)" required></td>
								</tr>	

								<!-- For cloning -->
								<tr id='emptyrow2' style="display:none;">
									<td><input class='inputtable' name='partno[]' id='partno' type='text' form='partnoform2' onkeydown="upperCaseF(this)"></td>
								</tr>						
							</table>		
						</div>

						<!-- Button to add new row -->
						<div class='field'>	<div tabindex="0" class="ui fluid vertical basic animated button" onclick="addNewRow2()">
							  	<div class="visible content"><i class='plus icon'></i></div>
							  	<div class="hidden content">
							    	Add new row
							 	</div>
						 	</div>
						</div>
			
						<button type='submit' class='ui inverted red button' form='partnoform2'>Update</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</body>
</html>