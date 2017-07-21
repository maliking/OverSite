<?php

$license = $_GET['license'];

require("databaseConnection.php");  
$dbConn = getConnection();

$sql = "SELECT TYGross, FYGross FROM commInfo WHERE license = '".$license."'";
$stmt = $dbConn -> prepare($sql);
$stmt->execute();
$userResults = $stmt->fetch();

echo json_encode($userResults);
?>