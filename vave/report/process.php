<html>
	<?php include "../header.php" ?>
	<div class="ui container">
		<h1 class='ui center aligned dividing header' id='titleheader'>Process Report</h1>

		<?php
		echo "<form class='ui form'>		
				<div class='inline fields'>	
					<div class='field'>
						<input type='text' name='model' id='processmodel' size='5' placeholder='Model' onkeydown='upperCaseF(this);'>
					</div>			
					<div class='field'>
						<select class='ui search dropdown' name='month' id='processmonth'>
						<option value='all'>All Month</option>";
						for($i=1;$i<13;$i++){
							$reqMonth = date("F",mktime(0,0,0,$i,1,2011));
							if($i==date('m')){
								echo "<option value='$i' selected>$reqMonth</option>";
							}else{
								echo "<option value='$i'>$reqMonth</option>";
							}
						}
		echo "			</select>
					</div>
					<label>-</label>
					<div class='field'>
						<input id='processyear' type='text' name='year' size=5 value='";
		echo 			date('Y');
		echo 			"'>
					</div>
					<div class='field'>
						<img class='ui centered mini image' src='../images/loading.gif' id='ajaxloading' style='display:none;'>
					</div>
				</div>
			</form>";

		?>
	<div id='reportprocesstable'><?php include 'processtable.php'; ?></div>
	<div class='ui divider'></div>
	</div>
</body>
</html>