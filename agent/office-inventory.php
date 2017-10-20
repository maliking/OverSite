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
    <title>Re/Max Salinas | Office Inventory</title>
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
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
                            <table class="table table-bordered table-striped" id="inventory-table">
                                <thead>


                                <tr>
                                    <th>Agent</th>
                                    <th data-breakpoints="all">Client</th>
                                    <th data-breakpoints="xs sm">Property</th>
                                    <th data-breakpoints="xs sm">Bedroom</th>
                                    <th data-breakpoints="xs sm">Bathroom</th>
                                    <th data-breakpoints="xs sm">Price</th>
                                    <th data-breakpoints="xs sm"></th>

                                </tr>
                                </thead>
                                <?php
                                // foreach ($result as $house) {
                                for ($i = 0; $i < sizeof($keys); $i++) {

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

                                    echo '<tbody><tr><td>Jorge Edeza</td>
                                                <td>Images</td>
                                                <td> ' . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] .  ' </td>
                                                <td>' . $bedrooms . '</td>
                                                <td>'. $bathrooms .'</td>
                                                <td>'.$response[$keys[$i]]['listingPrice'] .'</td>
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
        $('.table').footable({});
    });
</script>
</body>
</html>
