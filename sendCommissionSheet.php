<?php
require("databaseConnection.php");
// require("../keys/refreshKeyAdobe.php");
require("keys/cred.php");
session_start();
$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: index.html?error=wrong username or password");
}

$license = $_POST['license'];
$houseListingId = $_POST['propertyAddress'];

$agent = "SELECT * FROM UsersInfo WHERE license = '" . $license . "'";
$name = $dbConn->prepare($agent);
$name->execute();
$userResults = $name->fetch();

$currAgent = "SELECT * FROM UsersInfo WHERE userId = '" . $_SESSION['userId'] . "'";
$email = $dbConn->prepare($currAgent);
$email->execute();
$currAgentEmail = $email->fetch();

$sqlHouse = "SELECT * FROM HouseInfo WHERE listingId = '" . $houseListingId . "'";
$stmtHouse = $dbConn->prepare($sqlHouse);
$stmtHouse->execute();
$houseResults = $stmtHouse->fetch();

$TYGross =         str_replace(",", "", (string)$_POST['TYGross']);
$FYGross =         str_replace(",", "", (string)$_SESSION['FYGross']);
$initialGross =    str_replace(",", "", (string)$_POST['InitialGross']);
$netCommission =   str_replace(",", "", (string)$_POST['netCommission']);
$brokerFee =       str_replace(",", "", (string)$_POST['brokerFee']);
$miscell =         str_replace(",", "", (string)$_POST['miscell']);
$remaxFee =        str_replace(",", "", (string)$_POST['remaxFee']);
$finalHousePrice = str_replace(",", "", (string)$_POST['finalHousePrice']);

$addRemaxFeeSql = "INSERT INTO remaxFee (userId, date, paid) VALUES (:userId, :date, :paid)";
$remaxFeeParam = array();
$remaxFeeParam[':userId'] = $_SESSION['userId'];
$remaxFeeParam[':date'] = date("Y-m-d", strtotime($_POST['today-date']));
$remaxFeeParam[':paid'] = (int)$remaxFee;

$remaxFeeStmt = $dbConn->prepare($addRemaxFeeSql);
$remaxFeeStmt->execute($remaxFeeParam);

$sql = "INSERT INTO commInfo
        (houseId, license, firstName, lastName, date, settlementDate, checkNum, clients, address, city, state, zip, TYGross, FYGross, InitialGross, brokerFee, finalComm, remaxFee, misc, percentage, envelopeId, finalHousePrice)
        VALUES (:houseId, :license, :firstName, :lastName, :date, :settlementDate, :checkNum, :clients, :address, :city, :state, :zip, :TYGross, :FYGross, :InitialGross, :brokerFee, :finalComm, :remaxFee, :misc, :percentage, :envelopeId, :finalHousePrice)";

$namedParameters = array();
$namedParameters[":houseId"] = $houseResults['houseId'];
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
$namedParameters[":TYGross"] = (int)$TYGross + $initialGross;
$namedParameters[":FYGross"] = (int)$FYGross + $netCommission;
$namedParameters[":InitialGross"] = $initialGross;
$namedParameters[":brokerFee"] = $brokerFee;
$namedParameters[":finalComm"] = $netCommission;
$namedParameters[":misc"] = $miscell;
$namedParameters[":remaxFee"] = (int)$remaxFee;
$namedParameters[":clients"] = $_POST['clients'];
// $value = preg_replace('/[\%,]/', '', $_POST['percentage']);
$value = floatval($_POST['percentage']);
$namedParameters[":percentage"] = $value;
$namedParameters[":finalHousePrice"] = $finalHousePrice;
// str_replace(find,replace,string,count)
// $stmt = $dbConn -> prepare($sql);
// $stmt->execute($namedParameters); 

require('fpdf/fpdf.php');

// $data = $_GET["agentNum"];

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetLineWidth(.5);
$pdf->Rect(5, 5, 200, 285, 'D');

// $pdf->SetLineWidth(.3);
// $pdf->Rect(10, 11, 97, 8, 'D');

$pdf->SetFont('Times', 'B');
$pdf->SetFontSize(12);

$pdf->SetLineWidth(.3);
$pdf->Cell(96, 10, 'RE/MAX Property Experts Commission Breakdown', 1, 0);
$pdf->Cell(10, 10, '', 0, 0);
$pdf->Cell(0, 10, '                       Check # ' . $_POST['checkNum'], 'B', 1);


$pdf->Cell(166, 10, '                                                                                                   Beginning Gross Check Amount: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(5, 10, '$' . number_format($TYGross, 2) . ' ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(15, 10, 'Date: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(30, 10, '     ' . date("m-d-Y", strtotime($_POST['today-date'])) . '       ', 0, 1);

$pdf->Cell(10, 3, '', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(35, 10, 'Settlement Date: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(30, 10, '     ' . date("m-d-Y", strtotime($_POST['settlementDate'])) . '       ', 0, 1);

$pdf->Cell(10, 3, '', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(17, 10, 'Agent: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(50, 10, '     ' . $userResults['firstName'] . ' ' . $userResults['lastName'] . '      ', 0, 1);

$pdf->Cell(10, 3, '', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(18, 10, 'Clients: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(50, 10, '     ' . $_POST['clients'] . '     ', 0, 1);

$pdf->Cell(10, 3, '', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(37, 10, 'Property Address: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(50, 10, '   ' . $houseResults['address'] . ', ' . $houseResults['city'] . ', ' . $houseResults['state'] . ', ' . $houseResults['zip'] . '      ', 0, 1);

$pdf->Cell(0, 5, ' ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Gross Check Amount: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format($initialGross, 2) . '      ', 0, 1);

// $pdf->Cell(0,2,' ',0,1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Remax/Broker Fee: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format($brokerFee, 2) . '      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Total Fees: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format($brokerFee, 2) . '      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Subtotal: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format(((int)$initialGross - $brokerFee), 2) . '      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Processing Fee: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $200.00      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        TC. Tech Fee: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $50.00      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        E&O Insurance: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $99.00      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Remax Franchise: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format($remaxFee, 2) . '      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Misc: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format($miscell, 2) . '      ', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(69, 10, '                        Agent Commission: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(23, 10, '   $' . number_format($netCommission, 2) . '      ', 0, 1);


$pdf->Cell(0, 10, '', 0, 1);
$pdf->SetFont('Times', 'I', 14);
$pdf->Cell(7, 10, '   I, ', 0, 0);
$pdf->SetFont('Times', 'U', 14);
$pdf->Cell(41, 10, '                                            ', 0, 0);
$pdf->SetFont('Times');
$pdf->Cell(20, 10, '             , have READ & APPROVED this Commission Worksheet.  ', 0, 1);

$pdf->SetFontSize(12);
$pdf->Cell(0, 30, '', 0, 1);

$pdf->Cell(75, 10, '                                                     ', 0, 0);
$pdf->Cell(32, 10, '      ', 0, 0);
$pdf->Cell(84, 10, ' Owner and/or Broker Signature               Date  ', 'T', 1);

$pdf->Cell(0, 13, '', 0, 1);

$pdf->SetFont('Times', 'B');
$pdf->Cell(155, 5, '                                                                                                      New Gross Commission: ', 0, 0);
$pdf->SetFont('Times', 'U');
$pdf->Cell(30, 5, '   $' . number_format(((int)$TYGross + $initialGross), 2) . '      ', 0, 1);

// $pdf->Output();
$base = $pdf->Output('', 's');
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
	  \"emailBlurb\": \"Commission Sheet - Signature Required\",
	  \"recipients\": {
	  	\"signers\": [
	  		{
	  			\"email\": \"" . $userResults['email'] . "\",
		  		\"name\": \"" . $userResults['firstName'] . " " . $userResults['lastName'] . "\",
		  		\"recipientId\": \"1\",
		  		\"routingOrder\": \"1\",
		  		\"tabs\": {
		  			
		  				\"signHereTabs\": [
		  				{
			  				\"xPosition\": \"60\",
			  				\"yPosition\": \"555\",
			  				\"documentId\": \"1\",
			  				\"pageNumber\" : \"1\"
		  				}],
		  				\"dateSignedTabs\": [
		  				{
		  					\"xPosition\": \"140\",
			  				\"yPosition\": \"595\",
			  				\"documentId\": \"1\",
			  				\"pageNumber\" : \"1\"
		  				}]
		  			}
		  	},
		  	{
		  		\"email\": \"" . $currAgentEmail['email'] . "\",
		  		\"name\": \"" . $currAgentEmail['firstName'] . " " . $currAgentEmail['lastName'] .  "\",
		  		\"recipientId\": \"2\",
		  		\"routingOrder\": \"2\",
		  		\"tabs\": {
		  			
		  				\"signHereTabs\":[
		  				{
			  				\"xPosition\": \"340\",
			  				\"yPosition\": \"647\",
			  				\"documentId\": \"1\",
			  				\"pageNumber\" : \"1\"
		  				}],
		  				\"dateSignedTabs\": [
		  				{
		  					\"xPosition\": \"500\",
			  				\"yPosition\": \"687\",
			  				\"documentId\": \"1\",
			  				\"pageNumber\" : \"1\"
		  				}]
		  			}
		  	}]},
	  		\"documents\": [
	  		{
	  			\"documentId\": \"1\",
		  		\"name\": \"" . $houseResults['address'] . ".pdf\",
		  		\"documentBase64\": \"" . $doc . "\"
		  	}],
		  	\"status\": \"sent\"}",
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "content-type: application/json",
        "x-docusign-authentication: { \"Username\": \"" . $username . "\",\"Password\":\"" . $password . "\",\"IntegratorKey\":\"" . $intKey . "\" }"
    ),
));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
}
// else {
// echo $response;

// }

$envId = json_decode($response, true);
$namedParameters[":envelopeId"] = $envId['envelopeId'];
$stmt = $dbConn->prepare($sql);
try {


    $stmt->execute($namedParameters);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
// print_r($namedParameters);

header("Location: index.php");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <title>Commission Sheet</title>


    <meta charset="utf-8"/>


</head>


<body>

</body>

</html>