<?php
session_start();
// echo($_SESSION['userType']);
if (!isset($_SESSION['userId']) ) {
    header("Location: login.php");
}

if($_SESSION['userType'] == "1" && ($_SESSION['userId'] != "34" && $_SESSION['userId'] != "37"))
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
                            <h3><?php echo $houseStatus[0]['num']; ?></h3>
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
                            <h3><?php echo $houseStatus[1]['num']; ?></h3>
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
                            <h3><?php echo $houseStatus[2]['num']; ?></h3>
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
                                <sup style="font-size: 20px">$</sup><?php echo number_format($sumEarnings['average'], 0) ?>
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
                            <h3><?php echo number_format((float)$sumEarnings['avgPercent'], 2, '.', ''); ?><sup
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
                                <sup style="font-size: 20px">$</sup> <?php echo number_format($sumEarnings['earnings'], 0); ?>
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
                    <div class="box">
                        <div class="box-header">
                            <h4>Active/Active Contingent Properties</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Property</th>
                                    <th data-breakpoints="all">Client Name</th>
                                    <th data-breakpoints="all">Client Number</th>
                                    <th data-breakpoints="all">Client Email</th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Approval Date">Aprv. </a></th>
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
                                </tr>
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
</body>

</html>
