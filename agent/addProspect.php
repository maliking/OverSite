<?php

session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';


$dbConn = getConnection();

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$zip = $_POST['zip'];
$bedroom = $_POST['bedroom'];
$bathroom = $_POST['bathroom'];
$priceMax = $_POST['price'];
$userId = $_SESSION['userId'];



$sql = "INSERT INTO favorites
		(firstName, lastName, email, zip, phone, bedroom, bathroom, price, userId, howSoon, approved, sqft, lotSize)
		VALUES (:firstName, :lastName, :email, :zip, :phone, :bedroom, :bathroom, :price, :userId, :howSoon, :approved, :sqft, :lotSize)";
$namedParameters = array();
$namedParameters[':firstName'] = $firstName;
$namedParameters[':lastName'] = $lastName;
$namedParameters[':email'] = $email;
$namedParameters[':phone'] = $phone;
$namedParameters[':zip'] = $zip;
$namedParameters[':bedroom'] = $bedroom;
$namedParameters[':bathroom'] = (float)$bathroom;
$namedParameters[':price'] = $priceMax;
$namedParameters[':userId'] = $userId;
$namedParameters[':sqft'] = $_POST['sqft'];
$namedParameters[':lotSize'] = $_POST['lotSize'];
$namedParameters[':howSoon'] = $_POST['howSoon'];
$namedParameters[':approved'] = $_POST['preApproved'];
$stmt = $dbConn->prepare($sql);
try {
    $stmt->execute($namedParameters);
    header('Location: index.php');
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";

}

?>