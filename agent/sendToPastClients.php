<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

$pastClientSql = "INSERT INTO pastClients (userId, buyerId, firstName, email, phone) 
				  SELECT userId, transId, clientName, clientEmail, clientNum FROM transactions WHERE transId = :transId";
$param = array();
$param[':transId'] = $_POST['transId'];
$pastClientStmt = $dbConn->prepare($pastClientSql);
$pastClientStmt->execute($param);
?>