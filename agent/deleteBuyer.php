<?php
session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "DELETE FROM BuyerInfo 
                 WHERE buyerID = " . $_GET['buyerID'];

$stmt = $dbConn->prepare($sql);
$stmt->execute();


?>