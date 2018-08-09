<?php
session_start();
date_default_timezone_set('America/Los_Angeles');


require '../databaseConnection.php';

$dbConn = getConnection();

$sqlMlsId = "UPDATE pastClients SET junk = :junk WHERE pastClientId = :pastClientId ";

$namedParameters = array();
$namedParameters[':junk'] = "junk";
$namedParameters[':pastClientId'] = $_POST['pastClientId'];


$mlsIdStmt = $dbConn->prepare($sqlMlsId);
$mlsIdStmt->execute($namedParameters);

?>