<?php

session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT firstName, lastName, CAST(lastContacted AS DATE) as lastContacted FROM favorites WHERE userId = :userId AND
		DATEDIFF(CURDATE(), lastContacted ) >= 7  ";
$namedParameters = array();
$namedParameters[":userId"] = $_SESSION['userId'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

echo json_encode($results);

?>