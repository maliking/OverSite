<?php

require("../databaseConnection.php");
session_start();
$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: http://www.oversite.cc/login.php");
}



 $address = $_POST['address'];
 $city = $_POST['city'];
 $state = $_POST['state'];
 $zip = $_POST['zip'];
 $bedrooms = $_POST['bedrooms'];
 $bathrooms = $_POST['bathrooms'];
 $price = $_POST['price'];
 $sqft = $_POST['sqft'];

// echo "address " . $address . "<br>"."<br>";
// echo "city " . $city . "<br>"."<br>";
// echo "state " . $state . "<br>"."<br>";
// echo "zip " . $zip . "<br>"."<br>";
// echo "bedrooms " . $bedrooms . "<br>"."<br>";
// echo "bathrooms " . $bathrooms . "<br>"."<br>";
// echo "price " . $price . "<br>"."<br>";
// echo "sqft " . $sqft  . "<br>"."<br>";

$sql = "INSERT INTO HouseInfo (userId, status, address, city, state, zip, bedrooms, bathrooms, price, sqft)
	    VALUES (:userId, :status, :address, :city, :state, :zip, :bedrooms, :bathrooms, :price, :sqft)";
        $namedParameters = array();
        $namedParameters[":userId"] = $_SESSION['userId'];
        // $namedParameters[":listingId"] = $response[$keys[$i]]['listingID'];
        $namedParameters[":status"] = "added";
        $namedParameters[":address"] = $address;
        $namedParameters[":city"] = $city;
        $namedParameters[":state"] = $state;
        $namedParameters[":zip"] = $zip;
        $namedParameters[":bedrooms"] = $bedrooms;
        $namedParameters[":bathrooms"] = $bathrooms;
        $value = preg_replace('/[\$,]/', '', $price);
        $value = intval($value);
        $namedParameters[":price"] = $value;
        $squareFeet = preg_replace('/[\$,]/', '', $sqft);
        $squareFeet = intval($squareFeet);
        $namedParameters[":sqft"] = $squareFeet;
        $stmt = $dbConn->prepare($sql);
        // $stmt->execute($namedParameters);

        $filename = realpath('../addedHouses/'. $address);

        if (!file_exists($filename)) 
        {
            mkdir("../addedHouses/" . $address, 0700);
        }


foreach ($_FILES["housePictures"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["housePictures"]["tmp_name"][$key];
        // basename() may prevent filesystem traversal attacks;
        // further validation/sanitation of the filename may be appropriate
        $folder = "../addedHouses/" . $address . "/";
        

        $name = basename($_FILES["housePictures"]["name"][$key]);
        $target = realpath($folder . $name);
        // echo $name;
        if (move_uploaded_file($tmp_name, $target)) {
            echo "uploaded" . "<br>";
        }
        // echo $name . "<br><br>";
    }
}

echo "finished";






















?>