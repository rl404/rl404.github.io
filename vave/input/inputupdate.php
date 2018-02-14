<?php
	
	session_start();

	// Connect to db
	include "../db.php";
		
	if(empty($_POST['ideatype2'])){
		$_POST['ideatype2'] = "";
	}

	if($_POST['step'] == 2){

		if(is_uploaded_file($_FILES["scanold"]["tmp_name"][0])){
			
			for($i = 0; $i < count($_FILES["scanold"]["tmp_name"]); $i++){
				$target_dir = "../images/design/";
				$target_file = $target_dir . $_POST['vaveid']."old$i.PNG";

				if (move_uploaded_file($_FILES["scanold"]["tmp_name"][$i], $target_file)) {
					imagepng(imagecreatefromstring(file_get_contents($target_file)), $target_file);
			    } else {
			       	echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=3'; </script>";
			    }
			}
		}

		if(is_uploaded_file($_FILES["scannew"]["tmp_name"][0])){
			
			for($i = 0; $i < count($_FILES["scannew"]["tmp_name"]); $i++){
				$target_dir = "../images/design/";
				$target_file = $target_dir . $_POST['vaveid']."new$i.PNG";

				if (move_uploaded_file($_FILES["scannew"]["tmp_name"][$i], $target_file)) {
					imagepng(imagecreatefromstring(file_get_contents($target_file)), $target_file);
			    } else {
			       	echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=3'; </script>";
			    }
			}
		}

		$_POST['model'] = str_replace(' ', '', $_POST['model']);
		
		$today = date("Y-m-d");

		if(empty($_POST['proposerdate'])) $_POST['proposerdate'] = "0000-00-00";
		$proposerdate = date('Y-m-d',strtotime("$_POST[proposerdate]"));

		if(count($_POST['partno']) > 2){
			
			$partno = $_POST['partno'][0];
			$partname = $_POST['partname'][0];
			
			$updateSql = "UPDATE vave SET
						designer='$_POST[designer]',
						manufacturerNo='$_POST[manufacturerno]',
 						teardownNo='$_POST[teardownno]',
 						model='$_POST[model]',
 						piece='$_POST[piece]',
 						partNo='See Attachment',
 						partName='See Attachment',
 						ideaType='$_POST[ideatype]',
 						ideaType2='$_POST[ideatype2]',
 						ideaOld='$_POST[ideaold]',
 						ideaNew='$_POST[ideanew]',
 						photoNo='$_POST[photono]',
 						proposerName='$_POST[proposername]',
 						proposerDiv='$_POST[proposerdiv]',
 						proposerDate='$proposerdate'
 						WHERE id='$_POST[vaveid]'";

			if ($conn->query($updateSql) === TRUE) {
				
			// If error, back to tsauto with error message	
			}else{
				echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=0'; </script>";
				// echo "Error: " . $insertSql . "<br>" . $conn->error;
			}

			for($i = 0; $i < count($_POST['partno']); $i++){
				$partid = $_POST['partid'][$i];
				$partno = $_POST['partno'][$i];
				$partname = $_POST['partname'][$i];

				if($partid != "-1"){
					if(empty($partno) && empty($partname)){
						$deleteSql = "DELETE FROM attachment where id='$partid'";

						if ($conn->query($deleteSql) === TRUE) {
							
						// If error, back to tsauto with error message	
						}else{
							echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=0'; </script>";
							// echo "Error: " . $ideleteSql . "<br>" . $conn->error;
						}

					}else{
						$updateSql = "UPDATE attachment SET
									partNo='$partno',
									partName='$partname'
									where id='$partid'";

						// If success, back to tsauto with success message
						if ($conn->query($updateSql) === TRUE) {
							
						// If error, back to tsauto with error message	
						}else{
							echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=0'; </script>";
							// echo "Error: " . $insertSql . "<br>" . $conn->error;
						}	
					}	
				}else{
					if(!empty($partno)){
						$insertSql = "INSERT INTO attachment (proposerId,teardownNo,manufacturerNo,partNo,partName)
								VALUES ('$_POST[vaveid]', '$_POST[teardownno]','$_POST[manufacturerno]','$partno','$partname')";
											
						// If success, back to tsauto with success message
						if ($conn->query($insertSql) === TRUE) {					

						// If error, back to tsauto with error message	
						}else{
							echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=0'; </script>";
							// echo "Error: " . $insertSql . "<br>" . $conn->error;
						}
					}	
				}	
			}
		}else{
			$partno = $_POST['partno'][0];
			$partname = $_POST['partname'][0];

			$updateSql = "UPDATE vave SET
						designer='$_POST[designer]',
						manufacturerNo='$_POST[manufacturerno]',
 						teardownNo='$_POST[teardownno]',
 						model='$_POST[model]',
 						piece='$_POST[piece]',
 						partNo='$partno',
 						partName='$partname',
 						ideaType='$_POST[ideatype]',
 						ideaType2='$_POST[ideatype2]',
 						ideaOld='$_POST[ideaold]',
 						ideaNew='$_POST[ideanew]',
 						photoNo='$_POST[photono]',
 						proposerName='$_POST[proposername]',
 						proposerDiv='$_POST[proposerdiv]',
 						proposerDate='$proposerdate'
 						WHERE id='$_POST[vaveid]'";

	 		// If success, back to tsauto with success message
			if ($conn->query($updateSql) === TRUE) {
				
			// If error, back to tsauto with error message	
			}else{
				echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=0'; </script>";
				// echo "Error: " . $insertSql . "<br>" . $conn->error;
			}
		}

		$updateSql = "UPDATE vave SET
 						proposalRank='$_POST[proposalrank]',
 						pic='$_POST[pic]',
 						result='$_POST[result]',
 						rejection='$_POST[rejection]',
 						date1='$today',
 						uploader1='$_SESSION[usernameva]'
 						WHERE id='$_POST[vaveid]'";

 		// If success, back to tsauto with success message
		if ($conn->query($updateSql) === TRUE) {
			
		// If error, back to tsauto with error message	
		}else{
			echo "<script type='text/javascript'> document.location = 'inputstep2.php?id=$_POST[vaveid]&ok=0'; </script>";
			// echo "Error: " . $insertSql . "<br>" . $conn->error;
		}

		echo "<script type='text/javascript'> document.location = 'inputresult.php?id=$_POST[vaveid]&ok=1'; </script>";
 	
	}

	if($_POST['step'] == 3){

		$today = date("Y-m-d");

		// Convert month to string
		$receivedfrompe = "";
		if(empty($_POST['pp1date'])){$receivedfrompe = "0000-00-00";
		}else{$receivedfrompe = date('Y-m-d',strtotime($_POST['pp1date']));}

		$sendtopud = "";
		if(empty($_POST['pp2date'])){$sendtopud = "0000-00-00";
		}else{$sendtopud = date('Y-m-d',strtotime($_POST['pp2date']));}

		$repliedfrompud = "";
		if(empty($_POST['pp3date'])){$repliedfrompud = "0000-00-00";
		}else{$repliedfrompud = date('Y-m-d',strtotime($_POST['pp3date']));}

		$sendtoea = "";
		if(empty($_POST['pp4date'])){$sendtoea = "0000-00-00";
		}else{$sendtoea = date('Y-m-d',strtotime($_POST['pp4date']));}

		$updateSql = "UPDATE vave SET 
 					status='$_POST[status]',
					receivedFromPE='$receivedfrompe',
					sendToPuD='$sendtopud',
					repliedFromPuD='$repliedfrompud',
					sendToEA='$sendtoea',
					costReduction='$_POST[costreduction]',
					costPerPc='$_POST[costperpc]',
					piece='$_POST[piece]',
					costImpact='$_POST[costimpact]',
					date2='$today',
					uploader2='$_SESSION[usernameva]'
					where id='$_POST[vaveid]'";

		// If success, back to tsauto with success message
		if ($conn->query($updateSql) === TRUE) {
			echo "<script type='text/javascript'> document.location = 'inputresult.php?id=$_POST[vaveid]&ok=1'; </script>";

		// If error, back to tsauto with error message	
		}else{
			echo "<script type='text/javascript'> document.location = 'inputstep3.php?id=$_POST[vaveid]&ok=0'; </script>";
			// echo "Error: " . $insertSql . "<br>" . $conn->error;
		}
	}

	if($_POST['step'] == 4){

		$today = date("Y-m-d");

		$updateSql = "UPDATE vave SET 
					costReduction='$_POST[costreduction]',
					costPerPc='$_POST[costperpc]',
					piece='$_POST[piece]',
					costImpact='$_POST[costimpact]',
					datePuD='$today',
					uploaderPuD='$_SESSION[usernameva]'
					where id='$_POST[vaveid]'";

		// If success, back to tsauto with success message
		if ($conn->query($updateSql) === TRUE) {
			echo "<script type='text/javascript'> document.location = 'inputresult.php?id=$_POST[vaveid]&ok=1'; </script>";

		// If error, back to tsauto with error message	
		}else{
			// echo "<script type='text/javascript'> document.location = 'inputstep4.php?id=$_POST[vaveid]&ok=0'; </script>";
			echo "Error: " . $insertSql . "<br>" . $conn->error;
		}
	}

	if($_POST['step'] == 5){

		$result = mysqli_query($conn,"SELECT * FROM vave WHERE id='$_POST[vaveid]'");
		$row = mysqli_fetch_array($result);

		if(is_uploaded_file($_FILES["scanfile"]["tmp_name"])){
			$temp = explode(".", $_FILES["scanfile"]["name"]);

			$target_dir = "../images/proposal/";
			$target_file = $target_dir . $row['manufacturerNo'].".PDF";
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

			if (move_uploaded_file($_FILES["scanfile"]["tmp_name"], $target_file)) {
		    } else {
		       	echo "<script type='text/javascript'> document.location = 'inputstep5.php?id=$_POST[vaveid]&ok=3'; </script>";
		    }
		}

		$today = date("Y-m-d");

		$repliedfromtmc = "";
		if(empty($_POST['tmcdate'])){$repliedfromtmc = "0000-00-00";
		}else{$repliedfromtmc = date('Y-m-d',strtotime($_POST['tmcdate']));}

		$uploadtotmc = "";
		if(empty($_POST['totmcdate'])){$uploadtotmc = "0000-00-00";
		}else{$uploadtotmc = date('Y-m-d',strtotime($_POST['totmcdate']));}

		$ecidate = "";
		if(empty($_POST['ecidate'])){$ecidate = "0000-00-00";
		}else{$ecidate = date('Y-m-d',strtotime($_POST['ecidate']));}

		$updateSql = "UPDATE vave SET
					statusTMC='$_POST[statustmc]',
					repliedFromTMC='$repliedfromtmc',
					ECINo='$_POST[ecino]',
					ECIDate='$ecidate',
					uploadToTMC='$uploadtotmc',
					date3='$today',
					uploader3='$_SESSION[usernameva]'
					WHERE id='$vaveid'";

		// If success, back to tsauto with success message
		if ($conn->query($updateSql) === TRUE) {
			echo "<script type='text/javascript'> document.location = 'inputresult.php?id=$_POST[vaveid]&ok=1'; </script>";

		// If error, back to tsauto with error message	
		}else{
			echo "<script type='text/javascript'> document.location = 'inputstep5.php?id=$_POST[vaveid]&ok=0'; </script>";
			// echo "Error: " . $insertSql . "<br>" . $conn->error;
		}
	}

?>