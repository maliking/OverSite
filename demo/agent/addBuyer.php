<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
session_start();
date_default_timezone_set('America/Los_Angeles');
require '../databaseConnection.php';
require '../../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';

require '../PHPMailer/src/PHPMailer.php'; 
require '../PHPMailer/src/Exception.php'; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


use Twilio\Rest\Client;


$url = 'https://api.idxbroker.com/clients/featured';


// headers (required and optional)
$headers = array(
    'Content-Type: application/x-www-form-urlencoded', // required
    'accesskey: e1Br0B5DcgaZ3@JXI9qib5', // required - replace with your own
    'outputtype: json' // optional - overrides the preferences in our API control page
);

$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

// exec the cURL request and returned information. Store the returned HTTP code in $code for later reference
$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code >= 200 || $code < 300) {
    $response = json_decode($response, true);
} else {
    $error = $code;
}


$keys = array_keys($response);


// session_start();
$dbConn = getConnection();
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$bedroomsMin = $_POST['bedroomsMin'];
$bathroomsMin = $_POST['bathroomsMin'];
$priceMax = $_POST['price'];
// $priceMin = $_POST['priceMin'];
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
		(firstName, lastName, email, phone, registeredDate, meeting, bedroomsMin, bathroomsMin, priceMax, houseId, userId, howSoon, approved)
		VALUES (:firstName, :lastName, :email, :phone, :registeredDate, :meeting, :bedroomsMin, :bathroomsMin, :priceMax, :houseId, :userId, :howSoon, :approved)";
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
// $namedParameters[':priceMin'] = $priceMin;
$namedParameters[':houseId'] = $_POST['houseId'];
$namedParameters[':userId'] = $userId;
$namedParameters[':howSoon'] = $_POST['howSoon'];
$namedParameters[':approved'] = $_POST['preApproved'];
$stmt = $dbConn->prepare($sql);
try {
    $stmt->execute($namedParameters);
    $lastBuyerId = $dbConn->lastInsertId();
} catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), "\n";

}
//$stmt->execute();
//$result = $stmt->fetch(); //We are expecting one record

if($phone != "")
{
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
}

    $agentEmailSql = "SELECT firstName, lastName, email, phone FROM UsersInfo WHERE userId = :userId";
    $stmt = $dbConn->prepare($agentEmailSql);
    $namedParameters = array();
    $namedParameters[':userId'] = $_SESSION['userId'];
    $stmt->execute($namedParameters);
    $result = $stmt->fetch();

if($email != "")
{
    

    $mail = new PHPMailer;
    $mail->setFrom($result['email'], $result['firstName'] . " " . $result['lastName']);
    $mail->addAddress($_POST['email']);
    $mail->Subject  =  "Flyer from " . substr(rawurlencode($_SESSION['flyer']), 0, -4);
    $mail->Body     = "Flyer from " . substr(rawurlencode($_SESSION['flyer']), 0, -4) ;
    // $mail->addAttachment("../../uploadFlyers/" . rawurlencode($_POST['flyer']) . 'jpg')
    $mail->addStringAttachment(file_get_contents("http://52.11.24.75/uploadFlyers/" . substr(rawurlencode($_SESSION['flyer']), 0, -3) . 'jpg'), substr(rawurlencode($_SESSION['flyer']), 0, -3) . 'jpg');
    if(!$mail->send()) {
      echo 'Message was not sent.';
      echo 'Mailer error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message has been sent.';
    }
}

$listingId = $_SESSION['listingId'];

$houseInfo = "SELECT * FROM HouseInfo WHERE listingId = :listingId";
$houseStmt = $dbConn->prepare($houseInfo);

$houseParameters = array();
$houseParameters[':listingId'] = $listingId;
$houseStmt->execute($houseParameters);

$houseResult = $houseStmt->fetch();

$messageForLeadAgent = "Recent Lead, " . $firstName . " " . $lastName . ", matches with the following houses: \n";

$match = 1;
for ($i = 0; $i < sizeof($keys); $i++) 
{
    if($priceMax >= ($response[$keys[$i]]['rntLsePrice'] - 50000) && $priceMax <= ($response[$keys[$i]]['rntLsePrice'] + 70000))
    {
        if(!isset($response[$keys[$i]]['bedrooms']))
        {
            $houseBedrooms = 0;
        }
        else
        {
            $houseBedrooms = $response[$keys[$i]]['bedrooms'];
        }
        if(!isset($response[$keys[$i]]['totalBaths']))
        {
            $houseBaths = 0;
        }
        else
        {
            $houseBaths = $response[$keys[$i]]['totalBaths'];
        }
        if($houseBaths >= $bathroomsMin && $houseBedrooms >= $bedroomsMin )
        {
            $sqlMlsId = "SELECT  firstName, lastName, phone FROM UsersInfo WHERE mlsId = :mlsId";

            $namedParameters = array();
            $namedParameters[':mlsId'] = $response[$keys[$i]]['listingAgentID'];


            $mlsIdStmt = $dbConn->prepare($sqlMlsId);
            $mlsIdStmt->execute($namedParameters);
            $mlsIdResult = $mlsIdStmt->fetch();

            $response[$keys[$i]]['listingAgentID'] = $mlsIdResult['firstName'] . " " . $mlsIdResult['lastName'];

            $messageForLeadAgent .= $match . ". " . $mlsIdResult['firstName'] . " " . $mlsIdResult['lastName'] .
            " --- " . $response[$keys[$i]]['address'] . ", " . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['zipcode'] . " \n";

            $twilio_phone_number = "+18315851661";
//             // if($houseId == "89")
//             // {
            
            $client = new Client($sid, $token);
            $client->messages->create(
                $mlsIdResult['phone'],
                array(
                    "From" => $twilio_phone_number,
                    "Body" => $result['firstName'] . " " . $result['lastName'] . " has a potential lead, BuyerId: " . $lastBuyerId . ", for your listing: " .
                     $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'],
                )
            );

            // $lastBuyerId
            $match++;
        }
    }

}

if($match > 1)
{
    $twilio_phone_number = "+18315851661";
    // if($houseId == "89")
    // {
    $client = new Client($sid, $token);
    $client->messages->create(
        $result['phone'],
        array(
            "From" => $twilio_phone_number,
            "Body" => $messageForLeadAgent,
        )
    );
}


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
