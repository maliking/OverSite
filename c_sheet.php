<?php
session_start();
require("databaseConnection.php");  
$dbConn = getConnection();
if(!isset($_SESSION['userId'])) 
{
    header("Location: index.html?error=wrong username or password");
} 

$sql = "SELECT * FROM UsersInfo ";
$stmt = $dbConn -> prepare($sql);
$stmt->execute();
//$stmt->execute();
$sqlHouse = "SELECT * FROM HouseInfo ORDER BY address";
$stmtHouse = $dbConn -> prepare($sqlHouse);
$stmtHouse->execute();
$results = $stmt->fetchAll();
$houses = $stmtHouse->fetchAll();

?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Inventory</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/skin-blue-light.css">
        <link rel="stylesheet" href="plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css">

        <!-- jQuery 2.2.3 -->
        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Moment -->
        <script src="plugins/moment/moment.min.js"></script>
        <!-- Bootstrap 3.3.6 [JS] -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Bootstrap DatePicker -->
        <script src="plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js"></script>

        <!-- Bootstrap 3.3.6 [CSS] -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            label.col-xs-9 {
                text-align: right;
            }

        </style>

        <script src="commAlgoJS.js?t=1500963597208"></script>
        <script>
            $(function () {
                $('#today-date').datetimepicker({
                    defaultDate: new Date(),
                    format: "M/D/YYYY",
                });
                $('#settlement-date').datetimepicker({
                    format: "M/D/YYYY"

                });
            });

            function getLicense()
            {

                var x = document.getElementById("agentName").value;
                document.getElementById("agent").value = x;

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() 
                {
                    if (this.readyState == 4 && this.status == 200) 
                    {
                        var data = JSON.parse(this.responseText);
                        // alert(data.TYGross);
                        document.getElementById("beg-comm").value = data.TYGross;
                    }
                };
                xhttp.open("GET", "agentCommission.php?license=" + x, true);
                xhttp.send(); 
            }

            function getOwners()
            {

            }
        </script>
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
                                            <div class="col-xs-3 text-center">
                                                <a href="#">Followers</a>
                                            </div>
                                            <div class="col-xs-3 text-center">
                                                <a href="#">Sales</a>
                                            </div>
                                            <div class="col-xs-3 text-center">
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
                                            <a href="#" class="btn btn-default btn-flat">Sign out</a>
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
                        <li class="active"><a href="inventory.php"><i class="fa fa-home"></i> <span>Current Inventory</span></a></li>
                        <li><a href="coming-soon.php"><i class="fa fa-flag"></i> <span>Coming Soon</span></a></li>
                        <li class="past-sales"><a href="past-sales.php"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
                        <li class="header">TRANSACTIONS</li>
                        <li><a href="sales-breakdown.php"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
                        <li><a href="monthly-report.php"><i class="fa fa-file-text-o"></i> <span>Monthly Report</span></a></li>
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


                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4>Commission Sheet Breakdown</h4>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <form action="sendCommissionSheet.php" method="post">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Transaction Details</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group col-xs-4">
                                                                        <label class="control-label " for="email">Date</label>
                                                                        <input type="text" data-provide="datepicker" class="form-control" id="today-date" name = "today-date" placeholder="Enter today's date">
                                                                    </div>
                                                                    <div class="form-group col-xs-4">
                                                                        <label class="control-label  " for="pwd">Beginning Gross Commission</label>
                                                                        <input type="text" class="form-control" id="beg-comm" name="TYGross" placeholder="" readonly>
                                                                    </div>
                                                                    <div class="form-group col-xs-4">
                                                                        <label class="control-label  " for="datetimepicker4">Check Number</label>
                                                                        <input type="text" class="form-control" id="check" name="checkNum" placeholder="">
                                                                    </div>

                                                                    <div class="form-group col-xs-4">
                                                                        <label class="control-label  " for="email">Settlement Date</label>
                                                                        <input type="text" data-provide="datepicker" class="form-control" id="settlement-date" name="settlementDate" placeholder="Click to set date">
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <!-- <div class="form-group col-xs-3">
                                                                        <label class="control-label" for="pwd">Agent Name</label>
                                                                        <input type="text" class="form-control" id="agent" placeholder="">
                                                                    </div> -->

                                                                    <div class="form-group col-xs-3">
                                                                        <label class="control-label" for="pwd">Agent Name</label>
                                                                        <select id="agentName" onchange="getLicense()" name="agentName">
                                                                        <?php
                                                                            $license = "";
                                                                            foreach($results as $result)
                                                                            {
                                                                                echo "<option value='". $result['license']."'>". $result['firstName'] . " " . $result['lastName'] . "</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                    </div>

                                                                    <div class="form-group col-xs-3">
                                                                        <label class="control-label" for="pwd">Agent License</label>
                                                                        <input type="text" class="form-control" id="agent" placeholder="" name="license" value="" readonly>
                                                                    </div>
                                                                   <!--  <div class="form-group col-xs-6">
                                                                        <label class="control-label " for="pwd">Property Address</label>
                                                                        <input type="text" onFocus="geolocate()" class="form-control" id="address" placeholder="">
                                                                    </div> -->

                                                                     <div class="form-group col-xs-6">
                                                                        <label class="control-label " for="pwd">Property Address</label>
                                                                        <select id="houseId" onchange="getOwners()" name="propertyAddress">
                                                                        <?php
                                                                           
                                                                            foreach($houses as $house)
                                                                            {
                                                                                echo "<option value='". $house['houseId']."'>". $house['address'] . " " . $house['city'] . " " . $house['state'] . " " . $house['zip'] . "</option>";
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                    </div>

                                                                    <div class="form-group col-xs-3">
                                                                        <label class="control-label" for="pwd">Client Name(s)</label>
                                                                        <input type="text" class="form-control" id="client" placeholder="">
                                                                    </div>
                                                                    
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="panel panel-success">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title"><strong>Earnings & Deductions</strong></h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label " for="pwd">*Gross Commission</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="gross-comm" placeholder="" name="InitialGross" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">Broker Fee</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="broker" name="brokerFee" placeholder="" readonly>
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">Percentage</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="percentage" name="percentage" placeholder="" readonly>
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">Subtotal</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="subtotal" placeholder="" readonly>
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">Transaction Coordinator</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="trans-coor" placeholder="" value="200.00" readonly>
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">TC. Tech Fee</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="tech" placeholder="" value="50.00" readonly>
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">E&O Insurance</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="eo_insurance" placeholder="" value="99.00" readonly>
                                                                        </div>


                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">Re/Max Fee</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="remax" placeholder="">
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">*Misc.</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="misc" name="miscell" placeholder="" onchange="calculateCommission(this.value)">
                                                                        </div>

                                                                    </div>
                                                                    <div class="clearfix"></div>

                                                                    <div class="form-group col-xs-12">
                                                                        <label class="col-xs-9 control-label" for="pwd">Agent Net Commission</label>
                                                                        <div class="col-xs-3">
                                                                            <input type="text" class="form-control" id="agent_net" name="netCommission" placeholder="" readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-xs-11 col-xs-offset-11">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <!-- /.box -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                </section>
            </div>

            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->



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


        <!-- Slimscroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>

        <script>
                                                                            var placeSearch, autocomplete;

                                                                            var options = {
                                                                                componentRestrictions: {country: 'usa'},

                                                                            };

                                                                            function initAutocomplete() {
                                                                                // Create the autocomplete object, restricting the search to geographical
                                                                                // location types.
                                                                                autocomplete = new google.maps.places.Autocomplete(
                                                                                        /** @type {!HTMLInputElement} */(document.getElementById('address')),
                                                                                        {types: ['geocode'], options});

                                                                                // When the user selects an address from the dropdown, populate the address
                                                                                // fields in the form.
                                                                                autocomplete.addListener('place_changed', fillInAddress);
                                                                            }


                                                                            // Bias the autocomplete object to the user's geographical location,
                                                                            // as supplied by the browser's 'navigator.geolocation' object.
                                                                            function geolocate() {
                                                                                if (navigator.geolocation) {
                                                                                    navigator.geolocation.getCurrentPosition(function (position) {
                                                                                        var geolocation = {
                                                                                            lat: position.coords.latitude,
                                                                                            lng: position.coords.longitude
                                                                                        };
                                                                                        var circle = new google.maps.Circle({
                                                                                            center: geolocation,
                                                                                            radius: position.coords.accuracy
                                                                                        });
                                                                                        autocomplete.setBounds(circle.getBounds());
                                                                                    });
                                                                                }
                                                                            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK_Tffqf_2RClIjnuOPoz6wk1lZy4dAeg&libraries=places&callback=initAutocomplete"
        async defer></script>
    </body>

</html>
