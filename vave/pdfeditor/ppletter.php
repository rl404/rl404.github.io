<?php

	// Import fpdf
	require_once('fpdf/fpdf.php');
	require_once('fpdi/fpdi.php');

	class PDF extends FPDF {
		function Header(){

			$this->SetMargins(1.5,1.5,1.5);

			$this->SetXY(1.5,1.5);
			$this->SetFont('Arial','',9);
		    $this->Cell(0,0.4,'PT.Toyota Motor Manufacturing Indonesia','0',0,'L');
		    $this->Ln();
		    $this->Cell(0,0.4,'Engineering Division','0',0,'L');
		    $this->Ln();
		    $this->Cell(0,0.4,'Product Planning & EQ Promotion Dept.','0',0,'L');
		    $this->Ln();
		    $this->Ln();

		    $this->Cell(0,0.4,'Ref. No. : ','0',0,'L');

		    $this->SetX(14);
			$this->Cell(0,0.4,"Jakarta, $date",0,'L');
		    $this->Ln();
		    $this->Ln();

		    $this->Cell(0,0.4,'To : ','0',0,'L');

		    $this->SetX(2.5);
		    $this->SetFont('','B');
			$this->Cell(0,0.4,"TMMIN - Purchasing Division",0,'L');
		    $this->Ln();
		    $this->SetFont('');
		    $this->cell(1,0.4,"",0,'L');
			$this->Write(0.4,"Mr. / Mrs. $_GET[supppic]");

		}
	}

$pdf = new PDF('P','cm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(1.5,1.5,1.5);	

$pdf->Ln(1.5);

// Subject
$pdf->SetFont('Arial','',9);
$pdf->Write(0.4,'Dear Sir/Madam,');
$pdf->Ln(1);
$pdf->Write(0.4,'We have the pleasure of sending you herewith the under mentioned document, to which your due attention will be much apppreciated.');

// Output pdf
$pdf->Output();
?>