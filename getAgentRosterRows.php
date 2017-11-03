<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM  UsersInfo WHERE userType = 1 AND userId != :userId";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

echo json_encode($result);
?>