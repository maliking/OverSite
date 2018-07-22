<?php
session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "Name")
{
	$sql = "UPDATE transactions SET agentName = :agentName WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":agentName"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Num")
{
	$sql = "UPDATE transactions SET agentNum = :agentNum WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":agentNum"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}
else if($_POST['type'] == "Email")
{
	$sql = "UPDATE transactions SET agentEmail = :agentEmail WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":agentEmail"] = $_POST['newData'];
	$namedParameters[":transId"] = $_POST['id'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

?>