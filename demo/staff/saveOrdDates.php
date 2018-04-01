<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();


$transId = $_POST['transId'];

$type = $_POST['type'];
if($date != "NULL")
{
	$date = date_create($_POST['date']);
	$date = date_format($date, 'Y-m-d');
}
else
	$date = NULL;

if($type == "emd") 
{
	$dateSql = "UPDATE transactions SET  emdComp = :emdComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':emdComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "seller") 
{
	$dateSql = "UPDATE transactions SET  sellerDiscComp = :sellerDiscComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':sellerDiscComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
		
}
else if($type == "generalInspec") 
{
	$dateSql = "UPDATE transactions SET  genInspecOrd = :genInspecOrd WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':genInspecOrd'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "appr") 
{
	$dateSql = "UPDATE transactions SET  apprOrdered = :apprOrdered WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':apprOrdered'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "lc") 
{
	$dateSql = "UPDATE transactions SET  lcComp = :lcComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':lcComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "coe") 
{
	$dateSql = "UPDATE transactions SET  coeComp = :coeComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':coeComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

?>