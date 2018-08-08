<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

$favoriteSql = "UPDATE BuyerInfo SET note = :note WHERE buyerId = :buyerId AND houseId = :houseId";

$favoriteParameters = array();
$favoriteParameters[':buyerId'] = $_POST['buyerId'];
$favoriteParameters[':houseId'] = $_POST['houseId'];
$favoriteParameters[':note'] = $_POST['note'];
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);

$sql = "INSERT INTO visitorNotes (buyerId, houseId, noteDate, note)
VALUES (:buyerId, :houseId, :noteDate, :note)";
$namedParameters = array();
$namedParameters[":buyerId"] = $_POST['buyerId'];
$namedParameters[":houseId"] = $_POST['houseId'];
$namedParameters[":noteDate"] = date("Y-m-d H:i:s");
$namedParameters[":note"] = $_POST['note'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>