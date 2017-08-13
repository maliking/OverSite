<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT username FROM  UsersInfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Roster</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-admin/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <link rel="stylesheet" href="plugins/datatables/datatables.min.css">

    </head>

    <body class="hold-transition skin-blue-light sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">
            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-admin/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-admin/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Agent Roster
                    </h1>
                    <ol class="breadcrumb">
                        <li>Properties</li>
                        <li class="active"><a href="#"><i class="fa fa-archive"></i> Current Inventory</a></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">

                                <div class="box-body">
                                    <table id="listing-table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Zip</th>
                                                <th><i class="fa fa-bed"></i></th>
                                                <th><i class="fa fa-bath"></i></th>
                                                <th>Sqft</th>
                                                <th>Lot</th>
                                                <th>Price</th>
                                                <th>DOM <a href="#" data-toggle="tooltip" data-placement="top" title="Days on the market"><i class="fa fa-question-circle"></i></a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
    foreach ($result as $agent) {
        echo "<tr>";

        echo "<td>" . ucwords($agent['username']) . "</td>";

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
            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">

                    <?php
                    foreach ($result as $agent) {
                        echo '<div class="row">';
                        echo '<div class="col-md-8">';
                        echo '<div class="box box-default collapsed-box">';
                        echo '<div class="box-header with-border">';
                        echo '<h3 class="box-title">' . ucwords($agent['username']) . '</h3>';
                        echo '<div class="box-tools pull-right">';
                        echo '<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>';
                        echo '</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="box-body">';
                        echo 'Stats';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>

                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->

        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-admin/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- Right control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a>
                </li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:;">
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.control-sidebar-menu -->
                </div>
                <!-- /.tab-pane -->

                <!-- Settings tab pane -->
                <div class="tab-pane" id="control-sidebar-stats-tab">
                    Settings Tab Content
                </div>
                <!-- /.tab-pane -->

                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Setting1
                                <input type="checkbox" class="pull-right" checked>
                            </label>
                            <p>
                                Setting details
                            </p>
                        </div>
                        <!-- /.form-group -->
                    </form>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Sidebar Background -->
        <div class="control-sidebar-bg">
        </div>
        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-admin/default-js.php" ?>
        <!-- END TEMPLATE default-js.php INCLUDE -->

        <!-- PAGE-SPECIFIC JS -->
        <script type="text/javascript" src="plugins/datatables/datatables.min.js"></script>


        <script>
            // Listings Table Options (Current Inventory, past sales, etc)
            $(function () {
                $("#listing-table").DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "order": [8, 'desc'],
                    "info": true,
                    "responsive": true,
                    "autoWidth": false,
                    "select": true,
                    "search": {
                        "smart": true
                    },
                    "columnDefs": [{
                        "orderable": false,
                        "targets": 0,
                    },
                                   {
                                       responsivePriority: 1,
                                       targets: 0
                                   },
                                   {
                                       responsivePriority: 2,
                                       targets: 1
                                   },
                                   {
                                       responsivePriority: 3,
                                       targets: -5
                                   },
                                   {
                                       responsivePriority: 4,
                                       targets: -2
                                   },
                                   {
                                       responsivePriority: 5,
                                       targets: -4
                                   }
                                  ],
                });
            });
        </script>
    </body>

</html>
