<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

$pastClientSql = "INSERT INTO pastClients (userId, buyerId, firstName, email, phone, dateClosed, address) 
				  SELECT userId, transId, clientName, clientEmail, clientNum, coeComp, address FROM transactions WHERE transId = :transId";
$param = array();
$param[':transId'] = $_POST['transId'];
$pastClientStmt = $dbConn->prepare($pastClientSql);
$pastClientStmt->execute($param);

$lastPastClientId = $dbConn->lastInsertId();

$addFinalHousePriceSql = "UPDATE pastClients SET finalHousePrice = :finalHousePrice, listingType = :listingType WHERE pastClientId = :pastClientId";
$finalHousePriceParam = array();
$finalHousePriceParam[':finalHousePrice'] = $_POST['finalHousePrice'];
$finalHousePriceParam[':listingType'] = $_POST['listingType'];
$finalHousePriceParam[':pastClientId'] = $lastPastClientId;
$finalHousePriceStmt = $dbConn->prepare($addFinalHousePriceSql);
$finalHousePriceStmt->execute($finalHousePriceParam);

if($_POST['delClient'] == "yes")
{
	$deleteSql = "UPDATE transactions SET junk = \"junk\" WHERE transId = :transId";
	$deleteParam = array();
	$deleteParam[':transId'] = $_POST['transId'];
	$deleteStmt = $dbConn->prepare($deleteSql);
	$deleteStmt->execute($deleteParam);

}
?>