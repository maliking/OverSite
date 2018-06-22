<?php
session_start();

require 'keys/cred.php';
require 'twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;
require 'databaseConnection.php';

$dbConn = getConnection();

if ($_POST['function'] == "delete") {
    $sql = "DELETE FROM  UsersInfo WHERE userId = :userId";

    $namedParameters = array();
    $namedParameters[":userId"] = $_POST['userId'];


    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
} else if ($_POST['function'] == "edit") {
    $sql = "UPDATE UsersInfo SET  username = :username, firstName = :firstName, lastName = :lastName , email = :email, phone = :phone, license = :license  WHERE userId = :userId";

    $namedParameters = array();
    $namedParameters[":userId"] = $_POST['userId'];
    $namedParameters[":firstName"] = $_POST['firstName'];
    $namedParameters[":lastName"] = $_POST['lastName'];

    $namedParameters[":username"] = $_POST['username'];
    $namedParameters[":email"] = $_POST['email'];
    $namedParameters[":phone"] = $_POST['phone'];
    $namedParameters[":license"] = $_POST['license'];


    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
} else if ($_POST['function'] == "add") {
    $sql = "INSERT INTO  UsersInfo (userType, username, password, firstName, lastName, email, phone, license) VALUES (1, :username, :password, :firstName, :lastName, :email, :phone, :license)";

    $namedParameters = array();
    $namedParameters[":username"] = $_POST['username'];
    $namedParameters[":password"] = sha1($_POST['password']);
    $namedParameters[":firstName"] = $_POST['firstName'];
    $namedParameters[":lastName"] = $_POST['lastName'];
    $namedParameters[":email"] = $_POST['email'];
    $namedParameters[":phone"] = $_POST['phone'];
    $namedParameters[":license"] = $_POST['license'];

    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);    


    //$_SESSION['tempCode'] = rand(1, 999);
    $twilio_phone_number = "+18315851661";
    $client = new Client($sid, $token);
    $client->messages->create(
    $_POST['phone'],
    array(
        "From" => $twilio_phone_number,
        "Body" => "OVERSITE LOGIN CREDENTIALS \r\nLogin URL: www.oversite.cc\r\nUsername: " . $_POST['username'] . "\r\nPassword: " . $_POST['password'],
        
        )
    );
}

?>