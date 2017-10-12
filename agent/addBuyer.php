<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');
session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
require '../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;

// session_start();
$dbConn = getConnection();
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$bedroomsMin = $_POST['bedroomsMin'];
$bathroomsMin = $_POST['bathroomsMin'];
$priceMax = $_POST['priceMax'];
$priceMin = $_POST['priceMin'];
// $houseId = (string)$_GET['houseId'];
// $houseId = "253";
$nextMonday = date('Y-m-d', strtotime('next monday'));

$lastMeeting = "SELECT * FROM BuyerInfo WHERE substring(meeting,1,10) ='" . $nextMonday . "'  ORDER BY meeting DESC limit 1";

$meetingStmt = $dbConn->prepare($lastMeeting);
$meetingStmt->execute();
$meetingResult = $meetingStmt->fetch();

// $latestTime = new DateTime('07:00:00');
// $lastTime = $latestTime->format('H:i:s');
if (empty($meetingResult)) {
    $nextMeeting = date_create_from_format('Y-m-d', $nextMonday);
    $nextMeeting->setTime(7, 00, 00);

} else {


    $meetingDateTime = new DateTime($meetingResult['meeting']);

    // $lastMeetingDayName = $meetingDateTime->format('l');

    // $lastMeetingTime = $meetingDateTime->format('H:i:s');

    $nextMeeting = $meetingDateTime->add(new DateInterval('PT15M'));

    // $nextMeetingTime = $nextMeeting->format('H:i:s');
}

// if($nextMeetingTime > $lastTime && $meetingResult)
// {
//     $nextMeeting->setTime(7, 00, 00);
// }

// if($lastMeetingDayName == "Friday" && $nextMeetingTime >= $lastTime)
// if($lastMeetingDayName == "Friday" && $nextMeetingTime)
// {
//     $nextMeeting->add(new DateInterval('P3D'));
//     $nextMeeting->setTime(7, 00, 00);

// }
// else if($nextMeetingTime >= $lastTime)
// else if($nextMeetingTime)
// {
//     $nextMeeting->add(new DateInterval('P1D'));
//     $nextMeeting->setTime(8, 30, 00);
// }


$userId = $_SESSION['userId'];
$sql = "INSERT INTO BuyerInfo
		(firstName, lastName, email, phone, registeredDate, meeting, bedroomsMin, bathroomsMin, priceMax, priceMin, houseId, userId, howSoon)
		VALUES (:firstName, :lastName, :email, :phone, :registeredDate, :meeting, :bedroomsMin, :bathroomsMin, :priceMax, :priceMin, :houseId, :userId, :howSoon)";
$namedParameters = array();
$namedParameters[':firstName'] = $firstName;
$namedParameters[':lastName'] = $lastName;
$namedParameters[':email'] = $email;
$namedParameters[':phone'] = $phone;
$namedParameters[':registeredDate'] = date("Y/m/d");
$namedParameters[':meeting'] = $nextMeeting->format('Y-m-d H:i:s');
$namedParameters[':bedroomsMin'] = $bedroomsMin;
$namedParameters[':bathroomsMin'] = (float)$bathroomsMin;
$namedParameters[':priceMax'] = $priceMax;
$namedParameters[':priceMin'] = $priceMin;
$namedParameters[':houseId'] = $_POST['houseId'];
$namedParameters[':userId'] = $userId;
$namedParameters[':howSoon'] = $_POST['howSoon'];
$stmt = $dbConn->prepare($sql);
try {
    $stmt->execute($namedParameters);
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";

}
//$stmt->execute();
//$result = $stmt->fetch(); //We are expecting one record


$twilio_phone_number = "+18315851661";
// if($houseId == "89")
// {
$client = new Client($sid, $token);
$client->messages->create(
    $phone,
    array(
        "From" => $twilio_phone_number,
        "Body" => "Flyer",
        'mediaUrl' => "http://52.11.24.75/uploadFlyers/" . substr(rawurlencode($_SESSION['flyer']), 0, -3) . 'jpg',
    )
);

// }
// else if($houseId == "193")
// {
// 	$client = new Client($sid, $token);
// 	$client->messages->create(
// 	$phone,
// 	array(
// 	"From" => $twilio_phone_number,
// 	"Body" => "Flyer",
// 	'mediaUrl' => "http://52.11.24.75/keys/declaration.jpg",
// 	)
// 	);
// }
//if (empty($result)) {
header("Location: Confirmation.php");
//}
/*else {

$_SESSION['username']  = $result['username'];
$_SESSION['adminName'] = $result['firstName'] . " " . $result['lastName'];
$_SESSION['userId'] = $result['userId'];
header("Location: quiz.php");

}*/
?>
