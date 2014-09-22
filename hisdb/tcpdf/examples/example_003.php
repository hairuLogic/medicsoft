<?php
require_once('../config/lang/eng.php');
require_once('../tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'logoMS.png';
		$this->Image($image_file, 15, 7, 21, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('times', 'B', 22);
		// Title
		$this->MultiCell(110, 10, 'MEDICSOFTWARE SDB BHD', 0, 'J', 0, 0, 40, 5, false, 4, false);
		$this->SetFont('times', '', 11);
		$this->MultiCell(50, 10, '(742083-U)', 0, 'J', 0, 0, 152, 5.7, false, 'M', 'M');
		$this->MultiCell(100, 0, "No 5-1-1, Jalan Medan PB1A, Seksyen 9,", 0, 'J', 0, 0, 40, 11, false, 'M', 'M');
		$this->MultiCell(100, 0, "43650 Bandar Baru Bangi,Selangor,Malaysia", 0, 'J', 0, 0, 40, 15, false, 'M', 'M');
		$this->MultiCell(100, 0, "Tel: +603 8925 7632 ", 0, 'J', 0, 0, 40, 21, false, 'M', 'M');
		$this->MultiCell(100, 0, "Url: www.medicsoftware.com.my", 0, 'J', 0, 0, 40, 25, false, 'M', 'M');
	}
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, '', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Hazman');
$pdf->SetTitle('test');
$pdf->SetSubject('test');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(15, 50, 15);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

//make header line
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(10, 35, 200, 35, $style);

// set font
$pdf->SetFont('times', '', 12);

//print patient info using cell
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
$pdf->Cell(20, 0, 'MRN', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': 0000001', 0, 0, 'L', 0, '', 0);
$pdf->Cell(20, 0, 'DOB', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': 12-12-1987', 0, 1, 'L', 0, '', 0);
$pdf->Cell(20, 0, 'Name', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': Hazman bin Yusof', 0, 0, 'L', 0, '', 0);
$pdf->Cell(20, 0, 'Sex', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': Male', 0, 1, 'L', 0, '', 0);
$pdf->Cell(20, 0, 'Address', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': No 8, Jalan 3/4f,', 0, 0, 'L', 0, '', 0);
$pdf->Cell(20, 0, 'Citizen', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': Malaysia', 0, 1, 'L', 0, '', 0);
$pdf->Cell(20, 0, '', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, '  Bandar Baru Bangi, 43650', 0, 0, 'L', 0, '', 0);
$pdf->Cell(20, 0, 'Race', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, ': Melayu', 0, 1, 'L', 0, '', 0);
$pdf->Cell(20, 0, '', 0, 0, 'L', 0, '', 0);
$pdf->Cell(80, 0, '  Selangor Darul Ehsan', 0, 0, 'L', 0, '', 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
