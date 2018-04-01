<?php 

	session_start();

	require 'databaseConnection.php';

	$dbConn = getConnection();

	$sql = "SELECT username FROM UsersInfo WHERE username = :proposedUsername"; 
	$namedParameters = array(); 
	$namedParameters[":username"] = $_GET['proposedUsername']; 

	$stmt = $dbConn->prepare($sql); 
	$stmt->execute($namedParameters); 
	$result = $stmt->fetch(); 

	//print_r($result); 
	$checkUsername = array(); 
	if (empty($result)) { 
	   $checkUsername['exists'] = false; 
	   //echo "username available";     
	} else { 
	   $checkUsername['exists'] = true; 
	   //echo "username NOT available"; 
	} 

	echo json_encode($checkUsername); 


?>      