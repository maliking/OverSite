<?php

session_start();
require '../../databaseConnection.php';
$dbConn = getConnection();

$sql = "UPDATE BuyerInfo SET note = :note WHERE houseId = :houseId AND buyerID = :buyerID";
$namedParameters = array();
$namedParameters[":note"] = $_POST['note'];
$namedParameters[":houseId"] = $_POST['houseId'];
$namedParameters[":buyerID"] = $_POST['buyerID'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
?>