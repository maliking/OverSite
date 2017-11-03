<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM  UsersInfo WHERE userType = '1' AND userId != :userId";
$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt->fetchAll();

echo json_encode($result);
?>