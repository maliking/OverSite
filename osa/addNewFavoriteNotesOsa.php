<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

// $favoriteSql = "UPDATE favorites SET note = :note WHERE favoriteId = :favoriteId";

// $favoriteParameters = array();
// $favoriteParameters[':favoriteId'] = $_POST['favoriteId'];
// $favoriteParameters[':note'] = $_POST['note'];
// $favoriteStmt = $dbConn->prepare($favoriteSql);
// $favoriteStmt->execute($favoriteParameters);

$sql = "INSERT INTO favoritesNotesOsa (favoriteId, userId, noteDate, note)
VALUES (:favoriteId, :userId, :noteDate, :note)";
$namedParameters = array();
$namedParameters[":favoriteId"] = $_POST['favoriteId'];
$namedParameters[":userId"] = $_SESSION['userId'];
$namedParameters[":noteDate"] = date("Y-m-d H:i:s");
$namedParameters[":note"] = $_POST['note'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>