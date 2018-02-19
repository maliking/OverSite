<?php
date_default_timezone_set('America/Los_Angeles');
require("../databaseConnection.php");

require '../PHPMailer/src/PHPMailer.php'; 
require '../PHPMailer/src/Exception.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

session_start();
$dbConn = getConnection();

$houseId = $_POST['houseId'];
if($houseId[0] == "M")
{
	// $houseId = substr($_POST['houseId'], 1, -1);
	$sql = "SELECT address, city, state, zip FROM HouseInfo WHERE listingId = :houseId";
}
else
	$sql = "SELECT address, city, state, zip FROM HouseInfo WHERE houseId = :houseId";
$namedParameters = array();
$namedParameters[':houseId'] = $houseId;
$getAddress = $dbConn->prepare($sql);
$getAddress->execute($namedParameters);
$address = $getAddress->fetch();


$insertSql = "INSERT INTO transactions(houseId, userId, address, transType, clientName, clientNum, accDay, emdDays,
						 sellerDiscDays, buyerDiscDays, genInspecDays, termiteInspecDays, septicInspecDays, waterInspecDays, 
						 appraisalDays, apprOrdered, apprComp, lcDays, coeDays, notes) 
VALUES (:houseId, :userId, :address, :transType, :clientName, :clientNum, :accDay, :emdDays, :sellerDiscDays, :buyerDiscDays, :genInspecDays, :termiteInspecDays, 
	:septicInspecDays, :waterInspecDays, :appraisalDays, :apprOrdered, :apprComp, :lcDays, :coeDays, :notes)";

$parameters = array();
$parameters[':houseId'] = $houseId;
$parameters[':userId'] = $_SESSION['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Listing";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = date("y-m-d");
$parameters[':emdDays'] = "3";
$parameters[':sellerDiscDays'] = "7";
$parameters[':buyerDiscDays'] = "17";
$parameters[':genInspecDays'] = "17";
$parameters[':termiteInspecDays'] = "17";
$parameters[':septicInspecDays'] = "17";
$parameters[':waterInspecDays'] = "17";
$parameters[':appraisalDays'] = "17";
$parameters[':apprOrdered'] = "";
$parameters[':apprComp'] = "";
$parameters[':lcDays'] = "21";
$parameters[':coeDays'] = "30";
$parameters[':notes'] = "";

$stmt = $dbConn->prepare($insertSql);
$stmt->execute($parameters);

$buyerSql = "INSERT INTO transactions (houseId, userId, address, transType, clientName, clientNum, accDay, emdDays,
						 sellerDiscDays, buyerDiscDays, genInspecDays, termiteInspecDays, septicInspecDays, waterInspecDays, 
						 appraisalDays, apprOrdered, apprComp, lcDays, coeDays, notes) 
VALUES (:houseId, :userId, :address, :transType, :clientName, :clientNum, :accDay, :emdDays, :sellerDiscDays, :buyerDiscDays, :genInspecDays, :termiteInspecDays, 
	:septicInspecDays, :waterInspecDays, :appraisalDays, :apprOrdered, :apprComp, :lcDays, :coeDays, :notes)";

$parameters = array();
$parameters[':houseId'] = $houseId;
$parameters[':userId'] = $_SESSION['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Buyer";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = date("y-m-d");
$parameters[':emdDays'] = "3";
$parameters[':sellerDiscDays'] = "7";
$parameters[':buyerDiscDays'] = "17";
$parameters[':genInspecDays'] = "17";
$parameters[':termiteInspecDays'] = "17";
$parameters[':septicInspecDays'] = "17";
$parameters[':waterInspecDays'] = "17";
$parameters[':appraisalDays'] = "17";
$parameters[':apprOrdered'] = "";
$parameters[':apprComp'] = "";
$parameters[':lcDays'] = "21";
$parameters[':coeDays'] = "30";
$parameters[':notes'] = "";

$buyerstmt = $dbConn->prepare($buyerSql);
$buyerstmt->execute($parameters);


$agentEmailSql = "SELECT firstName, lastName, email FROM UsersInfo WHERE userId = :userId";
$stmt = $dbConn->prepare($agentEmailSql);
$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];
$stmt->execute($namedParameters);
$result = $stmt->fetch();

$mail = new PHPMailer;
$mail->setFrom($result['email'], $result['firstName'] . " " . $result['lastName']);
$mail->addAddress("jodiaz@csumb.edu");
$mail->Subject  =  $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'] . " placed in-contract";
$mail->Body     = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'] . " placed in-contract";
if(!$mail->send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent.';
}

$twilio_phone_number = "+18315851661";
$client = new Client($sid, $token);
$client->messages->create(
    "8312934153",
    array(
        "From" => $twilio_phone_number,
        "Body" => $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'] . " placed in-contract",
    )
);

?>