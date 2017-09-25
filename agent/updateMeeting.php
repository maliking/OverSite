<?php

session_start();

require '../databaseConnection.php';
$dbConn = getConnection();

$sqlLicense = "UPDATE BuyerInfo SET meeting = :meeting WHERE ";

$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];


$licenseStmt = $dbConn->prepare($sqlLicense);
$licenseStmt->execute($namedParameters);
$licenseResult = $licenseStmt->fetch();
?>
