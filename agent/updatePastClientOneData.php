<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

if($_POST['type'] == "name")
{
	$sql = "UPDATE pastClients SET firstName = :firstName WHERE pastClientId = :clientPastId";
	$namedParameters = array();
	$namedParameters[":firstName"] = $_POST['clientName'];
	$namedParameters[":clientPastId"] = $_POST['clientPastId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "number")
{
	$sql = "UPDATE pastClients SET phone = :phone WHERE pastClientId = :clientPastId";
	$namedParameters = array();
	$namedParameters[":phone"] = $_POST['clientNum'];
	$namedParameters[":clientPastId"] = $_POST['clientPastId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}

else if($_POST['type'] == "email")
{
	$sql = "UPDATE pastClients SET email = :email WHERE pastClientId = :clientPastId";
	$namedParameters = array();
	$namedParameters[":email"] = $_POST['clientEmail'];
	$namedParameters[":clientPastId"] = $_POST['clientPastId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($namedParameters);
}



?>