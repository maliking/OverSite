<?php
session_start();
clearstatcache();
date_default_timezone_set('America/Los_Angeles');
if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

$favoriteSql = "SELECT * FROM favorites WHERE userId = :userId";
$favoriteParameters = array();
$favoriteParameters[':userId'] = $_SESSION['userId'];
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);
$favoriteResults = $favoriteStmt->fetchAll();

$settingSql = "SELECT * FROM settings WHERE userId = :userId";
$settingParam = array();
$settingParam[':userId'] = $_SESSION['userId'];
$settingStmt = $dbConn->prepare($settingSql);
$settingStmt->execute($settingParam);
$settingResult = $settingStmt->fetch();

$sqlGetAgents = "SELECT userId, firstName, lastName, mlsId FROM UsersInfo WHERE userId = :userId";
$dataPara = array();
$dataPara[':userId'] = $_SESSION['userId'];
$agentStmt = $dbConn->prepare($sqlGetAgents);
$agentStmt->execute($dataPara);
$agentResults = $agentStmt->fetch();
$agentResults = array($agentResults);

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


// $pendingListings = (int)$addedHouseResults['added'];
// for($i = 0; $i < sizeof($keys); $i++) 
// {
//     if($response[$keys[$i]]['listingAgentID'] == $licenseResult['mlsId'])
//     {
//         $pendingListings++;
//     }
// }

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


            .top, .bottom {
                padding: 0 5px;    
            }

            

            .bottom{
                border-top: 1px solid #000;
                display: block;
            }

            .favoriteNoteRow{
                width: 100%;
            }
            .inContractNoteRow{
                width: 100%;
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/ca.js"></script>

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
                                    <p style="font-size:20px; text-align:center; background-color:#000080; margin-left: -10px; margin-right:-10px;"><b>Closed Units Rank</b></p>
                                        <?php 

                                        if($soldRank == 0)
                                        {
                                            echo '<p style="font-size:20px;">N/A</p>';
                                            echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                        }
                                        else
                                        {
                                            if($soldRank == "1")
                                            {
                                                echo '<p style="font-size:20px;">' . 
                                                        $soldRank . '<sup style="font-size: 15px">st</sup>' . " Place  Transactions: " . $resultNumSold[$soldRank - 1]['numSold'] .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                                // if(count($resultNumSold) > 1)
                                                // {
                                                //     echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($soldRank + 1) . "  Num: " . $resultNumSold[$soldRank]['numSold'] . '</p>';
                                                // }
                                                // if(count($resultNumSold) > 2)
                                                // {
                                                //     echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($soldRank + 2) . "  Num: " . $resultNumSold[$soldRank + 1]['numSold'] . '</p>';  
                                                //}
                                            }
                                            //else if($soldRank == count($resultNumSold))
                                            else if($soldRank == "2") 
                                            {
                                               //  if(count($resultNumSold) > 2)
                                               //  {
                                               //      echo '<p><sup style="font-size: 15px">#</sup>' . 
                                               //          ($soldRank - 2) . "  Num: " . $resultNumSold[$soldRank - 3]['numSold'] . '</p>'; 
                                               //  }
                                               //  if(count($resultNumSold) > 1)
                                               //  {
                                               //      echo '<p><sup style="font-size: 15px">#</sup>' . 
                                               //          ($soldRank - 1) . "  Num: " . $resultNumSold[$soldRank - 2]['numSold'] . '</p>';
                                               // }
                                                    echo '<p style="font-size:20px;">' . 
                                                        $soldRank . '<sup style="font-size: 15px">nd</sup>' . " Place  Transactions: " . $resultNumSold[$soldRank - 1]['numSold'] .
                                                        ' </p>';
                                                    echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                                
                                            }  
                                            else if($soldRank == "3") 
                                            {
                                                echo '<p style="font-size:20px;">' . 
                                                        $soldRank . '<sup style="font-size: 15px">rd</sup>' . " Place  Transactions: " . $resultNumSold[$soldRank - 1]['numSold'] .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                            }
                                            else
                                            {
                                                // echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($soldRank - 1) . "  Num: " . $resultNumSold[$soldRank - 2]['numSold'] . '</p>';
                                                echo '<p style="font-size:20px;">' . 
                                                        $soldRank . '<sup style="font-size: 15px">th</sup>' . " Place  Transactions: " . $resultNumSold[$soldRank - 1]['numSold'] .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                                // echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($soldRank + 1) . "  Num: " . $resultNumSold[$soldRank]['numSold'] . '</p>';
                                            }

                                        }

                                        ?>
                                   
                                    
                                </div>
                                <div class="icon">
                                    <!-- <i class="fa fa-dollar"></i> -->
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <p style="font-size:20px; text-align:center; background-color:#dd7205; margin-left: -10px; margin-right:-10px;"><b>Volume Sold Rank</b> <a href="houseHistory.php"><i class="fa fa-line-chart"></i></a></p>
                                        <?php 
                                        if($volumeRank == 0)
                                        {
                                            echo '<p style="font-size:20px;">N/A</p>';
                                            echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                        }
                                        else
                                        {
                                            //echo $volumeRank . " $" . number_format($resultVolSold[$volumeRank - 1]['volSold']);

                                            if($volumeRank == "1")
                                            {
                                                

                                                echo '<p style="font-size:20px;">' . 
                                                     $volumeRank . '<sup style="font-size: 15px">st</sup>' .
                                                     " Place $" . number_format($resultVolSold[$volumeRank - 1]['volSold']) .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                                // if(count($resultVolSold) > 1)
                                                // {
                                                //     echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($volumeRank + 1) . "  $: " . number_format($resultVolSold[$volumeRank]['volSold']) . '</p>';
                                                // }
                                                // if(count($resultVolSold) > 2)
                                                // {
                                                //     echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($volumeRank + 2) . "  $: " . number_format($resultVolSold[$volumeRank + 1]['volSold']) . '</p>';  
                                                // }
                                            }
                                            //else if($volumeRank == count($resultVolSold)) 
                                            else if($volumeRank == "2") 
                                            {
                                               //  if(count($resultVolSold) > 2)
                                               //  {
                                               //      echo '<p><sup style="font-size: 15px">#</sup>' . 
                                               //          ($volumeRank - 2) . "  $: " . number_format($resultVolSold[$volumeRank - 3]['volSold']) . '</p>'; 
                                               //  }
                                               //  if(count($resultVolSold) > 1)
                                               //  {
                                               //      echo '<p><sup style="font-size: 15px">#</sup>' . 
                                               //          ($volumeRank - 1) . "  $: " . number_format($resultVolSold[$volumeRank - 2]['volSold']) . '</p>';
                                               // }
                                                    echo '<p style="font-size:20px;">' . 
                                                     $volumeRank . '<sup style="font-size: 15px">nd</sup>' .
                                                     " Place $" . number_format($resultVolSold[$volumeRank - 1]['volSold']) .
                                                        ' </p>';
                                                    echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                                
                                            }  
                                            else if($volumeRank == "3") 
                                            {
                                                    echo '<p style="font-size:20px;">' . 
                                                     $volumeRank . '<sup style="font-size: 15px">rd</sup>' .
                                                     " Place $" . number_format($resultVolSold[$volumeRank - 1]['volSold']) .
                                                        ' </p>';
                                                    echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                                
                                            } 
                                            else
                                            {
                                                // echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($volumeRank - 1) . "  $: " . number_format($resultVolSold[$volumeRank - 2]['volSold']) . '</p>';
                                                echo '<p style="font-size:20px;">' . 
                                                     $volumeRank . '<sup style="font-size: 15px">th</sup>' .
                                                     " Place $" . number_format($resultVolSold[$volumeRank - 1]['volSold']) .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px;">Team Rank</p></a>';
                                                // echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($volumeRank + 1) . "  $: " . number_format($resultVolSold[$volumeRank]['volSold']) . '</p>';
                                            }
                                        }
                                        ?>
                                    
                                </div>
                                <div class="icon">
                                    <!-- <i class="fa fa-percent"></i> -->
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <p style="font-size:20px; text-align:center; background-color:#027e11; margin-left: -10px; margin-right:-10px;">Gross Commission Rank</p>
                                        <?php 
                                        if($grossRank == 0)
                                        {
                                            echo '<p style="font-size:20px;">N/A</p>';
                                            echo '<a href="teamRank.php"><p style="font-size:20px; color: #FF3300;">Team Rank</p></a>';
                                        }
                                        else
                                        {
                                            //echo $grossRank . " $" . number_format($resultGross[$grossRank - 1]['gross']); 
                                            if($grossRank == "1")
                                            {
                                                 

                                                echo '<p style="font-size:20px;">' . 
                                                     $grossRank . '<sup style="font-size: 15px">st</sup>' .
                                                    "  $" . number_format($resultGross[$grossRank - 1]['gross']) .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                                // if(count($resultGross) > 1)
                                                // {
                                                //     echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($grossRank + 1) . "  $: " . number_format($resultGross[$grossRank]['gross']) . '</p>';
                                                // }
                                                // if(count($resultGross) > 2)
                                                // {
                                                //     echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($grossRank + 2) . "  $: " . number_format($resultGross[$grossRank + 1]['gross']) . '</p>';  
                                                // }
                                            }
                                            //else if($grossRank == count($resultGross))
                                            else if($grossRank == "2") 
                                            {
                                               //  if(count($resultGross) > 2)
                                               //  {
                                               //      echo '<p><sup style="font-size: 15px">#</sup>' . 
                                               //          ($grossRank - 2) . "  $: " . number_format($resultGross[$grossRank - 3]['gross']) . '</p>'; 
                                               //  }
                                               //  if(count($resultGross) > 1)
                                               //  {
                                               //      echo '<p><sup style="font-size: 15px">#</sup>' . 
                                               //          ($grossRank - 1) . "  $: " . number_format($resultGross[$grossRank - 2]['gross']) . '</p>';
                                               // }
                                                    echo '<p style="font-size:20px;">' . 
                                                     $grossRank . '<sup style="font-size: 15px">nd</sup>' .
                                                    "  $" . number_format($resultGross[$grossRank - 1]['gross']) .
                                                        ' </p>';
                                                    echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                                
                                            }
                                            else if($grossRank == "3") 
                                            {
                                                    echo '<p style="font-size:20px;">' . 
                                                     $grossRank . '<sup style="font-size: 15px">rd</sup>' .
                                                    "  $" . number_format($resultGross[$grossRank - 1]['gross']) .
                                                        ' </p>';
                                                    echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                            }   
                                            else
                                            {
                                                // echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($grossRank - 1) . "  $: " . number_format($resultGross[$grossRank - 2]['gross']) . '</p>';
                                                echo '<p style="font-size:20px;">' . 
                                                     $grossRank . '<sup style="font-size: 15px">th</sup>' .
                                                    "  $" . number_format($resultGross[$grossRank - 1]['gross']) .
                                                        ' </p>';
                                                echo '<a href="teamRank.php"><p style="font-size:20px; ">Team Rank</p></a>';
                                                // echo '<p><sup style="font-size: 15px">#</sup>' . 
                                                //         ($grossRank + 1) . "  $: " . number_format($resultGross[$grossRank]['gross']) . '</p>';
                                            }
                                        }
                                        ?>
                                    
                                </div>
                                <div class="icon">
                                   <!-- <i class="fa fa-dollar"></i> -->
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <p style="font-size:20px; text-align:center; background-color:#C37410; margin-left: -10px; margin-right:-10px;">Potential Income</p>
                                    <h4>$<?php echo number_format($potentialGross, 2); ?></h4>
                                    
                                </div>
                                <div class="icon">
                                    <i class="fa fa-usd"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <p style="font-size:20px; text-align:center; background-color:#000080; margin-left: -10px; margin-right:-10px;">Prior Year Gross</p>
                                    <h4>$<?php echo number_format($prevYearResult['prevGross'], 0); ?></h4>
                                    
                                </div>
                                <div class="icon">
                                    <i class="fa fa-usd"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <p style="font-size:20px;  text-align:center; background-color:#AD0403; margin-left: -10px; margin-right:-10px;">Total Gross Earnings</p>
                                    <h3><sup style="font-size: 20px">$</sup>
                                        <?php echo number_format($result['earnings'], 0); ?>
                                    </h3>
                                    
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
                        <?php include 'progressGoal.php' ?>
                    </div>

                        <div class="col-md-12" id="activeProspectCollapse" style="height:60vh;">
                            <div class="box box-success" style="height:90%; overflow: auto;">
                                <div class="box-header">
                                    <h4 >Active Prospects<button type="button" onClick="collapseActiveProspects()">
                                        <span class="fa fa-compress" aria-hidden="true"></span></button></h4>
                                    <button onClick="showProspectModal()">Add Prospect</button>
                                    <button onClick="window.open('activeProspectives.php');">Open Table</button>
                                </div>
                                <div class="box-body"  style="height:100%; ">
                                    <table class="table footable table-bordered table-striped" id="favoriteTable" data-sorting="true" data-filtering="true" style="height:100%; ">
                                        <thead>
                                            
                                            <th></th>
                                            <th style="width:20px;">Last Contacted</th>
                                            <th>Type</th>
                                            <th>Client</th>
                                            <th data-breakpoints='all'>Client 2</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Zip</th>
                                            <th>Price</th>
                                            <th>Bedroom</th>
                                            <th>Bathroom</th>
                                            <th>SqFt</th>
                                            <th>Lot Size</th>
                                            <th>Prev. Note</th>
                                            <th>Add Note</th>
                                            <th>Match</th>
                                            <th>To Client List</th>
                                            <th>To In-Contract</th>
                                            <th>Delete</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $activeProspectCount =1;
                                            foreach ($favoriteResults as $favorite) 
                                            {   
                                            //     if($favorite['lastContacted'] == "0000-00-00")
                                            //         $lastContacted = "NA";
                                            //     else if ($favorite['lastContacted'] != "0000-00-00") 
                                            //         $lastContacted = date("m/d/y g:i a", strtotime($favorite['lastContacted']));
                                                // if($activeProspectCount % 5 == 0)
                                                // {
                                                //     echo "<tr>";
                                                //     echo '<td></td>';
                                                //     echo '<td><b>Last Contacted</b></td>';
                                                //     echo '<td><b>Type</b></td>';
                                                //     echo '<td><b>Client</b></td>';
                                                //     echo '<td><b>Phone</b></td>';
                                                //     echo '<td><b>Email</b></td>';
                                                //     echo '<td><b>Zip</b></td>';
                                                //     echo '<td><b>Price</b></td>';
                                                //     echo '<td><b>Bedroom</b></td>';
                                                //     echo '<td><b>Bathroom</b></td>';
                                                //     echo '<td><b>SqFt</b></td>';
                                                //     echo '<td><b>Lot Size</b></td>';
                                                //     echo '<td><b>Notes</b></td>';
                                                //     echo '<td><b>Match</b></td>';
                                                //     echo '<td><b>Archive</b></td>';
                                                //     echo '<td><b>Delete</b></td>';
                                                //     echo "</tr>";
                                                // }
                                                echo "<tr id=favorite" . $favorite['favoriteId'] . ">";
                                                echo '<td class="favoriteRowNumber"></td>';
                                                // "&nbsp&nbsp&nbsp"
                                                if($favorite['lastContacted'] != "0000-00-00 00:00:00")
                                                {
                                                    $lastContactedDate = strtotime($favorite['lastContacted']);
                                                    $lastContactedDate = date("m-d-Y", $lastContactedDate);
                                                }
                                                else
                                                    $lastContactedDate = "NA";

                                                echo '<td id=lastContacted' . $favorite['favoriteId'] . ' class="fa fa-phone"  style="text-align: center;" onClick="showLastContactedModal(this)">' . $lastContactedDate . '</td>';
                                                echo '<td>' . $favorite['listingType'] . '</td>';
                                                echo '<td id=name' . $favorite['favoriteId'] . ' onClick=editFavorite("name",' . $favorite['favoriteId'] . ',' . $favorite['firstName'] . " " . $favorite['lastName'] .  ')>' . $favorite['firstName'] . " " . $favorite['lastName'] . '</td>';
                                               echo '<td><table border="1">
                                                    <tr>
                                                    <td></td>
                                                    <td><b>Client</b></td>
                                                    
                                                    </tr>
                                                    <tr>
                                                    <td><b>Name</b></td>
                                                    <td style="color:#0000FF;" id=favTwoName'. $favorite['favoriteId'] . ' ondblclick="editFavClientName(' . $favorite['favoriteId'] . ')">' . $favorite['clientTwoName'] . '</td>
                                                    </tr>
                                                    <tr>
                                                    <td><b>Phone</b></td>
                                                    <td style="color:#0000FF;" id=favTwoNum' . $favorite['favoriteId'] . ' ondblclick="editFavClientNum(' . $favorite['favoriteId'] . ')">' . $favorite['clientTwoPhone'] . '</td>
                                                    </tr>
                                                    <tr>
                                                    <td><b>Email</b></td>
                                                    <td style="color:#0000FF;" id=favTwoEmail'. $favorite['favoriteId'] . ' ondblclick="editFavClientEmail(\'' . $favorite['favoriteId'] . '\')">' . $favorite['clientTwoEmail'] . '</td>
                                                    </tr>
                                                    
                                                    </table></td>';
                                                echo '<td id=phone' . $favorite['favoriteId'] . ' onClick=editFavorite("phone",' . $favorite['favoriteId'] . ', ' . $favorite['phone'] . ')>' . $favorite['phone'] . '</td>';
                                                echo '<td id=email' . $favorite['favoriteId'] . ' onClick=editFavorite("email",' . $favorite['favoriteId'] . ','. $favorite['email'] . ')>' . $favorite['email'] . '</td>';
                                                echo '<td id=zip' . $favorite['favoriteId'] . ' onClick=editFavorite("zip",' . $favorite['favoriteId'] . ','. $favorite['zip'] . ')>' . $favorite['zip'] . '</td>';
                                                echo '<td id=price' . $favorite['favoriteId'] . ' onClick=editFavorite("price",' . $favorite['favoriteId']. ','. $favorite['price'] .')>' . number_format($favorite['price']) . '</td>';
                                                echo '<td id=bedroom' . $favorite['favoriteId'] . ' onClick=editFavorite("bedroom",' . $favorite['favoriteId'] . ','. $favorite['bedroom'] . ')>' . $favorite['bedroom'] . '</td>';
                                                echo '<td id=bathroom' . $favorite['favoriteId'] . ' onClick=editFavorite("bathroom",' . $favorite['favoriteId'] . ','. $favorite['bathroom'] . ')>' . $favorite['bathroom'] . '</td>';
                                                echo '<td id=sqft' . $favorite['favoriteId'] . ' onClick=editFavorite("sqft",' . $favorite['favoriteId'] . ','. $favorite['sqft'] . ')>' . number_format($favorite['sqft']) . '</td>';
                                                echo '<td id=lotSize' . $favorite['favoriteId'] . ' onClick=editFavorite("lotSize",' . $favorite['favoriteId'] . ','. $favorite['lotSize'] . ')>' . number_format($favorite['lotSize']) . '</td>';
                                                echo '<td style="text-align: center;" >' . substr($favorite['note'], 0, 15) . '</td>';
                                                echo '<td><button data-toggle="modal" onClick=openNoteModal(' . $favorite['favoriteId'] . ')>Add Note</button></td>';
                                                echo '<td><a href="prospectsMatch.php?visitorId=' . $favorite['favoriteId'] . '" >House Matches</a></td>';
                                                echo '<td class="fa fa-archive" style="text-align: center;" onClick="archiveFavorite(' . $favorite['favoriteId'] . ')"></td>';
                                                echo '<td class="fa fa-file-text" style="text-align: center;" onClick="showSendToInContractModal(' . $favorite['favoriteId'] . ')"></td>';
                                                echo '<td class="fa fa-trash-o"  style="text-align: center;" onClick="deleteFavorite(' . $favorite['favoriteId'] . ')"></td>';
                                                echo "</tr>";
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
                                            <td></td>
                                            <td></td>
                                            <td><a href="prospectsMatch.php">House Matches</a></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                       <div class="col-md-12" id="inContractCollapse" style="height:80vh;">
                            <?php include 'inContractTable.php'; ?>

                        </div>
                        <!-- /.col -->

                        <div class="col-md-12" id="calendarCollapse" style="height:80vh;">
                                <div class="box box-success" style="height:100%; overflow: auto;">
                                    <h3>Meetings<button type="button" onClick="collapseCalendar()">
                                        <span class="fa fa-compress" aria-hidden="true"></span></button></h3>
                                    <!-- THE CALENDAR -->
                                    <div id="calendar" ></div>
                                </div>
                                <!-- /.box-body -->
                            </div>
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

        <!-- Modal -->
        <div id="inContractModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter new In-Contract Address</h4>
              </div>
              <div class="modal-body">
                Address: <input type="text" name="inContractAddress"><br><br>
                City: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="inContractCity"><br><br>
                State:&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="inContractState"><br><br>
                Zip: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="inContractZip"><br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onClick="addNewTransaction()">OK</button>
              </div>
            </div>

          </div>
        </div>

        <!-- Modal -->
        <div id="sendToInContractModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter new In-Contract Address</h4>
                <p id="sendToInContractId" hidden></p>
              </div>
              <div class="modal-body">
                Address: <input type="text" name="sendToInContractAddress"><br><br>
                City: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="sendToInContractCity"><br><br>
                State:&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" name="sendToInContractState"><br><br>
                Zip: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="sendToInContractZip"><br>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onClick="sendToInContract()">OK</button>
              </div>
            </div>

          </div>
        </div>

        <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="addLeadModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Prospect</h4>
                </div>
                <div class="modal-body">
                    <form action="addProspect.php" method="POST">
                        <input type="text" name="firstName" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="First Name" required>
                        <span class="form-control-feedback left" aria-hidden="true"></span>

                        </br>
                        <input type="text" name="lastName" class="form-control" id="inputSuccess3" placeholder="Last Name" required>
                        </br>
                        <input type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4"
                               placeholder="Email">
                        </br>
                        <input type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Phone">
                        </br>

                        <input type="text" name="zip" class="form-control" id="inputSuccess6" placeholder="zip">
                        </br>

                        <label>Client Type?</label>
                        <select id="" name="listingType" class="form-control" >
                            <option value="">--Select One--</option>
                            <option value="listing">Listing</option>
                            <option value="buyer">Buyer</option>
                            <option value="listing/buyer">Listing/Buyer</option>
                        </select>
                        </br>

                        <label>How soon are you looking to purchase a home?</label>
                        <select id="" name="howSoon" class="form-control" >
                            <option value="0">--Select One--</option>
                            <option value="1-3">1-3 months</option>
                            <option value="4-6">4-6 months</option>
                            <option value="7-12">7-12 months</option>
                            <option value="Visit">Just visiting</option>
                        </select>
                        </br>

                        <label>Have you been pre-approved?</label>
                        <select id="" name="preApproved" class="form-control" >
                            <option value="0">--Select One--</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        </br>

                        <label>Max Purchase Price</label>
                        <select id="" name="price" class="form-control" >
                            <option value="">--Select One--</option>
                            <!-- <option value="100000">$100,000</option>
                            <option value="150000">$150,000</option>
                            <option value="200000">$200,000</option> -->
                            <option value="250000">$250,000</option>
                            <option value="300000">$300,000</option>
                            <option value="350000">$350,000</option>
                            <option value="400000">$400,000</option>
                            <option value="450000">$450,000</option>
                            <option value="500000">$500,000</option>
                            <option value="550000">$550,000</option>
                            <option value="600000">$600,000</option>
                            <option value="650000">$650,000</option>
                            <option value="700000">$700,000</option>
                            <option value="750000">$750,000</option>
                            <option value="800000">$800,000</option>
                            <option value="850000">$850,000</option>
                            <option value="900000">$900,000</option>
                            <option value="950000">$950,000</option>
                            <option value="1000000">$1,000,000+</option>
                        </select>

                        </br>

                        <label>Min Bedrooms</label>
                        <select id="" name="bedroom" class="form-control" >
                            <option value="">--Select One--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>
                        </br>
                        <label>Min Bathrooms</label>
                        <select id="" name="bathroom" class="form-control" >
                            <option value="">--Select One--</option>
                            <option value="1">1</option>
                            <option value="1.5">1.5</option>
                            <option value="2">2</option>
                            <option value="2.5">2.5</option>
                            <option value="3">3</option>
                            <option value="3.5">3.5</option>
                            <option value="4">4</option>
                            <option value="4.5">4.5</option>
                        </select>
                        </br>

                        <input type="text" name="sqft" class="form-control has-feedback-left" id="inputSuccess4" placeholder="sqft" >
                        </br>
                        <input type="text" name="lotSize" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Lot Size" >
                        </br>
                        </br>
                        <button type="submit" class="btn btn-default" >Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-agent/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-agent/default-js.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <?php include "noteModal.php" ?>
        <?php include "inContractNoteModal.php" ?>

        <script type="text/javascript" src="../dist/js/vendor/footable.min.js"></script>

        <?php include "../staff/staffEventModalAgent.php" ?>

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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

        <script>
        
            //Date picker
            $('#datepicker').datepicker();
           
            jQuery(function($){
                $('.table').footable({
                    "sorting": {
                "enabled": true
            },
            "filtering": {
            "connectors": false,
            "position": "center"
            }
                    // "paging": {
                    //     "enabled": true,
                    //     "size": 4,
                    //     "position": "right"
                    // }

                });
            });

            $('#favoriteTable').bind({
                'after.ft.sorting': function (e) {
                addRowCount('#favoriteTable');
                },
                'footable_filtering': function (e) {
                addRowCount('#favoriteTable');
                },
                'ready.ft.table': function (e){
                    addRowCount('#favoriteTable');
                }
                });
            $('#inContractTable').bind({
                'after.ft.sorting': function (e) {
                addRowCountIC('#inContractTable');
                },
                'footable_filtering': function (e) {
                addRowCountIC('#inContractTable');
                },
                'ready.ft.table': function (e){
                    addRowCountIC('#inContractTable');
                }
                });
                function addRowCount(tableAttr) {
                var PageNumber = 0;
                $(tableAttr).each(function () {
                var RowCount = $('td.favoriteRowNumber', this).length;
                // alert(RowCount);
                $('td.favoriteRowNumber', this).each(function (i) {
                
                $(this).html( i + 1);

                });
                });
                }
                function addRowCountIC(tableAttr) {
                var PageNumber = 0;
                $(tableAttr).each(function () {
                var RowCount = $('td.inContractRowNumber', this).length;
                // alert(RowCount);
                $('td.inContractRowNumber', this).each(function (i) {
                
                $(this).html( i + 1);

                });
                });
                }
            // jQuery(function($){
            //     $('.inConctractTable').footable({
            //         "useParentWidth": true
            //     });
            // });

        </script>
        <script>
            var text = "";

            var activeProspectsCollapseStatus = "";
            var inContractCollapseStatus = "";
            var calendarCollapseStatus = "";

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
                if(confirm("Are you sure you want to delete?"))
                {
                    var id = $('#id').text();
                    $.post("deleteMeeting.php", {
                        id: id,
                    });
                    $('#calendar').fullCalendar('removeEvents', id.replace(" ", "T" ));
                    // alert(id);
                    alert("meeting deleted");
                }
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
                        center: 'month,agendaWeek,agendaDay',
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
            
            

            $.post( "getSettings.php", function( data ) {
                var dataResult = JSON.parse(data);
                activeProspectsCollapseStatus = dataResult.agentActiveProsTable;
                inContractCollapseStatus = dataResult.agentInContrTable;
                calendarCollapseStatus = dataResult.agentCalendar;
                if(activeProspectsCollapseStatus != "expanded")
                    $('#activeProspectCollapse').height("12vh");
                if(inContractCollapseStatus != "expanded")
                    $('#inContractCollapse').height("12vh");
                if(calendarCollapseStatus != "expanded")
                    $('#calendarCollapse').height("9vh");   
                  // alert( "Data Loaded: " + dataResult.agentActiveProsTable );
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

            
            function saveNameMisc(transId,type,name)
            {
                // alert(name.value);
                $.post( "../staff/saveMiscName.php", { transId: transId, type:type, name:name.value });
            }

            function saveOrdDate(transId,type,date)
            {
                var sendDate = date.value;
                if(sendDate == "")
                {
                    sendDate = "NULL";
                    $('#' + type + 'Ord' + transId).html("Ordered: N/A");
                }
                else
                    $('#' + type + 'Ord' + transId).html("Ordered: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                $.post( "../staff/saveOrdDates.php", { transId: transId, type:type, date:sendDate });

                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }
            }
            function saveCompDate(transId,type,date)
            {

                
                var sendDate = date.value;
                if( type == "recieved")
                {
                    if(sendDate == "")
                    {
                        sendDate = "NULL";
                        $('#' + type + 'Comp' + transId).html("Date Recieved: N/A");
                        $("#status" + transId+type).attr('class', '');
                        $("#status" + transId+type).css('color', "");
                    }
                    else
                    {
                        $('#' + type + 'Comp' + transId).html("Date Recieved: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                        $("#status" + transId+type).attr('class', 'fa fa-check-circle');
                        $("#status" + transId+type).css('color', "#5cb85c");
                    }
                }
                else if( type == "signed")
                {
                    if(sendDate == "")
                    {
                        sendDate = "NULL";
                        $('#' + type + 'Comp' + transId).html("Signed: N/A");
                        $("#status" + transId+type).attr('class', '');
                        $("#status" + transId+type).css('color', "");
                    }
                    else
                    {
                        $('#' + type + 'Comp' + transId).html("Signed: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                        $("#status" + transId+type).attr('class', 'fa fa-check-circle');
                        $("#status" + transId+type).css('color', "#5cb85c");
                    }
                }
                else
                {
                    if(sendDate == "")
                    {
                        sendDate = "NULL";
                        $('#' + type + 'Comp' + transId).html("Completed: N/A");
                        $("#status" + transId+type).attr('class', '');
                        $("#status" + transId+type).css('color', "");
                    }
                    else
                    {
                        $('#' + type + 'Comp' + transId).html("Completed: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                        $("#status" + transId+type).attr('class', 'fa fa-check-circle');
                        $("#status" + transId+type).css('color', "#5cb85c");
                    }
                }

                // updateStatus(transId, type date);
                $.post( "../staff/saveCompDates.php", { transId: transId, type:type, date:sendDate });
                
                

            }
             function saveDateCalendar(transId,type,date)
             {
                var dateValue = date.value;
                if(dateValue == "")
                    dateValue = moment($("#aprvDay"+transId).val()).format("YYYY-MM-DD");
          
                var aprvDay = $("#aprvDay"+transId).val();
                // $("#aprvDay" + transId).val(date.value);
                updateStatus(transId,type,date);
                $.post( "../staff/saveNewDates.php", { transId: transId, type:type, date:dateValue, aprvDay: aprvDay });
                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }
            }
            
            function saveDaysNum(transId,type,date)
             {
           
                $.post( "../staff/saveNewDaysNum.php", { transId: transId, type:type, date:date.value });
                updateStatus(transId,date);
                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }
            }

            function saveNewDates(transId)
            {

                $("#editDateModal"+transId).modal("toggle");
                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }

                alert( "Dates Saved" );
                location.reload();


            }

            function deleteInContract(inContractId)
            {
                // alert(inContractId);

                if(confirm("Are you sure you want to delete?"))
                {
                    $.post( "../staff/deleteInContract.php", { inContractId: inContractId })
                      .done(function( data ) {
                        alert("In-contract Deleted");
                        $("#editDateModal"+inContractId).modal("toggle");

                        $('#inContract' + inContractId).remove();
                      });

                }
                
            }

            function updateStatus(transId, type, date)
            {
                var aprvDay = $("#aprvDay"+transId).val();
                // alert(aprvDay);
                var newDate = moment(date.value).format("YYYY-MM-DD"); 
                var todayDate = moment().format("YYYY-MM-DD"); 
                var inThreeDays = moment(todayDate).add(3, 'days').format("YYYY-MM-DD");
               
                
                if(moment(newDate).isSameOrBefore(inThreeDays) && moment(newDate).isSameOrAfter(todayDate))
                {
                    $("#status" + transId + type).attr('class', 'fa fa-warning');
                    $("#status" + transId + type).css('color', "#ffae42");
                    // alert("caution");
                }
                else if(moment(newDate).isSameOrAfter(todayDate))
                {
                    
                    $("#status" + transId + type).attr('class', '');
                    // $("#status" + transId + type).css('color', "#5cb85c");
                    // alert("late");
                }
                else if(moment(newDate).isSameOrBefore(todayDate))
                {
                    $("#status" + transId + type).attr('class', 'fa fa-flag blink');
                    $("#status" + transId + type).css('color', "#d9534f");
                    // $("#status" + transId + type).attr('class', 'fa fa-check-circle');
                    // $("#status" + transId + type).css('color', "#5cb85c");
                    // alert("onTime");
                }
            }

            function updateGoal()
            {
                var newGoalEntry = prompt("Enter new goal: ");
                var newGoal = parseInt(newGoalEntry.replace(/,$./g, ''));
                while(newGoal < 100000 || isNaN(newGoal))
                {
                    newGoalEntry = prompt("Enter new goal: ");
                    newGoal = parseInt(newGoalEntry.replace(/,$./g, ''));
                }
                
                var dividedGoal = Math.ceil(newGoal/12);
                $(".agentGoal").each(function ()
                {
                    $(".agentGoal").html("$" + dividedGoal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                });
                $("#agentGoal").html("$" + newGoal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                $.post( "updateGoal.php", { newGoal: newGoal } );
                // alert("update goal");
            }
            function showTransactionModal()
            {
                 $('#inContractModal').modal('toggle');
            }
            function showSendToInContractModal(id)
            {
                $('#sendToInContractId').html(id);
                $('#sendToInContractModal').modal('toggle');
            }
            // function addNewTransaction()
            // {
            //     var inContractAddress = $('[name=inContractAddress]').val();
            //     var city = $('[name=inContractCity]').val();
            //     var state = $('[name=inContractState]').val();
            //     var zip = $('[name=inContractZip]').val();

            //     var address = inContractAddress + " " + city + ", " + state + " " + zip;
                
            //     bootbox.prompt({
            //     title: "Select what type of in-contract:",
            //     inputType: 'checkbox',
            //     inputOptions: [
            //         {
            //             text: 'Listing',
            //             value: 'Listing',
            //         },
            //         {
            //             text: 'Buyer',
            //             value: 'Buyer',
            //         },
            //         {
            //             text: 'List./Buy.',
            //             value: 'List./Buy.',
            //         }
            //     ],
            //     callback: function (result) {
            //         inContractType = result[0];
            //         // alert(inContractType);
            //         // alert(address);
            //         if(inContractType != null)
            //         {
            //         $.post( "addTransactionSimple.php", { address: address, type: inContractType})
            //         .done(function( data ) {

            //             alert("House In-contract. Will reflect on Dashboard after refreshing page.");
            //             });
            //         }
            //     }

            //     });
                    
            // }

            function addNewTransaction()
            {
                var houseSelected = $('#houseId').children(":selected").attr("value");   
                var agentSelected = $('#agentName').text();
                var accDate = $('#newAccDate').val();

                var inputAddress = $('#inputAddress').val();
                var inputCity = $('#inputCity').val();
                var inputState = $('#inputState').val();
                var inputZip = $('#inputZip').val();

                var coAgentName = $('#coAgentId option:selected').text();
                var coAgentId = $('#coAgentId').val();
                var coAgentOther = $('#coAgentNameOther').val();
                // alert(coAgentName);
                // alert(coAgentId);

                var typeEntered = $('#typeEntered').val();
                var agentInfoTypeEntered = $('#agentInfo option:selected').text();
                var agentInfoTypeEnteredId = $('#agentInfo').val();
                var agentInfoOther = $('#agentInfoOtherName').val();

                if(coAgentId == "")
                {
                    coAgentName = coAgentOther;
                }
                if(agentInfoTypeEnteredId == "")
                {
                    agentInfoTypeEntered = agentInfoOther;
                }
                // alert(accDate);

                // alert(agentSelected);

                // alert(houseSelected);
                if(coAgentName != "" && coAgentOther != "")
                {
                    alert("Choose House from dropdown, input house data, check date, co-agent, or agency type of transaction.");
                }
                else if(agentInfoTypeEntered != "" && agentInfoOther != "")
                {
                    alert("Choose House from dropdown, input house data, check date, co-agent, or agency type of transaction.");
                }
                else if(houseSelected == "" && inputAddress != "" && inputState != "" && inputCity != "" && inputZip != "" && accDate != "" && typeEntered != "")
                {
                    $.post("../staff/addTransactionStaffInput.php", {userId: agentSelected, address: inputAddress, state: inputState, 
                                                            city: inputCity, zip: inputZip , accDate: accDate, coAgentName: coAgentName, coAgentId: coAgentId, typeEntered: typeEntered,
                                                            agentInfoId: agentInfoTypeEnteredId ,agentInfoTypeEntered: agentInfoTypeEntered});
                    alert("House In-Contract");
                    location.reload();
                    
                }
                else if(houseSelected != "" && typeEntered != "" && inputAddress == "" && inputState == "" && inputCity == "" && inputZip == "" && accDate != "")
                {
                    $.post("../staff/addTransactionStaff.php", {userId: agentSelected, houseId: houseSelected, accDate: accDate, coAgentName: coAgentName, coAgentId: coAgentId,
                                                                agentInfoId: agentInfoTypeEnteredId, typeEntered: typeEntered, agentInfoTypeEntered: agentInfoTypeEntered});
                    alert("House In-Contract");
                    location.reload();
                }
                else
                {
                    alert("Choose House from dropdown, input house data, check date, or type of transaction.");
                }
                
                
            }

            function deleteFavorite(favoriteId)
            {
                if(confirm("Are you sure you want to remove this prospect?"))
                {
                    // alert(favoriteId);
                     $.post( "deleteFavorite.php", { favoriteId: favoriteId })
                      .done(function( data ) {
                        $("#favorite" + favoriteId).hide();
                        alert( "Prospect deleted" );
                      });
                }
            }

            function showProspectModal()
            {
                $('#addLeadModal').modal('toggle');
            }

            function takeNote(transId)
            {
                //erase all when opening modal
                $('#transId').html('');
                $('#addNewNoteInContractArea').val('');
                $("#inContractNoteTable").empty();

                //populate data
                $('#transId').html(transId);
                $.post( "getInContractNotes.php", { transId: transId })
                      .done(function( data ) {
                        var result = JSON.parse(data);
                        var x;
                        var table = document.getElementById("inContractNoteTable");
                        for(x in result)
                        {
                            var row = table.insertRow(0);
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            cell2.className = "inContractNoteRow";
                            cell1.innerHTML = "<h4>" + moment(result[x].noteDate).format('MM/DD/YYYY h:mma')+ "</h4>";
                            cell2.innerHTML = "<textarea class='form-control' rows='2' id='note" + result[x].noteId + "' style='resize:none; border: solid 1px black' onchange='saveInContractNote(this)'>" + result[x].note + "</textarea>";
                            // console.log(result[x].noteId);
                            // console.log(result[x].noteDate);
                            // console.log(result[x].note);
                        }
                        
                      });

                // Open Modal
                $('#incontractNoteModal').modal('toggle');

                // alert(id);
                // var today = moment().format("MM-DD-YYYY");
                // var prevNote = $("#" + id).html();
                // if(prevNote == "" || prevNote == " ")
                // {
                //     var noteEntered = prompt("Enter Note:", today + " " + prevNote );
                // }
                // else
                // {
                //     var noteEntered = prompt("Enter Note:", prevNote + " " + today );
                // }
                // if (noteEntered == null || noteEntered == "") {
                // } else {
                //     $("#" + id).html(noteEntered);
                //     // alert(houseId + " " + buyerID);
                //     $.post("saveInContractNote.php", {
                //         transId: id,
                //         note: noteEntered
                //     });
                // }
            }

            function editClientName(id)
            {
                // alert("edit client name");
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $(".clientName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("saveInContractClientName.php", {
                        transId: id,
                        clientName: clientName
                    });
                }

            }

            function editClientNum(id)
            {
                var clientNum = prompt("Enter client number:");
                if (clientNum == null || clientNum == "") {
                } else {
                    $("#clientNum" + id).html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("saveInContractClientNum.php", {
                        transId: id,
                        clientNum: clientNum
                    });
                }
            }

            function editClientEmail(id)
            {
                var clientEmail = prompt("Enter client email:");
                if (clientEmail == null || clientEmail == "") {
                } else {
                    $("#clientEmail" + id).html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("saveInContractClientEmail.php", {
                        transId: id,
                        clientEmail: clientEmail
                    });
                }
            }

            function editClientTwoName(id)
            {
                // alert("edit client name");
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $(".clientTwoName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("updateClientTwoData.php", {
                        transId: id,
                        clientTwoName: clientName,
                        type: "name"
                    });
                }

            }

            function editClientTwoNum(id)
            {
                var clientNum = prompt("Enter client number:");
                if (clientNum == null || clientNum == "") {
                } else {
                    $("#clientTwoNum" + id).html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("updateClientTwoData.php", {
                        transId: id,
                        clientTwoNum: clientNum,
                        type: "number"
                    });
                }
            }

            function editClientTwoEmail(id)
            {
                var clientEmail = prompt("Enter client email:");
                if (clientEmail == null || clientEmail == "") {
                } else {
                    $("#clientTwoEmail" + id).html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("updateClientTwoData.php", {
                        transId: id,
                        clientTwoEmail: clientEmail,
                        type: "email"
                    });
                }
            }

            function editFavClientName(id)
            {
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $("#favTwoName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("editFavTwo.php", {
                        favoriteId: id,
                        newData: clientName,
                        column: "clientTwoName"
                    });
                }
            }

            function editFavClientNum(id)
            {
                var clientNum = prompt("Enter client number:");
                if (clientNum == null || clientNum == "") {
                } else {
                    $("#favTwoNum" + id).html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("editFavTwo.php", {
                        favoriteId: id,
                        newData: clientNum,
                        column: "clientTwoPhone"
                    });
                }
            }

            function editFavClientEmail(id)
            {
                var clientEmail = prompt("Enter client email:");
                if (clientEmail == null || clientEmail == "") {
                } else {
                    $("#favTwoEmail" + id).html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("editFavTwo.php", {
                        favoriteId: id,
                        newData: clientEmail,
                        column: "clientTwoEmail"
                    });
                }
            }

            function editFavorite(type,id,editElement="test")
            {
                // alert("edit favorite");
                var input = prompt("Enter new " + type, editElement);
                if(input != null && input != "")
                {
                    $.post("editFavorite.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#'+type+id).html(input);
                      });
                }
            }

            function editCoAgentName(id)
            {
                var newCoAgentName = prompt("Enter co-agent name:");
                if (newCoAgentName == null || newCoAgentName == "") {
                } else {
                    $("#coAgentName" + id).html(newCoAgentName);
                    // alert(houseId + " " + buyerID);
                    $.post("updateClientTwoData.php", {
                        transId: id,
                        coAgentName: newCoAgentName,
                        type: "coAgentName"
                    });
                }
            }

            function showLastContactedModal(row)
            {
                $('#lastContactedModal').modal('toggle');
                var tableRow = row.id;
                var id = tableRow.replace("lastContacted", "");
                // alert(id);
                $('#favoriteIdContact').html(id);


            }
            function updateLastContacted(type)
            {
                var favoriteId = $('#favoriteIdContact').html();
                // alert(type);
                $.post("updateLastContacted.php", {
                                id: favoriteId,
                                note: type
                            })
                        .done(function( data ) {
                                alert("Updated last contacted ");
                                // $('#lastContacted'+id).html(moment().format('l'));
                                $('#lastContacted'+favoriteId).html(moment().format('M/DD/YYYY h:mma'));
                                $('#lastContactedModal').modal('toggle');
                          });
                
            }
            // function updateLastContacted(id)
            // {
                
            //     if(confirm("Want to update last contacted?"))
            //     {
            //         $.post("updateLastContacted.php", {
            //                     id: id
            //                 })
            //             .done(function( data ) {
            //                     alert("Updated last contacted ");
            //                     $('#lastContacted'+id).html(moment().format('l'));
            //               });
            //     }
            // }
            function editLendorInfo(type, id)
            {
                var input = prompt("Enter new lender " + type);
                if(input != null && input != "")
                {
                    $.post("editLendorInfo.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#lendor'+type+id).html(input);
                      });
                }
            }
            function editEscrowInfo(type, id)
            {
                var input = prompt("Enter new escrow " + type);
                if(input != null && input != "")
                {
                    $.post("editEscrowInfo.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#escrow'+type+id).html(input);
                      });
                }
            }
            function editAgentInfo(type, id)
            {
                var input = prompt("Enter new agent" + type);
                if(input != null && input != "")
                {
                    $.post("editAgentInfo.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#agent'+type+id).html(input);
                      });
                }
            }
            function editProperty(id)
            {
                var input = prompt("Enter new property address: ");
                if(input != null && input != "")
                {
                    $.post("editPropertyAddress.php", {
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#propertyAddress'+id).html(input);
                      });
                }
            }
            

            function archiveFavorite(favoriteId)
            {
                if(confirm("Are you sure you want to archive this prospect?"))
                {
                    // alert(favoriteId);
                    bootbox.confirm({
                    message: "Do you want to remove Prospect from Active Prospects table?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        // alert(result);
                        $.post( "archiveFavorite.php", { favoriteId: favoriteId, delFavorite:result })
                      .done(function( data ) {
                        if(result == "true")
                            $("#favorite" + favoriteId).hide();
                        alert( "Prospect archived" );
                      });
                    }
                });
                    
                     
                }
            }
            function sendToInContract()
            {
                var favoriteId = $('#sendToInContractId').html();
                ////
                var inContractAddress = $('[name=sendToInContractAddress]').val();
                var city = $('[name=sendToInContractCity]').val();
                var state = $('[name=sendToInContractState]').val();
                var zip = $('[name=sendToInContractZip]').val();

                var address = inContractAddress + " " + city + ", " + state + " " + zip;
                
                bootbox.prompt({
                title: "Select what type of in-contract:",
                inputType: 'checkbox',
                inputOptions: [
                    {
                        text: 'Listing',
                        value: 'Listing',
                    },
                    {
                        text: 'Buyer',
                        value: 'Buyer',
                    },
                    {
                        text: 'Dual',
                        value: 'Dual',
                    }
                ],
                callback: function (result) {
                    inContractType = result[0];
                    // alert(inContractType);
                    // alert(address);
                    if(inContractType != null)
                    {
                    $.post( "sendToInContract.php", {favoriteId: favoriteId, address: address, type: inContractType})
                    .done(function( data ) {

                        alert("Prospect In-contract. Will reflect on Dashboard after refreshing page.");
                        });
                    }
                }

                });
            /////
            }

            function openNoteModal(favoriteId)
            {
                //erase all when opening modal
                $('#favoriteId').html('');
                $('#addNewNoteArea').val('');
                $("#noteTable").empty();

                //populate data
                $('#favoriteId').html(favoriteId);
                $.post( "getFavoriteNotes.php", { favoriteId: favoriteId })
                      .done(function( data ) {
                        var result = JSON.parse(data);
                        var x;
                        var table = document.getElementById("noteTable");
                        for(x in result)
                        {
                            var row = table.insertRow(0);
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            cell2.className = "favoriteNoteRow";
                            cell1.innerHTML = "<h4>" + moment(result[x].noteDate).format('MM/DD/YYYY h:mma')+ "</h4>";
                            cell2.innerHTML = "<textarea class='form-control' rows='2' id='note" + result[x].noteId + "' style='resize:none; border: solid 1px black' onchange='saveNote(this)'>" + result[x].note + "</textarea>";
                            text += result[x].noteId + " ";
                            // console.log(result[x].noteId);
                            // console.log(result[x].noteDate);
                            // console.log(result[x].note);
                        }
                        
                      });
                alert(text);
                // Open Modal
                $('#noteModal').modal('toggle');
            }

            function sendNotesText(favoriteId){
                $('#favoriteId').html('');
                $('#favoriteId').html(favoriteId);
                var text = "";
                $.post( "getFavoriteNotes.php", { favoriteId: favoriteId })
                      .done(function( data ) {
                        var result = JSON.parse(data);
                        var x;
                        for(x in result)
                        {
                            text = text + " 2 " + moment(result[x].noteDate).format('MM/DD/YYYY h:mma');
                            text = text + " " + result[x].note;
                        }
                        
                      });

                alert(text);


            }

            function openActiveProspectiveTable(){
                window.open('activeProspectives.php');
            }

            function openInContractTable(){
                window.open('inContractTable2.php');
            }

            function addNewNote()
            {
                var favoriteId = $('#favoriteId').html();
                var note = $('#addNewNoteArea').val();
                // alert(note);

                if(note != "" && note != null)
                {
                    $.post( "addNewFavoriteNote.php", { favoriteId: favoriteId, note:note })
                      .done(function( data ) {
                        var table = document.getElementById("noteTable");
                        var row = table.insertRow(0);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        cell2.className = "favoriteNoteRow";
                        cell1.innerHTML = "<h4>" + moment().format('L') + "</h4>";
                        cell2.innerHTML = "<textarea class='form-control' rows='2' id='comment' style='resize:none; border: solid 1px black' onchange='saveNote(this)'>" + note + "</textarea>";
                        alert( "Note Added");
                        $('#addNewNoteArea').val("");
                      });
                }
                else
                    alert("Note Empty");
            }
            function saveNote(textArea)
            {
                var noteId = textArea.id.replace("note", "");
                var newNote = textArea.value;
                // alert(areaId);
                // alert(textArea.value);
                $.post( "updateFavoriteNote.php", { noteId: noteId, note: newNote })
                      .done(function( data ) {
                        alert("Note Updated");
                      });
            }

            function saveInContractNote(textArea)
            {
                var noteId = textArea.id.replace("note", "");
                var newNote = textArea.value;
                // alert(areaId);
                // alert(textArea.value);
                $.post( "updateInContractNote.php", { noteId: noteId, note: newNote })
                      .done(function( data ) {
                        alert("Note Updated");
                      });
            }
            function addNewNoteInContract()
            {
                var transId = $('#transId').html();
                var note = $('#addNewNoteInContractArea').val();
                // alert(note);

                if(note != "" && note != null)
                {
                    $.post( "addNewInContractNote.php", { transId: transId, note:note })
                      .done(function( data ) {
                        var table = document.getElementById("inContractNoteTable");
                        var row = table.insertRow(0);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        cell2.className = "inContractNoteRow";
                        cell1.innerHTML = "<h4>" + moment().format('L') + "</h4>";
                        cell2.innerHTML = "<textarea class='form-control' rows='2' id='comment' style='resize:none; border: solid 1px black' onchange='saveInContractNote(this)'>" + note + "</textarea>";
                        alert( "Note Added");
                        $('#addNewNoteInContractArea').val("");
                      });
                }
                else
                    alert("Note Empty");
            }

            function sendToPastCleints(transId)
            {
                // alert($('#coeComp' + transId).html());
                if($('#coeComp' + transId).html() != "Completed: N/A " )
                {
                    var listingType = "";
                    var finalHousePrice = "";
                    bootbox.prompt("Enter final house price", function(result){
                     if(result != null)
                     {
                        finalHousePrice = result;
                        bootbox.prompt({
                            title: "Choose Agency Type",
                            inputType: 'select',
                            inputOptions: [
                                {
                                    text: '--Select One --',
                                    value: '',
                                },
                                {
                                    text: 'Listing',
                                    value: 'listing',
                                },
                                {
                                    text: 'Buyer',
                                    value: 'buyer',
                                },
                                {
                                    text: 'Dual',
                                    value: 'dual',
                                }
                            ],
                            callback: function (result) {
                                listingType = result;
                                // alert(listingType);
                                if(listingType != null)
                                {
                                    bootbox.confirm({
                                        message: "Do you want to delete from In-Contract Table?",
                                        buttons: {
                                            confirm: {
                                                label: 'Yes',
                                                className: 'btn-success'
                                            },
                                            cancel: {
                                                label: 'No',
                                                className: 'btn-danger'
                                            }
                                        },
                                        callback: function (result) {
                                            if(result == true)
                                            {
                                                $.post( "sendToPastClients.php", { transId: transId, finalHousePrice: finalHousePrice, delClient: "yes", listingType: listingType})
                                                  .done(function( data ) {
                                                    $('#inContract' + transId).remove();
                                                    alert("Added to past clients");
                                                  }); 
                                            }
                                            else
                                            {
                                                $.post( "sendToPastClients.php", { transId: transId, finalHousePrice: finalHousePrice, delClient: "no", listingType: listingType})
                                                  .done(function( data ) {
                                                    // $('#inContract' + transId).remove();
                                                    alert("Added to past clients");
                                                  }); 
                                            }
                                        }
                                    });
                            }
                            else
                                alert("Listing type needed");

                            }
                        });
                            

                         
                     }
                     else
                     {
                        alert("Final house price Needed");
                    }
                    });
                }
                else
                    alert("COE Completed date needs to be entered");
                // alert(clientId);
            }


            function collapseActiveProspects()
            {
                if(activeProspectsCollapseStatus == "expanded")
                {
                    $('#activeProspectCollapse').height("12vh");
                    activeProspectsCollapseStatus = "collapse";
                }
                else 
                {   
                    $('#activeProspectCollapse').height("60vh");
                    activeProspectsCollapseStatus = "expanded";
                }
                $.post( "updateTableCollapse.php", { column: "agentActiveProsTable", status: activeProspectsCollapseStatus } );
                // alert($('#activeProspectCollapse').height());
            }

            
            function collapseInContract()
            {
                if(inContractCollapseStatus == "expanded")
                {
                    $('#inContractCollapse').height("12vh");
                    inContractCollapseStatus = "collapse";
                }
                else 
                {   
                    $('#inContractCollapse').height("80vh");
                    inContractCollapseStatus = "expanded";
                }
                $.post( "updateTableCollapse.php", { column: "agentInContrTable", status: inContractCollapseStatus } );
                // alert($('#activeProspectCollapse').height());
            }
            
            function collapseCalendar()
            {
                if(calendarCollapseStatus == "expanded")
                {
                    $('#calendarCollapse').height("9vh");
                    calendarCollapseStatus = "collapse";
                }
                else 
                {   
                    $('#calendarCollapse').height("80vh");
                    calendarCollapseStatus = "expanded";
                }
                $.post( "updateTableCollapse.php", { column: "agentCalendar", status: calendarCollapseStatus } );
            }

            jQuery(document).ready(function($) {
                $(".clickable-table").click(function() {
                    window.open($(this).data("href"));
                });
            });

            function displayLabelAgentInfo()
            {
                // alert($('#typeEntered').val());
                if($('#typeEntered').val() == "buyer")
                {
                    $('#agentInfoDiv').show();
                    $('#agentInfoLabel').text("Enter Seller agent Name");
                    $("#agentInfo")[0].selectedIndex = 0;
                    $('#agentInfoOtherName').val("");
                }
                else if($('#typeEntered').val() == "seller")
                {
                    $('#agentInfoDiv').show();
                    $('#agentInfoLabel').text("Enter Buyer agent Name");
                    $("#agentInfo")[0].selectedIndex = 0;
                    $('#agentInfoOtherName').val("");
                }
                else if($('#typeEntered').val() == "dual")
                {
                    $('#agentInfoDiv').hide();
                    $('#agentInfoLabel').text("");
                    $("#agentInfo")[0].selectedIndex = 0;
                    $('#agentInfoOtherName').val("");
                }
            }

            function filterTransactions(type)
            {
                // var count
                // console.log($('.filterCheck'));
                if(type == "flag")
                {
                    var containsFlag = "no";
                    $('#flagFilterButton').css("background-color", "red");
                    $('#warningFilterButton').css("background-color", "");
                    $('#agentInContractTable > tbody  > tr').each(function() {
                            $(this).show();                        
                    });

                    $('#agentInContractTable > tbody  > tr').each(function() {
                        // console.log("New row");
                        containsFlag = "no";
                        $($(this).find("td i")).each(function() {
                            if($(this).attr('class') == "fa fa-flag blink")
                            {
                                containsFlag = "yes";
                                // console.log("hide " + $(this).attr('class'));
                            }
                        });
                        if(containsFlag == "no")
                            $(this).hide();
                    });
                }
                else if(type == "warning")
                {
                    var containsWarning = "no";
                    $('#flagFilterButton').css("background-color", "");
                    $('#warningFilterButton').css("background-color", "red");
                    $('#agentInContractTable > tbody  > tr').each(function() {
                            $(this).show();                        
                    });
                    
                    $('#agentInContractTable > tbody  > tr').each(function() {
                        // console.log("New row");
                        containsWarning = "no";
                        $($(this).find("td i")).each(function() {
                            if($(this).attr('class') == "fa fa-warning")
                            {
                                containsWarning = "yes";
                                // console.log("hide " + $(this).attr('class'));
                            }
                        });
                        if(containsWarning == "no")
                            $(this).hide();
                    });
                }
                else if(type == "clear")
                {
                    $('#flagFilterButton').css("background-color", "");
                    $('#warningFilterButton').css("background-color", "");
                    $('#agentInContractTable > tbody  > tr').each(function() {
                    
                            $(this).show();                        
                    });
                }
            }
        </script>


    </body>

    </html>
