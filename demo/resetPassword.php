<?php
session_start();

require 'keys/cred.php';
require 'twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;
require 'databaseConnection.php';

$dbConn = getConnection();

$sql = "SELECT phone FROM  UsersInfo WHERE license = :license";
$namedParameters = array();
$namedParameters[':license'] = $_POST['license'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$result = $stmt->fetch();


if($_POST['code'] == " ")
{
	$_SESSION['tempCode'] = rand(1, 999);
	$twilio_phone_number = "+18315851661";
	$client = new Client($sid, $token);
	$client->messages->create(
    $result['phone'],
    array(
        "From" => $twilio_phone_number,
        "Body" => $_SESSION['tempCode'],
        
    )
);

}
else
{
	if($_POST['code'] == $_SESSION['tempCode'])
	{
		$sql = "UPDATE UsersInfo SET password = :password WHERE license = :license AND userType = 1";

	    $namedParameters = array();
	    $namedParameters[":password"] = sha1($_POST['password']);
	    $namedParameters[":license"] = $_POST['license'];
	    $stmt = $dbConn->prepare($sql);
		$stmt->execute($namedParameters);
		echo json_encode("Success");	
		session_destroy(); 
	}
	else
	{
		echo json_encode("Error");	
		
	}
	// echo json_encode($_SESSION['tempCode']);
}

?>