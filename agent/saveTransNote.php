<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "UPDATE transactions SET notes = :note WHERE transId = :transId";
$namedParameters = array();
$namedParameters[":note"] = $_POST['note'];
$namedParameters[":transId"] = $_POST['transId'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>