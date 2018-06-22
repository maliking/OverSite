<?php

session_start();
require("../databaseConnection.php");

$dbConn = getConnection();


// $sql = "SELECT BuyerInfo.*, UsersInfo.firstName as agentFirstName, UsersInfo.lastName as agentLastName FROM BuyerInfo 
// 		LEFT JOIN HouseInfo ON BuyerInfo.houseId = HouseInfo.houseId LEFT JOIN UsersInfo ON UsersInfo.userId = BuyerInfo.userId 
// 		WHERE ORDER BY agentFirstName ";
$sql = "SELECT BuyerInfo.*, UsersInfo.firstName as agentFirstName, UsersInfo.lastName as agentLastName FROM BuyerInfo 
		LEFT JOIN UsersInfo ON UsersInfo.userId = BuyerInfo.userId 
		WHERE BuyerInfo.priceMax BETWEEN :lessPrice AND :morePrice AND BuyerInfo.bedroomsMin <= :moreBedrooms AND BuyerInfo.bathroomsMin <= :moreBathrooms
		ORDER BY BuyerInfo.priceMax DESC LIMIT 5";

$namedParameters = array();
$namedParameters[':morePrice'] = $_POST['price'] + 70000;
$namedParameters[':lessPrice'] = $_POST['price'] - 50000;
$namedParameters[':moreBedrooms'] = $_POST['bedrooms'] ;
$namedParameters[':moreBathrooms'] = $_POST['bathrooms'] ;
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
//$stmt->execute();
$results = $stmt->fetchAll();

$json=json_encode($results);

echo $json;
// echo json_encode(array("name"=>"John","time"=>"2pm"));

?>