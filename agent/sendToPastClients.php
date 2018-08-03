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

$addFinalHousePriceSql = "UPDATE pastClients SET finalHousePrice = :finalHousePrice WHERE pastClientId = :pastClientId";
$finalHousePriceParam = array();
$finalHousePriceParam[':finalHousePrice'] = $_POST['finalHousePrice'];
$finalHousePriceParam[':pastClientId'] = $lastPastClientId;
$finalHousePriceStmt = $dbConn->prepare($addFinalHousePriceSql);
$finalHousePriceStmt->execute($finalHousePriceParam);

?>