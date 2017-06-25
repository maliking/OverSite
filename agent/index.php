<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Dashboard</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/skin-red-light.min.css">
        <link rel="stylesheet" href="../plugins/footable/css/footable.bootstrap.min.css">
        <style>
            .form-group.required .control-label:after {
                content:"*";
                color:red;
                margin-left: 4px;
            }

        </style>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-red-light sidebar-mini">
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
                                                        <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
                                    <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image in the menu -->
                                    <li class="user-header">
                                        <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
                                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
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

                <!-- Sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <a href="index.php" class="logo">
                        <!-- Logo -->
                        <img class="img-responsive" src="../dist/img/remax-logo.png">
                    </a>
                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu">
                        <li class="header">OVERVIEW</li>
                        <li class="active"><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                        <li><a href="signIn.php" target="_blank"><i class=""></i> <span>Sign In Sheet</span></a></li>
                        <li class="header">PROPERTIES</li>
                        <li><a href="agent-active-properties.php"><i class="fa fa-home"></i> <span>My Inventory</span></a></li>
                        <li><a href="#"><i class="fa fa-flag"></i> <span>Office Inventory</span></a></li>
                        <li><a href="#"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
                        <li class="header">TRANSACTIONS</li>
                        <li><a href="#"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
                        <li><a href="#"><i class="fa fa-file-text"></i> <span> Monthly Report</span></a></li>
                        <li class="header">STATISTICS</li>
                        <li><a href="statistics.php"><i class="fa fa-line-chart"></i> <span> Analytics</span></a></li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
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
                                    <h3><?php echo $houseStatus[0]['num']; ?></h3>
                                    <p>Active Listings</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-flash"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">2%</span> than last year</a>
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
                                    <i class="ion ion-ios-timer"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">5%</span> than last year</a>
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
                                    <i class="ion-ios-pricetags"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">8%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup><?php echo number_format($sumEarnings['average'], 0) ?></h3>
                                    <p>Avg. Agent Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
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

                                    <p>Avg. Agent Commission </p>
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
                                    <h3><sup style="font-size: 20px">$</sup> <?php echo number_format($sumEarnings['earnings'], 0); ?> </h3>
                                    <p>Total Net Earnings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bank"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">11%</span> than last year</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class=" fa fa-flash"></i> My Inventory</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="myTable" data-editing-always-show="true" data-editing="true" class="table table-bordered table-striped">
                                        
                                    </table>
                                    <div class="modal fade" id="editor-modal" tabindex="-1" role="dialog" aria-labelledby="editor-title">

                                        <div class="modal-dialog" role="document">
                                            <form class="modal-content form-horizontal" id="editor">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title" id="editor-title">Add Row</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="number" id="id" name="id" class="hidden"/>
                                                    <div class="form-group required">
                                                        <label for="property" class="col-sm-3 control-label">Property Address</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="property" name="property" placeholder="property" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label for="lastname" class="col-sm-3 control-label">Last Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="firstname" class="col-sm-3 control-label">First Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group required">
                                                        <label for="phone" class="col-sm-3 control-label">Phone Number</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="XXX-XXX-XXXX" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="approval" class="col-sm-3 control-label">Approval</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" id="approval" name="approval">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="emd" class="col-sm-3 control-label">EMD</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" id="emd" name="emd" >
                                                        </div>
                                                    </div>                        <div class="form-group">
                                                        <label for="contingency" class="col-sm-3 control-label">Contingency</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" id="contingency" name="contingency" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="coe" class="col-sm-3 control-label">COE</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" id="coe" name="coe">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="loans" class="col-sm-3 control-label">Loans</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" id="loans" name="loans">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="notes" class="col-sm-3 control-label">Notes</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="notes" name="notes" placeholder="Notes">
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
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Powered by <a href="#">OverSite</a>
            </div>
            <!-- Default to the left -->
            <strong>&copy; 2016 | <a href="#">Re/Max Salinas</a>.</strong> All rights reserved.
        </footer>

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.2.3 -->
        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../plugins/moment/moment.min.js"></script>

        <!-- Slimscroll -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- Datatables -->
        <script type="text/javascript" src="../plugins/footable/js/footable.min.js"></script>
        <script>
            jQuery(function ($) {
                $('#myTable').footable({
=                    "columns": [
                        {"name": "id", "title": "ID", "breakpoints": "xs"},
                        {"name": "property", "title": "Property",},
                        {"name": "firstname", "title": "First Name",},
                        {"name": "lastname", "title": "Last Name",},
                        {"name": "phone", "title": "Phone","breakpoints": "xs"},
                        {"name": "approval", "title": "Approval","breakpoints": "xs sm"},
                        {"name": "emd", "title": "emd", "breakpoints": "xs sm md"},
                        {"name": "contingency", "title": "Contingency","breakpoints": "xs sm md"},
                        {"name": "coe", "title": "coe", "breakpoints": "xs sm md"},
                        {"name": "loans", "title": "Loans", "breakpoints": "xs sm md"},
                        {"name": "notes", "title": "Notes", "breakpoints": "xs sm md"},
                    ],
                    "rows": [
                        {"id": 1, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                        {"id": 2, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                        {"id": 3, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                        {"id": 4, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                        {"id": 5, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                        {"id": 6, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                        {"id": 7, "property": "43298 Craig Dr. Salinas CA, 94832", "firstname": "Elodia", "lastname": "Weisz", "phone":"329-328-3284", "approval": "03/12/2017", "emd": "03/12/2017", "contingency": "03/12/2017", "coe": "03/12/2017",  "loans": "03/12/2017", "notes": "notes"},
                    ]
                });
            });
        </script>
        <script>
            jQuery(function ($) {

                var $modal = $('#editor-modal'),
                        $editor = $('#editor'),
                        $editorTitle = $('#editor-title'),
                        ft = FooTable.init('#myTable', {

                            editing: {
                                enabled: true,
                                addRow: function () {
                                    $modal.removeData('row');
                                    $editor[0].reset();
                                    $editorTitle.text('Add a new row');
                                    $modal.modal('show');
                                },
                                editRow: function (row) {
                                    var values = row.val();
                                    $editor.find('#id').val(values.id);
                                    $editor.find('#property').val(values.property);
                                    $editor.find('#firstname').val(values.firstname);
                                    $editor.find('#lastname').val(values.lastname);
                                    $editor.find('#phone').val(values.phone);
                                    $editor.find('#approval').val(values.approval.format('MM-DD-YYYY'));
                                    $editor.find('#emd').val(values.emd.format('MM-DD-YYYY'));
                                    $editor.find('#contingency').val(values.contingency.format('MM-DD-YYYY'));
                                    $editor.find('#coe').val(values.coe.format('MM-DD-YYYY'));
                                    $editor.find('#loans').val(values.loans.format('MM-DD-YYYY'));

                                    $editor.find('#notes').val(values.notes);
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
                                property: $editor.find('#property').val(),
                                firstname: $editor.find('#firstname').val(),
                                lastname: $editor.find('#lastname').val(),
                                phone: $editor.find('#phone').val(),
                                approval: moment($editor.find('#approval').val(), 'MM-DD-YYYY'),
                                emd: moment($editor.find('#emd').val(), 'MM-DD-YYYY'),
                                contingency: moment($editor.find('#contingency').val(), 'MM-DD-YYYY'),
                                coe: moment($editor.find('#coe').val(), 'MM-DD-YYYY'),
                                loans: moment($editor.find('#loans').val(), 'MM-DD-YYYY'),
                                notes: $editor.find('#notes').val()

                            };

                    if (row instanceof FooTable.Row) {
                        row.val(values);
                    } else {
                        values.id = uid++;
                        ft.rows.add(values);
                    }
                    $modal.modal('hide');
                });
            });
        </script>


    </body>

</html>
