<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
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
        <title>RE/MAX Salinas | Calendar</title>

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
                color: black;
            }

        </style>
        <!-- NOTIFICATION Links-->
<!--        <link href="../plugins/pnotify/dist/pnotify.css" rel="stylesheet">-->
<!--        <link href="../plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">-->
<!--        <link href="../plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">-->

        <!-- daterange picker -->
        <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

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



            <?php include "./fullcalendar/links.php" ?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                   

                    <!--MODAL AREA!!-->


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

                                                            <td id="firstName">John</td>
                                                            <td id="lastName">
                                                                Doe
                                                            </td>
                                                            <tr>


                                                                <th>Min Bed</th>
                                                                <th>Min Bath</th>


                                                            </tr>
                                                            <tr>

                                                                <td id="minBed">2</td>
                                                                <td id="minBath">
                                                                    2
                                                                </td>
                                                                <tr>


                                                                    <th>Min Price</th>
                                                                    <th>Max Price</th>


                                                                </tr>
                                                                <tr>

                                                                    <td id="minPrice">$120,000</td>
                                                                    <td id="maxPrice">
                                                                        $910,000
                                                                    </td>

                                                                </tr>
                                                                <tr>

                                                                    <th>Looking to purchase home within:</th>
                                                                    <th>Pre-Approved?</th>

                                                                </tr>
                                                                <tr>

                                                                    <td id="purchaseWithin">3-6 months</td>
                                                                    <td>
                                                                        <form action="">
                                                                            <input type="radio" name="preapproved" value="yes"> Yes
                                                                            <br>
                                                                            <input type="radio" name="preapproved" value="no"> No
                                                                            <br>
                                                                        </form>

                                                                    </td>

                                                                </tr>
                                                                <tr>


                                                                    <th>Notes from open house</th>


                                                                </tr>
                                                                <tr>

                                                                    <td id="notes">

                                                                        Preferes large back yard for 2 dogs.
                                                                    </td>
                                                                    <p id="id" hidden></p>
                                                                    <!-- <td>
                                                                <small>
                            May 19, 2017 12:43pm
                        </small>
                                                            </td> -->

                                                                    <!-- <tr>
                                                                <td>
                                                                    Must have garage
                                                                </td>
                                                                <td>
                                                                    <small>
                            May 19, 2017 1:09pm
                        </small>
                                                                </td>

                                                            </tr> -->


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
                                                <textarea id="textArea" style="color:black;" rows="6" cols="60"></textarea>

                                            </div>


                                        </div>


                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close
                                </button>
                                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Delete
                                    Appointment
                                </button>
                                <button type="button" class="btn btn-outline" onClick="saveMeeting()">Save changes
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->

                    <!-- /.modal -->
                    <div class="container">

                        <!--MODAL AREA-->

                    </div>

                    <!--                    END example modal-->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-body">
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
<!--        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.js"></script>-->
<!--        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.buttons.js"></script>-->

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
                $('.table').footable({});
            });

        </script>
        <script>
            function saveMeeting() {
                var id = $('#id').text();
                var newNote = $('#textArea').val();
                $.post("saveNoteCalendar.php", {
                    id: id,
                    note: newNote
                });
                $('#notes').html(newNote);
                // $('#modal-primary').modal('toggle');
                // alert();
            }

            $(document).ready(function() {
                $('#calendar').fullCalendar({

                    eventSources: [{
                        url: 'getMeetings.php', // use the `url` property
                        color: 'yellow', // an option!
                        textColor: 'black' // an option!
                    }],
                    header: {
                        left: 'title',
                        center: 'month,agendaWeek,agendaDay,basicWeek',
                        right: 'today prev,next'
                    },
                    firstDay: 6,

                    customButtons: {
                        myCustomButton: {
                            text: 'custom!',
                            click: function() {
                                alert('clicked the custom button!');
                            }
                        }
                    },
                    // businessHours: {
                    //     // days of week. an array of zero-based day of week integers (0=Sunday)
                    //     // dow: [ 1, 2, 3, 4 ], // Monday - Thursday

                    //     start: '07:30', // a start time (10am in this example)
                    //     end: '21:00', // an end time (6pm in this example)
                    // },
                    editable: true,
                    defaultView: 'agendaWeek',
                    duration: {
                        days: 7
                    },
                    selectable: true,
                    selectHelper: true,
                    eventLimit: true,
                    // firstHour: 12,
                    minTime: '07:00:00',
                    maxTime: '21:00:00',
                    slotDuration: '00:15:00',
                    height: "parent",
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
                        var id = event.id.replace("T", " ");

                        var formData = {
                            id: id
                        };

                        $.ajax({
                            url: "getMeetingInfo.php",
                            type: "POST",
                            data: formData,
                            success: function(data, textStatus, jqXHR) {
                                var meetingInfo = JSON.parse(data);
                                $('#firstName').html(meetingInfo['firstName']);

                                $('#lastName').html(meetingInfo['lastName']);
                                $('#minBed').html(meetingInfo['bedroomsMin']);
                                $('#minBath').html(meetingInfo['bathroomsMin']);
                                $('#minPrice').html(meetingInfo['priceMin']);
                                $('#maxPrice').html(meetingInfo['priceMax']);
                                $('#purchaseWithin').html(meetingInfo['howSoon']);
                                $('#notes').html(meetingInfo['note']);
                                $('#id').html(meetingInfo['meeting']);
                                $('#textArea').append(meetingInfo['note']);

                            }
                        });
                        $("#modal-primary").modal();

                    },

                    eventDrop: function(event, delta, revertFunc, jsEvent, ui, view) {

                        // alert(event.title + " end is now " + event.start.format().replace("T", " ") + " " + event.id.replace("T", " "));

                        var id = event.id.replace("T", " ");
                        var startTime = event.start.format().replace("T", " ");
                        var endTime = event.end.format().replace("T", " ");

                        if (!confirm("is this okay?")) {
                            revertFunc();
                        } else {
                            event.id = startTime;
                            var formData = {
                                id: id,
                                start: startTime,
                                end: endTime
                            };
                            $.ajax({
                                url: "updateMeeting.php",
                                type: "POST",
                                data: formData,
                                success: function(data, textStatus, jqXHR) {
                                    // alert("finished");
                                }
                            });

                        }

                    },
                    eventResize: function(event, delta, revertFunc, jsEvent, ui, view) {

                        // alert("ive been resized!!!");
                        var id = event.id.replace("T", " ");
                        var startTime = event.start.format().replace("T", " ");
                        var endTime = event.end.format().replace("T", " ");

                        if (!confirm("is this okay?")) {
                            revertFunc();
                        } else {
                            $.post("updateMeeting.php", {
                                id: id,
                                start: startTime,
                                end: endTime
                            });
                            // alert("finished");
                        }
                    }


                });

            });


            // window.setInterval(function() { // Set interval for checking
            //     var date = new Date(); // Create a Date object to find out what time it is
            //     if (date.getHours() === 18 && date.getMinutes() === 49) { // Check the time
            //
            //         new PNotify({
            //             title: 'Contact Client',
            //             text: 'Must send email to John by 5:15pm.',
            //             styling: 'fontawesome'
            //
            //         });
            //     }
            // }, 60000); // Repeat every 60000 milliseconds (1 minute)

        </script>


    </body>

    </html>
