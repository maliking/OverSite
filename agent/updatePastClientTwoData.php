<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "name")
{
	$sql = "UPDATE pastClients SET secondName = :secondName WHERE pastClientId = :clientPastId";
	$namedParameters = array();
	$namedParameters[":secondName"] = $_POST['clientTwoName'];
	$namedParameters[":clientPastId"] = $_POST['clientPastId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "number")
{
	$sql = "UPDATE pastClients SET secondNumber = :secondNumber WHERE pastClientId = :clientPastId";
	$namedParameters = array();
	$namedParameters[":secondNumber"] = $_POST['clientTwoNum'];
	$namedParameters[":clientPastId"] = $_POST['clientPastId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "email")
{
	$sql = "UPDATE pastClients SET secondEmail = :secondEmail WHERE pastClientId = :clientPastId";
	$namedParameters = array();
	$namedParameters[":secondEmail"] = $_POST['clientTwoEmail'];
	$namedParameters[":clientPastId"] = $_POST['clientPastId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}



?>