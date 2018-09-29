<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "name")
{
	$sql = "UPDATE transactions SET clientTwoName = :clientTwoName WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":clientTwoName"] = $_POST['clientTwoName'];
	$namedParameters[":transId"] = $_POST['transId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "number")
{
	$sql = "UPDATE transactions SET clientTwoNum = :clientTwoNum WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":clientTwoNum"] = $_POST['clientTwoNum'];
	$namedParameters[":transId"] = $_POST['transId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "email")
{
	$sql = "UPDATE transactions SET clientTwoEmail = :clientTwoEmail WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":clientTwoEmail"] = $_POST['clientTwoEmail'];
	$namedParameters[":transId"] = $_POST['transId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "coAgentName")
{
	$sql = "UPDATE transactions SET coAgent = :coAgent WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[":coAgent"] = $_POST['coAgentName'];
	$namedParameters[":transId"] = $_POST['transId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

?>