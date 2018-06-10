<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();

$junkSql = "UPDATE BuyerInfo SET junk = 'yes' WHERE buyerID = :buyerId";
$junkParam = array();
$junkParam[':buyerId'] = $_POST['buyerId'];
$junkStmt = $dbConn->prepare($junkSql);
$junkStmt->execute($junkParam);

?>