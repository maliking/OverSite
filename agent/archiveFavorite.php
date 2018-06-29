<?php
session_start();

require '../databaseConnection.php';

$dbConn = getConnection();

$copySql = "INSERT INTO BuyerInfo (userId, firstName, lastName, phone, email, bedroomsMin, bathroomsMin, priceMax, howSoon, approved) 
			SELECT favorites.userId, favorites.firstName, favorites.lastName, favorites.phone, favorites.email, favorites.bedroom, favorites.bathroom, 
			favorites.price, favorites.howSoon, favorites.approved FROM favorites WHERE favorites.favoriteId = :favoriteId";


$copyParameters = array();
$copyParameters[':favoriteId'] = $_POST['favoriteId'];
$copyStmt = $dbConn->prepare($copySql);
$copyStmt->execute($copyParameters);

$deleteFavoriteSql = "DELETE FROM favorites WHERE favoriteId = :favoriteId";
$deleteParameters = array();
$deleteParameters[':favoriteId'] = $_POST['favoriteId'];
$deleteStmt = $dbConn->prepare($deleteFavoriteSql);
$deleteStmt->execute($deleteParameters);

?>