<?php
session_start();
header('Content-Type: application/pdf');
require 'databaseConnection.php';
require("keys/cred.php");

$dbConn = getConnection();
$sql = "SELECT envelopeId FROM commInfo WHERE commId=" . $_GET['comm'];
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://demo.docusign.net/restapi/v2/accounts/" . $acId . "/envelopes/" . $result['envelopeId'] . "/documents/1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "x-docusign-authentication: { \"Username\": \"" . $username . "\",\"Password\":\"" . $password . "\",\"IntegratorKey\":\"" . $intKey . "\"  }"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
echo $response;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Sales Breakdown</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.min.css">
</head>

<body>


</body>

</html>
