<?php
session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "DELETE FROM BuyerInfo 
                 WHERE buyerID = " . $_POST['buyerID'];

$stmt = $dbConn->prepare($sql);
$stmt->execute();


?>