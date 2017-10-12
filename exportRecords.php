<?php

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=spreadsheet.xls");

require 'databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT license, firstName, lastName, MAX(TYGross) as commissionAmount, count(*) as sold, SUM(finalHousePrice) as listingAmount FROM commInfo GROUP BY license";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();


$lastDayThisMonth = date("m-t-Y");


echo 'OfficeId' . "\t" . 'AssociateId' . "\t" . 'StatisticsDate' . "\t" . 'StatisticsType' . "\t" . 'Currency' . "\t" .
    'CommissionAmount' . "\t" . 'Listing' . "\t" . 'ListingAmount' . "\t" . 'Sale' . "\t" . 'SaleAmount' . "\t" . 'TeamID' . "\t" . 'AgentFunction' . "\t" .
    'PropertyType' . "\t" . 'PropertyStatus' . "\t" . 'CloseDate' . "\t" . 'LeadSource' . "\t" . 'SellerName' . "\t" . 'BuyerName' . "\t" .
    'Address' . "\t" . 'City' . "\t" . 'State' . "\t" . 'PostalCode' . "\t" . 'CountryCode' . "\t" . 'MLS' . "\t" . 'MLSID' . "\t" . 'TransactionID' . "\t" .
    'TeamLeaderID' . "\t" . 'EffectiveDate' . "\n";


echo 'Needed' . "\t" . 'needed per agent' . "\t" . $lastDayThisMonth . "\t" . 'RES' . "\t" . 'USD' . "\t" . number_format($result[1]['commissionAmount'], 2) . "\t" . $result[1]['sold'] .
    "\t" . number_format($result[1]['listingAmount'], 2) . "\t" . '3' . "\t" . '400000' . "\t" . 'optional' . "\t" . 'BOTH' . "\t" . 'SINGLE_FAMILY_HOME' . "\t" . 'CLOSED' . "\t" .
    $lastDayThisMonth . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . '915 A N. Main Street' . "\t" . 'SALINAS' . "\t" . 'CA' . "\t" . '93906' . "\t" .
    'USA' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\n";

echo 'Needed' . "\t" . 'needed per agent' . "\t" . $lastDayThisMonth . "\t" . 'COMM' . "\t" . 'USD' . "\t" . '0' . "\t" . '0' .
    "\t" . '0' . "\t" . '0' . "\t" . '0' . "\t" . 'optional' . "\t" . 'BOTH' . "\t" . 'SINGLE_FAMILY_HOME' . "\t" . 'CLOSED' . "\t" .
    $lastDayThisMonth . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . '915 A N. Main Street' . "\t" . 'SALINAS' . "\t" . 'CA' . "\t" . '93906' . "\t" .
    'USA' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT' . "\t" . 'OPT';
?>

