<html>
	<?php include "../header.php";
	include "../function.php"; ?>
	<div class="ui container">
		<h1 class='ui center aligned header' id='titleheader2'>MANUAL COVER LETTER CREATOR</h1>
		<div class="ui divider"></div>
		<div class='ui grid'>
			<div class='two column row'>
				<div class='column'>
					<form class='ui form'>
						<div class="field">
							<label>Supplier name</label>
							<input type="text" name="suppname" id="inputsupp" list="suppsuggestion" autofocus required>
							<datalist id="suppsuggestion"><?php include "../request/requestsuggestion.php";?></datalist>
						</div>
						<div class='two fields'>
							<div class='field'>
								<label>PIC Division</label>
								<input type='text' name='div' id='inputdiv'>
							</div>
							<div class="field">
								<label>PIC name</label>
								<input type="text" name="supppic" id="inputpic">
							</div>							
						</div>

						<table class='ui center aligned sortable table' id='newrow'>
							<thead><tr>
								<th id='tableheader'>TS Number</th>
								<th id='tableheader'>Revision</th>
								<th id='tableheader'>Model</th>
								<th id='tableheader'>Part No.</th>
							</tr></thead>
							<tr>
								<td><input type='text' name='tsno' value='' id='inputts' class='inputtable' onkeydown='upperCaseF(this)' list='tsno'></td>
								<td><input type='text' name='rev' value='' id='inputrev' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
								<td><input type='text' name='model' value='' id='inputmodel' class='center aligned inputtable'></td>
								<td><input type='text' name='part' value='' id='inputpart' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
							</tr>

							<tr id='emptyrow' style='display:none;'>
								<td><input type='text' name='tsno' value='' id='inputts' class='inputtable' onkeydown='upperCaseF(this)' list='tsno'></td>
								<td><input type='text' name='rev' value='' id='inputrev' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
								<td><input type='text' name='model' value='' id='inputmodel' class='center aligned inputtable'></td>
								<td><input type='text' name='part' value='' id='inputpart' class='center aligned inputtable' onkeydown='upperCaseF(this)'></td>
							</tr>
						</table>
						<div class='field'>	
							<div tabindex='0' class='ui fluid vertical basic animated button' onclick='addNewRow()'>
							  	<div class='visible content'><i class='plus icon'></i></div>
							  	<div class='hidden content'>Add new row</div>
						 	</div>
						 </div>

						<div class='field'>
							<label>Date</label>
							<div class="ui calendar calendarinput">						
								<div class="ui input left icon">
									<i class="calendar icon"></i>
									<input type='text' name='reqdate' id='reqdate' placeholder='date' value="<?php echo date('Y-M-d'); ?>">
								</div>
							</div>
						</div>	

						<div class='field'>	
							<button class='ui red inverted button' id='coverlettercreatebutton'>Create</button>
						</div>
					</form>
				</div>

				<div class='column'>
					<div id='manualconvert'></div>
				</div>
			</div>
		</div>
		
	</div>

	<datalist id='tsno'><?php include "../update/tssuggestion.php"; ?></datalist>
</body>
</html>