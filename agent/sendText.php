<?php
session_start();

require '../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';
require '../databaseConnection.php';
use Twilio\Rest\Client;

$dbConn = getConnection();

$agentEmailSql = "SELECT firstName, lastName, email, phone FROM UsersInfo WHERE userId = :userId";
$stmt = $dbConn->prepare($agentEmailSql);
$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];
$stmt->execute($namedParameters);
$result = $stmt->fetch();



$twilio_phone_number = "+18315851661";
$client = new Client($sid, $token);
$client->messages->create(
    $_POST['phone'],
    array(
        "From" => $twilio_phone_number,
        "Body" => $_POST['text'] . " %0a" . 
        "Please don’t respond to this text. Please contact " . $result['firstName'] . " " . $result['lastName'] . "  at: " . $result['phone'] ,
    )
);

?>