<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();

$buyerSql = "SELECT firstName, lastName, email, phone, priceMax, bedroomsMin, bathroomsMin, howSoon, approved, note FROM BuyerInfo WHERE buyerID = :buyerId";
$buyerParameters = array();
$buyerParameters[':buyerId'] = $_POST['buyerId'];
$buyerStmt = $dbConn->prepare($buyerSql);
$buyerStmt->execute($buyerParameters);
$buyerResults = $buyerStmt->fetch();

$addFavoriteSql = "INSERT INTO favorites (userId, firstName, lastName, phone, email, price, bedroom, bathroom, howSoon, approved, note) 
						VALUES (:userId, :firstName, :lastName, :phone, :email, :price, :bedroom, :bathroom, :howSoon, :approved, :note)";
$favoriteParameters = array();
$favoriteParameters[':userId'] = $_SESSION['userId'];
$favoriteParameters[':firstName'] = $buyerResults['firstName'];
$favoriteParameters[':lastName'] = $buyerResults['lastName'];
$favoriteParameters[':phone'] = $buyerResults['phone'];
$favoriteParameters[':email'] = $buyerResults['email'];
$favoriteParameters[':price'] = $buyerResults['priceMax'];
$favoriteParameters[':bedroom'] = $buyerResults['bedroomsMin'];
$favoriteParameters[':bathroom'] = $buyerResults['bathroomsMin'];
$favoriteParameters[':howSoon'] = $buyerResults['howSoon'];
$favoriteParameters[':approved'] = $buyerResults['approved'];
$favoriteParameters[':note'] = $buyerResults['note'];

$favoriteStmt = $dbConn->prepare($addFavoriteSql);
$favoriteStmt->execute($favoriteParameters);

?>
