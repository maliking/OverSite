<?php
session_start();
require '../databaseConnection.php';
$dbConn = getConnection();

if (!isset($_SESSION['userId'])) {
    header("Location: http://www.oversite.cc/login.php");
}


$price = $_POST['price'];
$bedrooms = $_POST['bed'];
$bathrooms = $_POST['bath'];


$url = 'https://api.idxbroker.com/clients/featured';

$method = 'GET';

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

// print_r($response);

$keys = array_keys($response);

$houseArray = array();
$houseCount = 0;
for ($i = 0; $i < sizeof($keys); $i++) 
{
	if($houseCount >= 5)
		break;

	else if($price >= ($response[$keys[$i]]['rntLsePrice'] - 50000) && $price <= ($response[$keys[$i]]['rntLsePrice'] + 70000))
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
    	if($houseBaths >= $bathrooms && $houseBedrooms >= $bedrooms )
    	{
    		$sqlMlsId = "SELECT  firstName, lastName FROM UsersInfo WHERE mlsId = :mlsId";

			$namedParameters = array();
			$namedParameters[':mlsId'] = $response[$keys[$i]]['listingAgentID'];


			$mlsIdStmt = $dbConn->prepare($sqlMlsId);
			$mlsIdStmt->execute($namedParameters);
			$mlsIdResult = $mlsIdStmt->fetch();

			$response[$keys[$i]]['listingAgentID'] = $mlsIdResult['firstName'] . " " . $mlsIdResult['lastName'];
    		array_push($houseArray,$response[$keys[$i]]);
    		$houseCount++;
    	}
	}

}

$json=json_encode($houseArray);

echo $json;

?>