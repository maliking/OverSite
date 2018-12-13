<?php

session_start();
require 'databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT * FROM UsersInfo WHERE userId = :userId";
$namedParameters = array();
$namedParameters[":userId"] = $_SESSION['userId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

echo json_encode($results);

?>