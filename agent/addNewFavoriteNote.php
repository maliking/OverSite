<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "INSERT INTO favoritesNotes (favoriteId, userId, noteDate, note)
VALUES (:favoriteId, :userId, :noteDate, :note)";
$namedParameters = array();
$namedParameters[":favoriteId"] = $_POST['favoriteId'];
$namedParameters[":userId"] = $_SESSION['userId'];
$namedParameters[":noteDate"] = date("Y/m/d");
$namedParameters[":note"] = $_POST['note'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>