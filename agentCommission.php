<?php
session_start();

$license = $_GET['license'];

require("databaseConnection.php");  
$dbConn = getConnection();

$sql = "SELECT TYGross, FYGross FROM commInfo WHERE license = '".$license."' ORDER BY TYGross DESC";
$stmt = $dbConn -> prepare($sql);
$stmt->execute();
$userResults = $stmt->fetch();

$_SESSION['FYGross'] = $userResults['FYGross'];

echo json_encode($userResults);
?>