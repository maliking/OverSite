<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp17.org/login.php");

}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Dashboard</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
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
                        Agent Dashboard
                        <small>Week Overview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>Overview</li>
                        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
                                    <h3>4</h3>
                                    <p>Active Listings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-flash"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">2%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>2</h3>
                                    <p>Pending Listings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">5%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>6</h3>
                                    <p>Sold Listings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">8%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup>12,232</h3>
                                    <p>Avg. Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-down "></i> <span class="text-red">3%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>2.2<sup style="font-size: 20px">%</sup></h3>

                                    <p>Avg. Commission </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-down "></i> <span class="text-red">1%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup> 39,434</h3>
                                    <p>Total Gross Earnings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bank"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">11%</span> than last year</a>
                            </div>
                        </div>
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
    </body>

</html>
