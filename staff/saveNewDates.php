<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();


$transId = $_POST['transId'];

//01-01-2018
$aprvDay =  date_create($_POST['aprvDay'] );
$emdDay =   date_create($_POST['emdDay']  );
$sellDay =  date_create($_POST['sellDay'] );
$genDay =   date_create($_POST['genDay']  );
$apprvDay = date_create($_POST['apprvDay']);
$lcDay =    date_create($_POST['lcDay']   );
$coeDay =   date_create($_POST['coeDay']  );

$dateSql = "UPDATE transactions SET  accDay = :accDay, emdDays = :emdDays, sellerDiscDays = :sellerDiscDays, genInspecDays = :genInspecDays,
									 appraisalDays = :appraisalDays, lcDays = :lcDays, coeDays = :coeDays WHERE transId = :transId";
$namedParameters = array();
$namedParameters[':transId'] = $transId;
$namedParameters[':accDay'] = date_format($aprvDay, 'Y-m-d');

$diff  = date_diff($aprvDay, $emdDay);
$namedParameters[':emdDays'] = $diff->days;

$diff  = date_diff($aprvDay, $sellDay);
$namedParameters[':sellerDiscDays'] = $diff->days;

$diff  = date_diff($aprvDay, $genDay);
$namedParameters[':genInspecDays'] = $diff->days;

$diff  = date_diff($aprvDay, $apprvDay);
$namedParameters[':appraisalDays'] = $diff->days;

$diff  = date_diff($aprvDay, $lcDay);
$namedParameters[':lcDays'] = $diff->days;

$diff  = date_diff($aprvDay, $coeDay);
$namedParameters[':coeDays'] = $diff->days;

$dateStmt = $dbConn->prepare($dateSql);
$dateStmt->execute($namedParameters);
?>