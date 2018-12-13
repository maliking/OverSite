<?php

session_start();
require 'databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT phone FROM transactions LEFT JOIN UsersInfo ON UsersInfo.userId = transactions.userId WHERE transactions.transId = :transId";
$namedParameters = array();
$namedParameters[":transId"] = $_POST['transId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetch();

echo json_encode($results);

?>