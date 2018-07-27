<?php

session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT UsersInfo.firstName, UsersInfo.lastName, COUNT(commInfo.license) as closedUnits, commInfo.license, 
        SUM(commInfo.finalHousePrice) as volSold, SUM(commInfo.InitialGross) as GCI, AVG(commInfo.percentage) as avgPercent 
        FROM UsersInfo LEFT JOIN commInfo ON UsersInfo.license = commInfo.license WHERE UsersInfo.userType != '0' AND YEAR(commInfo.settlementDate) = YEAR(CURDATE()) 
        AND MONTH(commInfo.settlementDate) >= :startMonth AND MONTH(commInfo.settlementDate) <= :endMonth GROUP BY commInfo.license
        ORDER BY closedUnits DESC";
$namedParameters = array();
$namedParameters[':startMonth'] = $_GET['startMonth'];
$namedParameters[':endMonth'] = $_GET['endMonth'];        
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

$data = array();

$rankCount = 1;

foreach ($results as $row) 
{
	$myObj = new row();
	$myObj->rank = $rankCount;
	$myObj->name = $row['firstName'] . " " . $row['lastName'];
	$myObj->closedUnits = $row['closedUnits'];
	$myObj->volSold = "$" . number_format($row['volSold'], 2, ".", ",");
	$myObj->gci = "$" . number_format($row['GCI'],2 , ".", ",");
	$myObj->avgPercent = number_format($row['avgPercent'],2);

	$rankCount++;

	array_push($data,$myObj);
}

$myJSON = json_encode($data);

echo $myJSON;

class row
{
	var $rank;
	var $name;
	var $closedUnits;
	var $volSold;
	var $gci;
	var $avgPercent;
}

?>