<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

$settingSql = "SELECT * FROM settings WHERE userId = :userId";
$settingParam = array();
$settingParam[':userId'] = $_SESSION['userId'];
$settingStmt = $dbConn->prepare($settingSql);
$settingStmt->execute($settingParam);
$settingResult = $settingStmt->fetch();

echo json_encode($settingResult);

?>