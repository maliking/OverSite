<?php
session_start();
date_default_timezone_set('America/Los_Angeles');

require '../databaseConnection.php';
$dbConn = getConnection();

$favoriteSql = "UPDATE favorites SET lastContacted = :lastContacted WHERE favoriteId = :favoriteId";

$favoriteParameters = array();
$favoriteParameters[':favoriteId'] = $_POST['id'];
$favoriteParameters[':lastContacted'] = date("Y/m/d");
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);



?>