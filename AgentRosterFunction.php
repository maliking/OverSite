<?php
	session_start();

	require 'databaseConnection.php';
	$dbConn = getConnection();

	if($_POST['function'] == "delete")
	{
		$sql = "DELETE FROM  UsersInfo WHERE userId = :userId";

		$namedParameters = array();
		$namedParameters[":userId"] = $_POST['userId'];


		$stmt = $dbConn->prepare($sql);
		$stmt->execute($namedParameters);
	}
	else if($_POST['function'] == "edit")
	{
		$sql = "UPDATE UsersInfo SET firstName = :firstName, lastName = :lastName WHERE userId = :userId";

		$namedParameters = array();
		$namedParameters[":userId"] = $_POST['userId'];
		$namedParameters[":firstName"] = $_POST['firstName'];
		$namedParameters[":lastName"] = $_POST['lastName'];



		$stmt = $dbConn->prepare($sql);
		$stmt->execute($namedParameters);
	}
	else if($_POST['function'] == "add")
	{
		$sql = "INSERT INTO  UsersInfo (firstName, lastName) VALUES (:firstName, :lastName)";

		$namedParameters = array();
		$namedParameters[":firstName"] = $_POST['firstName'];
		$namedParameters[":lastName"] = $_POST['lastName'];



		$stmt = $dbConn->prepare($sql);
		$stmt->execute($namedParameters);
	}
	
?>