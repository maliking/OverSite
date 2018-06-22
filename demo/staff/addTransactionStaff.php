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
$parameters[':userId'] = $_POST['userId'];
$parameters[':address'] = $address['address'] . " " . $address['city'] . " ," . $address['state'] . " " . $address['zip'];
$parameters[':transType'] = "Listing";
$parameters[':clientName'] = "NA";
$parameters[':clientNum'] = "NA";
$parameters[':accDay'] = $_POST['accDate'];
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
$parameters[':coeOrgDate'] = $_POST['accDate'];
$parameters[':notes'] = "";

$buyerstmt = $dbConn->prepare($buyerSql);
$buyerstmt->execute($parameters);

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