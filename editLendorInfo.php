<?php
session_start();
require 'databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "Name")
{
	$sql = "UPDATE transactions SET lendorName = :lendorName WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":lendorName"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Num")
{
	$sql = "UPDATE transactions SET lendorNum = :lendorNum WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":lendorNum"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Email")
{
	$sql = "UPDATE transactions SET lendorEmail = :lendorEmail WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":lendorEmail"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

?>