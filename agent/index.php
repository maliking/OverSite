<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp2017.org/login.php");
//}
require '../databaseConnection.php';
$dbConn = getConnection();

$sqlLicense = "SELECT license FROM UsersInfo WHERE userId = :userId";

$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];


$licenseStmt = $dbConn->prepare($sqlLicense);
$licenseStmt->execute($namedParameters);
$licenseResult = $licenseStmt->fetch();


$sql = "SELECT firstName, lastName, count(*) as sold, AVG(finalComm) as average, SUM(finalComm) AS earnings, AVG(percentage) AS avgPercent FROM commInfo WHERE license = :license GROUP BY license ";
$parameters = array();
$parameters[':license'] = $licenseResult['license'];

$stmt = $dbConn->prepare($sql);
$stmt->execute($parameters);
$result = $stmt->fetch();

// $sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm FROM UsersInfo LEFT JOIN commInfo on UsersInfo.license = commInfo.license group by UsersInfo.license order by sold Desc ";
// $stmtRank = $dbConnRank->prepare($sqlRank);
// $stmtRank->execute();
// $rank = $stmtRank->fetchAll();
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Dashboard</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <style>
            .modal-title {
                font-size: 150%;
                font-weight: bold;
            }
            #modal-table {
              color:black; 
            }

        </style>

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

            <!-- PAGE-SPECIFIC CSS -->
            <link rel="stylesheet" href="../dist/css/vendor/fullcalendar.min.css">


            <!--FULL CALENDAR links-->

            <?php include "./fullcalendar/links.php" ?>



            <!-- NOTIFICATION Links-->
            <link href="../plugins/pnotify/dist/pnotify.css" rel="stylesheet">
            <link href="../plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
            <link href="../plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
            
<!-- daterange picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


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
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>
                                        <?php echo number_format($result['avgPercent'],2);?><sup style="font-size: 20px">%</sup></h3>

                                    <p>Avg. Commission </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">5%</span> than last year</a>

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
                                    <h3>
                                        <?php echo $result['sold'];?>
                                    </h3>
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
                                    <h3><sup style="font-size: 20px">$</sup>
                                        <?php echo number_format($result['average'],2);?>
                                    </h3>
                                    <p>Avg. Commission</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-money"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-down "></i> <span class="text-red">3%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>
                                        <?php echo number_format($result['avgPercent'],2);?><sup style="font-size: 20px">%</sup></h3>

                                    <p>Avg. Commission </p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-percent"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-down "></i> <span class="text-red">1%</span> than last year</a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-2 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup>
                                        <?php echo number_format($result['earnings'],2);?>
                                    </h3>
                                    <p>Total Gross Earnings</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-bank"></i>
                                </div>
                                <a href="#" class="small-box-footer"><i class="fa fa-chevron-up "></i> <span class="text-lime">11%</span> than last year</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <!--                    Example modal below for how pop ups should look on calendar-->
                    <div class="row">

                        <!--MODAL AREA!!-->
                        <div class="box-body">




                            <div class="modal modal-primary fade" id="modal-primary">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">John Doe</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <i>Scheduled to contact: </i>
                                                        <b>9:15am</b> <i>September 23, 2017</i>
                                                    </div>
                                                </div>
                                                <div class="row">


                                                    <!--                                        Start Box-->
                                                    <div class="box">

                                                        <div class="box-body no-padding">
                                                            <table id="modal-table" class="table table-striped">
                                                                <tr>


                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>


                                                                </tr>
                                                                <tr>

                                                                    <td>John</td>
                                                                    <td>
                                                                        Doe
                                                                    </td>
                                                                    <tr>


                                                                        <th>Min Bed</th>
                                                                        <th>Min Bath</th>


                                                                    </tr>
                                                                    <tr>

                                                                        <td>2</td>
                                                                        <td>
                                                                            2
                                                                        </td>
                                                                        <tr>


                                                                            <th>Min Price</th>
                                                                            <th>Max Price</th>


                                                                        </tr>
                                                                        <tr>

                                                                            <td>$120,000</td>
                                                                            <td>
                                                                                $910,000
                                                                            </td>

                                                                        </tr>
                                                                        <tr>

                                                                            <th>Looking to purchase home within:</th>
                                                                            <th>Pre-Approved?</th>

                                                                        </tr>
                                                                        <tr>

                                                                            <td>3-6 months</td>
                                                                            <td>
                                                                                <form action="">
                                                                                    <input type="radio" name="preapproved" value="yes"> Yes<br>
                                                                                    <input type="radio" name="preapproved" value="no"> No<br>
                                                                                </form>

                                                                            </td>

                                                                        </tr>
                                                                        <tr>


                                                                            <th>Notes from open house</th>



                                                                        </tr>
                                                                        <tr>

                                                                            <td>

                                                                                Preferes large back yard for 2 dogs.
                                                                            </td>
                                                                            <td>
                                                                                <small>
                                            May 19, 2017 12:43pm
                                        </small>
                                                                            </td>

                                                                            <tr>
                                                                                <td>
                                                                                    Must have garage
                                                                                </td>
                                                                                <td>
                                                                                    <small>
                                            May 19, 2017 1:09pm
                                        </small>
                                                                                </td>

                                                                            </tr>


                                                                        </tr>
                                                            <tr></tr>
                                                                        <tr>

                                                                            <th>Schedule next call appointment:</th>
                                                                            <th>
                                                                                <p>Schedule in person appointment:</th>

                                                                        </tr>
                                                                        <tr>

                                                                            <td>
                                                                                <i class="fa fa-calendar"></i>
                                                                                <input type="text" class="form-control pull-right" id="datepicker">
                                                                            </td>
                                                                            <td>
                                                                                <i class="fa fa-calendar"></i>
                                                                                <input type="text" class="fa fa-calendar form-control pull-right" id="datepicker">
                                                                            </td>

                                                                        </tr>

                                                            </table>
                                                        </div>
                                                        <!-- /.box-body -->
                                                    </div>
                                                    <!-- /.box -->


                                                    <div class="col-md-12">
                                                        <p>Additional Notes:</p>
                                                        <textarea style="color:black;" rows="6" cols="75">

                                                            </textarea>

                                                    </div>


                                                </div>



                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Delete Appointment</button>
                                        <button type="button" class="btn btn-outline">Save changes</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <div class="container">



                            <!--MODAL AREA-->

                        </div>
                        <!--                    END example modal-->
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-md-12">
                                <div class="box box-primary">
                                    <div class="box-body no-padding">
                                        <!-- THE CALENDAR -->
                                        <div id="calendar"></div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /. box -->
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


        <script type="text/javascript" src="../dist/js/vendor/footable.min.js"></script>

        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/moment-with-locales.min.js"></script>
        <script src="../dist/js/vendor/fullcalendar/gcal.min.js"></script>
        <script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.buttons.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.nonblock.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>

        <!-- date-range-picker -->
        <script src="../plugins/moment/min/moment.min.js"></script>
        <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })
            jQuery(function($) {
                $('.table').footable({

                });
            });

        </script>
        <script>
        

            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    
                    events: {
                       
                        color: 'yellow', // an option!
                        textColor: 'black' // an option!

                    },
                   
                    events: [{
                            title: 'Event1',
                            start: '2017-09-26T12:00:00',
                            end: '2017-09-26T12:30:00'
                        },
                        {
                            title: 'Event2',
                            start: '2017-09-24'
                        }
                    ],

                    editable: true,
                    defaultView: 'agenda',
                    duration: {
                        days: 7
                    },
                    selectable: true,
                    selectHelper: true,
                    eventLimit: true,
                    
                    navLinks: true, // can click day/week names to navigate views
                    eventLimit: true, // allow "more" link when too many events

                    select: function(start, end) {
                        var title = prompt('Event Title:');
                        var eventData;
                        if (title) {
                            eventData = {
                                title: title,
                                start: start,
                                end: end
                            };



                            $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
                        }
                        $('#calendar').fullCalendar('unselect');
                    },
                    eventClick: function(event, element) {

                        $("#modal-primary").modal();



                    }


                  
                });

            });

   
            window.setInterval(function() { // Set interval for checking
                var date = new Date(); // Create a Date object to find out what time it is
                if (date.getHours() === 18 && date.getMinutes() === 49) { // Check the time

                    new PNotify({
                        title: 'Contact Client',
                        text: 'Must send email to John by 5:15pm.',
                        styling: 'fontawesome'

                    });
                }
            }, 60000); // Repeat every 60000 milliseconds (1 minute)

        </script>


    </body>

    </html>
