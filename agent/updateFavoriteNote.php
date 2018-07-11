<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
$dbConn = getConnection();


$sql = "UPDATE favoritesNotes SET note = :note, noteDate = :noteDate WHERE noteId = :noteId";
$namedParameters = array();
$namedParameters[":noteId"] = $_POST['noteId'];
$namedParameters[":noteDate"] = date("Y/m/d");
$namedParameters[":note"] = $_POST['note'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);

?>