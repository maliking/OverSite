<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT * FROM favoritesNotes WHERE favoriteID = :favoriteId AND userId = :userId";
$namedParameters = array();
$namedParameters[":favoriteId"] = $_POST['favoriteId'];
$namedParameters[":userId"] = $_SESSION['userId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

echo json_encode($results);

?>