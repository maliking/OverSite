<?php
session_start();
require 'keys/cred.php';
require 'twilio-php-master/Twilio/autoload.php';
use Twilio\Rest\Client;

require 'databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT address
            FROM HouseInfo";
// WHERE userId = :userId";

// $namedParameters = array();
// $namedParameters[':userId'] = $_SESSION['userId'];
$stmt = $dbConn->prepare($sql);
$stmt->execute();
// $stmt->execute($namedParameters);
//$stmt->execute();
$results = $stmt->fetchAll();


function inDatabase($address, $results)
{
    foreach ($results as $result) {
        if (strtolower($result['address']) == strtolower($address)) {
            return true;
        }
    }
    return false;
}

$url = 'https://api.idxbroker.com/clients/featured';

$method = 'GET';

// headers (required and optional)
$headers = array(
    'Content-Type: application/x-www-form-urlencoded', // required
    'accesskey: e1Br0B5DcgaZ3@JXI9qib5', // required - replace with your own
    'outputtype: json' // optional - overrides the preferences in our API control page
);

// set up cURL
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

for ($i = 0; $i < sizeof($keys); $i++) {
    if (!inDatabase($response[$keys[$i]]['address'], $results)) {
        $sql = "INSERT INTO HouseInfo
	                 (userId, listingId, status, address, city, state, zip, bedrooms, bathrooms, price, sqft)
	                 VALUES (:userId, :listingId, :status, :address, :city, :state, :zip, :bedrooms, :bathrooms, :price, :sqft)";
        $namedParameters = array();
        $namedParameters[":userId"] = "0";
        $namedParameters[":listingId"] = $response[$keys[$i]]['listingID'];
        $namedParameters[":status"] = strtolower($response[$keys[$i]]['idxStatus']);
        $namedParameters[":address"] = $response[$keys[$i]]['address'];
        $namedParameters[":city"] = ucfirst(strtolower($response[$keys[$i]]['cityName']));
        $namedParameters[":state"] = $response[$keys[$i]]['state'];
        $namedParameters[":zip"] = $response[$keys[$i]]['zipcode'];
        $namedParameters[":bedrooms"] = $response[$keys[$i]]['bedrooms'];
        $namedParameters[":bathrooms"] = $response[$keys[$i]]['totalBaths'];
        $value = preg_replace('/[\$,]/', '', $response[$keys[$i]]['listingPrice']);
        $value = intval($value);
        $namedParameters[":price"] = $value;
        $squareFeet = preg_replace('/[\$,]/', '', $response[$keys[$i]]['sqFt']);
        $squareFeet = intval($squareFeet);
        $namedParameters[":sqft"] = $squareFeet;
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($namedParameters);

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

        $getLeadsDb = "SELECT BuyerInfo.*, UsersInfo.firstName as agentFirstName, UsersInfo.lastName as agentLastName FROM BuyerInfo 
        LEFT JOIN UsersInfo ON UsersInfo.userId = BuyerInfo.userId 
        WHERE BuyerInfo.priceMax BETWEEN :lessPrice AND :morePrice AND BuyerInfo.bedroomsMin <= :moreBedrooms AND BuyerInfo.bathroomsMin <= :moreBathrooms
        ORDER BY BuyerInfo.priceMax DESC LIMIT 10";

        $leadParameters = array();
        $leadParameters[':morePrice'] = $response[$keys[$i]]['rntLsePrice'] + 70000;
        $leadParameters[':lessPrice'] = $response[$keys[$i]]['rntLsePrice'] - 50000;
        $leadParameters[':moreBedrooms'] = $houseBedrooms;
        $leadParameters[':moreBathrooms'] = $houseBaths;

        $leadStmt = $dbConn->prepare($getLeadsDb);
        $leadStmt->execute($leadParameters);
        //$stmt->execute();
        $leadResults = $leadStmt->fetchAll();

        $message = "Potential leads for your recent listing ( " . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . " " .
        $response[$keys[$i]]['zipcode'] . "): \n ";

        $leadCount = 1;
        foreach($leadResults as $lead)
        {
            $message .= $leadCount . ". Agent: " . $lead['agentFirstName'] . " " . $lead['agentLastName'] . "  BuyerId: " . $lead['buyerID'] . " \n";
            $leadCount++;
        }

        $getAgentPhone = "SELECT phone FROM UsersInfo WHERE mlsId = :mlsId";
        $agentParam = array();
        $agentParam[':mlsId'] = $response[$keys[$i]]['listingAgentID'];

        $agentStmt = $dbConn->prepare($getAgentPhone);
        $agentStmt->execute($agentParam);
        $agentPhoneResult = $agentStmt->fetch();

        if($leadCount > 1)
        {

            $twilio_phone_number = "+18315851661";
            $client = new Client($sid, $token);
            $client->messages->create(
                $agentPhoneResult['phone'],
                array(
                    "From" => $twilio_phone_number,
                    "Body" => $message,
                )
            );
        }

    }
}

header("Location: agent/index.php");

?>
