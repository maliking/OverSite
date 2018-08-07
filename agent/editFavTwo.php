<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();


$sql = "UPDATE favorites SET " . $_POST['column'] . " = :type WHERE favoriteId = :favoriteId";
$editParameters = array();
$editParameters[':type'] = $_POST['newData'];
$editParameters[':favoriteId'] = $_POST['favoriteId'];
$editStmt = $dbConn->prepare($sql);
$editStmt->execute($editParameters);




?>