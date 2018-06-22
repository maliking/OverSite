<?php
session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "UPDATE transactions SET clientName = :clientName WHERE transId = :transId";
$namedParameters = array();
$namedParameters[":clientName"] = $_POST['clientName'];
$namedParameters[":transId"] = $_POST['transId'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
?>