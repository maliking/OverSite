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
    <title>RE/MAX Salinas | Office Inventory</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-staff/default-css.php" ?>
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

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">

    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-staff/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-staff/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Office Inventory
            </h1>
            <ol class="breadcrumb">
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Office Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->

       
                

            </div>
        </div>

        <section class="content">
            <div class="row">

                <?php
                // $dbConn = getConnection();
                $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip,
                          FROM HouseInfo";
                $stmt = $dbConn->prepare($sql);
                $stmt->execute();
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
                  
                   
                        echo "<div class=\"col-xs-12 col-md-6 col-lg-3\">
                                <div class=\"box\">
                                    <div class=\"box-header with-border\">
                                        Agent Name
                                    </div>
                                <div class=\"box-body\">
                                    <img class=\"img-responsive\" style='min-height: 180px' src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error'>
                                    <div class=\"listing-info\">
                                    
                                   <h4 class='box-title'>" . $response[$keys[$i]]['address'] . "<br>" .
                             $response[$keys[$i]]['cityName'] . " " .
                             $response[$keys[$i]]['state'] . ", 
                                        " . $response[$keys[$i]]['zipcode'] . "</h4>
                                  <table>
                                  <tr><td>APRV</td><td> 1/2/17 </td></tr>
                                  <tr><td>EMD</td><td> 1/2/17 </td></tr>
                                  <tr><td>DISC</td><td> 1/2/17 </td></tr> 
                                  <tr><td>INSP</td><td> 1/2/17 </td></tr> 
                                  <tr> <td>APPR</td><td> 1/2/17 </td></tr> 
                                  <tr><td>LC</td><td> 1/2/17 </td></tr> 
                                  <tr><td>COE</td><td> 1/2/17 </td> </tr>
                                  </table>
                                   <button type=\"button\" class=\"btn btn-primary btn-block\"> " . include 'editDates.php' . "<i class='fa fa-edit'></i> Edit Dates</button>
                                     <button type=\"button\" class=\"btn btn-success btn-block\" 
                                    onClick=\"addTransaction('" . $response[$keys[$i]]['listingID'] . "')\"><i class='fa fa-check'></i> In-Contract</button>
                                </div>
                                </div>
                             </div>";
                    
                }

                ?>





            </div> <!-- /.box -->
 
    </div> <!-- /.col-xs-3 -->
</div> <!-- /.row -->

</section>
</div> <!-- /.content-wrapper -->
</div> <!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-staff/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-staff/default-js.php" ?>
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



    function addTransaction(houseId)
    {
        // alert(houseId);
        $.post( "addTransaction.php", { houseId: houseId})
            .done(function( data ));
    }
</script>
</body>

</html>