<?php

session_start();
require '../databaseConnection.php';

require '../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;


$dbConn = getConnection();

$sql = "DELETE FROM transactions 
                 WHERE transId = " . $_POST['inContractId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute();


$transInfoSql = "SELECT address FROM transactions WHERE transId = :transId";
$transParam = array();
$transParam[':transId'] = $_POST['inContractId'];

$transInfoStmt = $dbConn->prepare($transInfoSql);
$transInfoStmt->execute($transParam);

$transInfoResults = $transInfoStmt->fetch();


$sendToNums = array("8319059490", "8313206212");
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
        "Body" => $transInfoResults['address'] . " Deleted from In-Contract",
    )
);
}

?>