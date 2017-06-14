<?php

  session_start();

  if(!isset($_SESSION['userId'])) 
  {
        header("Location: login.php");
  } 

  require 'databaseConnection.php';

  $dbConn = getConnection();
  $sql = "SELECT status, count(*) AS num FROM HouseInfo GROUP BY status";
  $stmt = $dbConn -> prepare($sql);
  $stmt->execute();
  $houseStatus = $stmt->fetchAll();

  $dbConnEarn = getConnection();
  $sqlEarn = "SELECT AVG(finalComm) as average, SUM(finalComm) AS earnings FROM commInfo";
  $stmtEarn = $dbConnEarn -> prepare($sqlEarn);
  $stmtEarn->execute();
  $sumEarnings = $stmtEarn->fetch();

  $dbConnRank = getConnection();
  $sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm 
              FROM UsersInfo Inner Join commInfo on UsersInfo.license = commInfo.license 
              group by UsersInfo.license order by sold Desc ";
  $stmtRank = $dbConnRank -> prepare($sqlRank);
  $stmtRank->execute();
  $rank = $stmtRank->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Re/Max Salinas | Dashboard</title>

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
                <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['username']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image in the menu -->
                <li class="user-header">
                  <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                  <p>
                    Alexander Pierce - Web Developer
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
          <img class="img-responsive" src="dist/img/remax-logo.png">
        </a>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
          <li class="header">OVERVIEW</li>
          <li class="active"><a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="header">PROPERTIES</li>
          <li><a href="inventory.php"><i class="fa fa-home"></i> <span>Current Inventory</span></a></li>
          <li><a href="coming-soon.html"><i class="fa fa-flag"></i> <span>Coming Soon</span></a></li>
          <li><a href="past-sales.php"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
          <li class="header">TRANSACTIONS</li>
          <li><a href="#"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
          <li><a href="#"><i class="fa fa-file-text"></i> <span>Monthly Report</span></a></li>
          <li class="header">AGENTS</li>
          <li><a href="roster.php"><i class="fa fa-users"></i> <span> Roster</span></a></li>
          <li class="header">STATISTICS</li>
          <li><a href="#"><i class="fa fa-home"></i> <span> Sales Breakdown</span></a></li>
          <li><a href="#"><i class="fa fa-archive"></i> <span>Monthly Report</span></a></li>
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
                <h3><sup style="font-size: 20px">$</sup><?php echo $sumEarnings['average']; ?></h3>
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
                <h3><sup style="font-size: 20px">$</sup> <?php echo $sumEarnings['earnings']; ?> </h3>
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
          <div class="col-lg-6 col-xs-12">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title"><i class=" fa fa-thumbs-up"></i> Top Performing Agents</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="rank-table-top" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Rank</th>
                      <th>Last</th>
                      <th>First</th>
                      <th><i class="fa fa-home"></i> Sold</th>
                      <th><i class="fa fa-home"></i> YTD Comm.</th>
                      <th><i class="fa fa-percent"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $limit = 0;
                    foreach ($rank as $agent)
                    {
                      if($limit > 4)
                        break;
                    
                      echo "<tr>";
                      echo "<td>#" . $limit . <"/td>";
                      echo "<td>" . $agent["lastName"] . "</td>"; 
                      echo "<td>" . $agent["firstName"] . "</td>"; 
                      echo "<td>" . $agent["sold"] . "</td>"; 
                      echo "<td>" . $agent["YTDComm"] . "</td>"; 
                      echo "<td>" . "NA" . "</td>"; 
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <div class="col-lg-6 col-xs-12">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-thumbs-down"></i> Poorest Performing Agents</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="rank-table-bottom" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Rank</th>
                      <th>Last</th>
                      <th>First</th>
                      <th><i class="fa fa-home"></i> Sold</th>
                      <th><i class="fa fa-money"> YTD Comm.</i></th>
                      <th><i class="fa fa-percent"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>#16</td>
                      <td>Walter</td>
                      <td>Emily</td>
                      <td>2</td>
                      <td>$19,323</td>
                      <td>1.4%</td>
                    </tr>
                    <tr>
                      <td>#15</td>
                      <td>Reals</td>
                      <td>Paul</td>
                      <td>4</td>
                      <td>$20,323</td>

                      <td>1.5%</td>
                    </tr>
                    <tr>
                      <td>#14</td>
                      <td>Musk</td>
                      <td>Charles
                      </td>
                      <td>4</td>
                      <td>$22,320</td>

                      <td>1.5%</td>
                    </tr>
                    <tr>
                      <td>#13</td>
                      <td>Holmes</td>
                      <td>Greg</td>
                      <td>5</td>
                      <td>$23,023</td>

                      <td>1.4%</td>
                    </tr>
                    <tr>
                      <td>#12</td>
                      <td>Lee</td>
                      <td>Miriam</td>
                      <td>5</td>
                      <td>$33,230</td>

                      <td>1.3%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- ./row -->
        <div class="row">
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">YTD Monthly Net Earnings</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="chart">
                  <canvas id="lineChart"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- BAR CHART -->
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Buyer's Listing vs. Seller's Listing</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChart"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col (RIGHT) -->
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
      Powered by <a href="#">Oversite</a>
    </div>
    <!-- Default to the left -->
    <strong>&copy; 2016 | <a href="#">Re/Max Salinas</a>.</strong> All rights reserved.
  </footer>

  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 2.2.3 -->
  <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="bootstrap/js/bootstrap.min.js"></script>

  <!-- Slimscroll -->
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/app.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
  <script>
    /*
     * DATATABLE CONTROLS
     * -----------------------
     */

    // Ranked 5 Agent Table Options (Top Performing Agents & Poorest Performing Agents)
    $(function() {
          $("#rank-table-top").DataTable({
              "paging": false,
              "lengthChange": false,
              "searching": false,
              "ordering": true,
              "order": [0, 'asc'],
              "columnDefs": [{
                  "orderable": false,
                  "targets": [1],
                },
                "info": false,
                "autoWidth": true,
                "columnDefs": [{
                  "width": "1%",
                  "targets": 0
                }]
              }); $('#rank-table-bottom').DataTable({
              "paging": false,
              "lengthChange": false,
              "searching": false,
              "ordering": true,
              "order": [0, 'desc'],
              "select": true,
              "info": false,
              "autoWidth": true,
              "columnDefs": [{
                "width": "1%",
                "targets": 0
              }]
            });
          });
  </script>
  <script>
    /*
     * CHART JS CONTROLS
     * -----------------------
     */

    // Line Chart - YTD Monthly Net Earnings
    var lineChartCanvas = document.getElementById("lineChart");

    var lineChartData = {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: '2017',
        data: [103940, 123023, 123023, 102934, 121234, 112039, 103942, 120393, 109234, 102384, 122402, 122012],
        backgroundColor: 'rgba(1, 195, 32, 0.72)'
      }, {
        label: '2016',
        data: [124343, 102934, 129482, 103824, 129271, 103982, 102934, 110232, 112902, 102412, 113304, 129023],
        backgroundColor: 'rgba(81, 89, 73, 0.4)'
      }]
    }

    var lineChartOptions = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: false,
            max: 150000,
            callback: function(value, index, values) {
              if (parseInt(value) >= 1000) {
                return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
              } else {
                return '$' + value;
              }
            }

          }
        }]
      }
    }

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    });
  </script>

  <script>
    var barChartCanvas = document.getElementById("barChart");
    var myChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Buyer\'s',
          data: [504923, 340242, 402492, 604923, 400232, 360234, 504934, 604394, 540942, 604343, 405923, 503239],
          backgroundColor: "rgba(220,220,220,0.5)",
        }, {
          label: 'Seller\'s',
          data: [604032, 402392, 503924, 590423, 429321, 498243, 552843, 623203, 502934, 598493, 450294, 559823],
          backgroundColor: "rgba(82,154,190,0.5)",
        }]
      },
      options: {
        tooltips: {
          mode: 'label',
          callbacks: {
            afterTitle: function() {
              window.total = 0;
            },
            label: function(tooltipItem, data) {
              var corporation = data.datasets[tooltipItem.datasetIndex].label;
              var valor = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
              window.total += valor;
              return corporation + ": $" + valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },
            footer: function() {
              return "Total: $" + window.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
          }
        },
        scales: {
          yAxes: [{
            beginAtZero: false,
            stacked: true,
            ticks: {
              beginAtZero: false,
              callback: function(value, index, values) {
                if (parseInt(value) >= 1000) {
                  return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                } else {
                  return '$' + value;
                }
              }
            },
          }],
          xAxes: [{
            stacked: true
          }],
        }
      }
    });
  </script>
</body>

</html>
