<?php
require("databaseConnection.php");
// require("../keys/refreshKeyAdobe.php");
require("keys/cred.php");
session_start();
$dbConn = getConnection();
if(!isset($_SESSION['userId'])) 
{
    header("Location: index.html?error=wrong username or password");
} 

$license = $_POST['license'];
$houseId = $_POST['propertyAddress'];

$agent = "SELECT * FROM UsersInfo WHERE license = '".$license."'";
$name = $dbConn -> prepare($agent);
$name->execute();
$userResults = $name->fetch();

$currAgent = "SELECT * FROM UsersInfo WHERE userId = '".$_SESSION['userId']."'";
$email = $dbConn -> prepare($currAgent);
$email->execute();
$currAgentEmail = $email->fetch();

$sqlHouse = "SELECT * FROM HouseInfo WHERE houseId = '" . $houseId . "'";
$stmtHouse = $dbConn -> prepare($sqlHouse);
$stmtHouse->execute();
$houseResults = $stmtHouse->fetch();

$sql ="INSERT INTO commInfo
        (houseId, license, firstName, lastName, date, settlementDate, checkNum, address, city, state, zip, TYGross, FYGross, InitialGross, brokerFee, finalComm, misc, percentage, envelopeId)
        VALUES (:houseId, :license, :firstName, :lastName, :date, :settlementDate, :checkNum, :address, :city, :state, :zip, :TYGross, :FYGross, :InitialGross, :brokerFee, :finalComm, :misc, :percentage, :envelopeId)";
           
$namedParameters = array();
$namedParameters[":houseId"] = $houseId;
$namedParameters[":license"] = $license;
$namedParameters[":firstName"] = $userResults['firstName'];
$namedParameters[":lastName"] = $userResults['lastName'];     
$namedParameters[":date"] = date("Y-m-d", strtotime($_POST['today-date']));     
$namedParameters[":settlementDate"] = date("Y-m-d", strtotime($_POST['settlementDate']));     
$namedParameters[":checkNum"] = $_POST['checkNum'];   
$namedParameters[":address"] = $houseResults['address'];     
$namedParameters[":city"] = $houseResults['city'];     
$namedParameters[":state"] = $houseResults['state']; 
$namedParameters[":zip"] = $houseResults['zip'];
$namedParameters[":TYGross"] = $_POST['TYGross'] + $_POST['InitialGross'];   
$namedParameters[":FYGross"] = $_SESSION['FYGross'] + $_POST['netCommission'];
$namedParameters[":InitialGross"] = $_POST['InitialGross'];   
$namedParameters[":brokerFee"] = $_POST['brokerFee'];
$namedParameters[":finalComm"] =  $_POST['netCommission']; 
$namedParameters[":misc"] =  $_POST['miscell'];
// $value = preg_replace('/[\%,]/', '', $_POST['percentage']);
$value = floatval($_POST['percentage']);
$namedParameters[":percentage"] = $value;

// $stmt = $dbConn -> prepare($sql);
// $stmt->execute($namedParameters); 

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
$pdf->Cell(0,10,'Property Address: ' . $houseResults['address'],0,1);
$pdf->Cell(0,10,' ',0,1);
$pdf->Cell(0,10,'                        Agent Initial Gross Commission: $' . $_POST['InitialGross'],0,1);
$pdf->Cell(0,10,'                        Remax/Broker Fee: $' . $_POST['brokerFee'],0,1);
$pdf->Cell(0,10,'                        Agent Subtotal: $' . ($_POST['InitialGross'] - $_POST['brokerFee']),0,1);
$pdf->Cell(0,10,'                        Processing Fee: $200.00  Flat fee fixed ',0,1);
$pdf->Cell(0,10,'                        TC. Tech Fee:  $50.00  Flat fee fixed ',0,1);
$pdf->Cell(0,10,'                        E&O Insurance:  $99.00  Flat fee fixed ',0,1);
$pdf->Cell(0,10,'                        Other Fees: $' . $_POST['miscell'],0,1);
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
		  		\"name\": \"" . $_POST['agentName'] . "\",
		  		\"recipientId\": \"1\",
		  		\"routingOrder\": \"1\"
		  	},
		  	{
		  		\"email\": \"jodiaz@csumb.edu\",
		  		\"name\": \"Jose \",
		  		\"recipientId\": \"2\",
		  		\"routingOrder\": \"2\"	
		  	}]},
	  		\"documents\": [
	  		{
	  			\"documentId\": \"1\",
		  		\"name\": \"" . $houseResults['address'] . ".pdf\",
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
	  	$envId = json_decode($response, true);
		$namedParameters[":envelopeId"] = $response['envelopeId'];
		$stmt = $dbConn -> prepare($sql);
		$stmt->execute($namedParameters); 
	}
	

	header("Location: index.php");

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