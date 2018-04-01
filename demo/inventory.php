<?php
// session_start();

// require 'databaseConnection.php';

// $dbConn = getConnection();
// $sql = "SELECT * FROM HouseInfo";
// $stmt = $dbConn->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll();

session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}

require 'databaseConnection.php';
$dbConn = getConnection();
// $dbConn = getConnection();
// $sql = "SELECT address, city, state, zip FROM  HouseInfo";
// $stmt = $dbConn->prepare($sql);
// $stmt->execute();
// $result = $stmt->fetchAll();
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
    <title>RE/MAX Salinas | Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="dist/css/vendor/footable.bootstrap.min.css">
</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-admin/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-admin/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Current Inventory
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-archive"></i> Current Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                             <table class="table table-bordered table-striped" id="inventory-table">
                                <thead>


                                <tr>
                                    <th>Agent</th>
                                    <th>Property</th>
                                    <th>Bedroom</th>
                                    <th>Bathroom</th>
                                    <th>Price</th>
                                    <th>House Images</th>
                                    <th>Map</th>

                                </tr>
                                </thead>
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

                                        echo '<tbody><tr><td> ' . $name['firstName'] . " " . $name['lastName'] .  '</td>
                                                    <td> ' . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] .  ' </td>
                                                    <td>' . $bedrooms . '</td>
                                                    <td>'. $bathrooms .'</td>
                                                    <td>'.$response[$keys[$i]]['listingPrice'] .'</td>
                                                    <td ><a href="viewHouseImages.php?id=' . $response[$keys[$i]]['listingID'] . '" target="_blank"><button >View</button></a></td>

                                                    <td ><a href="https://maps.google.com/?q=' . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] . '" target="_blank"><button >View on Map</button></a></td>
                                                    
                                                </tr></tbody>';
                                    
                                }
                                ?>

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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<script type="text/javascript" src="dist/js/vendor/footable.min.js"></script>
<script>

    jQuery(function ($) {
        $('.table').footable();
    });

</script>
</body>

</html>
