<?php
    require("../databaseConnection.php");  
    session_start();
    $dbConn = getConnection();
    if (!isset($_SESSION['userId'])) {
        header("Location: http://jjp17.org/login.php");
    }
?>



    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Home</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../plugins/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../dist/css/skins/skin-blue.css">
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

    <body class="hold-transition skin-blue sidebar-mini">
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

                        <li><a href="listings-openhouse.php"><i class="fa fa-home"></i> <span>Open House</span></a></li>
                        <li><a href="visitors.php"><i class="fa fa-male"></i> <span>My Visitors</span></a></li>
                        <li><a href="OverSite/signIn.php" target="_blank"><i class="fa fa-edit"></i> <span>Sign In Sheet</span></a></li>
                        <li><a href="#"><i class="fa fa-globe"></i> <span>Geofencing</span></a></li>

                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3>My Visitors</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Visitors</th>

                                                <th data-breakpoints="all">Phone Number</th>
                                                <th data-breakpoints="all">Email</th>


                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Approval Date">Address Visited </a></th>

                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Contact </a></th>
                                                <th data-breakpoints="all">Notes</th>

                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Notes</a></th>
                                                <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip" data-placement="top" title="Appraisal">Delete</a></th>
                                            </tr>
                                        </thead>

        <?php

            function getHouseAddress($houseId){
                $dbConn = getConnection();
                $sql = "SELECT * FROM HouseInfo WHERE houseId = :houseId";
                $namedParameters = array();
                $namedParameters[':houseId'] = $houseId;
                $stmt = $dbConn -> prepare($sql);
                $stmt->execute($namedParameters);
                //$stmt->execute();
                $results = $stmt->fetch();
                return $results['address'] . ", " . $results['city'] . ", " . $results['state'] . " " . $results['zip'];

            }
            $dbConn = getConnection();
            $sql = "SELECT * FROM BuyerInfo WHERE userId = :userId";
            $namedParameters = array();
            $namedParameters[':userId'] = $_SESSION['userId'];
            $stmt = $dbConn -> prepare($sql);
            $stmt->execute($namedParameters);
            //$stmt->execute();
            $results = $stmt->fetchAll();

            foreach($results as $result){
                echo "<tbody>";
                echo "<td>" . $result['firstName'] . " " . $result['lastName'] . "</td>";
                echo "<td>" . $result['phone'] . "</td>";
                echo "<td>" . htmlspecialchars($result['email']) . "</td>";
                echo "<td>" . htmlspecialchars($getHouseAddress($result['houseId'])) . "</td>";

                echo "<td>
                        <button>Call</button>
                        <button>Text</button>
                        <button>Forward Listing Flyer</button>
                    </td>
                    <td><button>View</button></td>
                    <td>
                        <button>Add</button>
                        <button>Edit</button>

                    </td>
                    <td>
                        <button class='fa fa-trash-o'>  </button>
                    </tbody>";
                }

        ?>
                                        <tbody>



                                            <td>Patty Hershang</td>
                                            <td>831-382-4833</td>
                                            <td>phershang@gmail.com</td>
                                            <!--                                       <td style="display: table-cell;">Looking for 3 bed 2 bath min</td>-->



                                            <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                            <td>
                                                <button>Call</button>
                                                <button>Text</button>
                                                <button>Forward Listing Flyer</button>
                                            </td>
                                            <td><button>View</button></td>
                                            <td>
                                                <button>Add</button>
                                                <button>Edit</button>

                                            </td>
                                            <td>
                                                <button class="fa fa-trash-o">  </button>



                                        </tbody>
                                        <tbody>



                                            <td>Peter Harris</td>
                                            <td>831-239-6289</td>
                                            <td>pharris23@gmail.com</td>
                                            <!--                                       <td style="display: table-cell;">Looking for 3 bed 2 bath min</td>-->



                                            <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                            <td>
                                                <button>Call</button>
                                                <button>Text</button>
                                                <button>Forward Listing Flyer</button>
                                            </td>
                                            <td> <button>View</button></td>
                                            <td>
                                                <button>Add</button>
                                                <button>Edit</button>

                                            </td>
                                            <td>
                                                <button class="fa fa-trash-o">  </button>



                                        </tbody>
                                        <tbody>



                                            <td>Tony Craver</td>
                                            <td>831-588-0444</td>
                                            <td>tcraver@yahoo.com</td>
                                            <!--                                       <td style="display: table-cell;">Looking for 3 bed 2 bath min</td>-->



                                            <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                            <td>
                                                <button>Call</button>
                                                <button>Text</button>
                                                <button>Forward Listing Flyer</button>
                                            </td>
                                            <td><button>View</button></td>
                                            <td>
                                                <button>Add</button>
                                                <button>Edit</button>

                                            </td>
                                            <td>
                                                <button class="fa fa-trash-o">  </button>



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
            <!-- Main content -->
            <section class="content">

            </section>



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
