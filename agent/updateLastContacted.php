<?php
session_start();
date_default_timezone_set('America/Los_Angeles');

require '../databaseConnection.php';
$dbConn = getConnection();

$favoriteSql = "UPDATE favorites SET lastContacted = :lastContacted, note = :note WHERE favoriteId = :favoriteId";

$favoriteParameters = array();
$favoriteParameters[':favoriteId'] = $_POST['id'];
$favoriteParameters[':note'] = $_POST['note'];
$favoriteParameters[':lastContacted'] = date("Y-m-d H:i:s");
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);

$sql = "INSERT INTO favoritesNotes (favoriteId, userId, noteDate, note)
VALUES (:favoriteId, :userId, :noteDate, :note)";
$namedParameters = array();
$namedParameters[":favoriteId"] = $_POST['id'];
$namedParameters[":userId"] = $_SESSION['userId'];
$namedParameters[":noteDate"] = date("Y-m-d H:i:s");
$namedParameters[":note"] = $_POST['note'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>