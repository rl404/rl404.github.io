<?php
	$conn = mysqli_connect("localhost","jobloading_admin","toyota123","job_loading");

	// Check connection
	if (mysqli_connect_errno()){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	// Select all subcribed user
	$allEmail = array();
	$emailIndex = 0;

	$selectSql = "SELECT * FROM staff WHERE notify='1'";
	// $selectSql = "SELECT * FROM staff WHERE noReg='Admin'";
	$selectResult = $conn->query($selectSql);
	while($row = mysqli_fetch_assoc($selectResult)) {
		$allEmail[$emailIndex] = $row['email'];
		$emailIndex++;
	}

	require_once("PHPMailer/PHPMailerAutoload.php");

	$mail = new PHPMailer;

	$mail->isHTML(true);

	$mail->isSMTP();                                      
	$mail->Host = 'mail-relay.toyota.co.id'; 
	$mail->SMTPAuth = false; 

	$mail->setFrom('ED-TS-Admin@toyota.co.id');

	// TS new revision email
	if($_POST['type'] == 1 || $_POST['type'] == 2){

		// $mail->addAddress("ed_magang_01@toyota.co.id");
		
		for($i=0;$i<$emailIndex;$i++){
			$mail->addCC($allEmail[$i]);
			// echo $allEmail[$i];
		}

		// Email subject
		$mail->Subject  = '[TS NEWS] Revision Update';

		// Email header

		$reqdate = explode("-",$_POST['reqdate']);

		$bodyMail = "
		Dear Mr / Mrs,<br><br>
		
		TMC has announced new TS revision update on <b>$reqdate[2]-$reqdate[1]-$reqdate[0]</b>.<br><br>";
		
		// Auto update
		if($_POST['type'] == 1){

			$bodyMail .= "<table border='1' cellpadding='5'>";

			for($i=0;$i<count($_POST['tsno']);$i++){
				$tsno = $_POST['tsno'][$i];
				$rev = $_POST['rev'][$i];
				$content = $_POST['content'][$i];

				$bodyMail .= "<tr>
								<td>$tsno</td>
								<td>REV.$rev</td>
								<td>$content</td>
							</tr>";
			}
			
			$bodyMail .= "</table>";

		// Manual update
		}else{
			$tsno = $_POST['tsno'];
			$rev = $_POST['rev'];
			$content = $_POST['content'];

			$bodyMail .= "$tsno REV.$rev $content<br>";
		}

		// Email footer
		$bodyMail .= "<br>

			*Please use <b>Mozilla Firefox</b> to access URL below.<br>
			To see TS revision history, please go to 
			<a href='http://intranet.toyota.co.id/TSOnline/'>TS ED System</a>.<br>
			To view TS content, please go to 
			<a href='https://ts-global.stnd.toyota.co.jp/affl/es1/ats_ts_dom'>TMC TS Online</a>.<br>
			Other useful <a href='http://10.16.22.11/edtims/'>links</a>.<br><br>
			<i style='color:red;'>*please do not reply and forward this email.</i><br><br>

			Best Regards,<br><br><br>


			ED TS Administrator<br><br>";

	// New request email
	}else{

		// Email subject
		$mail->Subject  = 'Supplier New Request';
	}	

	// Combine body email
	$mail->Body = $bodyMail;


	// Send email
	if(!$mail->send()) {
		echo "<script type='text/javascript'> document.location = 'tsauto.php?ok=0'; </script>";
	  	// echo 'Message was not sent.';
	  	// echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {}
	
?>