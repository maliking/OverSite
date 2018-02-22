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

$threeDay = dateVerify(3);
$sevenDay = dateVerify(7);
$sevenTeenDay =dateVerify(17);
$twentyOneDay = dateVerify(21);
$thirtyDay = dateVerify(30);

$insertSql = "INSERT INTO transactions(houseId, userId, address, transType, clientName, clientNum, accDay, emdDays,
						 sellerDiscDays, buyerDiscDays, signedDiscDays, genInspecDays, termiteInspecDays, septicInspecDays, waterInspecDays, 
						 appraisalDays, apprOrdered, apprComp, lcDays, coeDays, coeOrgDate, notes) 
VALUES (:houseId, :userId, :address, :transType, :clientName, :clientNum, :accDay, :emdDays, :sellerDiscDays, :buyerDiscDays, :signedDiscDays, :genInspecDays, :termiteInspecDays, 
	:septicInspecDays, :waterInspecDays, :appraisalDays, :apprOrdered, :apprComp, :lcDays, :coeDays, :coeOrgDate, :notes)";

$parameters = array();
$parameters[':houseId'] = $houseId;
$parameters[':userId'] = $_SESSION['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Listing";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = date("y-m-d");
$parameters[':emdDays'] = $threeDay;
$parameters[':sellerDiscDays'] = $sevenDay;
$parameters[':buyerDiscDays'] = $sevenTeenDay;
$parameters[':signedDiscDays'] = $sevenTeenDay;
$parameters[':genInspecDays'] = $sevenTeenDay;
$parameters[':termiteInspecDays'] = $sevenTeenDay;
$parameters[':septicInspecDays'] = $sevenTeenDay;
$parameters[':waterInspecDays'] = $sevenTeenDay;
$parameters[':appraisalDays'] = $sevenTeenDay;
$parameters[':apprOrdered'] = "";
$parameters[':apprComp'] = "";
$parameters[':lcDays'] = $twentyOneDay;
$parameters[':coeDays'] = $thirtyDay;
$parameters[':coeOrgDate'] = date("y-m-d");
$parameters[':notes'] = "";

$stmt = $dbConn->prepare($insertSql);
$stmt->execute($parameters);

$buyerSql = "INSERT INTO transactions (houseId, userId, address, transType, clientName, clientNum, accDay, emdDays,
						 sellerDiscDays, buyerDiscDays, signedDiscDays, genInspecDays, termiteInspecDays, septicInspecDays, waterInspecDays, 
						 appraisalDays, apprOrdered, apprComp, lcDays, coeDays, coeOrgDate, notes) 
VALUES (:houseId, :userId, :address, :transType, :clientName, :clientNum, :accDay, :emdDays, :sellerDiscDays, :buyerDiscDays, :signedDiscDays, :genInspecDays, :termiteInspecDays, 
	:septicInspecDays, :waterInspecDays, :appraisalDays, :apprOrdered, :apprComp, :lcDays, :coeDays, :coeOrgDate, :notes)";

$parameters = array();
$parameters[':houseId'] = $houseId;
$parameters[':userId'] = $_SESSION['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Buyer";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = date("y-m-d");
$parameters[':emdDays'] = $threeDay;
$parameters[':sellerDiscDays'] = $sevenDay;
$parameters[':buyerDiscDays'] = $sevenTeenDay;
$parameters[':signedDiscDays'] = $sevenTeenDay;
$parameters[':genInspecDays'] = $sevenTeenDay;
$parameters[':termiteInspecDays'] = $sevenTeenDay;
$parameters[':septicInspecDays'] = $sevenTeenDay;
$parameters[':waterInspecDays'] = $sevenTeenDay;
$parameters[':appraisalDays'] = $sevenTeenDay;
$parameters[':apprOrdered'] = "";
$parameters[':apprComp'] = "";
$parameters[':lcDays'] = $twentyOneDay;
$parameters[':coeDays'] = $thirtyDay;
$parameters[':coeOrgDate'] = date("y-m-d");
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
        "Body" => $result['firstName'] . " " . $result['lastName'] . " - " .$address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'] . " placed in-contract",
    )
);

function dateVerify($addDays) 
{
	$returnDaysToAdd = $addDays;
    $today = date("Y-m-d");
    $addedDate = date("Y-m-d", strtotime($today . ' + ' . $addDays . ' days' ));

    $holidays = array("2018-01-01", "2018-01-15", "2018-02-19", "2018-05-28", "2018-07-04",
    				 "2018-09-03", "2018-10-08", "2018-11-12", "2018-11-22", "2018-12-25" );

    if(date("l", strtotime($addedDate)) == "Saturday")
	{
	    $addedDate = date("Y-m-d", strtotime($addedDate . ' + 2 days' ));
	    $returnDaysToAdd += 2;
	}
	else if(date("l", strtotime($addedDate)) == "Sunday")
	{
	    $addedDate = date("Y-m-d", strtotime($addedDate . ' + 1 days' ));
	    $returnDaysToAdd += 1;
	}

	foreach($holidays as $holiday)
	{
		if($addedDate == $holiday)
		{
		    $addedDate = date("Y-m-d", strtotime($addedDate . ' + 1 days' ));
		    $returnDaysToAdd += 1;
		     if(date("l", strtotime($addedDate)) == "Saturday")
			{
			    $addedDate = date("Y-m-d", strtotime($addedDate . ' + 2 days' ));
			    $returnDaysToAdd += 2;
			}
			else if(date("l", strtotime($addedDate)) == "Sunday")
			{
			    $addedDate = date("Y-m-d", strtotime($addedDate . ' + 1 days' ));
			    $returnDaysToAdd += 1;
			}

		}
	}

    return $returnDaysToAdd;
}

?>













