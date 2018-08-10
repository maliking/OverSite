<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

if($_POST['column'] == "agentActiveProsTable")
{
	$settingSql = "UPDATE settings SET agentActiveProsTable = :newData WHERE userId = :userId";
	$settingParam = array();
	$settingParam[':newData'] = $_POST['status'];
	$settingParam[':userId'] = $_SESSION['userId'];
	$settingStmt = $dbConn->prepare($settingSql);
	$settingStmt->execute($settingParam);
}
else if($_POST['column'] == "agentInContrTable")
{
	$settingSql = "UPDATE settings SET agentInContrTable = :newData WHERE userId = :userId";
	$settingParam = array();
	$settingParam[':newData'] = $_POST['status'];
	$settingParam[':userId'] = $_SESSION['userId'];
	$settingStmt = $dbConn->prepare($settingSql);
	$settingStmt->execute($settingParam);
}
else if($_POST['column'] == "agentCalendar")
{
	$settingSql = "UPDATE settings SET agentCalendar = :newData WHERE userId = :userId";
	$settingParam = array();
	$settingParam[':newData'] = $_POST['status'];
	$settingParam[':userId'] = $_SESSION['userId'];
	$settingStmt = $dbConn->prepare($settingSql);
	$settingStmt->execute($settingParam);
}


?>
