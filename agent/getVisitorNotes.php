<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT * FROM visitorNotes WHERE buyerId = :buyerId AND houseId = :houseId";
$namedParameters = array();
$namedParameters[":buyerId"] = $_POST['buyerId'];
$namedParameters[":houseId"] = $_POST['houseId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

echo json_encode($results);

?>