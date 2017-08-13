<?php
require("../databaseConnection.php");  
session_start();
$dbConn = getConnection();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
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
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Property</th>
                                                <th data-breakpoints="all">Client Name</th>
                                                <th data-breakpoints="all">Client Number</th>
                                                <th data-breakpoints="all">Client Email</th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Approval Date">Aprv. </a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Earnest Money Deposit">EMD </a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Disclosures">Disc. </a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Inspection">Insp. </a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Appr. </a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Loan Contingencies">LC </a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Close of Escrow">COE </a></th>
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
                                                    <br> <span class="label label-success">Done! <i class="fa fa-check-circle-o"></i></span> </td>
                                                <td>3/1/17
                                                    <br> <span class="label label-success">Done! <i class="fa fa-check-circle-o"></i></span> </td>
                                                <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17" data-toggle="popover" data-Oplacement="right" data-content="<b>Completed:</b> 3/4/17"><i class="fa fa-chevron-circle-right"></i></a>
                                                    <br> <span class="label label-danger">Overdue</span> </td>
                                                <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17" data-toggle="popover" data-Oplacement="right" data-content="<b>Completed:</b> 3/4/17"><i class="fa fa-chevron-circle-right"></i></a>
                                                    <br> <span class="label label-warning">Due in 8d</span> </td>
                                                <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17" data-toggle="popover" data-Oplacement="right" data-content="<b>Completed:</b> 3/4/17"><i class="fa fa-chevron-circle-right"></i></a>
                                                    <br> <span class="label label-warning">Due in 8d</span> </td>
                                                <td>3/1/17
                                                    <br> <span class="label label-default">Incomplete</span> </td>
                                                <td>3/1/17
                                                    <br> <span class="label label-default">Incomplete</span> </td>
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