<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "UPDATE BuyerInfo SET note = :note WHERE meeting = :id";
$namedParameters = array();
$namedParameters[":note"] = $_POST['note'];
$namedParameters[":id"] = $_POST['id'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
?>