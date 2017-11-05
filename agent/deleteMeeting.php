<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$deleteMeeting = "UPDATE BuyerInfo SET meeting = :meeting WHERE meeting = :id";

$namedParameters = array();
$namedParameters[':id'] = $_POST['id'];
$namedParameters[':meeting'] = '0000-00-00 00:00:00';

$meetingStmt = $dbConn->prepare($deleteMeeting);
$meetingStmt->execute($namedParameters);


?>