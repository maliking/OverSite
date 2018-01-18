<?php

require '../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';

// use Twilio\Rest\Client;


// // $twilio_phone_number = "+18315851661";
// $twilio_phone_number = "Oversite";
// $client = new Client($sid, $token);
// $client->messages->create(
// $_POST['phone'],
// array(
//     "From" => $twilio_phone_number,
//     "Body" => $_POST['text'],
    
//     )
// );
	
// require_once './vendor/autoload.php';
use Twilio\Twiml;

$response = new Twiml();
$message = $response->message();
$message->body($_POST['text']);
// $message->media('https://demo.twilio.com/owl.png');

// echo $response;

?>