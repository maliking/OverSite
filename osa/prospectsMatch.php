<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

$prospectInfoSql = "SELECT * FROM BuyerInfo WHERE buyerID = :buyerID";
$prospectParameters = array();
$prospectParameters[':buyerID'] = $_GET['visitorId'];
$prospectStmt = $dbConn->prepare($prospectInfoSql);
$prospectStmt->execute($prospectParameters);
$prospectResult = $prospectStmt->fetch();

$houseMatchSql = "SELECT DISTINCT HouseInfo.address, HouseInfo.price, HouseInfo.bedrooms, HouseInfo.bathrooms, HouseInfo.city, HouseInfo.state, 
                HouseInfo.zip , HouseInfo.sqft, HouseInfo.listingId, UsersInfo.firstName as fName, UsersInfo.lastName as lName  
                FROM HouseInfo LEFT JOIN UsersInfo ON HouseInfo.agentMlsId = UsersInfo.mlsId 
                WHERE HouseInfo.bedrooms >= :bedroom AND HouseInfo.bathrooms >= :bathroom AND HouseInfo.price BETWEEN :lessPrice AND :morePrice AND HouseInfo.houseId != '0'
                AND UsersInfo.userType != '0'
                ORDER BY price DESC";
$namedParameters = array();
$namedParameters[':morePrice'] = $prospectResult['priceMax'] + 70000;
$namedParameters[':lessPrice'] = $prospectResult['priceMax'] - 50000;
$namedParameters[':bedroom'] = $prospectResult['bedroomsMin'] ;
$namedParameters[':bathroom'] = $prospectResult['bathroomsMin'] ;
$stmt = $dbConn->prepare($houseMatchSql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();

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
        <title>RE/MAX Salinas | Sales Breakdown</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-osa/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <style>
            .modal-title {
                font-size: 150%;
                font-weight: bold;
            }
            
            #modal-table {
                color: black;
            }

        </style>
        <!-- NOTIFICATION Links-->
        

        <!-- daterange picker -->
        <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    </head>

    <body class="hold-transition skin-black sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">

            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-osa/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-osa/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->

            <!-- PAGE-SPECIFIC CSS -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                    <!-- Content Wrapper. Contains page content -->
                    <!-- Small boxes (Stat box) -->
                <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h3><?php echo $prospectResult['firstName'] . " " . $prospectResult['lastName']; ?>
                                    </h3>
                                    <h4><?php echo  "<strong>Price:</strong>  $" . number_format($prospectResult['priceMax']) .
                                    " <strong>Bed:</strong>  " . $prospectResult['bedroomsMin'] . " <strong>Bath:</strong>  " . $prospectResult['bathroomsMin'];
                                    //  . " <strong>Zip:</strong>  " . 
                                    // $prospectResult['zip'] . " <strong>SqFt:</strong> " . number_format($prospectResult['sqft']); 
                                    ?></h4>
                                    <h4>Active Prospects</h4>
                                    <!-- <button onClick="showProspectModal()">Add Prospect</button> -->
                                </div>
                                <div class="box-body" style="height:500px; overflow: auto;">
                                    <table class="table footable table-bordered table-striped">
                                        <thead>
                                            
                                            <!-- <th style="width:20px;">Favorite</th> -->
                                            <th>Agent</th>
                                            <th>Address</th>
                                            <th>Price</th>
                                            <th>Bedroom</th>
                                            <th>Bathroom</th>
                                            <th>Zip</th>
                                            <th>SQFT</th>
                                            <th>View House</th>
                                            <th>Map</th>
                                        </thead>
                                        <tbody>
                                            
                                            <?php

                                            $prospectMaxRangePrice = $prospectResult['priceMax'] + 70000;
                                            $prospectMinRangePrice = $prospectResult['priceMax'] - 50000;
                                            // foreach ($results as $house) 
                                            for ($i = 0; $i < sizeof($keys); $i++)
                                            {                                     
                                                if($response[$keys[$i]]['rntLsePrice'] <= $prospectMaxRangePrice && $response[$keys[$i]]['rntLsePrice'] >= $prospectMinRangePrice &&
                                                    $response[$keys[$i]]['totalBaths'] >= $prospectResult['bathroomsMin'] && $response[$keys[$i]]['bedrooms'] >= $prospectResult['bedroomsMin'])
                                                {     
                                                    $agentNameSql = "SELECT firstName, lastName FROM UsersInfo WHERE userId = :userId";
                                                    $param = array();
                                                    $param[':userId'] = $response[$keys[$i]]['listingAgentID'];
                                                    $stmt = $dbConn->prepare($agentNameSql);
                                                    $stmt->execute($param);
                                                    $agentNameResult = $stmt->fetch();

                                                    echo "<tr>";
                                                    echo "<td>" . $agentNameResult['firstName'] . " " . $agentNameResult['lastName'] . "</td>";
                                                    echo "<td>" . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] . "</td>";
                                                    echo "<td>$" . number_format($response[$keys[$i]]['rntLsePrice']) . "</td>";
                                                    echo "<td>" . $response[$keys[$i]]['bedrooms'] . "</td>";
                                                    echo "<td>" . $response[$keys[$i]]['totalBaths'] . "</td>";
                                                    echo "<td>" . $response[$keys[$i]]['zipcode'] . "</td>";
                                                    echo "<td>" . $response[$keys[$i]]['sqFt'] . "</td>";
                                                    echo '<td ><a href="viewHouseImages.php?id=' . $response[$keys[$i]]['listingID'] . '" target="_blank"><button >View</button></a></td>';
                                                    echo '<td ><a href="https://maps.google.com/?q=' . $response[$keys[$i]]['address'] . 
                                                        " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . 
                                                        " " . $response[$keys[$i]]['zipcode'] . '" target="_blank"><button >View on Map</button></a></td>';
                                                    echo "</tr>";
                                                }
                                            }

                                            ?>
                                            <!-- <tr>
                                            <td class="fa fa-usd"  style="color: green; text-align: center;" onClick="deleteFavorite()"></td>
                                            <td>test</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="prospectsMatch.php">House Matches</a></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->
        </div>
        <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->


        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-osa/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-osa/default-js.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->


      
        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>

        <!-- date-range-picker -->
        <script src="../plugins/moment/min/moment.min.js"></script>
        <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            jQuery(function($){
                $('.footable').footable({

                    // "paging": {
                    //     "enabled": true,
                    //     "size": 4,
                    //     "position": "right"
                    // }

                });
            });
           
        </script>


    </body>

    </html>
