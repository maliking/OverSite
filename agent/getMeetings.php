<?php

// SELECT * FROM `BuyerInfo` WHERE `meeting` = "0000-00-00 00:00:00"   Select all that dont have meeting time or date

// SELECT * FROM `BuyerInfo` WHERE MONTH(`registeredDate`) = 9     Select all from current month

// date("d-M-Y", strtotime("next monday")); gets next monday

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$monthMeetings = "SELECT CONCAT(firstName, ',', lastName) as title , DATE_FORMAT(meeting, '%Y-%m-%dT%H:%i:%s') as start, ADDTIME(meeting, '00:15:00') as end FROM BuyerInfo WHERE MONTH(registeredDate) >=:registeredDate";

$namedParameters = array();
$namedParameters[':registeredDate'] = date('m');

$meetingStmt = $dbConn->prepare($monthMeetings);
$meetingStmt->execute($namedParameters);
$meetingResults = $meetingStmt->fetchAll();

echo json_encode($meetingResults);

?>