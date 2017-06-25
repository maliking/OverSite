<?php
  session_start();

  require 'databaseConnection.php';

  $dbConn = getConnection();
  $sql = "SELECT HouseInfo.address, HouseInfo.city, HouseInfo.zip, HouseInfo.bedrooms, HouseInfo.bathrooms, HouseInfo.price FROM HouseInfo
  INNER JOIN commInfo ON HouseInfo.houseId = commInfo.houseId";
  $stmt = $dbConn -> prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Re/Max Salinas | Past Sales</title>

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
  <link rel="stylesheet" href="plugins/datatables/datatables.min.css">

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
                          <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
          <li><a href="inventory.php"><i class="fa fa-home"></i> <span>Current Inventory</span></a></li>
          <li><a href="coming-soon.html"><i class="fa fa-flag"></i> <span>Coming Soon</span></a></li>
          <li class="past-sales"><a href="past-sales.php"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
          <li class="header">TRANSACTIONS</li>
          <li><a href="#"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
          <li><a href="#"><i class="fa fa-file-text"></i> <span>Monthly Report</span></a></li>
          <li class="header">STATISTICS</li>
          <li><a href="statistics.php"><i class="fa fa-line-chart"></i> <span> Analytics</span></a></li>
          <li><a href="#"><i class="fa fa-dollar"></i> <span> Sales Breakdown</span></a></li>
          <li><a href="#"><i class="fa fa-file-text-o"></i> <span>Monthly Report</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3>Past Sales</h3>
              </div>
              <div class="box-body">
                <table id="listing-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th colspan="9">
                        <div class="pull-right">
                          <div class="dropdown" style="display: inline-block">
                            <button class="btn dropdown-toggle btn-xs btn-warning" type="button" data-toggle="dropdown">Filter Price <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li style="display: flex">
                                <div id="min-box" style="display: flex-item; padding-left: 7px; padding-right: 7px; padding-top: 6px">
                                  <input type="text" placeholder="min" style="padding: 3px;" size="10">
                                </div>
                                <p style="padding-top: 10px">-</p>
                                <div id="max-box" style="display: flex-item; padding-right: 7px; padding-left: 7px; padding-top: 6px">
                                  <input type="text" placeholder="max" style="padding: 3px;" size="10">
                                </div>
                              </li>
                              <div class="divider"></div>
                              <li><a href="#">$50,000+</a></li>
                              <li><a href="#">$75,000+</a></li>
                              <li><a href="#">$100,000+</a></li>
                              <li><a href="#">$150,000+</a></li>
                              <li><a href="#">$200,000+</a></li>
                              <li><a href="#">$250,000+</a></li>
                              <li><a href="#">$300,000+</a></li>
                              <li><a href="#">$400,000+</a></li>
                              <li><a href="#">$500,000+</a></li>
                            </ul>

                          </div>


                          <div class="dropdown" style="display: inline-block;margin-right: 10px;">
                            <button class="btn dropdown-toggle btn-xs btn-success" type="button" data-toggle="dropdown">Filter Bedrooms <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="#">0+</a></li>
                              <li><a href="#">1+</a></li>
                              <li><a href="#">2+</a></li>
                              <li><a href="#">3+</a></li>
                              <li><a href="#">4+</a></li>
                              <li><a href="#">5+</a></li>
                            </ul>
                          </div>
                        </div>
                      </th>


                    </tr>
                    <tr>
                      <th>Address</th>
                      <th>City</th>
                      <th>Zip</th>
                      <th><i class="fa fa-bed"></i></th>
                      <th><i class="fa fa-bath"></i></th>
                      <th>Sqft</th>
                      <th>Lot</th>
                      <th>Price</th>
                      <th>DOM</th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php
                        foreach ($result as $house)
                        {
                            echo "<tr>";
                            echo "<td>" . $house['address'] . "</td>";
                            echo "<td>" . $house['city'] . "</td>";
                            echo "<td>" . $house['zip'] . "</td>";
                            echo "<td>" . $house['bedrooms'] . "</td>";
                            echo "<td>" . $house['bathrooms'] . "</td>";
                            echo "<td>" . "NA" . "</td>";
                            echo "<td>" . "NA" . "</td>";
                            echo "<td>" . '$' . number_format($house['price'], 0) . "</td>";
                            echo "<td>" . "NA" . "</td>";
                            echo "</tr>";
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
  </div>
  <!-- /.wrapper -->

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
  <!-- Datatables -->
  <script type="text/javascript" src="plugins/datatables/datatables.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>

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
</body>

</html>
