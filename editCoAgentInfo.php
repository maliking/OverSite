<?php
session_start();
require 'databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "Name")
{
	$sql = "UPDATE transactions SET coAgent = :coAgent WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":coAgent"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Num")
{
	$sql = "UPDATE transactions SET coAgentNum = :coAgentNum WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":coAgentNum"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Email")
{
	$sql = "UPDATE transactions SET coAgentEmail = :coAgentEmail WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":coAgentEmail"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

?>