<?php
require("../databaseConnection.php");

session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM salesinfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();


if (!isset($_SESSION['userId'])) {
    header("Location: ../login.php");
}
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Monthly Report</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

        <link rel="stylesheet" href="dist/css/skins/skin-blue-light.css">
        <!-- <link rel="stylesheet" href="plugins/datatables/datatables.min.css"> -->
        <link rel="stylesheet" href="plugins/footable/css/footable.bootstrap.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-blue-light sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style is in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li>
                                        <!-- Inner message menu -->
                                        <ul class="menu">
                                            <li>
                                                <!-- Start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <!-- User Image -->
                                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                    </div>
                                                    <!-- Message title and timestamp -->
                                                    <h4>
                                                        Support Team
                                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                    </h4>
                                                    <!-- Message content -->
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li>
                                            <!-- End message -->
                                        </ul>
                                        <!-- /.menu -->
                                    </li>
                                    <li class="footer"><a href="#">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- /.messages-menu -->

                            <!-- Notifications Menu -->
                            <li class="dropdown notifications-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning">10</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 10 notifications</li>
                                    <li>
                                        <!-- Inner nofications menu -->
                                        <ul class="menu">
                                            <li>
                                                <!-- Start notification -->
                                                <a href="#">
                                                    <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                                </a>
                                            </li>
                                            <!-- End notification -->
                                        </ul>
                                    </li>
                                    <li class="footer"><a href="#">View all</a></li>
                                </ul>
                            </li>
                            <!-- Tasks Menu -->
                            <li class="dropdown tasks-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-flag-o"></i>
                                    <span class="label label-danger">9</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 9 tasks</li>
                                    <li>
                                        <!-- Inner tasks menu -->
                                        <ul class="menu">
                                            <li>
                                                <!-- Task item -->
                                                <a href="#">
                                                    <!-- Task title and progress text -->
                                                    <h3>
                                                        Design some buttons
                                                        <small class="pull-right">20%</small>
                                                    </h3>
                                                    <!-- Progress bar -->
                                                    <div class="progress xs">
                                                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">20% Complete</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                            <!-- End task item -->
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <a href="#">View all tasks</a>
                                    </li>
                                </ul>
                            </li>
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- User image in navbar-->
                                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image in the menu -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                                        <p>
                                            <?php echo $_SESSION['username']; ?>
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">
                                        <div class="row">
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Followers</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Sales</a>
                                            </div>
                                            <div class="col-xs-4 text-center">
                                                <a href="#">Friends</a>
                                            </div>
                                        </div>
                                        <!-- /.row -->
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <<<<<<< HEAD:monthly-report.php
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                            =======
                                            <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                                            >>>>>>> origin/master:agent/agent-active-properties.php
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- Sidebar -->
                <section class="sidebar">
                    <a href="index.php" class="logo">
                        <!-- Logo -->
                        <img class="img-responsive" src="dist/img/remax-logo.png">
                    </a>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">OVERVIEW</li>
                        <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                        <li class="header">PROPERTIES</li>
                        <li><a href="inventory.php"><i class="fa fa-home"></i> <span>Current Inventory</span></a></li>
                        <li><a href="coming-soon.php"><i class="fa fa-flag"></i> <span>Coming Soon</span></a></li>
                        <li class="past-sales"><a href="past-sales.php"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
                        <li class="header">TRANSACTIONS</li>
                        <li><a href="sales-breakdown.php"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
                        <li class="active"><a href="monthly-report.php"><i class="fa fa-file-text-o"></i> <span>Monthly Report</span></a></li>
                        <li class="header">STATISTICS</li>
                        <li><a href="analytics.php"><i class="fa fa-line-chart"></i> <span> Analytics</span></a></li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Monthly Report
                    </h1>
                    <ol class="breadcrumb">
                        <li>Transactions</li>
                        <li class="active"><a href="#"><i class="fa fa-archive"></i> Monthly Report</a></li>
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
                                                <th>Agent</th>
                                                <th>Commissions</th>
                                                <th>Listings</th>
                                                <th>L.V. <a href="#" data-toggle="tooltip" data-placement="top" title="Listings Volume"><i class="fa fa-question-circle"></i></a></th>
                                                <th>Sales</th>
                                                <th>S.V. <a href="#" data-toggle="tooltip" data-placement="top" title="Sales Volume"><i class="fa fa-question-circle"></i></a></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <<<<<<< HEAD:monthly-report.php
                                            <?php
                                            foreach ($result as $sales) {
                                                echo "<tr>";
                                                echo "<td>" . $sales['agent'] . "</td>";
                                                echo "<td>" . '$' . number_format($sales['total'], 0) . "</td>";
                                                echo "<td>" . '$' . number_format($sales['office'], 0) . "</td>";
                                                echo "<td>" . '$' . number_format($sales['eo'], 0) . "</td>";
                                                echo "<td>" . '$' . number_format($sales['tech'], 0) . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            =======
                                            <?php
                                            /* $dbConn = getConnection();

                                              $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip, bedrooms, bathrooms, price
                                              FROM HouseInfo
                                              WHERE userId = :userId
                                              ORDER BY dateTimes ASC";

                                              $namedParameters = array();
                                              $namedParameters[':userId'] = $_SESSION['userId'];
                                              $stmt = $dbConn -> prepare($sql);
                                              $stmt->execute($namedParameters);
                                              //$stmt->execute();
                                              $results = $stmt->fetchAll();

                                              foreach($results as $result){
                                              echo "<tr>";
                                              echo "<td>" . $result['houseId'] . "</td>";
                                              echo "<td>" . $result['address'] . "</td>";
                                              echo "<td>King</td>";
                                              echo "<td>Mali</td>";
                                              echo "<td>4083488336</td>":
                                              echo "<td>5/6/17</td>";
                                              echo "<td>5/9/17</td>";
                                              echo "<td>5/12/17</td>";
                                              echo "<td>5/12/17</td>";
                                              echo "<td>5/12/17</td>";
                                              echo "<td>Notes</td>";
                                              } //closes foreach */
                                            ?>
                                            >>>>>>> origin/master:agent/agent-active-properties.php
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

        <div class="modal fade" id="editor-modal" tabindex="-1" role="dialog" aria-labelledby="editor-title">
            <style scoped>
                /* provides a red astrix to denote required fields - this should be included in common stylesheet */
                .form-group.required .control-label:after {
                    content:"*";
                    color:red;
                    margin-left: 4px;
                }
            </style>
            <div class="modal-dialog" role="document">
                <form class="modal-content form-horizontal" id="editor">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="editor-title">Add Row</h4>
                    </div>
                    <div class="modal-body">
                        <input type="number" id="id" name="id" class="hidden"/>
                        <div class="form-group required">
                            <label for="address" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="address" name="address" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zip" class="col-sm-3 control-label">Zip</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="Job Title">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="bedrooms" class="col-sm-3 control-label">Bedrooms</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="bedrooms" name="bedrooms" placeholder="Started On" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bathrooms" class="col-sm-3 control-label">Bathrooms</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="bathrooms" name="bathrooms" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sqft" class="col-sm-3 control-label">Sqft</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="sqft" name="sqft" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lot" class="col-sm-3 control-label">Lot Size</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="lot" name="lot" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-sm-3 control-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="price" name="price" placeholder="Date of Birth">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dom" class="col-sm-3 control-label">DOM <a href="#" data-toggle="tooltip" data-placement="top" title="Days on the market"><i class="fa fa-question-circle"></i></a></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="dom" name="dom" placeholder="Date of Birth">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- Right side -->
            <div class="pull-right hidden-xs">
                Powered by <a href="#">Oversite</a>
            </div>
            <!-- Left side -->
            <strong>&copy; 2016 | <a href="#">Re/Max Salinas</a>.</strong> All rights reserved.
        </footer>

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

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.js"></script>
        <!-- Datatables
        <script type="text/javascript" src="plugins/datatables/datatables.min.js"></script> -->
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <script type="text/javascript" src="plugins/footable/js/footable.min.js"></script>

        <script>
            var $modal = $('#editor-modal'),
                    $editor = $('#editor'),
                    $editorTitle = $('#editor-title'),
                    ft = FooTable.init('#listing-table', {
                        editing: {
                            enabled: true,
                            alwaysShow: true,
                            addRow: function () {
                                $modal.removeData('row');
                                $editor[0].reset();
                                $editorTitle.text('Add a new row');
                                $modal.modal('show');
                            },
                            editRow: function (row) {
                                var values = row.val();
                                $editor.find('#id').val(values.id);
                                $editor.find('#address').val(values.firstName);
                                $editor.find('#city').val(values.lastName);
                                $editor.find('#zip').val(values.jobTitle);
                                $editor.find('#bedrooms').val(values.startedOn);
                                $editor.find('#bathrooms').val(values.dob);
                                $editor.find('#sqft').val(values.dob);
                                $editor.find('#lot').val(values.dob);
                                $editor.find('#price').val(values.dob);
                                $editor.find('#dom').val(values.dob);



                                $modal.data('row', row);
                                $editorTitle.text('Edit row #' + values.id);
                                $modal.modal('show');
                            },
                            deleteRow: function (row) {
                                if (confirm('Are you sure you want to delete the row?')) {
                                    row.delete();
                                }
                            }
                        }
                    }),
                    uid = 10;

            $editor.on('submit', function (e) {
                if (this.checkValidity && !this.checkValidity())
                    return;
                e.preventDefault();
                var row = $modal.data('row'),
                        values = {
                            id: $editor.find('#id').val(),
                            address: $editor.find('#address').val(),
                            city: $editor.find('#city').val(),
                            zip: $editor.find('#zip').val(),
                            bedrooms: $editor.find('#bedrooms').val(),
                            bathrooms: $editor.find('#bathrooms').val(),
                            sqft: $editor.find('#sqft').val(),
                            lot: $editor.find('#lot').val(),
                            price: $editor.find('#price').val(),
                            dom: $editor.find('#dom').val(),

                        };

                if (row instanceof FooTable.Row) {
                    row.val(values);
                } else {
                    values.id = uid++;
                    ft.rows.add(values);
                }
                $modal.modal('hide');
            });
        </script>
        <!--
        <script>
          // Listings Table Options (Current Inventory, past sales, etc)
          $(function() {
            $("#listing-table").DataTable({
              "paging": false,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "order": [3, 'desc'],
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
                  targets: -1
                },
                {
                  responsivePriority: 5,
                  targets: -4
                }
              ],
            });
          });
        </script>
        -->
    </body>

</html>
