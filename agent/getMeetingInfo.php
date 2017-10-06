<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$meetingInfo = "SELECT * FROM BuyerInfo WHERE meeting = :id";

$namedParameters = array();
$namedParameters[':id'] = $_POST['id'];

$meetingStmt = $dbConn->prepare($meetingInfo);
$meetingStmt->execute($namedParameters);
$meetingResults = $meetingStmt->fetch();

echo json_encode($meetingResults);

?>