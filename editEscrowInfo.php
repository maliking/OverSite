<?php
session_start();
require 'databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "Name")
{
	$sql = "UPDATE transactions SET escrowName = :escrowName WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":escrowName"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Num")
{
	$sql = "UPDATE transactions SET escrowNum = :escrowNum WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":escrowNum"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Email")
{
	$sql = "UPDATE transactions SET escrowEmail = :escrowEmail WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":escrowEmail"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

?>