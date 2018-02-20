<?php
date_default_timezone_set('America/Los_Angeles');
require("../databaseConnection.php");

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
						 sellerDiscDays, buyerDiscDays, signedDiscDays, genInspecDays, termiteInspecDays, septicInspecDays, waterInspecDays, 
						 appraisalDays, apprOrdered, apprComp, lcDays, coeDays, coeOrgDate, notes) 
VALUES (:houseId, :userId, :address, :transType, :clientName, :clientNum, :accDay, :emdDays, :sellerDiscDays, :buyerDiscDays, :signedDiscDays, :genInspecDays, :termiteInspecDays, 
	:septicInspecDays, :waterInspecDays, :appraisalDays, :apprOrdered, :apprComp, :lcDays, :coeDays, :coeOrgDate, :notes)";

$parameters = array();
$parameters[':houseId'] = $houseId;
$parameters[':userId'] = $_POST['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Listing";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = $_POST['accDate'];
$parameters[':emdDays'] = "3";
$parameters[':sellerDiscDays'] = "7";
$parameters[':buyerDiscDays'] = "17";
$parameters[':signedDiscDays'] = "17";
$parameters[':genInspecDays'] = "17";
$parameters[':termiteInspecDays'] = "17";
$parameters[':septicInspecDays'] = "17";
$parameters[':waterInspecDays'] = "17";
$parameters[':appraisalDays'] = "17";
$parameters[':apprOrdered'] = "";
$parameters[':apprComp'] = "";
$parameters[':lcDays'] = "21";
$parameters[':coeDays'] = "30";
$parameters[':coeOrgDate'] = $_POST['accDate'];
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
$parameters[':userId'] = $_POST['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Buyer";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = $_POST['accDate'];
$parameters[':emdDays'] = "3";
$parameters[':sellerDiscDays'] = "7";
$parameters[':buyerDiscDays'] = "17";
$parameters[':signedDiscDays'] = "17";
$parameters[':genInspecDays'] = "17";
$parameters[':termiteInspecDays'] = "17";
$parameters[':septicInspecDays'] = "17";
$parameters[':waterInspecDays'] = "17";
$parameters[':appraisalDays'] = "17";
$parameters[':apprOrdered'] = "";
$parameters[':apprComp'] = "";
$parameters[':lcDays'] = "21";
$parameters[':coeDays'] = "30";
$parameters[':coeOrgDate'] = $_POST['accDate'];
$parameters[':notes'] = "";

$buyerstmt = $dbConn->prepare($buyerSql);
$buyerstmt->execute($parameters);



?>