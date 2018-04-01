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
	$dateSql = "UPDATE transactions SET  genInspecComp = :genInspecComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':genInspecComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "appr") 
{
	$dateSql = "UPDATE transactions SET  apprComp = :apprComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':apprComp'] = $date;
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


else if($type == "recieved")
{
	$dateSql = "UPDATE transactions SET  sellerDiscRec = :sellerDiscRec WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':sellerDiscRec'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "signed")
{
	$dateSql = "UPDATE transactions SET  signedDiscComp = :signedDiscComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':signedDiscComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if($type == "miscOne")
{
	$dateSql = "UPDATE transactions SET  miscOneComp = :miscOneComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':miscOneComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if($type == "miscTwo")
{
	$dateSql = "UPDATE transactions SET  miscTwoComp = :miscTwoComp WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':miscTwoComp'] = $date;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
?>