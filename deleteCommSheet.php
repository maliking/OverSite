<?php
session_start();
date_default_timezone_set('America/Los_Angeles');
require 'databaseConnection.php';
$dbConn = getConnection();

$delCommSheetSql = "DELETE FROM commInfo WHERE commId = :commId";
$deleteParam = array();
$deleteParam[':commId'] = $_POST['commId'];
$delCommStmt = $dbConn->prepare($delCommSheetSql);
$delCommStmt->execute($deleteParam);


?>