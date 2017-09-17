<?php
try
{
	clearstatcache();
	require_once '../keys/cred.php';
	require '../twilio-php-master/Twilio/autoload.php';
	use Twilio\Rest\Client;

	$im = new Imagick();

	$im->setResolution(300,300);
	$im->readimage('930_Provincetown.pdf[0]'); 
	$im->setImageFormat('jpeg');    
	$im->writeImage('thumb.jpg'); 
	$im->clear(); 
	$im->destroy();

	echo '<img src=thumb.jpg height=100% >';

// Twilio Code
	try
	{
		$twilio_phone_number = "+18317038053";
		$client = new Client($sid, $token);
		$client->messages->create(
			"8312934153",
			array(
				"From" => $twilio_phone_number,
				"Body" => "Flyer",
				"mediaUrl" => "thumb.jpg",
				)
			);
	}
	catch(Exception $e)
	{
		echo "error: " . $e->getMessage();
	}

}
catch(Exception $e)
{
	echo "error: " . $e->getMessage();
}
?>
