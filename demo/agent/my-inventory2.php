<?php

require("../databaseConnection.php");
session_start();
$dbConn = getConnection();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
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

// print_r($response);

$keys = array_keys($response);

$getAddedListings = "SELECT * FROM HouseInfo WHERE status = :status AND userId = :userId";
$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];
$namedParameters[':status'] = "added";
$addedListings = $dbConn->prepare($getAddedListings);
$addedListings->execute($namedParameters);
$addedListingsResults = $addedListings->fetchAll();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | My Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-agent/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="../dist/css/vendors/footable.bootstrap.min.css">
    <style>
        .btn-block {
            padding: 0px;
        }

        .listing-info {
            text-align: center;
        }
    </style>

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
                My Inventory
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> My Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->

        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="matchLeads" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Top 5 Leads</h4>
                    </div>
                    <div class="modal-body">
                        1: <strong>Agent: </strong><span id="agentName0">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>BuyerID: </strong><span id="buyerId0">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Price: </strong><span id="price0">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bedroom: </strong><span id="minBed0">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bathroom: </strong><span id="minBath0">Not Available</span>

                        </br></br>

                        2: <strong>Agent: </strong><span id="agentName1">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>BuyerID: </strong><span id="buyerId1">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Price: </strong><span id="price1">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bedroom: </strong><span id="minBed1">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bathroom: </strong><span id="minBath1">Not Available</span>
                        </br></br>
                        3: <strong>Agent: </strong><span id="agentName2">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>BuyerID: </strong><span id="buyerId2">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Price: </strong><span id="price2">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bedroom: </strong><span id="minBed2">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bathroom: </strong><span id="minBath2">Not Available</span>
                        </br></br>
                        4: <strong>Agent: </strong><span id="agentName3">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>BuyerID: </strong><span id="buyerId3">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Price: </strong><span id="price3">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bedroom: </strong><span id="minBed3">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bathroom: </strong><span id="minBath3">Not Available</span>
                        </br></br>
                        5: <strong>Agent: </strong><span id="agentName4">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>BuyerID: </strong><span id="buyerId4">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Price: </strong><span id="price4">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bedroom: </strong><span id="minBed4">Not Available</span>&nbsp&nbsp&nbsp
                        <strong>Min-Bathroom: </strong><span id="minBath4">Not Available</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <section class="content">
            <div class="row">

                <?php
                // $dbConn = getConnection();
                $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip, bedrooms, bathrooms, price
                          FROM HouseInfo
                         WHERE userId = :userId";
                $namedParameters = array();
                $namedParameters[':userId'] = $_SESSION['userId'];
                $stmt = $dbConn->prepare($sql);
                $stmt->execute($namedParameters);
                $results = $stmt->fetchAll();

                $agentMlsId = "SELECT mlsId 
                                 FROM UsersInfo 
                                WHERE userId = :userId";
                $namedParameters = array();
                $namedParameters[':userId'] = $_SESSION['userId'];
                $stmt = $dbConn->prepare($agentMlsId);
                $stmt->execute($namedParameters);
                $mlsIdResult = $stmt->fetch();

                for ($i = 0; $i < sizeof($keys); $i++) {
                    if ($response[$keys[$i]]['listingAgentID'] == $mlsIdResult['mlsId']) {
                        if (!isset($response[$keys[$i]]['bedrooms'])) {
                            $houseBedrooms = 0;
                        } else {
                            $houseBedrooms = $response[$keys[$i]]['bedrooms'];
                        }
                        if (!isset($response[$keys[$i]]['totalBaths'])) {
                            $houseBaths = 0;
                        } else {
                            $houseBaths = $response[$keys[$i]]['totalBaths'];
                        }
                        echo "<div class=\"col-xs-3\">
                                <div class=\"box\">
                                    <div class=\"box-header with-border\">
                                        <h4 class='box-title'>" . $response[$keys[$i]]['address'] . "<br>" .
                                            $response[$keys[$i]]['cityName'] . " " .
                                            $response[$keys[$i]]['state'] . ", 
                                        " . $response[$keys[$i]]['zipcode'] . "</h4>
                                        <div class=\"box-tools pull-right\">
          
                                          <a href='#'><span class=\"label label-default\"><i class='fa fa-trash'></i> 
                                          Remove
                                          </span></a>
                                        </div>
                                    </div>
                                <div class=\"box-body\">
                                    <img class=\"img-responsive\" style='min-height: 180px' src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error'>
                                    <div class=\"listing-info\">
                                    <h4>$" . number_format($response[$keys[$i]]['rntLsePrice']) . "</h4>
                                    <h5>" . $houseBedrooms . " <i class='fa fa-bed'></i></h5>
                                    <h5>" . $houseBaths . " <i class='fa fa-bath'></i></h5>
                                    </div>
                                    <a class=\"btn btn-block\" href=\"openhouse/create-flyer.php?id=" .
                                         $response[$keys[$i]]['listingID'] . "\"><i class='fa fa-file-text-o'></i> Create a New Flyer</a>
                                    <a class=\"btn btn-block\" href=\"signIn.php?id=" . $response[$keys[$i]]['listingID'] . "\" target=\"_blank\"><i class='fa fa-key'></i> Open House Sign-In</a>
                                    <a class=\"btn btn-block\" href=\"singleListingVisitors.php?id=" .
                             $response[$keys[$i]]['listingID'] . "\" target=\"_blank\"><i class='fa fa-users'></i> Open House Visitors</a>
                                    <button type=\"button\" class=\"btn btn-link btn-block\" 
                                    onClick=\"matchLeadsModal(" . $response[$keys[$i]]['rntLsePrice'] . "," .
                             $houseBedrooms . "," . $houseBaths .  ")\"> Top 5 Leads</button>
                                    <button type=\"button\" class=\"btn btn-success btn-block\" 
                                    onClick=\"addTransaction(" . $response[$keys[$i]]['listingID'] . ")\"><i class='fa fa-check'></i> In-Contract</button>
                                </div>
                                </div>
                             </div>";
                    }
                }



//                foreach($addedListingsResults as $addHouse)
//                {
//                    $directory = "../addedHouses/" . $addHouse['address'] . "/";
//                    $files = scandir ($directory);
//                    echo "<tr>";
//                    echo "<td style=\"padding-left:10%\"><img src='" . $directory . $files[2] . "' alt='error' width=\"225px\" height=\"200px\"></td>";
//                    echo "<td>";
//                    echo $addHouse['address'] . "<br>" . $addHouse['city'] . " " . $addHouse['state'] . ", " . $addHouse['zip'];
//                    echo "</td>";
//                    echo "<td>";
//
//                    echo '<a href="openhouse/create-flyer.php?id=' . $addHouse['houseId'] . '"><button type="button" class="btn btn-primary ">Create a New Flyer</button></a></br></br>';
//                    echo '<a href=signIn.php?id=' . $addHouse['houseId'] . ' target="_blank"><button type="button" class="btn btn-primary">Sign-In</button></a></br></br>';
//                    echo '<a href="singleListingVisitors.php?id=' . $addHouse['houseId'] . '"><button type="button" class="btn btn-primary ">Listing Visitors</button></a></br></br>';
//                    echo '<button type="button" class="btn btn-primary" onClick="matchLeadsModal(' . $addHouse['price'] . "," . $addHouse['bedrooms'] . "," . $addHouse['bathrooms'] . ')">Top 5 Leads</button></br></br>';
//                    echo '<button type="button" class="btn btn-primary" onClick="addTransaction(' . $addHouse['houseId'] . ')">In-Contract</button></br></br>';
//                    echo '<button type="button" class="btn btn-danger">Remove</button></br></br>';
//                    echo "                               </td>";
//                    echo "</tr>";
//                }
                ?>





                    </div> <!-- /.box -->
                </div> <!-- /.col-xs-3 -->
            </div> <!-- /.row -->

        </section>
    </div> <!-- /.content-wrapper -->
</div> <!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-agent/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-agent/default-js.php" ?>
<!-- END TEMPLATE default-css.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<!-- Footable -->
<script src="../dist/js/vendor/footable.min.js"></script>


<script>
    jQuery(function ($) {
        $('.table').footable({});
    });
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });

    function matchLeadsModal(price,bedrooms,bathrooms)
    {
        // $.post( "getTopLeads.php", { price: price, bedrooms: bedrooms, bathrooms: bathrooms}, function( data )
        // {
        //   // console.log( data.name ); // John
        //   // console.log( data.time ); // 2pm
        //   console.log("data");

        // }, "json");
        $.post( "getTopLeads.php", { price: price, bedrooms: bedrooms, bathrooms: bathrooms})
            .done(function( data ) {
                var leadData = JSON.parse(data);
                // alert(leadData );
                for(var i = 0; i < 5; i++ )
                {
                    $('#agentName' + i).text("Not Available");
                    $('#buyerId' + i).text("Not Available");
                    $('#price' + i).text("Not Available");
                    $('#minBed' + i).text("Not Available");
                    $('#minBath' + i).text("Not Available");
                }
                for(var i = 0; i < 5; i++ )
                {
                    // $('#lead' + i).text("Agent: " + leadData[i]['agentFirstName'] + "&nbsp" + leadData[i]['agentLastName'] + "   BuyerId: " + leadData[i]['buyerID'] + "   Min-Bathrooms: " +
                    //    leadData[i]['bathroomsMin'] + "   Min-Bedrooms: " + leadData[i]['bedroomsMin'] + "   Price: " + leadData[i]['priceMax']);

                    $('#agentName' + i).text(leadData[i]['agentFirstName'] + " " + leadData[i]['agentLastName']);
                    $('#buyerId' + i).text(leadData[i]['buyerID']);
                    $('#price' + i).text(leadData[i]['priceMax']);
                    $('#minBed' + i).text(leadData[i]['bedroomsMin']);
                    $('#minBath' + i).text(leadData[i]['bathroomsMin']);


                }
            });
        // alert(mlsId);
        $('#matchLeads').modal('show');


    }

    function addTransaction(houseId)
    {
        // alert(houseId);
        $.post( "addTransaction.php", { houseId: houseId})
            .done(function( data ) {

                alert("House In-contract. Will reflect on Dashboard.");
            });




    }
</script>
</body>

</html>