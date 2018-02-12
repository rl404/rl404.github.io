<html>
	<?php include "../header.php" ?>
	<div class="ui container">
		
	<?php 
		// Show supplier list
		if(empty($_POST['supplier'])){
			include "export1search.php";

		// Show selected request detail
		}else{
			include "export2convert.php";
		} 
	?>
	
	</div>
</body>
</html>