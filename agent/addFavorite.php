<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();

$buyerSql = "SELECT firstName, lastName, phone, priceMax, bedroomsMin, bathroomsMin FROM BuyerInfo WHERE buyerID = :buyerId";
$buyerParameters = array();
$buyerParameters[':buyerId'] = $_POST['buyerId'];
$buyerStmt = $dbConn->prepare($buyerSql);
$buyerStmt->execute($buyerParameters);
$buyerResults = $buyerStmt->fetch();

$addFavoriteSql = "INSERT INTO favorites (userId, client, phone, price, bedroom, bathroom) VALUES (:userId, :client, :phone, :price, :bedroom, :bathroom)";
$favoriteParameters = array();
$favoriteParameters[':userId'] = $_SESSION['userId'];
$favoriteParameters[':client'] = $buyerResults['firstName'] . " " . $buyerResults['lastName'];
$favoriteParameters[':phone'] = $buyerResults['phone'];
$favoriteParameters[':price'] = $buyerResults['priceMax'];
$favoriteParameters[':bedroom'] = $buyerResults['bedroomsMin'];
$favoriteParameters[':bathroom'] = $buyerResults['bathroomsMin'];

$favoriteStmt = $dbConn->prepare($addFavoriteSql);
$favoriteStmt->execute($favoriteParameters);

?>
