<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();


$transId = $_POST['transId'];

$type = $_POST['type'];
$date = $_POST['date'];

if($type == "emd") 
{
	$dateSql = "UPDATE transactions SET  emdDays = :emdDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':emdDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "seller") 
{
	$dateSql = "UPDATE transactions SET  sellerDiscDays = :sellerDiscDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':sellerDiscDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
		
}
else if($type == "generalInspec") 
{
	$dateSql = "UPDATE transactions SET  genInspecDays = :genInspecDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':genInspecDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "appr") 
{
	$dateSql = "UPDATE transactions SET  appraisalDays = :appraisalDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':appraisalDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "lc") 
{
	$dateSql = "UPDATE transactions SET  lcDays = :lcDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':lcDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "coe") 
{
	$dateSql = "UPDATE transactions SET  coeDays = :coeDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':coeDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if($type == "miscOne")
{
	$dateSql = "UPDATE transactions SET  miscOneDays = :miscOneDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':miscOneDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "miscTwo")
{
	$dateSql = "UPDATE transactions SET  miscTwoDays = :miscTwoDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':miscTwoDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if($type == "signed")
{
	$dateSql = "UPDATE transactions SET  signedDiscDays = :signedDiscDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':signedDiscDays'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

?>