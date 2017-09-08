<?php
clearstatcache();

require_once('../../fpdf/fpdf.php');
require_once('../../databaseConnection.php');

$dbConn = getConnection();

try
{
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
$pdf->Text(150,21, substr($_POST['price'], 0, -1));

$address = $_POST['address'] . " " . substr($_POST['city'] ,0,-1) . " " . substr($_POST['state'] ,0,-1) . " " . substr($_POST['zip'] ,0,-1);

$pdf->SetTextColor(0,0,0);
$pdf->Text(9,45, $address);


$pdf->SetTextColor(255,255,255);
// Image(string file [, float x [, float y [, float w [, float h [, string type [, mixed link]]]]]])
$pdf->Image($_POST['imageOne'], 9,49,160,85,'JPEG');

$pdf->Image('redLeftArrow.png', 158,49,50,20,'PNG');
$pdf->Text(170,60,substr($_POST['bedrooms'] ,0,-1). " Bedrooms");
$pdf->Image('redLeftArrow.png', 158,71,50,20,'PNG');
$pdf->Text(170,82,substr($_POST['bathrooms'] ,0,-1). " Bathrooms");
$pdf->Image('redLeftArrow.png', 158,93,50,20,'PNG');
$pdf->Text(170,104,substr($_POST['sqft'] ,0,-1). " SqFt");
$pdf->Image('redLeftArrow.png', 158,114,50,20,'PNG');
$pdf->Text(170,126,substr($_POST['mlsId'],0,-1));


$pdf->Image($_POST['imageTwo'], 9,134,55,34,'JPEG');

$pdf->Image($_POST['imageThree'], 64,134,54,34,'JPEG');

$pdf->Image($_POST['imageFour'], 9,168,55,34,'JPEG');
$pdf->Image($_POST['imageFive'], 64,168,54,34,'JPEG');

$pdf->SetXY(120,137);
$pdf->SetFont('Times');

$pdf->SetTextColor(0,0,0);

$pdf->SetFontSize(12);
// $pdf->SetAutoPageBreak(true,0);
// MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
$pdf->MultiCell(85,4.5,$_POST['description'],0,"L");

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

$sql = "UPDATE HouseInfo SET flyer = :flyer WHERE listingId = :listingId";

$namedParameters = array();
$namedParameters[":flyer"] = $_POST['address'] . '.pdf';
$namedParameters[':listingId'] = substr($_POST['mlsId'],0,-1);



$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

 // $pdf->Output('/Applications/XAMPP/xamppfiles/htdocs/test/generateExample.pdf', 'F');
$pdf->Output('../../uploadFlyers/' . $_POST['address']. '.pdf', 'F');
 echo 'vanilla!';
}
catch(Exception $e)
{
echo $e->getMessage();
}
sleep(5);

?>