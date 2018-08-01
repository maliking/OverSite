<?php
session_start();

require 'databaseConnection.php';
$dbConn = getConnection();

$updateCommSql = "UPDATE commInfo SET " .$_POST['type'] . " = :value WHERE commId = :commId";
$updateParam = array();
$updateParam[':value'] = (string)$_POST['data'];
$updateParam[':commId'] = (string)$_POST['commId'];

$updateStmt = $dbConn->prepare($updateCommSql);
$updateStmt->execute($updateParam);
?>