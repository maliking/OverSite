
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
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/skin-red-light.css">
    <link rel="stylesheet" href="../plugins/footable/css/footable.bootstrap.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <style>
        a.dotted {
            color: #333333;
            border-bottom: 1px dashed #999;
            text-decoration: none;
        }

    </style>

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
                                <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs">Agent</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image in the menu -->
                                <li class="user-header">
                                    <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                    <p>
                                        Agent
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
                                        <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
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
                    <li class="active"><a href="./index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<!--                    <li><a href="signIn.php" target="_blank"><i class="fa fa-edit"></i> <span>Sign In Sheet</span></a></li>-->
                     <li><a href="OverSite/openhouse/listings-openhouse.php" target="_blank"><i class="fa fa-home"></i> <span>Open House</span></a></li>
                    <li><a href="my-calendar.php"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
                    <!--                    WANT THE REST TO BE DROPDOW MENUS-->
                    <li class="header">PROPERTIES <span class="fa fa-chevron-down"></span></li>
                    <li><a href="my-inventory.php"><i class="fa fa-home"></i> <span>My Inventory</span></a></li>
                    <li><a href="office-inventory.php"><i class="fa fa-building"></i> <span>Office Inventory</span></a></li>
                    <li class="header">TRANSACTIONS <span class="fa fa-chevron-down"></span></li>



                    <li><a href="#"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
                    <li><a href="#"><i class="fa fa-file-text-o"></i> <span>Monthly Report</span></a></li>
                    <li><a href="#"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
                    <li class="header">STATISTICS <span class="fa fa-chevron-down"></span></li>
                    <li><a href="#"><i class="fa fa-line-chart"></i> <span> Analytics</span></a></li>

                    <li><a href="viewVisitors.php"><i class="fa fa-file-text-o"></i> <span>Visitors</span></a></li>
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


<!--
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div>
                        <div class="x_title">
                            <h2>Top Profiles</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a>
                                        </li>
                                        <li><a href="#">Settings 2</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <ul class="list-unstyled top_profiles scroll-view">
                            <li class="media event">
                                <a class="pull-left border-aero profile_thumb">
                                    <i class="fa fa-user aero"></i>
                                </a>
                                <div class="media-body">
                                    <a class="title" href="#">Ms. Mary Jane</a>
                                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                    <p> <small>12 Sales Today</small>
                                    </p>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-green profile_thumb">
                                    <i class="fa fa-user green"></i>
                                </a>
                                <div class="media-body">
                                    <a class="title" href="#">Ms. Mary Jane</a>
                                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                    <p> <small>12 Sales Today</small>
                                    </p>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-user blue"></i>
                                </a>
                                <div class="media-body">
                                    <a class="title" href="#">Ms. Mary Jane</a>
                                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                    <p> <small>12 Sales Today</small>
                                    </p>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-aero profile_thumb">
                                    <i class="fa fa-user aero"></i>
                                </a>
                                <div class="media-body">
                                    <a class="title" href="#">Ms. Mary Jane</a>
                                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                    <p> <small>12 Sales Today</small>
                                    </p>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-green profile_thumb">
                                    <i class="fa fa-user green"></i>
                                </a>
                                <div class="media-body">
                                    <a class="title" href="#">Ms. Mary Jane</a>
                                    <p><strong>$2300. </strong> Agent Avarage Sales </p>
                                    <p> <small>12 Sales Today</small>
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
-->





                <!--                   -------------------------------OLD CALENDAR CODE BELOW------------------------             -->
                <!--
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>Calendar <small>Click to add/edit events</small></h3>
                            </div>

                            <div class="title_right">
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Calendar Events <small>Sessions</small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Settings 1</a>
                                                    </li>
                                                    <li><a href="#">Settings 2</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">

                                        <div id='calendar'></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
-->

                <!--   -------------------------------OLD CALENDAR CODE ABOVE------------------------             -->


                <!--   <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4>My Inventory</h4>
                                </div>
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
                                                    <br>
                                                    <span class="label label-success">Done! <i class="fa fa-check-circle-o"></i></span>
                                                </td>
                                                <td>3/1/17
                                                    <br>
                                                    <span class="label label-success">Done! <i class="fa fa-check-circle-o"></i></span>
                                                </td>
                                                <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17" data-toggle="popover" data-Oplacement="right" data-content="<b>Completed:</b> 3/4/17"><i class="fa fa-chevron-circle-right"></i></a>
                                                    <br>
                                                    <span class="label label-danger">Overdue</span>
                                                </td>

                                                <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17" data-toggle="popover" data-Oplacement="right" data-content="<b>Completed:</b> 3/4/17"><i class="fa fa-chevron-circle-right"></i></a>
                                                    <br>
                                                    <span class="label label-warning">Due in 8d</span>
                                                </td>

                                                <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17" data-toggle="popover" data-Oplacement="right" data-content="<b>Completed:</b> 3/4/17"><i class="fa fa-chevron-circle-right"></i></a>
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
                                </div>   -->
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

    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- Footable -->
    <script type="text/javascript" src="../plugins/footable/js/footable.min.js"></script>
    <script>
        jQuery(function($) {
            $('.table').footable({

            });
        });

    </script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover({
                html: true
            });
        });

    </script>
</body>

</html>
