<?php


require_once('../../fpdf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage("P","letter");
$pdf->SetMargins(0,0,0);
$pdf->SetXY(0,0);

// ---------------TEST-------------------------------------------
// $firstImage = (string)$_POST['imageTwo'];
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Image($firstImage, 60,30,90,0,'JPEG');

// $pdf->Output('/Applications/XAMPP/xamppfiles/htdocs/test/generateExample.pdf', 'F');

// --------------------------------------------------------------

$pdf->SetFont('Arial','B',55);
$pdf->SetTextColor(255,255,255);
$pdf->setFillColor(255,0,0);
$pdf->Cell(0,32,' OPEN HOUSE |',0,0,'',true);

// Text(float x, float y, string txt)
$pdf->SetFont('Arial');
$pdf->SetFontSize(14);

$pdf->Text(150,15,"OFFERED AT:");
$pdf->Text(150,21,"$");


$pdf->SetTextColor(0,0,0);
$pdf->Text(9,45,'930 PROVINCETOWN DR SALINAS CA 93906');

// Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
$pdf->Image($_POST['imageOne'], 9,49,160,85,'JPEG');

$pdf->Image($_POST['imageTwo'], 9,134,55,34,'JPEG');

$pdf->Image($_POST['imageThree'], 64,134,54,34,'JPEG');

$pdf->Image($_POST['imageTwo'], 9,168,55,34,'JPEG');
$pdf->Image($_POST['imageTwo'], 64,168,54,34,'JPEG');

$pdf->SetXY(120,137);
$pdf->SetFont('Times');

$pdf->SetFontSize(10);
// $pdf->SetAutoPageBreak(true,0);
// MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
$pdf->MultiCell(85,3.5,"Don't miss out on this charming 4 bedroom 2 bath home in a highly desired neighborhood! Inside features include high ceilings, every rooms brings in much desired natural light , the perfect blend of beautiful engineered laminate wood flooring and new carpet. An amazing floor plan, foyer entry into the spacious and bright living room highlighted by a lovely gas fireplace. The welcoming family room is adjacent to the spacious kitchen. The kitchen includes stainless steal appliances, granite counter tops, and a lovely eating area. The generous size bedrooms have plenty of closet space. The master bedroom is complete with an in suite bathroom  that has a wonderful standing shower and equipped with double sinks. The backyard in this home has been beautifully designed including stamp concrete, iron rod fencing, a gas fire pit for you to enjoy beautiful nights outdoors and an area perfect for your pets. This home and neighborhood show true pride of ownership.",0,"L");

$pdf->SetFontSize(13);
$pdf->Text(9,210,'RE/MAX Property Experts');
$pdf->Image('jorge.jpg', 9,212, 20,30,"jpg");

$pdf->Text(30,216,'Jorge Edeza');
$pdf->Text(30,221,'Broker Associate and Owner');
$pdf->Text(30,226,'Office Phone');
$pdf->Text(30,231,'Mobile Phone');
$pdf->Text(30,236,'Email');
$pdf->Text(30,241,'www.PropertyExperts.Remax.com');
$pdf->Text(9,248,'915A N. Main Street, Salinas, CA 93906');

$pdf->Image('remax.png', 155,236, 45,30,"png");

$pdf->Output('/Applications/XAMPP/xamppfiles/htdocs/test/generateExample.pdf', 'F');


?>