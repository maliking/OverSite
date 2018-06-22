<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();

if($_POST['type'] == "name")
{
	$nameSplit = explode(" ", $_POST['newData']);
	$sql = "UPDATE favorites SET firstName = :firstaName, lastName = :lastName WHERE favoriteId = :favoriteId";
	$editParameters = array();
	$editParameters[':firstaName'] = $nameSplit[0];
	$editParameters[':lastName'] = $nameSplit[1];
	$editParameters[':favoriteId'] = $_POST['id'];

	$editStmt = $dbConn->prepare($sql);
	$editStmt->execute($editParameters);

}
else
{
	$sql = "UPDATE favorites SET " . $_POST['type'] . " = :type WHERE favoriteId = :favoriteId";
	$editParameters = array();
	$editParameters[':type'] = $_POST['newData'];
	$editParameters[':favoriteId'] = $_POST['id'];
	$editStmt = $dbConn->prepare($sql);
	$editStmt->execute($editParameters);
}



?>