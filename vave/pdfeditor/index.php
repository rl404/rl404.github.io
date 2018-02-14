<?php

	// Import fpdf
	require_once('fpdf/fpdf.php');
	require_once('fpdi/fpdi.php');

	$pdf = new FPDI();
	// add a page
	$pdf->AddPage();
	// set the source file
	$pdf->setSourceFile("blank.pdf");
	// import page 1
	$tplIdx = $pdf->importPage(1);
	// use the imported page and place it at point 10,10 with a width of 100 mm
	$pdf->useTemplate($tplIdx, 0, 0, 0);

	// now write some text above the imported page
	$pdf->SetFont('Helvetica');
	$pdf->SetTextColor(0, 0, 0);
	// $pdf->SetFillColor(255,255,255); 	
	$pdf->SetFillColor(220,220,220,0.5); 

	// Toyota Design Staff
	$pdf->SetXY(33, 14);
	$pdf->SetFont('',B);
	$pdf->Cell(120, 5, "$_POST[designer]", 0, 0, 'c', false);

	$pdf->SetFont('','',10);

	// Car manufacturer no
	$pdf->SetXY(158, 23);	
	$pdf->Cell(37, 5, "$_POST[manufacturerno]", 0, 0, 'c', false);

	// Proposer no
	$pdf->SetXY(158, 35);	
	$pdf->Cell(38, 5, "$_POST[teardownno]", 0, 0, 'c', false);

	// Partno
	$partno = $_POST['partno'][0];
	$separatedPartNo = explode("-", "$partno");
	for($j = 0; $j < count($separatedPartNo); $j++){
		$pdf->SetXY(20+26*$j, 43.5);	
		$pdf->Cell(22, 5, "$separatedPartNo[$j]", 0, 0, 'c', false);
	}

	// Part Name
	$partname = $_POST['partname'][0];
	$pdf->SetXY(100, 43.5);	
	$pdf->Cell(90, 5, "$partname", 0, 0, 'c', false);

	// Model
	$pdf->SetXY(170, 49.5);	
	$pdf->Cell(25, 4, "$_POST[model]", 0, 0, 'c', false);

	$pdf->SetXY(170, 90.5);	
	$pdf->setFillColor(204,255,204); 
	$pdf->Cell(10, 3, "$_POST[piece]", 0, 0, 'C', true);

	$pdf->SetXY(170, 82.5);	
	$pdf->Cell(10, 3, "", 0, 0, 'C', true);
	$pdf->SetXY(170, 98.5);	
	$pdf->Cell(10, 3, "", 0, 0, 'C', true);

	// Old design	
	$pdf->SetFont('','',8);

	$filename = "../images/design/$_POST[vaveid]old0.png";
	if (file_exists($filename)) {	
		list($width, $height) = getimagesize($filename);
		
		if($width <= 2.5*$height){
			$pdf->Image("../images/design/$_POST[vaveid]old0.png",20,85,0,20);
		}else{
			$pdf->Image("../images/design/$_POST[vaveid]old0.png",20,85,-135,0);
		}
	}

	$pdf->SetXY(20, 74);	
	$pdf->drawTextBox("$_POST[ideaold]", 60, 30, 'L', 'T', false);	

	// New design
	$filename = "../images/design/$_POST[vaveid]new0.png";
	if (file_exists($filename)) {
		list($width, $height) = getimagesize($filename);

		if($width <= 3*$height){
			$pdf->Image("../images/design/$_POST[vaveid]new0.png",82,85,0,20);
		}else{
			$pdf->Image("../images/design/$_POST[vaveid]new0.png",82,85,-120,0);
		}
	}

	$pdf->SetXY(82, 74);	
	$pdf->drawTextBox("$_POST[ideanew]", 70, 30, 'L', 'T', false);

	$pdf->SetFont('','',10);
	
	// Proposer company + div
	$pdf->SetXY(20, 127);	
	$pdf->Cell(80, 5, "$_POST[proposerdiv]", 0, 0, 'c', false);

	// Proposer date
	$_POST['proposerdate'] = date('Y-M-d',strtotime($_POST['proposerdate']));
	$pdf->SetXY(52, 134.5);	
	$pdf->Cell(50, 4, "$_POST[proposerdate]", 0, 0, 'c', false);

	// Proposer name
	$pdf->SetXY(130, 133);	
	$pdf->Cell(60, 5, "$_POST[proposername]", 0, 0, 'c', false);

	// PE Date
	$_POST['date1'] = date('Y-M-d',strtotime($_POST['date1']));
	$pdf->SetXY(100, 169);	
	$pdf->Cell(30, 5, "$_POST[date1]", 0, 0, 'c', false);

	if(count($_POST['partno']) > 1){
		// add a page
		$pdf->AddPage();

		$pdf->SetWidths(array(10, 20, 55, 100));

		$pdf->SetFont('Arial','B',10);
		$pdf->SetAligns(array('C','C','C','C'));
		$pdf->Row(array('NO', 'Model', 'Part No', 'Part Name'));

		$pdf->SetAligns(array('C','C','C','L'));

		$no = 1;
	    for($i=1;$i<count($_POST['partno']);$i++){
	    	$partno = $_POST['partno'][$i];
	    	$partname = $_POST['partname'][$i];

		    if(!empty($partno)){
		    	$pdf->SetFont('Arial','',10);
			    $pdf->Row(array($no.".",$_POST['model'],$partno,$partname));
			    $no++;
			}
		}
	}

	$pdf->Output();
?>