<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://www.oversite.cc/login.php");
}
require '../databaseConnection.php';


$dbConn = getConnection();
$dbConnTwo = getConnection();

$sqlMlsId = "SELECT  mlsId FROM UsersInfo WHERE userId = :userId";

$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];


$mlsIdStmt = $dbConn->prepare($sqlMlsId);
$mlsIdStmt->execute($namedParameters);
$mlsIdResult = $mlsIdStmt->fetch();

$addedHouses = "SELECT * FROM HouseInfo WHERE userId = :userId AND status = :status";
$addedHouseParam = array();
$addedHouseParam[':userId'] = $_SESSION['userId'];
$addedHouseParam[':status'] = "added";

$addedHousesStmt = $dbConn->prepare($addedHouses);
$addedHousesStmt->execute($addedHouseParam);
$addedHouseResults = $addedHousesStmt->fetchAll();

$houses = $addedHousesStmt->rowCount();

$otherHouses = "SELECT * FROM HouseInfo WHERE userId = :userId AND status != :status";
$otherHouseParam = array();
$otherHouseParam[':userId'] = $_SESSION['userId'];
$otherHouseParam[':status'] = "added";

$otherHousesStmt = $dbConn->prepare($otherHouses);
$otherHousesStmt->execute($otherHouseParam);
$otherHouseResults = $otherHousesStmt->fetchAll();





function updateSort($sort)
{
    if ($sort == 1) {
        return 0;
    } else {
        return 1;
    }
}

//sort variables; 1 will be alphabetical; 0 will be reverse alphabetical
$visitorSort = 1;
$emailSort = 1;
$addressSort = 1;
$bedroomSort = 1;
$bathroomSort = 1;

if (isset($_GET['visitorSort'])) {
    $visitorSort = $_GET['visitorSort'];
}
if (isset($_GET['emailSort'])) {
    $emailSort = $_GET['emailSort'];
}
if (isset($_GET['addressSort'])) {
    $addressSort = $_GET['addressSort'];
}
if (isset($_GET['bedroomSort'])) {
    $bedroomSort = $_GET['bedroomSort'];
}
if (isset($_GET['bathroomSort'])) {
    $bathroomSort = $_GET['bathroomSort'];
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
for ($h = 0; $h < sizeof($keys); $h++)
{
    for ($g = 0; $g < sizeof($otherHouseResults); $g++)
    {
        if($response[$keys[$h]]['listingID'] == $otherHouseResults[$g]['listingID'])
        {
            unset($otherHouseResults[$g]);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | My Visitors</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-agent/default-css.php" ?>
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
    <link href="../plugins/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- daterange picker -->
    <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/ca.js"></script>

    <style>
        .panel-heading a:after {
            font-family:'Glyphicons Halflings';
            content:"\e114";
            float: right;
            color: grey;
        }
        .panel-heading a.collapsed:after {
            content:"\e079";
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
        <!-- Main content -->

        <section class="content" style="min-height:initial;">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        

                        <div class="box-body">
                            <table class="table table-striped" data-filtering="true">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>closed Units</th>
                                    <th>Vol Sold</th>
                                    <th>GCI</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $rank = 1;
                                $sql = "SELECT UsersInfo.firstName, UsersInfo.lastName, COUNT(commInfo.license) as closedUnits, commInfo.license, 
                                        SUM(commInfo.InitialGross) as volSold, SUM(commInfo.finalComm) as GCI 
                                        FROM UsersInfo LEFT JOIN commInfo ON UsersInfo.license = commInfo.license GROUP BY commInfo.license
                                        ORDER BY closedUnits DESC";

                                $namedParameters = array();
                                $namedParameters[':userId'] = $_SESSION['userId'];
                                $stmt = $dbConn->prepare($sql);
                                $stmt->execute($namedParameters);
                                $results = $stmt->fetchAll();

                                foreach($results as $result) {
                                    if($result['volSold'] == "")
                                        $result['volSold'] = 0;
                                    if($result['GCI'] == "")
                                        $result['GCI'] = 0;
                                    // Rank
                                    echo "<td>";
                                    echo $rank;
                                    echo "</td>";

                                    // Name
                                    echo "<td>";
                                    echo $result['firstName'] . " " . $result['lastName'];
                                    echo "</td>";

                                   
                                    // How soon?
                                    echo "<td>";
                                    echo $result['closedUnits'];
                                    echo "</td>";

                                    // Pre-approved?
                                    echo "<td>";
                                    echo "$" . number_format($result['volSold']);
                                    echo "</td>";

                             
                                    // Bedroom
                                    echo "<td>";
                                    echo "$" . number_format($result['GCI']);
                                    echo "</td>";

                                    echo "</tr>";
                                    $rank++;
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
<?php include "./templates-agent/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-agent/default-js.php" ?>
<!-- END TEMPLATE default-css.php INCLUDE -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type='text/javascript'
        src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.0.3/jquery.floatThead.js"></script>

<script type="text/javascript" src="//media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>

<script>
    
</script>

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
