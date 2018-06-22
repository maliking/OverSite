<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "DELETE FROM HouseInfo 
                 WHERE houseId = " . $_POST['listingId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute();


?>