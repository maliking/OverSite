<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT * FROM inContractNotes WHERE transId = :transId AND userId = :userId";
$namedParameters = array();
$namedParameters[":transId"] = $_POST['transId'];
$namedParameters[":userId"] = $_SESSION['userId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

echo json_encode($results);

?>