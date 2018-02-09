<html>
	<?php include "../header.php" ?>
	<div class="ui container" id='homepage'>

		<h1 class='ui center aligned dividing header' id='titleheader'>Report By Project</h1>

		<?php
		echo "<form class='ui form' action='projectdownload.php' method='post'>		
				<div class='inline fields'>
					<div class='field'>
						<input type='text' id='projectname' name='project' list='projectlist' placeholder='Project Code...'>
					</div>
					<div class='field'>
						<select name='month' id='projectmonth'>";
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
						<input id='projectyear' type='text' name='year' size=5 value='";
		echo 			date('Y');
		echo 			"'>
					</div>
					<div class='field'>
						<img class='ui centered mini image' src='../images/loading.gif' id='ajaxloading' style='display:none;'>
					</div>";
				if($_SESSION['deptname'] == "EA"){
					echo "<div class='field'>
						<button class='ui inverted green labeled icon button' type='submit'>
							<i class='link file excel outline icon'></i>
							Download
						</button>
					</div>";
				}				
		echo "	</div>
			</form>";

		?>
		<div id='reportprojecttable'><?php include 'projecttable.php'; ?></div>
		<div class='ui divider'></div>
	</div>
	<datalist id='projectlist'><?php include 'projectsuggestion.php'; ?></datalist>
</body>
</html>