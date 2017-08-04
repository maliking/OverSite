<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
?>


    <!DOCTYPE html>
    <html>


    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | My Calendar</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/skin-red-light.css">
        <link rel="stylesheet" href="../plugins/footable/css/footable.bootstrap.min.css">

        <!-- NProgress -->
        <!-- <link href="../plugins/nprogress/nprogress.css" rel="stylesheet"> -->
        <!-- FullCalendar -->
        <link href="../plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
        <link href="../plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet">
        <link href="../plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" media="print">
        <link href="../plugins/fullcalendar/fullcalendar.min.js">
        <link href="../plugins/fullcalendar/fullcalendar.js" >
        <script  src="https://code.jquery.com/jquery-3.2.1.js"  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="  crossorigin="anonymous"></script>
        <!-- Custom styling plus plugins -->
        <!-- <link href="../build/css/custom.min.css" rel="stylesheet"> -->



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
                    <!--
                <h1>
                    Agent Dashboard
                    <small>Week Overview</small>
                </h1>
                <ol class="breadcrumb">
                    <li>Overview</li>
                    <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                </ol>
-->
                </section>






                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
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

        <!-- calendar modal -->
        <div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">New Calendar Entry</h4>
                    </div>
                    <div class="modal-body">
                        <div id="testmodal" style="padding: 5px 20px;">
                            <form id="antoform" class="form-horizontal calender" role="form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="title" name="title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary antosubmit">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel2">Edit Calendar Entry</h4>
                    </div>
                    <div class="modal-body">

                        <div id="testmodal2" style="padding: 5px 20px;">
                            <form id="antoform2" class="form-horizontal calender" role="form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="title2" name="title2">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary antosubmit2">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
        <div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>
        <!-- /calendar modal -->

        
        <!-- Google Analytics -->
        <script type="text/rocketscript">
            // (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','https://www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-23581568-13', 'auto'); ga('send', 'pageview');

        </script>

        <script>
            // jQuery(function($) {
            //     $('.table').footable({

            //     });
            // });

        </script>
        <script>
            // $(document).ready(function() {
            //     $('[data-toggle="popover"]').popover({
            //         html: true
            //     });
            // });

        </script>

        /* CALENDAR */
        <script>
        $(document).ready(function() {

    // page is now ready, initialize the calendar...

        $('#calendar').fullCalendar({
        // put your options and callbacks here
        })

        });
            // function init_calendar() {

            //     if (typeof($.fn.fullCalendar) === 'undefined') {
            //         return;
            //     }
            //     console.log('init_calendar');

            //     var date = new Date(),
            //         d = date.getDate(),
            //         m = date.getMonth(),
            //         y = date.getFullYear(),
            //         started,
            //         categoryClass;

            //     var calendar = $('#calendar').fullCalendar({
            //         header: {
            //             left: 'prev,next today',
            //             center: 'title',
            //             right: 'month,agendaWeek,agendaDay,listMonth'
            //         },
            //         selectable: true,
            //         selectHelper: true,
            //         select: function(start, end, allDay) {
            //             $('#fc_create').click();

            //             started = start;
            //             ended = end;

            //             $(".antosubmit").on("click", function() {
            //                 var title = $("#title").val();
            //                 if (end) {
            //                     ended = end;
            //                 }

            //                 categoryClass = $("#event_type").val();

            //                 if (title) {
            //                     calendar.fullCalendar('renderEvent', {
            //                             title: title,
            //                             start: started,
            //                             end: end,
            //                             allDay: allDay
            //                         },
            //                         true // make the event "stick"
            //                     );
            //                 }

            //                 $('#title').val('');

            //                 calendar.fullCalendar('unselect');

            //                 $('.antoclose').click();

            //                 return false;
            //             });
            //         },
            //         eventClick: function(calEvent, jsEvent, view) {
            //             $('#fc_edit').click();
            //             $('#title2').val(calEvent.title);

            //             categoryClass = $("#event_type").val();

            //             $(".antosubmit2").on("click", function() {
            //                 calEvent.title = $("#title2").val();

            //                 calendar.fullCalendar('updateEvent', calEvent);
            //                 $('.antoclose2').click();
            //             });

            //             calendar.fullCalendar('unselect');
            //         },
            //         editable: true,
            //         events: [{
            //             title: 'All Day Event',
            //             start: new Date(y, m, 1)
            //         }, {
            //             title: 'Long Event',
            //             start: new Date(y, m, d - 5),
            //             end: new Date(y, m, d - 2)
            //         }, {
            //             title: 'Meeting',
            //             start: new Date(y, m, d, 10, 30),
            //             allDay: false
            //         }, {
            //             title: 'Lunch',
            //             start: new Date(y, m, d + 14, 12, 0),
            //             end: new Date(y, m, d, 14, 0),
            //             allDay: false
            //         }, {
            //             title: 'Birthday Party',
            //             start: new Date(y, m, d + 1, 19, 0),
            //             end: new Date(y, m, d + 1, 22, 30),
            //             allDay: false
            //         }, {
            //             title: 'Click for Google',
            //             start: new Date(y, m, 28),
            //             end: new Date(y, m, 29),
            //             url: 'http://google.com/'
            //         }]
            //     });

            // };

        </script>
    </body>

    </html>
