<?php
require("databaseConnection.php");
// require("../keys/refreshKeyAdobe.php");
require("keys/cred.php");
session_start();
$dbConn = getConnection();
// $commId;
// if(!isset($_GET['commId']))
// {
// 	$commId = $_POST['id'];
// }
// else
// {
// 	$commId = $_GET['commId'];
// }
// $sqlAgent = "SELECT FYGross FROM commInfo  WHERE commId = '" . $commId . "'";
// $stmtAgent = $dbConn -> prepare($sqlAgent);
// $stmtAgent->execute();
// $comm = $stmtAgent->fetch();
require('fpdf/fpdf.php');
 
        // $data = $_GET["agentNum"];
       
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Times','I');
$pdf->SetFontSize(10);
$pdf->Cell(0,10,'Re/MAX Property Experts Commission Breakdown',0,1);
$pdf->Cell(0,10,'Date:  ' . date("d-m-Y", strtotime($_POST['today-date'])) .'                                                                     Total Year to Date Gross: $' . $_POST['TYGross'],0,1);
$pdf->Cell(0,10,'Check # '. $_POST['checkNum'] .'                                                                           Agent Final Year to Date Gross Comission: $' . $_SESSION['FYGross'],0,1);
$pdf->Cell(0,10,'Settlement Date: ' . date("d-m-Y", strtotime($_POST['settlementDate'])),0,1);
$pdf->Cell(0,10,'Agent:  ' . $_POST['agentName'],0,1);
$pdf->Cell(0,10,'Clients:  ',0,1);
$pdf->Cell(0,10,'Property Address: ' . $_POST['propertyAddress'],0,1);
$pdf->Cell(0,10,' ',0,1);
$pdf->Cell(0,10,'                        Agent Initial Gross Commission: $' . $_POST['InitialGross'],0,1);
$pdf->Cell(0,10,'                        Remax/Broker Fee: $' . $_POST['brokerFee'],0,1);
$pdf->Cell(0,10,'                        Agent Subtotal: $' . ($_POST['InitialGross'] . $_POST['brokerFee']),0,1);
$pdf->Cell(0,10,'                        Processing Fee: $200.00  Flat fee fixed ',0,1);
$pdf->Cell(0,10,'                        TC. Tech Fee:  $50.00  Flat fee fixed ',0,1);
$pdf->Cell(0,10,'                        E&O Insurance:  $99.00  Flat fee fixed ',0,1);
$pdf->Cell(0,10,'                        Other Fees:  ',0,1);
$pdf->Cell(0,10,' ',0,1);
$pdf->Cell(0,10,'                        Agents Final Commission:  $' . $_POST['netCommission'],0,1);
$pdf->Cell(0,10,'',0,1);
$pdf->SetFont('Times','BI',14);
$pdf->Cell(0,10,'                                                               Have READ & APPROVED this Commission Worksheet ',0,1);
$pdf->SetFontSize(10);
$pdf->Cell(0,10,'',0,1);
$pdf->Cell(0,10,'',0,1);
$pdf->Cell(0,10,'',0,1);
$pdf->Cell(0,10,'',0,1);
$pdf->Cell(0,10,'',0,1);
$pdf->Cell(0,10,'Agent Signature                              Date                                     Owner and/or Broker Signature                                         Date',0,1);

	
	$base = $pdf->Output('','s');
	$doc = base64_encode($base);
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://demo.docusign.net/restapi/v2/accounts/2837693/envelopes",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "{
	  \"emailSubject\":\"DocuSign REST API Quickstart Sample\",
	  \"emailBlurb\": \"Shows how to create and send an envelope from a document.\",
	  \"recipients\": {
	  	\"signers\": [
	  		{
	  			\"email\": \"jodiaz@csumb.edu\",
		  		\"name\": \"Jose Diaz\",
		  		\"recipientId\": \"1\",
		  		\"routingOrder\": \"1\"
		  	},
		  	{
		  		\"email\": \"michael50974@gmail.com\",
		  		\"name\": \"Jose \",
		  		\"recipientId\": \"2\",
		  		\"routingOrder\": \"2\"	
		  	}]},
	  		\"documents\": [
	  		{
	  			\"documentId\": \"1\",
		  		\"name\": \"test.pdf\",
		  		\"documentBase64\": \"" . $doc ."\"
		  	}],
		  	\"status\": \"sent\"}",
	  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "content-type: application/json",
    "x-docusign-authentication: { \"Username\": \"" . $username . "\",\"Password\":\"" . $password ."\",\"IntegratorKey\":\"" . $intKey . "\" }"
  	),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
		if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}
	//header("Location: index.php");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    
<head>
    <title>Commission Sheet</title>
    
    
    <meta charset = "utf-8"/>

 
</head>
    

    <body>
       
    </body>

</html>