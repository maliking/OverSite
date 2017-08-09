<?php
session_start();

require 'databaseConnection.php';
require("keys/cred.php");

$dbConn = getConnection();
$sql = "SELECT * FROM commInfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://demo.docusign.net/restapi/v2/accounts/" . $acId . "/envelopes/" . $enId . "/documents/1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "x-docusign-authentication: { \"Username\": \"" . $username . "\",\"Password\":\"" . $password ."\",\"IntegratorKey\":\"" . $intKey . "\"  }"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  // echo $response;
}


?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Sales Breakdown</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

        <link rel="stylesheet" href="dist/css/skins/skin-blue-light.css">
        <!-- <link rel="stylesheet" href="plugins/datatables/datatables.min.css"> -->
        <link rel="stylesheet" href="plugins/footable/css/footable.bootstrap.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
       

    </body>

</html>
