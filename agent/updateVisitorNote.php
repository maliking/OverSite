<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();


$sql = "UPDATE visitorNotes SET note = :note, noteDate = :noteDate WHERE visitorId = :visitorId";
$namedParameters = array();
$namedParameters[":visitorId"] = $_POST['visitorId'];
$namedParameters[":noteDate"] = date("Y-m-d H:i:s");
$namedParameters[":note"] = $_POST['note'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>