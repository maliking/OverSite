<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM  UsersInfo WHERE userType = '1' AND license != :license";
$namedParameters = array();
$namedParameters[':license'] = $_SESSION['license'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt->fetchAll();

echo json_encode($result);
?>