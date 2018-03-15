<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require("databaseConnection.php");
$dbConn = getConnection();
$todaysMonth =  date("n");

$paidRemaxFeeSql = "SELECT SUM(paid) as paid FROM remaxFee  LEFT JOIN UsersInfo ON remaxFee.userId = UsersInfo.userId 
					WHERE UsersInfo.license = :license GROUP BY license";
$paidParam = array();
$paidParam[':license'] = $_POST['license'];

$paidStmt = $dbConn->prepare($paidRemaxFeeSql);
$paidStmt->execute($paidParam);
$paidResults = $paidStmt->fetch();

$remaxFeeToPay = (350 * $todaysMonth) - $paidResults['paid'];

$feeArray = array("fee" => $remaxFeeToPay);
echo json_encode($feeArray);

?>