<?php

$license = $_GET['license'];

require("databaseConnection.php");  
$dbConn = getConnection();
if(!isset($_SESSION['userId'])) 
{
    header("Location: index.html?error=wrong username or password");
} 

$sql = "SELECT TYGross, FYGross FROM UsersInfo WHERE license = '".$license."'";
$stmt = $dbConn -> prepare($sql);
$stmt->execute();
$userResults = $stmt->fetch();

echo json_encode($userResults);
?>