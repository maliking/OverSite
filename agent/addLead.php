<?php

session_start();
// date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';


$dbConn = getConnection();

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$bedroomsMin = $_POST['bedroomsMin'];
$bathroomsMin = $_POST['bathroomsMin'];
$priceMax = $_POST['price'];
$userId = $_SESSION['userId'];



$sql = "INSERT INTO BuyerInfo
		(firstName, lastName, email, phone, registeredDate, bedroomsMin, bathroomsMin, priceMax, houseId, userId, howSoon)
		VALUES (:firstName, :lastName, :email, :phone, :registeredDate, :bedroomsMin, :bathroomsMin, :priceMax, :houseId, :userId, :howSoon)";
$namedParameters = array();
$namedParameters[':firstName'] = $firstName;
$namedParameters[':lastName'] = $lastName;
$namedParameters[':email'] = $email;
$namedParameters[':phone'] = $phone;
$namedParameters[':registeredDate'] = date("Y/m/d");
// $namedParameters[':meeting'] = $nextMeeting->format('Y-m-d H:i:s');
$namedParameters[':bedroomsMin'] = $bedroomsMin;
$namedParameters[':bathroomsMin'] = (float)$bathroomsMin;
$namedParameters[':priceMax'] = $priceMax;
// $namedParameters[':priceMin'] = $priceMin;
$namedParameters[':houseId'] = "0";
$namedParameters[':userId'] = $userId;
$namedParameters[':howSoon'] = $_POST['howSoon'];
$stmt = $dbConn->prepare($sql);
try {
    $stmt->execute($namedParameters);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";

}

?>
