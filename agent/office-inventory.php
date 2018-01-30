<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}

require '../databaseConnection.php';
$dbConn = getConnection();
// $dbConn = getConnection();
// $sql = "SELECT address, city, state, zip FROM  HouseInfo";
// $stmt = $dbConn->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll();

function updateSort($sort)
{
    if ($sort == 1) {
        return 0;
    } else {
        return 1;
    }
}

//sort variables; 1 will be alphabetical; 0 will be reverse alphabetical
$agentSort = 1;
$propertySort = 1;
$bedroomSort = 1;
$bathroomSort = 1;
$priceSort = 1;

if (isset($_GET['agentSort'])) {
    $agentSort = $_GET['agentSort'];
}
if (isset($_GET['propertySort'])) {
    $propertySort = $_GET['propertySort'];
}
if (isset($_GET['bedroomSort'])) {
    $bedroomSort = $_GET['bedroomSort'];
}
if (isset($_GET['bathroomSort'])) {
    $bathroomSort = $_GET['bathroomSort'];
}
if (isset($_GET['priceSort'])) {
    $priceSort = $_GET['priceSort'];
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

                                    
                                        $agentName = "SELECT firstName, lastName FROM UsersInfo WHERE mlsId = :mlsId";
                                        $namedParameters = array();
                                        $namedParameters[':mlsId'] = $response[$keys[$i]]['listingAgentID'];
                                        $stmt = $dbConn->prepare($agentName);
                                        $stmt->execute($namedParameters);
                                        $name = $stmt->fetch();
    array_push($response[$keys[$i]]['agentName'], $name['firstName'] . " " . $name['lastName']);              

}



function priceASC($a, $b)
{
    return strcmp($a["listingPrice"], $b["listingPrice"]);
}

function priceDESC($a, $b)
{
    return strcmp($b["listingPrice"], $a["listingPrice"]);
}

function bathroomASC($a, $b)
{
    return strcmp($a["totalBaths"], $b["totalBaths"]);
}

function bathroomDESC($a, $b)
{
    return strcmp($b["totalBaths"], $a["totalBaths"]);
}

function bedroomASC($a, $b)
{
    return strcmp($a["bedrooms"], $b["bedrooms"]);
}

function bedroomDESC($a, $b)
{
    return strcmp($b["bedrooms"], $a["bedrooms"]);
}

function propertyASC($a, $b)
{
    return strcmp(SUBSTR(LTRIM($a["address"]), LOCATE(' ', LTRIM($a["address"]))), SUBSTR(LTRIM($b["address"]), LOCATE(' ', LTRIM($b["address"]))));
}

function propertyDESC($a, $b)
{
    return strcmp(SUBSTR(LTRIM($b["address"]), LOCATE(' ', LTRIM($b["address"]))), SUBSTR(LTRIM($a["address"]), LOCATE(' ', LTRIM($a["address"]))));
}

function agentASC($a, $b)
{
    return strcmp($a["bedrooms"], $b["bedrooms"]);
}

function agentDESC($a, $b)
{
    return strcmp($b["bedrooms"], $a["bedrooms"]);
}


if (isset($_GET['agentSort'])) {
        if ($agentSort == 1) {
            usort($response, "agentASC");
        } else {
            usort($response, "agentDESC");
        }
} elseif (isset($_GET['propertySort'])) {
        if ($propertySort == 1) {
            //usort($response, "propertyASC");
        } else {
            //usort($response, "propertyDESC");
        }
} elseif (isset($_GET['priceSort'])) {
        if ($priceSort == 1) {
            usort($response, "priceASC");
            //$sql .= "SUBSTR(LTRIM(address), LOCATE(' ', LTRIM(address))) ASC";
        } else {
            usort($response, "priceDESC");
            //$sql .= "SUBSTR(LTRIM(address), LOCATE(' ', LTRIM(address))) DESC";
            }
} elseif (isset($_GET['bedroomSort'])) {
        if ($bedroomSort == 1) {
            usort($response, "bedroomASC");
        } else {
            usort($response, "bedroomDESC");
        }
} elseif (isset($_GET['bathroomSort'])) {
        if ($bathroomSort == 1) {
            usort($response, "bathroomASC");
        } else {
            usort($response, "bathroomDESC");
        }
} else {
        usort($response, "priceASC"); //CHANGE IT TO AGENT WHEN COMPLETE
}

// print_r($response);

$keys = array_keys($response);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Office Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-agent/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="../dist/css/vendors/footable.bootstrap.min.css">
</head>

<body class="hold-transition skin-red-light sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-agent/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-agent/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Office Inventory
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Office Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered table-striped"
                                   id="inventory-table" data-filtering="true">
                                <thead>
                                <tr>
                                    <th data-breakpoints="xs">Agent</th>
                                    <th>Property</th>
                                    <th data-type="number">Bd</th>
                                    <th data-type="number">Ba</th>
                                    <th>Price</th>
                                    <th data-breakpoints="xs">Images</th>
                                    <th data-breakpoints="xs">Open House</th>
                                    <th data-breakpoints="xs">Map</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // foreach ($result as $house) {
                                for ($i = 0; $i < sizeof($keys); $i++) {
                                        $agentName = "SELECT firstName, lastName FROM UsersInfo WHERE mlsId = :mlsId";
                                        $namedParameters = array();
                                        $namedParameters[':mlsId'] = $response[$keys[$i]]['listingAgentID'];
                                        $stmt = $dbConn->prepare($agentName);
                                        $stmt->execute($namedParameters);
                                        $name = $stmt->fetch();

                                        if(!isset($response[$keys[$i]]['bedrooms']))
                                        {
                                            $bedrooms = "0";
                                        }
                                        else
                                        {
                                            $bedrooms = $response[$keys[$i]]['bedrooms'];
                                        }
                                        if(!isset($response[$keys[$i]]['totalBaths']))
                                        {
                                            $bathrooms = "0";
                                        }
                                        else
                                        {
                                            $bathrooms = $response[$keys[$i]]['totalBaths'];
                                        }   

                                        echo '<tr><td> ' . $name['firstName'] . " " . $name['lastName'] .  '</td>
                                                    <td> ' . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] .  ' </td>
                                                    <td>' . $bedrooms . '</td>
                                                    <td>'. $bathrooms .'</td>
                                                    <td>'.$response[$keys[$i]]['listingPrice'] .'</td>
                                                    <td ><a href="viewHouseImages.php?id=' . $response[$keys[$i]]['listingID'] . '" target="_blank"><button >View</button></a></td>

                                                    <td><a href=openhouse/create-flyer.php?id=' . $response[$keys[$i]]['listingID'] . ' target=\"_blank\"><button>Open House Sign-In</button></a></td>


                                                    <td ><a href="https://maps.google.com/?q=' . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] . '" target="_blank"><button >View on Map</button></a></td>
                                                    
                                                </tr>';
                                    
                                }
                                ?>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-agent/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-agent/default-js.php" ?>
<!-- END TEMPLATE default-css.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="../dist/js/vendors/footable.min.js"></script>
<script>
    jQuery(function ($) {
        $('.table').footable({
            "sorting": {
                "enabled": true
            },
            "paging": {
                "enabled": true,
                "size": 15
            }
        });
    });
</script>
</body>
</html>
