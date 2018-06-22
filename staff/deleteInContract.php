<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "DELETE FROM transactions 
                 WHERE transId = " . $_POST['inContractId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute();

?>