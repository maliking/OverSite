<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require 'databaseConnection.php';

$dbConn = getConnection();

if($_POST['holdStatus'] == "")
{
	$sql = "UPDATE transactions SET holdStatus = :holdStatus WHERE transId = :transId";
	$param = array();
	$param['holdStatus'] = "hold";
	$param['transId'] = $_POST['transId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($param);
}
else if($_POST['holdStatus'] == "hold")
{
	$sql = "UPDATE transactions SET holdStatus = :holdStatus, accDay = :accDay WHERE transId = :transId";
	$param = array();
	$param['holdStatus'] = "";
	$param['accDay'] = date("Y-m-d");
	$param['transId'] = $_POST['transId'];
	$stmt = $dbConn->prepare($sql);
	$stmt->execute($param);
}




?>