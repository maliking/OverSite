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

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Re/Max Salinas | My Inventory</title>
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
                My Inventory
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> My Inventory</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
           <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3>Open House Listings</h3>
                        </div>
                        <div class="box-body">


                            <table class="table">
                                <?php
                                $dbConn = getConnection();
                                $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip, bedrooms, bathrooms, price
                        FROM HouseInfo
                        WHERE userId = :userId";
                                $namedParameters = array();
                                $namedParameters[':userId'] = $_SESSION['userId'];
                                $stmt = $dbConn->prepare($sql);
                                $stmt->execute($namedParameters);
                                $results = $stmt->fetchAll();

                                for ($i = 0; $i < sizeof($keys); $i++) {
                                    echo "<tr>";
                                    echo "<td style=\"padding-left:10%\"><img src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error' width=\"225px\" height=\"200px\"></td>";
                                    echo "<td>";
                                    echo $response[$keys[$i]]['address'] . "<br>" . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . ", " . $response[$keys[$i]]['zipcode'];
                                    echo "</td>";
                                    echo "<td>";

                                    echo '<a href="openhouse/create-flyer.php?id=' . $response[$keys[$i]]['listingID'] . '"><button type="button" class="btn btn-primary ">Create a New Flyer</button></a></br></br>';
                                    echo '<a href=signIn.php?id=' . $response[$keys[$i]]['listingID'] . ' target="_blank"><button type="button" class="btn btn-primary">Sign-In</button></a></br></br>';
                                    echo '<a href="openhouse/singleListingVisitors.php?id=' . $response[$keys[$i]]['listingID'] . '"><button type="button" class="btn btn-primary ">Listing Visitors</button></a></br></br>';
                                    echo '<button type="button" class="btn btn-danger">Remove</button></br></br>';
                                    echo "                               </td>";
                                    echo "</tr>";

                                }
                                ?>
                            </table>


                            <?php
                    //         for ($i = 0; $i < 2; $i++) {
                    //             echo '<div class="col-md-3 col-sm-3 col-xs-4">
                    //      <div class="thumbnail">
                    //         <div class="image view view-first">';
                    //             echo "<img src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error' width=\"50%\" height=\"100%\">";
                    //             echo '           <div class="mask">
                    //                 <p>Options</p>
                    //                 <div class="tools tools-bottom">
                    //                     <a href="../openhouse/create-flyer.php" data-toggle="tooltip" title="Create Flyer"><i class="fa fa-paint-brush"></i></a>
                    //                     <a href="../openhouse/listing-info.php" data-toggle="tooltip" title="Listing Information"><i class="fa fa-info-circle"></i></a>
                    //                     <a href="../signIn.php" data-toggle="tooltip" title="Sign In Sheet"><i class="fa fa-edit"></i></a>  
                    //                     <a href="#" data-toggle="tooltip" title="Remove"><i class="fa fa-trash-o"></i></a>
                    //                 </div>
                    //             </div>
                    //         </div>
                    //         <div class="caption">';
                    //             echo '    <p>' . $response[$keys[$i]]['address'] . "<br>" . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . ", " . $response[$keys[$i]]['zipcode'] . '</p>';
                    //             echo '</div>
                    //     </div>
                    // </div>';
                    //         }
                            ?>

                        </div>


                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
    </div>
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
</script>
</body>

</html>