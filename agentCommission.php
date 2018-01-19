<?php
session_start();

$license = $_GET['license'];

require("databaseConnection.php");
$dbConn = getConnection();

$sql = "SELECT SUM(TYGross) as TYGross, SUM(FYGross) as FYGross FROM commInfo WHERE license = '" . $license . "' AND YEAR(date) = :year";
$namedParameters = array();
$namedParameters[':year'] = date("Y");
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$userResults = $stmt->fetch();

if (!isset($userResults['FYGross'])) {
    $_SESSION['FYGross'] = 0;
} else {
    $_SESSION['FYGross'] = $userResults['FYGross'];
}


echo json_encode($userResults);
?>