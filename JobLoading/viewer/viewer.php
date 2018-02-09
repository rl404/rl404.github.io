<html>
	<?php include "../header.php"; ?>
	<div class="ui container">
		<h1 class='ui center aligned dividing header' id='titleheader'>
			<div data-tooltip="You can see the other member with the same position or lower in your deparment only." data-position="bottom center">
				Viewer <?php echo $_SESSION['deptname']; ?> Department	
			</div>
		</h1>
	
		<div id='worklisttable'><?php include 'worklist.php'; ?></div>
		<div id='downloadviewer'></div>
		<div class='ui divider'></div>
	</div>
</body>
</html>