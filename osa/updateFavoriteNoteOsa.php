<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();


$sql = "UPDATE favoritesNotesOsa SET note = :note, noteDate = :noteDate WHERE noteId = :noteId";
$namedParameters = array();
$namedParameters[":noteId"] = $_POST['noteId'];
$namedParameters[":noteDate"] = date("Y-m-d H:i:s");
$namedParameters[":note"] = $_POST['note'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>