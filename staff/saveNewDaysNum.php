<?php
session_start();

require '../databaseConnection.php';

require 'keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;

$dbConn = getConnection();


$transId = $_POST['transId'];

$type = $_POST['type'];
$date = $_POST['date'];

$statusUpdate = "";

if($type == "emd") 
{
	$dateSql = "UPDATE transactions SET  emdDays = :emdDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':emdDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "EMD Days";
}
else if($type == "seller") 
{
	$dateSql = "UPDATE transactions SET  sellerDiscDays = :sellerDiscDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':sellerDiscDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "Seller Disclosures Days";
		
}
else if($type == "generalInspec") 
{
	$dateSql = "UPDATE transactions SET  genInspecDays = :genInspecDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':genInspecDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "General Inspection Days";
}
else if($type == "appr") 
{
	$dateSql = "UPDATE transactions SET  appraisalDays = :appraisalDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':appraisalDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "Appraisal Days";
}
else if($type == "lc") 
{
	$dateSql = "UPDATE transactions SET  lcDays = :lcDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':lcDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "LC Days";
}
else if($type == "vpc") 
{
	$dateSql = "UPDATE transactions SET  vpcDays = :vpcDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':vpcDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "coe") 
{
	$dateSql = "UPDATE transactions SET  coeDays = :coeDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':coeDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "COE Days";
}

else if($type == "miscOne")
{
	$dateSql = "UPDATE transactions SET  miscOneDays = :miscOneDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':miscOneDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "miscTwo")
{
	$dateSql = "UPDATE transactions SET  miscTwoDays = :miscTwoDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':miscTwoDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if($type == "signed")
{
	$dateSql = "UPDATE transactions SET  signedDiscDays = :signedDiscDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':signedDiscDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
	$statusUpdate = "Signed Disclosures Days";
}


$transInfoSql = "SELECT address FROM transactions WHERE transId = :transId";
$transParam = array();
$transParam[':transId'] = $transId;

$transInfoStmt = $dbConn->prepare($transInfoSql);
$transInfoStmt->execute($transParam);

$transInfoResults = $transInfoStmt->fetch();


$sendToNums = array("8312934153", "8312934153");
$twilio_phone_number = "+18315851661";
// if($houseId == "89")
// {
foreach ($sendToNums as $sendTo) 
{
	$client = new Client($sid, $token);
	$client->messages->create(
    $sendTo,
    array(
        "From" => $twilio_phone_number,
        "Body" => $transInfoResults['address'] . " " . $statusUpdate . " updated",
    )
);
}

?>