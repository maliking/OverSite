<?php
    session_start();

    require 'databaseConnection.php';
    $dbConn = getConnection();

    $sql = "SELECT address
            FROM HouseInfo
            WHERE userId = :userId";

    $namedParameters = array();
    $namedParameters[':userId'] = $_SESSION['userId'];
    $stmt = $dbConn -> prepare($sql);
    $stmt->execute($namedParameters);
    //$stmt->execute();
    $results = $stmt->fetchAll();


function inDatabase($address, $results)
{
    foreach($results as $result){
        if(strtolower($result['address']) === strtolower($address)) {
            return true;
        }
    }
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

    for($i = 0; $i < sizeof($keys); $i++){
        if(!inDatabase($response[$keys[$i]]['address'], $results)) {
            $sql = "INSERT INTO HouseInfo
	                 (userId, status, address, city, state, zip, bedrooms, bathrooms, price, sqft)
	                 VALUES (:userId, :status, :address, :city, :state, :zip, :bedrooms, :bathrooms, :price, :sqft)";
                 $namedParameters = array();
                 $namedParameters[":userId"] = $_SESSION['userId'];
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
                 $namedParameters[":sqft"] = $response[$keys[$i]]['sqFt']);
                 $stmt = $dbConn -> prepare($sql);
                 $stmt->execute($namedParameters);

                 
        }
    }

    header("Location: agent/index.php");

?>
