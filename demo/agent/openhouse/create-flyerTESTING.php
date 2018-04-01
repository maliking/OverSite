<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
clearstatcache();
$listingId = $_GET['id'];

require '../../databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM  HouseInfo WHERE listingId = :listingId";
$stmt = $dbConn->prepare($sql);
$namedParameters = array();
$namedParameters[':listingId'] = $listingId;
$stmt->execute($namedParameters);
$result = $stmt->fetch();


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

// print_r($response);

$keys = array_keys($response);

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Home</title>
    <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<!-- END TEMPLATE nav.php INCLUDE -->

<p>If you click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>

<p>If you click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>


<?php
for ($i = 0; $i < sizeof($keys); $i++) {

    if ($response[$keys[$i]]['listingID'] == $listingId) {
        $index = $i;
        for ($j = 0; $j < (int)$response[$keys[$i]]['image']['totalCount']; $j++) {
            echo '<label class="item col-md-4 col-sm-4 col-xs-6">
                                                                <input class="js-switch" type="checkbox" name="imageURL" value="' . $response[$keys[$i]]['image'][$j]['url'] . '"/> 
                                                                <img src="' . $response[$keys[$i]]['image'][$j]['url'] . '" style="width:100%; height:100%" >
                                                            </label>';
        }
        break;
    }
}
?>


<script>
    $(document).ready(function () {
        $("p").click(function () {
            $(this).hide();
        });
        $('.js-switch').click(function () {
            if ($('.js-switch:checked').length > 3) {
                $(this).prop('checked', false);
                alert("allowed only 3");
            }
        });
    });
    /*
     * For demonstration porpuse, all JavaScript code was incorporated in
     * the HTML file. But when developing your application, your JavaScript code
     * should be in a separated file. Check this page for more information:
     * https://developer.yahoo.com/performance/rules.html#external

    $('.js-switch :checkbox').change(function () {
        alert("Hello! I am an alert box!!");
        var $cs = $(this).closest('.js-switch').find(':checkbox:checked');
        if ($cs.length > 3) {
            this.checked = false;
        }
    });*/
</script>

</body>

</html>
