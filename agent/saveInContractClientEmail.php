<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "UPDATE transactions SET clientEmail = :clientEmail WHERE transId = :transId";
$namedParameters = array();
$namedParameters[":clientEmail"] = $_POST['clientEmail'];
$namedParameters[":transId"] = $_POST['transId'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>