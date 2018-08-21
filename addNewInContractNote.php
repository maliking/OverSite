<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require 'databaseConnection.php';
$dbConn = getConnection();

$favoriteSql = "UPDATE transactions SET notes = :notes WHERE transId = :transId";

$favoriteParameters = array();
$favoriteParameters[':transId'] = $_POST['transId'];
$favoriteParameters[':notes'] = $_POST['note'];
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);

$sql = "INSERT INTO inContractNotes (transId, userId, noteDate, note)
VALUES (:transId, :userId, :noteDate, :note)";
$namedParameters = array();
$namedParameters[":transId"] = $_POST['transId'];
$namedParameters[":userId"] = $_SESSION['userId'];
$namedParameters[":noteDate"] = date("Y-m-d H:i:s");
$namedParameters[":note"] = $_POST['note'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>