<?php
session_start();
require 'databaseConnection.php';
$dbConn = getConnection();


$sql = "UPDATE transactions SET address = :address WHERE transId = :transId";
$namedParameters = array();
$namedParameters[":address"] = $_POST['newData'];
$namedParameters[":transId"] = $_POST['id'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);


?>