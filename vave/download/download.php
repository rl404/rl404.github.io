<html>
	<?php include "../header.php"; ?>

	<div class="ui container">
		<h1 class='ui center aligned header' id='titleheader1'>
			Download
		</h1>

		<div class='ui segment'>
			<form class='ui form' method='POST' action='downloadexport.php' id='exportform'>
				<div class='three fields'>
					<div class='field'>
						<label>Model</label>
						<select name='model' id='model'>";
							<?php include 'modelsuggestion.php'; ?>
						</select>
					</div>
					<div class='field'>
						<label>Month</label>
						<select name="month" id='downloadmonth'>
							<option value="all">All Month</option>
							<?php
								for($i=1;$i<13;$i++){
									$reqMonth = date("F",mktime(0,0,0,$i,1,2011));
									echo "<option value='$i'>$reqMonth</option>";									
								}
							?>
						</select>
					</div>
					<div class='field'>
						<label>Year</label>
						<?php
							echo "<input type='text' name='year' id='downloadyear' value='";
							echo date('Y');
							echo "'>";
						?>
					</div>
					<div class='field'>
						<label>.</label>
						<button class='ui green fluid inverted button' onclick="submitForm('exportform');"><i class='file excel outline icon'></i>Download</button>
					</div>
				</div>
			</form>
		</div>

		<div id='downloadcontent'>
			<?php include "downloadview.php" ?>
		</div>

	</div>
</body>
</html>