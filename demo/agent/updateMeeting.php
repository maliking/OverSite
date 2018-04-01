<?php

session_start();

require '../databaseConnection.php';
$dbConn = getConnection();

$sqlLicense = "UPDATE BuyerInfo SET meeting = :newMeeting WHERE meeting = :id";

$namedParameters = array();
$namedParameters[':newMeeting'] = $_POST['start'];
$namedParameters[':id'] = $_POST['id'];

$licenseStmt = $dbConn->prepare($sqlLicense);
$licenseStmt->execute($namedParameters);
?>
