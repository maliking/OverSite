<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();


$transId = $_POST['transId'];

$type = $_POST['type'];
$name = $_POST['name'];

if ($type == "miscOne")
{
	$dateSql = "UPDATE transactions SET  miscOneName = :miscOneName WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$namedParameters[':miscOneName'] = $name;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if ($type == "miscTwo")
{
	$dateSql = "UPDATE transactions SET  miscTwoName = :miscTwoName WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$namedParameters[':miscTwoName'] = $name;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

?>