<?php
	
	session_start();

	// Connect to db
	include "../db.php";
	
	if(empty($_POST['ideatype2'])){
		$_POST['ideatype2'] = "";
	}
	
	$_POST['model'] = str_replace(' ', '', $_POST['model']);

	if(empty($_POST['vaveid'])){
		$today = date("Y-m-d");

		$proposerdate = date('Y-m-d',strtotime("$_POST[proposerdate]"));

		// $_POST['partno'] = array_filter($_POST['partno']);
		if(count($_POST['partno']) > 2){

			$partno = $_POST['partno'][0];
			$partname = $_POST['partname'][0];

			// Insert query
			$insertSql = "INSERT INTO vave (
						teardownNo,
						designer,		manufacturerNo,		
						partName,		partNo,				model,			
						ideaType,		ideaType2,			ideaOld,			ideaNew,		
						photoNo,		proposerName,		proposerDiv,
						proposerDate)

						VALUES (
						'$_POST[teardownno]',
						'$_POST[designer]',		'$_POST[manufacturerno]',	
						'See Attachment',		'See Attachment',			'$_POST[model]',	
						'$_POST[ideatype]',		'$_POST[ideatype2]',		'$_POST[ideaold]',			'$_POST[ideanew]',
						'$_POST[photono]',		'$_POST[proposername]',		'$_POST[proposerdiv]',
						'$proposerdate')";


			// If success, back to tsauto with success message
			if ($conn->query($insertSql) === TRUE) {					

			// If error, back to tsauto with error message	
			}else{
				echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
				// echo "Error: " . $insertSql . "<br>" . $conn->error;
			}

			$latestId = $conn->insert_id;

			for($i = 0; $i < count($_POST['partno']); $i++){
				$partno = $_POST['partno'][$i];
				$partname = $_POST['partname'][$i];						

				if(!empty($partno)){
					$insertSql = "INSERT INTO attachment (proposerId,teardownNo,manufacturerNo,partNo,partName)
							VALUES ('$latestId', '$_POST[teardownno]','$_POST[manufacturerno]','$partno','$partname')";
										
					// If success, back to tsauto with success message
					if ($conn->query($insertSql) === TRUE) {					

					// If error, back to tsauto with error message	
					}else{
						echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
						// echo "Error: " . $insertSql . "<br>" . $conn->error;
					}
				}				
			}
		}else{
			
			$partno = $_POST['partno'][0];
			$partname = $_POST['partname'][0];

			// Insert query
			$insertSql = "INSERT INTO vave (
						teardownNo,
						designer,		manufacturerNo,		
						partName,		partNo,				model,			
						ideaType,		ideaType2,			ideaOld,			ideaNew,		
						photoNo,		proposerName,		proposerDiv,
						proposerDate)

						VALUES (
						'$_POST[teardownno]',
						'$_POST[designer]',		'$_POST[manufacturerno]',	
						'$partname',			'$partno',					'$_POST[model]',	
						'$_POST[ideatype]',		'$_POST[ideatype2]',		'$_POST[ideaold]',			'$_POST[ideanew]',
						'$_POST[photono]',		'$_POST[proposername]',		'$_POST[proposerdiv]',
						'$proposerdate')";


			// If success, back to tsauto with success message
			if ($conn->query($insertSql) === TRUE) {					

			// If error, back to tsauto with error message	
			}else{
				echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
				// echo "Error: " . $insertSql . "<br>" . $conn->error;
			}										
		}

		echo "<script type='text/javascript'> document.location = 'inputproposal.php?ok=1'; </script>";	
	
	}else{
		$today = date("Y-m-d");

		$proposerdate = date('Y-m-d',strtotime("$_POST[proposerdate]"));

		if(count($_POST['partno']) > 2){
		
			$updateSql = "UPDATE vave SET
						designer='$_POST[designer]',
						manufacturerNo='$_POST[manufacturerno]',
 						teardownNo='$_POST[teardownno]',
 						model='$_POST[model]',
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
				echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
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
							echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
							// echo "Error: " . $deleteSql . "<br>" . $conn->error;
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
							echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
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
							echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
							// echo "Error: " . $insertSql . "<br>" . $conn->error;
						}
					}	
				}	
			}

			echo "<script type='text/javascript'> document.location = 'inputproposal.php?ok=2'; </script>";
		}else{
			$partno = $_POST['partno'][0];
			$partname = $_POST['partname'][0];

			$updateSql = "UPDATE vave SET
						designer='$_POST[designer]',
						manufacturerNo='$_POST[manufacturerno]',
 						teardownNo='$_POST[teardownno]',
 						model='$_POST[model]',
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
				echo "<script type='text/javascript'> document.location = 'inputproposal2.php?ok=0'; </script>";
				// echo "Error: " . $insertSql . "<br>" . $conn->error;
			}

			echo "<script type='text/javascript'> document.location = 'inputproposal.php?ok=2'; </script>";
		}
				
 	}
	
?>