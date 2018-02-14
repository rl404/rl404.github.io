<html><body onload="document.peform.submit()">
	<!-- onload="document.peform.submit()" -->
<?php
	include "../db.php";

	$result = mysqli_query($conn,"SELECT * FROM vave WHERE id='$_GET[vaveid]'");
	$row = mysqli_fetch_array($result);

	echo "
		<form action='index.php' method='post' name='peform'>
			<input type='hidden' name='designer' value='$row[designer]'>
			<input type='hidden' name='manufacturerno' value='$row[manufacturerNo]'>
			<input type='hidden' name='teardownno' value='$row[teardownNo]'>
			<input type='hidden' name='piece' value='$row[piece]'>";

			$selectSql2 = "SELECT * FROM attachment where proposerId='$_GET[vaveid]'";
			$selectResult2 = $conn->query($selectSql2);
			
			if($selectResult2->num_rows > 1){

				echo "<input type='hidden' name='partno[]' value='See Attachment'>
					<input type='hidden' name='partname[]' value='See Attachment'>";

				while($row2 = mysqli_fetch_assoc($selectResult2)) {
					echo "<input type='hidden' name='partno[]' value='$row2[partNo]'>
						<input type='hidden' name='partname[]' value='$row2[partName]'>";
				}
			}else{
				echo "<input type='hidden' name='partno[]' value='$row[partNo]'>
					<input type='hidden' name='partname[]' value='$row[partName]'>";
			}
			
	echo "	<input type='hidden' name='vaveid' value='$row[id]'>
			<input type='hidden' name='model' value='$row[model]'>
			<input type='hidden' name='ideaold' value='$row[ideaOld]'>
			<input type='hidden' name='ideanew' value='$row[ideaNew]'>
			<input type='hidden' name='proposerdiv' value='$row[proposerDiv]'>
			<input type='hidden' name='proposername' value='$row[proposerName]'>
			<input type='hidden' name='proposerdate' value='$row[proposerDate]'>
			<input type='hidden' name='date1' value='$row[date1]'>
		</form>
	";
?>
</body></html>