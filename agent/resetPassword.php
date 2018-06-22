<?php
session_start();
require '../databaseConnection.php';

$dbConn = getConnection();

$sql = "UPDATE UsersInfo SET password = :password WHERE license = :license AND userType = 1";

$namedParameters = array();
$namedParameters[":password"] = sha1($_POST['newPassword']);
$namedParameters[":license"] = $_SESSION['license'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>