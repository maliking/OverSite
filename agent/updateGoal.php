<?php
session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$updateAgentGoal = "UPDATE UsersInfo SET goal = :newGoal WHERE userId = :userId";

$goalParameters = array();
$goalParameters[':userId'] = $_SESSION['userId'];
$goalParameters[':newGoal'] = $_POST['newGoal'];

$goalStmt = $dbConn->prepare($updateAgentGoal);
$goalStmt->execute($goalParameters);



?>