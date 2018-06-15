<?php
session_start();
// echo($_SESSION['userType']);
if (!isset($_SESSION['userId']) ) {
    header("Location: login.php");
}
if($_SESSION['username'] == 'demo')
{
    header("Location: demo/index.php");
}
else if($_SESSION['userType'] == "1" && ($_SESSION['userId'] != "34" && $_SESSION['userId'] != "37"))
{
    header("Location: agent/index.php");
}
if($_SESSION['userType'] == "2"){
    header("Location: staff/index.php");
}
require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT status, count(*) AS num FROM HouseInfo GROUP BY status";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$houseStatus = $stmt->fetchAll();

$dbConnEarn = getConnection();
$sqlEarn = "SELECT AVG(finalComm) as average, SUM(finalComm) AS earnings, AVG(percentage) AS avgPercent FROM commInfo";
$stmtEarn = $dbConnEarn->prepare($sqlEarn);
$stmtEarn->execute();
$sumEarnings = $stmtEarn->fetch();


$dbConnRank = getConnection();
$sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm FROM UsersInfo LEFT JOIN commInfo on UsersInfo.license = commInfo.license group by UsersInfo.license order by sold Desc ";
$stmtRank = $dbConnRank->prepare($sqlRank);
$stmtRank->execute();
$rank = $stmtRank->fetchAll();

$dbConnInContract = getConnection();
$inContractSql = "SELECT *, UsersInfo.firstName, UsersInfo.lastName  FROM transactions LEFT JOIN UsersInfo ON 
                        transactions.userId = UsersInfo.userId";
$stmtInContract = $dbConnInContract->prepare($inContractSql);
$stmtInContract->execute();
$inContractResults = $stmtInContract->fetchAll();

$inContractCountSql = "SELECT count(*) as count FROM transactions";
$stmtInContractCount = $dbConnInContract->prepare($inContractCountSql);
$stmtInContractCount->execute();
$inContractCountResult = $stmtInContractCount->fetch();

$sqlTransactions = "SELECT transactions.*, UsersInfo.firstName as fName, UsersInfo.lastName lName FROM transactions LEFT JOIN UsersInfo ON UsersInfo.userId = transactions.userId  ORDER BY UsersInfo.firstName DESC";
$transParameters = array();
$transParameters[':userId'] = $_SESSION['userId'];
$transStmt = $dbConn->prepare($sqlTransactions);
$transStmt->execute();
$transResults = $transStmt->fetchAll();

$sqlGetAgents = "SELECT userId, firstName, lastName, mlsId FROM UsersInfo";

$agentStmt = $dbConn->prepare($sqlGetAgents);
$agentStmt->execute();
$agentResults = $agentStmt->fetchAll();


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
    <title>RE/MAX Salinas | Dashboard</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/ca.js"></script>
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Admin Dashboard
                <small>Week Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li>Overview</li>
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo count($keys); ?></h3>
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
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $inContractCountResult['count']; ?></h3>
                            <p>Pending Listings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php //echo $houseStatus[2]['num']; ?></h3>
                            <p>Sold Listings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-tag"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>
                                <sup style="font-size: 20px">$</sup><?php //echo number_format($sumEarnings['average'], 0) ?>
                            </h3>
                            <p>Avg. Agent Commission</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3><?php //echo number_format((float)$sumEarnings['avgPercent'], 2, '.', ''); ?><sup
                                        style="font-size: 20px">%</sup></h3>

                            <p>Avg. Agent Commission </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-percent"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <sup style="font-size: 20px">$</sup> <?php //echo number_format($sumEarnings['earnings'], 0); ?>
                            </h3>
                            <p>Total Net Earnings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bank"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php //include 'inContractTableAdmin.php'; ?>
                    <div class="box box-success">
                                <div class="box-header">
                                    <h4>In-Contract Properties</h4>
                                    <div class="col-xs-2" >
                                    <button style="margin-bottom: 10px" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal">Add New Transaction</button>
                                  </div>
                                    <!-- <button><a href="my-inventory.php">Add New In-Contract</a></button>
                                    <button onClick="showTransactionModal()">Add New Transaction</button> -->
                                </div>
                                <div class="box-body" style="height:300px; overflow: auto;">
                                    <table class="table footable table-bordered table-striped" >
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Agent</th>
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
                                                                            data-placement="top" title="signedDisclousres">Sign. Disc. </a>
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

                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Close of Escrow">Misc. 1 </a></th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Close of Escrow">Misc. 2 </a></th>
                                            <th data-breakpoints="xs sm">Notes</th>
                                            <!-- <th data-breakpoints="xs sm"></th> -->
                                            <th data-breakpoints="xs sm">Edit Dates</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            foreach ($transResults as $trans) {
                                                # code...
                                                $day = $trans['accDay'];

                                                echo '<tr id=inContract' . $trans['transId'] . ' ><td>';
                                                // if ($trans['transType'] == 'Listing') {
                                                //     echo '<b>LIST</b>';
                                                // } else {
                                                //     echo '<b>BUY</b>';
                                                // }
                                                echo $trans['transType'];
                                                echo '</td>';
                                                echo '<td>' . $trans['fName'] . " " .$trans['lName'];
                                            echo '<td id=clientName'. $trans['transId'] . ' onClick="editClientName(' . $trans['transId'] . ')">' . $trans['clientName'] . '</td>
                                            <td>' . $trans['address'] . '</td>
                                            <td id=clientNum' . $trans['transId'] . ' onClick="editClientNum(' . $trans['transId'] . ')">' . $trans['clientNum'] . '</td>
                                            <td id=clientEmail'. $trans['transId'] . ' onClick="editClientEmail(' . $trans['transId'] . ')">' . $trans['clientEmail'] . '</td>
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
                                                    echo '<li><a href="#" id=emdComp' . $trans['transId'] . ' >Completed: ' . date('m/d/y', strtotime($trans['emdComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate("' . $trans['transId'] . '",\'emd\',this) value=' . $trans['emdComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=emdComp' . $trans['transId'] . '>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'emd\',this) ></li>';
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
                                                    echo '<i id=status' . $trans['transId'] . 'emd' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $emdReduced && $today < $emdOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'emd' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $emdOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'emd' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  
                                                  if($trans['sellerDiscRec'] != NULL && $trans['sellerDiscRec'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=recievedComp' . $trans['transId'] . '>Date Recieved: ' . date('m/d/y', strtotime($trans['sellerDiscRec'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'recieved\',this) value=' . $trans['sellerDiscRec'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=recievedComp' . $trans['transId'] . '>Date Recieved: N/A</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'recieved\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['sellerDiscComp'] != NULL && $trans['sellerDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=sellerComp' . $trans['transId'] . '>Completed: ' . date('m/d/y', strtotime($trans['sellerDiscComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'seller\',this) value=' . $trans['sellerDiscComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=sellerComp' . $trans['transId'] . '>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'seller\',this)></li>';
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
                                                    echo '<i id=status' . $trans['transId'] .  'seller' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $sellerReduced && $today < $sellerOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'seller' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $sellerOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'seller' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['signedDiscDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
/////////
                                                
                                                  if($trans['signedDiscComp'] != NULL && $trans['signedDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=signedComp'. $trans['transId'] .'>Signed: ' . date('m/d/y', strtotime($trans['signedDiscComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\''.$trans['transId'] . '\',"signed",this)  value='.$trans['signedDiscComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=signedComp'. $trans['transId'] .'>Signed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\''.$trans['transId'] . '\',"signed",this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $signedOnTime = new DateTime($trans['accDay']);
                                                  $signedOnTime = $signedOnTime->add(new DateInterval('P'.$trans['signedDiscDays'] .'D'));

                                                  $signedReduced = new DateTime($trans['accDay']);
                                                  $signedReduced = $signedReduced->add(new DateInterval('P'.$trans['signedDiscDays'] .'D'));
                                                  $signedReduced = $signedReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['signedDiscComp'] != NULL && $trans['signedDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'signed' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $signedReduced && $today < $signedOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'signed' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $signedOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'signed' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['genInspecDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['genInspecOrd'] != NULL && $trans['genInspecOrd'] != '0000-00-00')
                                                    {
                                                        echo '<li><a href="#" id=generalInspecOrd' . $trans['transId'] . '>Ordered: ' . date('m/d/y', strtotime($trans['genInspecOrd'])) . '</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"generalInspec",this)  value='.$trans['genInspecOrd'] . '></li>';
                                                    }
                                                    else
                                                    {
                                                        echo '<li><a href="#" id=generalInspecOrd' . $trans['transId'] . '>Ordered: N/A</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"generalInspec",this)></li>';
                                                    }

                                                    echo '<li role="separator" class="divider"></li>';

                                                  if($trans['genInspecComp'] != NULL && $trans['genInspecComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=generalInspecComp' . $trans['transId']  . '>Completed: ' . date('m/d/y', strtotime($trans['genInspecComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'generalInspec\',this) value=' . $trans['genInspecComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=generalInspecComp' . $trans['transId']  . '>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'generalInspec\',this) ></li>';
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
                                                    echo '<i id=status' . $trans['transId'] .  'generalInspec' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $genReduced && $today < $genOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'generalInspec' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $genOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'generalInspec' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
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
                                                        echo '<li><a href="#" id=apprOrd' .$trans['transId'].'>Ordered: ' . date('m/d/y', strtotime($trans['apprOrdered'])) . '</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"appr",this) value='. $trans['apprOrdered'].'></li>';
                                                    }
                                                    else
                                                    {
                                                        echo '<li><a href="#" id=apprOrd' .$trans['transId'].'>Ordered: N/A</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"appr",this)></li>';
                                                    }
                                                    
                                                echo '<li role="separator" class="divider"></li>';

                                                  if($trans['apprComp'] != NULL && $trans['apprComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=apprComp' . $trans['transId'] . '>Completed: ' . date('m/d/y', strtotime($trans['apprComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'appr\',this) value='. $trans['apprComp'] . ' ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=apprComp' . $trans['transId'] . ' >Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'appr\',this)></li>';
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
                                                    echo '<i id=status' . $trans['transId'] .  'appr' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $apprReduced && $today < $apprOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'appr' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $apprOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'appr' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
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
                                                    echo '<li><a href="#" id=lcComp' . $trans['transId'] .'>Completed: ' . date('m/d/y', strtotime($trans['lcComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'lc\',this) value=' . $trans['lcComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=lcComp' . $trans['transId'] .'>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'lc\',this)></li>';
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
                                                    echo '<i id=status' . $trans['transId'] .  'lc' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $lcReduced && $today < $lcOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'lc' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $lcOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'lc' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['coeDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['coeOrgDate'] != NULL && $trans['coeOrgDate'] != '0000-00-00')
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
                                                    echo '<li><a href="#" id=coeComp'. $trans['transId'] .'>Completed: ' . date('m/d/y', strtotime($trans['coeComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'coe\',this) value=' . $trans['coeComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=coeComp'. $trans['transId'] .'>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'coe\',this) ></li>';
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
                                                    echo '<i id=status' . $trans['transId'] .  'coe' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $coeReduced && $today < $coeOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'coe' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $coeOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'coe' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['miscOneDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  echo '<li><a href="#">' . $trans['miscOneName'] . '</a></li>';

                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['miscOneComp'] != NULL && $trans['miscOneComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['miscOneComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscOne\',this) value=' . $trans['miscOneComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscOne\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }

                                                 
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $miscOneOnTime = new DateTime($trans['accDay']);
                                                  $miscOneOnTime = $miscOneOnTime->add(new DateInterval('P'.$trans['miscOneDays'] .'D'));

                                                  $miscOneReduced = new DateTime($trans['accDay']);
                                                  $miscOneReduced = $miscOneReduced->add(new DateInterval('P'.$trans['miscOneDays'] .'D'));
                                                  $miscOneReduced = $miscOneReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['miscOneComp'] != NULL && $trans['miscOneComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'miscOne' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $miscOneReduced && $today < $miscOneOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscOne' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $miscOneOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscOne' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }



                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['miscTwoDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  echo '<li><a href="#">' . $trans['miscTwoName'] . '</a></li>';

                                                  echo '<li role="separator" class="divider"></li>';

                                                  if($trans['miscTwoComp'] != NULL && $trans['miscTwoComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['miscTwoComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscTwo\',this) value=' . $trans['miscTwoComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscTwo\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }

                                                  
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $miscTwoOnTime = new DateTime($trans['accDay']);
                                                  $miscTwoOnTime = $miscTwoOnTime->add(new DateInterval('P'.$trans['miscTwoDays'] .'D'));

                                                  $miscTwoReduced = new DateTime($trans['accDay']);
                                                  $miscTwoReduced = $miscTwoReduced->add(new DateInterval('P'.$trans['miscTwoDays'] .'D'));
                                                  $miscTwoReduced = $miscTwoReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['miscTwoComp'] != NULL && $trans['miscTwoComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'miscTwo' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $miscTwoReduced && $today < $miscTwoOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscTwo' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $miscTwoOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscTwo' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td id=' . $trans['transId'] . ' onClick="takeNote(' . $trans['transId'] . ')" > ' . $trans['notes']  . ' </td>';
                                           // <td> <button onClick=takeTransNote(' .$trans['transId'] . ')>  <i class="fa fa-edit" style="color:#d3d3d3"></i> </button></td>
                                           echo '<td>';
                                           ?>
                                           <?php include "staff/editDates.php"; ?>
                                           <?php

                                           echo '</td>
                                        </tr>';
                                    }
                                            ?>

                                        </tbody>
                                    </table>
                                </div> <!-- /.box-body -->
                            </div> <!-- /.box -->
                    <!-- <div class="box">
                        <div class="box-header">
                            <h4>Office Active/Active Contingent Properties</h4>
                        </div>
                        <div class="box-body"> -->
                            <!-- <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>Property</th>
                                    <th data-breakpoints="all">Client Name</th>
                                    <th data-breakpoints="all">Client Number</th>
                                    <th data-breakpoints="all">Client Email</th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Accepted Date">Acc. </a></th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Earnest Money Deposit">EMD </a>
                                    </th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Disclosures">Disc. </a>
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
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // foreach ($inContractResults as $inContract) 
                                    // {
                                        // $day = $inContract['accDay'];
                                        // echo "<tr>";
                                        // echo "<td>" . $inContract['firstName'] . " " . $inContract['lastName'] . "</td>";
                                        // echo "<td>" . $inContract['address'] . "</td>";
                                        // echo "<td>" . $inContract['clientName'] . "</td>";
                                        // echo "<td>" . $inContract['clientNum'] . "</td>";
                                        // echo "<td>" . $inContract['clientEmail'] . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day)) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['emdDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['sellerDiscDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['genInspecDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['appraisalDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['lcDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['coeDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . $inContract['notes'] . "</td>";
                                        // echo "</tr>";
                                    // }
                                    ?>
                                <tr>

                                    <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                    <td>Patty Hershang</td>
                                    <td>831-382-4833</td>
                                    <td>phershang@gmail.com</td>

                                    <td>3/1/17
                                        <br>
                                        <span class="label label-success">Done! <i
                                                    class="fa fa-check-circle-o"></i></span>
                                    </td>
                                    <td>3/1/17
                                        <br>
                                        <span class="label label-success">Done! <i
                                                    class="fa fa-check-circle-o"></i></span>
                                    </td>
                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"><i
                                                    class="fa fa-chevron-circle-right"></i></a>
                                        <br>
                                        <span class="label label-danger">Overdue</span>
                                    </td>

                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"><i
                                                    class="fa fa-chevron-circle-right"></i></a>
                                        <br>
                                        <span class="label label-warning">Due in 8d</span>
                                    </td>

                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"><i
                                                    class="fa fa-chevron-circle-right"></i></a>
                                        <br>
                                        <span class="label label-warning">Due in 8d</span>
                                    </td>

                                    <td>3/1/17
                                        <br>
                                        <span class="label label-default">Incomplete</span>
                                    </td>
                                    <td>3/1/17
                                        <br>
                                        <span class="label label-default">Incomplete</span>
                                    </td>
                                    <td>Write some notes here!</td>
                                </tr> -->
                               <!--  </tbody>
                            </table> --> 
                        <!-- </div> -->
                        <!-- /.box-body -->
                    <!-- </div> -->
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

<?php include "staff/staffEventModal.php" ?>

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="./dist/js/vendor/footable.min.js"></script>

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
<script>

 function editClientName(id)
            {
                // alert("edit client name");
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $("#clientName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractClientName.php", {
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
                    $("#clientNum" + id + "-detail").html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractClientNum.php", {
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
                    $("#clientEmail" + id+ "-detail").html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractClientEmail.php", {
                        transId: id,
                        clientEmail: clientEmail
                    });
                }
            }

            function takeNote(id)
            {
                // alert(id);
                var today = moment().format("MM-DD-YYYY");
                var prevNote = $("#" + id).html();
                if(prevNote == "" || prevNote == " ")
                {
                    var noteEntered = prompt("Enter Note:", today + " " + prevNote );
                }
                else
                {
                    var noteEntered = prompt("Enter Note:", prevNote + " " + today );
                }
                if (noteEntered == null || noteEntered == "") {
                } else {
                    $("#" + id).html(noteEntered);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractNote.php", {
                        transId: id,
                        note: noteEntered
                    });
                }
            }

            function saveNameMisc(transId,type,name)
            {
                // alert(name.value);
                $.post( "staff/saveMiscName.php", { transId: transId, type:type, name:name.value });
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
                $.post( "staff/saveOrdDates.php", { transId: transId, type:type, date:sendDate });

                if(confirm("Do you want to download Extension Form?"))
                {

                }
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
                $.post( "staff/saveCompDates.php", { transId: transId, type:type, date:sendDate });
                
                

            }
             function saveDateCalendar(transId,type,date)
             {
          
                var aprvDay = $("#aprvDay"+transId).val();
                $("#aprvDay" + transId).val(date.value);
                updateStatus(transId,type,date);
                $.post( "staff/saveNewDates.php", { transId: transId, type:type, date:date.value, aprvDay: aprvDay });
                if(confirm("Do you want to download Extension Form?"))
                {

                }
            }
            
            function saveDaysNum(transId,type,date)
             {
           
                $.post( "staff/saveNewDaysNum.php", { transId: transId, type:type, date:date.value });
                updateStatus(transId,date);
                if(confirm("Do you want to download Extension Form?"))
                {

                }
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
                    $.post( "staff/deleteInContract.php", { inContractId: inContractId })
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

            function takeTransNote(transId)
        {
            var prevNote = $("#" + transId).html();
            var noteEntered = prompt("Enter Note:", prevNote);
            if (noteEntered == null || noteEntered == "") {
            } else {
                $("#" + transId).html(noteEntered);
                // alert(houseId + " " + buyerID);
                $.post("agent/saveTransNote.php", {
                    transId: transId,
                    note: noteEntered
                });
                
            }

        }

function addNewTransaction()
            {
                var houseSelected = $('#houseId').children(":selected").attr("value");   
                var agentSelected = $('#agentName').children(":selected").attr("value"); 
                var accDate = $('#newAccDate').val();

                var inputAddress = $('#inputAddress').val();;
                var inputCity = $('#inputCity').val();;
                var inputState = $('#inputState').val();;
                var inputZip = $('#inputZip').val();;

                // alert(accDate);

                // alert(agentSelected);

                // alert(houseSelected);

                if(houseSelected == "" && inputAddress != "" && inputState != "" && inputCity != "" && inputZip != "" && accDate != "")
                {
                    $.post("staff/addTransactionStaffInput.php", {userId: agentSelected, address: inputAddress, state: inputState, 
                                                            city: inputCity, zip: inputZip , accDate: accDate});
                    alert("House In-Contract");
                    
                }
                else if(houseSelected != "" && inputAddress == "" && inputState == "" && inputCity == "" && inputZip == "" && accDate != "")
                {
                    $.post("staff/addTransactionStaff.php", {userId: agentSelected, houseId: houseSelected, accDate: accDate});
                    alert("House In-Contract");
                }
                else
                {
                    alert("Choose House from dropdown, input house data, or check date.");
                }
                
                
            }
</script>
</body>

</html>
