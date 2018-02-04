<?php
session_start();
clearstatcache();
if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();



// $sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm FROM UsersInfo LEFT JOIN commInfo on UsersInfo.license = commInfo.license group by UsersInfo.license order by sold Desc ";
// $stmtRank = $dbConnRank->prepare($sqlRank);
// $stmtRank->execute();
// $rank = $stmtRank->fetchAll();
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
$pendingListings = (int)$addedHouseResults['added'];
for($i = 0; $i < sizeof($keys); $i++) 
{
    if($response[$keys[$i]]['listingAgentID'] == $licenseResult['mlsId'])
    {
        $pendingListings++;
    }
}
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | Dashboard</title>

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
            
            .btn-group {
                display: inline-block!important
            }

        </style>
        <style type "text/css">


        .blink {
            -webkit-animation: blink .75s linear infinite;
            -moz-animation: blink .75s linear infinite;
            -ms-animation: blink .75s linear infinite;
            -o-animation: blink .75s linear infinite;
             animation: blink .75s linear infinite;
        }
        @-webkit-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @-moz-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @-ms-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @-o-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
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


            <?php include "./fullcalendar/links.php" ?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                    <!-- Content Wrapper. Contains page content -->
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>
                                        <sup style="font-size: 20px">$</sup>0</h3>
                                    <p>Listing Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-dollar"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><?php echo number_format($result['avgPercent'], 2); ?><sup style="font-size: 20px">%</sup></h3></h3>
                                    <p>Listing Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        <sup style="font-size: 20px">$</sup>0</h3>
                                    </h3>
                                    <p>Buyer Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-dollar"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3><?php echo number_format($result['avgPercent'], 2); ?><sup style="font-size: 20px">%</sup></h3></h3>
                                    <p>Buyer Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>
                                        <?php echo number_format($result['avgPercent'], 0); ?><sup style="font-size: 20px">%</sup></h3>
                                    <p>Active Listings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-flash"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup>
                                        <?php echo number_format($result['earnings'], 0); ?>
                                    </h3>
                                    <p>Total Gross Earnings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bank"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->


                    <!--MODAL AREA!!-->


                    <div class="modal modal-primary fade" id="modal-primary">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="titleName">John Doe</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <i>Scheduled to contact: </i>
                                                <b id="meetingTime">9:15am</b> <i id="meetingDay">September 23, 2017</i>
                                            </div>
                                        </div>
                                        <div class="row">


                                            <!-- Start Box-->
                                            <div class="box">

                                                <div class="box-body no-padding">
                                                    <table id="modal-table" class="table footable table-striped">
                                                        <tr>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                        </tr>
                                                        <tr>
                                                            <td id="firstName">John</td>
                                                            <td id="lastName">Doe</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Phone</th>
                                                        </tr>
                                                        <tr>
                                                            <th id="phone"></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Min Bed</th>
                                                            <th>Min Bath</th>
                                                        </tr>
                                                        <tr>
                                                            <td id="minBed">2</td>
                                                            <td id="minBath">2
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Min Price</th>
                                                            <th>Max Price</th>
                                                        </tr>
                                                        <tr>
                                                            <td id="minPrice">$120,000</td>
                                                            <td id="maxPrice">$910,000</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Looking to purchase home within:</th>
                                                            <th>Pre-Approved?</th>
                                                        </tr>
                                                        <tr>
                                                            <td id="purchaseWithin">3-6 months</td>
                                                            <td>
                                                                <form action="">
                                                                    <input type="radio" name="preapproved" value="yes"> Yes
                                                                    <br>
                                                                    <input type="radio" name="preapproved" value="no"> No
                                                                    <br>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th>Notes from open house</th>
                                                        </tr>
                                                        <tr>
                                                            <td id="notes">Preferes large back yard for 2 dogs.</td>
                                                            <p id="id" hidden></p>
                                                        </tr>
                                                        <tr></tr>
                                                        <tr>
                                                            <th>Schedule next call appointment:</th>
                                                            <th>
                                                                <p>Schedule in person appointment:</th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <i class="fa fa-calendar"></i>
                                                                <input type="text" class="form-control pull-right" id="datepicker">
                                                            </td>
                                                            <td>
                                                                <i class="fa fa-calendar"></i>
                                                                <input type="text" class="fa fa-calendar form-control pull-right" id="datepicker">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <!-- /.box-body -->
                                            </div>
                                            <!-- /.box -->

                                            <div class="col-md-12">
                                                <p>Additional Notes:</p>
                                                <textarea id="textArea" style="color:black;" rows="6" cols="60"></textarea>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close
                                </button>
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" onClick="deleteMeeting()">Delete
                                    Appointment
                                </button>
                                <button type="button" class="btn btn-outline" onClick="saveMeeting()">Save changes
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->

                    <!-- /.modal -->
                    <div class="container">
                        <!--MODAL AREA-->
                    </div>


                    <!-- END example modal-->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h4>In-Contract Properties</h4>
                                </div>
                                <div class="box-body">
                                    <table class="table footable table-bordered table-striped"  >
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Client</th>
                                            <th>Property</th>

                                            <th data-breakpoints="all">Client Number</th>
                                            <th data-breakpoints="all">Client Email</th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Accepted Date">Acc. </a></th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="Earnest Money Deposit">EMD </a>
                                            </th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="Disclosures">Seller Disc. </a>
                                            </th>

                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="Inspection">Insp. </a>
                                            </th>


                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="Appraisal">Appr. </a>
                                            </th>

                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Loan Contingencies">LC </a></th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Close of Escrow">COE </a></th>
                                            <th data-breakpoints="xs sm">Notes</th>
                                            <th data-breakpoints="xs sm"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach ($transResults as $trans) {
                                                # code...
                                                $day = $trans['accDay'];

                                                echo '<td>';
                                                if ($trans['transType'] == 'Listing') {
                                                    echo '<b>LIST</b>';
                                                } else {
                                                    echo '<b>BUY</b>';
                                                }
                                                echo '</td>
                                            <td>' . $trans['clientName'] . '</td>
                                            <td>' . $trans['address'] . '</td>
                                            <td>' . $trans['clientNum'] . '</td>
                                            <td>Test Email</td>
                                            <td>
                                                <div class="btn-group">
                                                    ' . date('m/d/y', strtotime($day)) . ' 
                                                </div>
                                                <i class="fa fa-check-circle" style="color:#5cb85c"></i>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['emdDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
                                                  if($trans['emdComp'] != NULL && $trans['emdComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['emdComp'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  $today = new DateTime('today');
                                                  $emdOnTime = new DateTime($trans['accDay']);
                                                  $emdOnTime = $emdOnTime->add(new DateInterval('P'.$trans['emdDays'] .'D'));

                                                  $emdReduced = new DateTime($trans['accDay']);
                                                  $emdReduced = $emdReduced->add(new DateInterval('P'.$trans['emdDays'] .'D'));
                                                  $emdReduced = $emdReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['emdComp'] != NULL && $trans['emdComp'] != '0000-00-00')
                                                  {
                                                    echo '<i class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $emdReduced && $today < $emdOnTime)
                                                    {
                                                        echo '<i class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $emdOnTime)
                                                    {
                                                        echo '<i class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  
                                                  if($trans['sellerDiscComp'] != NULL && $trans['sellerDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['sellerDiscRec'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Date Recieved: N/A</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['sellerDiscComp'] != NULL && $trans['sellerDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['sellerDiscComp'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $sellerOnTime = new DateTime($trans['accDay']);
                                                  $sellerOnTime = $sellerOnTime->add(new DateInterval('P'.$trans['sellerDiscDays'] .'D'));

                                                  $sellerReduced = new DateTime($trans['accDay']);
                                                  $sellerReduced = $sellerReduced->add(new DateInterval('P'.$trans['sellerDiscDays'] .'D'));
                                                  $sellerReduced = $sellerReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['sellerDiscComp'] != NULL && $trans['sellerDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<i class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $sellerReduced && $today < $sellerOnTime)
                                                    {
                                                        echo '<i class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $sellerOnTime)
                                                    {
                                                        echo '<i class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
        
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['genInspecDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
                                                  if($trans['genInspecComp'] != NULL && $trans['genInspecComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['genInspecComp'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $genOnTime = new DateTime($trans['accDay']);
                                                  $genOnTime = $genOnTime->add(new DateInterval('P'.$trans['genInspecDays'] .'D'));

                                                  $genReduced = new DateTime($trans['accDay']);
                                                  $genReduced = $genReduced->add(new DateInterval('P'.$trans['genInspecDays'] .'D'));
                                                  $genReduced = $genReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['genInspecComp'] != NULL && $trans['genInspecComp'] != '0000-00-00')
                                                  {
                                                    echo '<i class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $genReduced && $today < $genOnTime)
                                                    {
                                                        echo '<i class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $genOnTime)
                                                    {
                                                        echo '<i class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>               
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['appraisalDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['apprOrdered'] != NULL && $trans['apprOrdered'] != '0000-00-00')
                                                    {
                                                        echo '<li><a href="#">Ordered: ' . date('m/d/y', strtotime($trans['apprOrdered'])) . '</a></li>';
                                                    }
                                                    else
                                                    {
                                                        echo '<li><a href="#">Ordered: N/A</a></li>';
                                                    }
                                                    
                                                echo '<li role="separator" class="divider"></li>';

                                                  if($trans['apprComp'] != NULL && $trans['apprComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['apprComp'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                
                                                    
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $apprOnTime = new DateTime($trans['accDay']);
                                                  $apprOnTime = $apprOnTime->add(new DateInterval('P'.$trans['appraisalDays'] .'D'));

                                                  $apprReduced = new DateTime($trans['accDay']);
                                                  $apprReduced = $apprReduced->add(new DateInterval('P'.$trans['appraisalDays'] .'D'));
                                                  $apprReduced = $apprReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['apprComp'] != NULL && $trans['apprComp'] != '0000-00-00')
                                                  {
                                                    echo '<i class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $apprReduced && $today < $apprOnTime)
                                                    {
                                                        echo '<i class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $apprOnTime)
                                                    {
                                                        echo '<i class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['lcDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
                                                  if($trans['lcComp'] != NULL && $trans['lcComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['lcComp'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $lcOnTime = new DateTime($trans['accDay']);
                                                  $lcOnTime = $lcOnTime->add(new DateInterval('P'.$trans['lcDays'] .'D'));

                                                  $lcReduced = new DateTime($trans['accDay']);
                                                  $lcReduced = $lcReduced->add(new DateInterval('P'.$trans['lcDays'] .'D'));
                                                  $lcReduced = $lcReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['lcComp'] != NULL && $trans['lcComp'] != '0000-00-00')
                                                  {
                                                    echo '<i class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $lcReduced && $today < $lcOnTime)
                                                    {
                                                        echo '<i class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $lcOnTime)
                                                    {
                                                        echo '<i class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['coeDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['coeComp'] != NULL && $trans['coeComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Original Due Date: ' . date('m/d/y', strtotime($trans['coeOrgDate'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Original Due Date: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }

                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['coeComp'] != NULL && $trans['coeComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['coeComp'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $coeOnTime = new DateTime($trans['accDay']);
                                                  $coeOnTime = $coeOnTime->add(new DateInterval('P'.$trans['coeDays'] .'D'));

                                                  $coeReduced = new DateTime($trans['accDay']);
                                                  $coeReduced = $coeReduced->add(new DateInterval('P'.$trans['coeDays'] .'D'));
                                                  $coeReduced = $coeReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['coeComp'] != NULL && $trans['coeComp'] != '0000-00-00')
                                                  {
                                                    echo '<i class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $coeReduced && $today < $coeOnTime)
                                                    {
                                                        echo '<i class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $coeOnTime)
                                                    {
                                                        echo '<i class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td id=' . $trans['transId'] . '> ' . $trans['notes']  . ' </td>
                                           <td> <button onClick=takeTransNote(' .$trans['transId'] . ')>  <i class="fa fa-edit" style="color:#d3d3d3"></i> </button></td>
                                        </tr>';
                                    }
                                            ?>

                                        </tbody>
                                    </table>
                                </div> <!-- /.box-body -->
                            </div> <!-- /.box -->
                            <div class="box box-primary">
                                <div class="box-body">
                                    <!-- THE CALENDAR -->
                                    <div id="calendar" style="height:600px;"></div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. box -->
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


        <script type="text/javascript" src="../dist/js/vendor/footable.min.js"></script>

        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/moment-with-locales.min.js"></script>
        <script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.buttons.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.nonblock.js"></script>

        <!-- Custom Theme Scripts -->

        <!-- date-range-picker -->
        <script src="../plugins/moment/moment.min.js"></script>
        <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })
            jQuery(function($){
                $('.footable').footable({
                    "paging": {
                        "enabled": true,
                        "size": 4,
                        "position": "right"
                    }

                });
            });

        </script>
        <script>
            function saveMeeting() {
                var id = $('#id').text();
                var newNote = $('#textArea').val();
                $.post("saveNoteCalendar.php", {
                    id: id,
                    note: newNote
                });
                $('#notes').html(newNote);
                // $('#modal-primary').modal('toggle');
                // alert();
                alert("Note Saved");
            }

            function deleteMeeting()
            {
                var id = $('#id').text();
                $.post("deleteMeeting.php", {
                    id: id,
                });
                $('#calendar').fullCalendar('removeEvents', id.replace(" ", "T" ));
                // alert(id);
                alert("meeting deleted");
            }

            $(document).ready(function() {
                $('#calendar').fullCalendar({

                    eventSources: [{
                        url: 'getMeetings.php', // use the `url` property
                        color: 'yellow', // an option!
                        textColor: 'black' // an option!
                    }],
                    header: {
                        left: 'title',
                        center: 'month,agendaWeek,basicDay',
                        right: 'today prev,next'
                    },
                    firstDay: 6,
                    customButtons: {
                        myCustomButton: {
                            text: 'custom!',
                            click: function() {
                                alert('clicked the custom button!');
                            }
                        }
                    },
                    // businessHours: {
                    //     // days of week. an array of zero-based day of week integers (0=Sunday)
                    //     // dow: [ 1, 2, 3, 4 ], // Monday - Thursday

                    //     start: '07:30', // a start time (10am in this example)
                    //     end: '21:00', // an end time (6pm in this example)
                    // },
                    editable: true,
                    defaultView: 'agendaWeek',
                    duration: {
                        days: 7
                    },
                    selectable: true,
                    selectHelper: true,
                    eventLimit: true,
                    // firstHour: 12,
                    minTime: '07:00:00',
                    maxTime: '21:00:00',
                    slotDuration: '00:15:00',
                    height: "parent",
                    navLinks: true, // can click day/week names to navigate views
                    eventLimit: true, // allow "more" link when too many events

                    select: function(start, end) {
                        var title = prompt('Event Title:');
                        var eventData;
                        if (title) {
                            eventData = {
                                title: title,
                                start: start,
                                end: end
                            };


                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                        }
                        $('#calendar').fullCalendar('unselect');
                    },
                    eventClick: function(event, element) {
                        var id = event.id.replace("T", " ");

                        var formData = {
                            id: id
                        };

                        $.ajax({
                            url: "getMeetingInfo.php",
                            type: "POST",
                            data: formData,
                            success: function(data, textStatus, jqXHR) {
                                var meetingInfo = JSON.parse(data);
                                $('#titleName').html(meetingInfo['firstName'] + " " + meetingInfo['lastName']);

                                $('#firstName').html(meetingInfo['firstName']);

                                $('#lastName').html(meetingInfo['lastName']);
                                $('#phone').html(meetingInfo['phone']);
                                $('#minBed').html(meetingInfo['bedroomsMin']);
                                $('#minBath').html(meetingInfo['bathroomsMin']);
                                $('#minPrice').html(meetingInfo['priceMin']);
                                $('#maxPrice').html(meetingInfo['priceMax']);
                                $('#purchaseWithin').html(meetingInfo['howSoon']);
                                $('#notes').html(meetingInfo['note']);
                                $('#id').html(meetingInfo['meeting']);
                                $('#textArea').val(meetingInfo['note']);

                                $('#meetingTime').html(meetingInfo['meetingFormat'].substring(10,16));
                                $('#meetingDay').html(meetingInfo['meetingFormat'].substring(0,10));

                            }
                        });
                        $("#modal-primary").modal();
                        // alert(event.id);

                    },

                    eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {

                        // alert(event.title + " end is now " + event.start.format().replace("T", " ") + " " + event.id.replace("T", " "));

                        var id = event.id.replace("T", " ");
                        var startTime = event.start.format().replace("T", " ");
                        var endTime = event.end.format().replace("T", " ");

                        if (!confirm("is this okay?")) {
                            revertFunc();
                        } else {
                            event.id = startTime;
                            var formData = {
                                id: id,
                                start: startTime,
                                end: endTime
                            };
                            $.ajax({
                                url: "updateMeeting.php",
                                type: "POST",
                                data: formData,
                                success: function(data, textStatus, jqXHR) {
                                    // alert("finished");
                                }
                            });

                        }

                    },
                    eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {

                        // alert("ive been resized!!!");
                        var id = event.id.replace("T", " ");
                        var startTime = event.start.format().replace("T", " ");
                        var endTime = event.end.format().replace("T", " ");

                        if (!confirm("is this okay?")) {
                            revertFunc();
                        } else {
                            $.post("updateMeeting.php", {
                                id: id,
                                start: startTime,
                                end: endTime
                            });
                            // alert("finished");
                        }
                    }


                });

            });
        
        function takeTransNote(transId)
        {
            var prevNote = $("#" + transId).html();
            var noteEntered = prompt("Enter Note:", prevNote);
            if (noteEntered == null || noteEntered == "") {
            } else {
                $("#" + transId).html(noteEntered);
                // alert(houseId + " " + buyerID);
                $.post("saveTransNote.php", {
                    transId: transId,
                    note: noteEntered
                });
                
            }

        }

            // window.setInterval(function() { // Set interval for checking
            //     var date = new Date(); // Create a Date object to find out what time it is
            //     if (date.getHours() === 18 && date.getMinutes() === 49) { // Check the time
            //
            //         new PNotify({
            //             title: 'Contact Client',
            //             text: 'Must send email to John by 5:15pm.',
            //             styling: 'fontawesome'
            //
            //         });
            //     }
            // }, 60000); // Repeat every 60000 milliseconds (1 minute)

        </script>


    </body>

    </html>
