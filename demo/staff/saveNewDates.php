<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();


$transId = $_POST['transId'];

$type = $_POST['type'];
$date = $_POST['date'];
$aprvDay = date_create($_POST['aprvDay']);
if($type == "aprv")
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  accDay = :accDay WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;
	$namedParameters[':accDay'] = date_format($createDate, 'Y-m-d');
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "emd") 
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  emdDays = :emdDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':emdDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "seller") 
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  sellerDiscDays = :sellerDiscDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':sellerDiscDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
		
}
else if($type == "generalInspec") 
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  genInspecDays = :genInspecDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':genInspecDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "appr") 
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  appraisalDays = :appraisalDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':appraisalDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "lc") 
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  lcDays = :lcDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':lcDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if($type == "coe") 
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  coeDays = :coeDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':coeDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if ($type == "miscOne")
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  miscOneDays = :miscOneDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':miscOneDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}
else if ($type == "miscTwo")
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  miscTwoDays = :miscTwoDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':miscTwoDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else if($type == "signed")
{
	$createDate = date_create($date);
	$dateSql = "UPDATE transactions SET  signedDiscDays = :signedDiscDays WHERE transId = :transId";
	$namedParameters = array();
	$namedParameters[':transId'] = $transId;

	$diff  = date_diff($aprvDay, $createDate);
	$namedParameters[':signedDiscDays'] = $diff->days;
	$dateStmt = $dbConn->prepare($dateSql);
	$dateStmt->execute($namedParameters);
}

else
{}
//01-01-2018
// $aprvDay =  date_create($_POST['aprvDay'] );
// $emdDay =   date_create($_POST['emdDay']  );
// $sellDay =  date_create($_POST['sellDay'] );
// $genDay =   date_create($_POST['genDay']  );
// $apprvDay = date_create($_POST['apprvDay']);
// $lcDay =    date_create($_POST['lcDay']   );
// $coeDay =   date_create($_POST['coeDay']  );

// $dateSql = "UPDATE transactions SET  accDay = :accDay, emdDays = :emdDays, sellerDiscDays = :sellerDiscDays, genInspecDays = :genInspecDays,
// 									 appraisalDays = :appraisalDays, lcDays = :lcDays, coeDays = :coeDays WHERE transId = :transId";
// $namedParameters = array();
// $namedParameters[':transId'] = $transId;
// $namedParameters[':accDay'] = date_format($aprvDay, 'Y-m-d');

// $diff  = date_diff($aprvDay, $emdDay);
// $namedParameters[':emdDays'] = $diff->days;

// $diff  = date_diff($aprvDay, $sellDay);
// $namedParameters[':sellerDiscDays'] = $diff->days;

// $diff  = date_diff($aprvDay, $genDay);
// $namedParameters[':genInspecDays'] = $diff->days;

// $diff  = date_diff($aprvDay, $apprvDay);
// $namedParameters[':appraisalDays'] = $diff->days;

// $diff  = date_diff($aprvDay, $lcDay);
// $namedParameters[':lcDays'] = $diff->days;

// $diff  = date_diff($aprvDay, $coeDay);
// $namedParameters[':coeDays'] = $diff->days;

// $dateStmt = $dbConn->prepare($dateSql);
// $dateStmt->execute($namedParameters);
?>