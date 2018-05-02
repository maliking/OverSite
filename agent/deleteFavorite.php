<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();

$deleteFavoriteSql = "DELETE FROM favorites WHERE favoriteId = :favoriteId";
$deleteParameters = array();
$deleteParameters[':favoriteId'] = $_POST['favoriteId'];
$deleteStmt = $dbConn->prepare($deleteFavoriteSql);
$deleteStmt->execute($deleteParameters);

?>