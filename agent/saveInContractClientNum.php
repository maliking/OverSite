<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "UPDATE transactions SET clientNum = :clientNum WHERE transId = :transId";
$namedParameters = array();
$namedParameters[":clientNum"] = $_POST['clientNum'];
$namedParameters[":transId"] = $_POST['transId'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>