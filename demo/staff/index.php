<?php
session_start();
// echo($_SESSION['userType']);
if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
}

if ($_SESSION['userType'] == "0") {
    header("Location: ../index.php");
}

if ($_SESSION['userType'] == "1") {
    header("Location: ../agent/index.php");
}

require '../databaseConnection.php';

$dbConn = getConnection();

$sqlGetAgents = "SELECT userId, firstName, lastName, mlsId FROM UsersInfo";

$agentStmt = $dbConn->prepare($sqlGetAgents);
$agentStmt->execute();
$agentResults = $agentStmt->fetchAll();
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | Staff Dashboard</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "templates-staff/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->

        <!-- PAGE-SPECIFIC CSS -->
        <link rel="stylesheet" href="../dist/css/vendor/footable.bootstrap.min.css">
        <link rel="stylesheet" href="../../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="../dist/css/vendor/fullcalendar.min.css">

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="../plugins/iCheck/all.css">
    </head>

    <body class="hold-transition skin-black sidebar-mini">

        <!-- Site Wrapper -->
        <div class="wrapper">

            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "templates-staff/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "templates-staff/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->

            <?php include "./fullcalendar/links.php" ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Staff Dashboard
                        <small>Week Overview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li>Overview</li>
                        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Staff Dashboard</a></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->


                    <div class="row">

                        <div class="col-xs-9">
                            <div class="box">

                                <div class="box-body">
                                    <div class="box-body no-padding" style="height:600px;">
                                        <!-- THE CALENDAR -->
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-3">

                            <div class="box">

                                
                                <div class="box-header">
                                    <h4>Agent Schedules</h4>
                                </div>
                                <div class="col-xs-12">
                                    <button style="margin-bottom: 10px" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal">Add New</button>
                                </div>
                                <div class="box-body">

                                    <div>
                                        <input type="checkbox" id="selectAll" name="selectAll" value="selectAll">
                                        <label for="selectAll">Select All</label>
                                        &nbsp
                                        <input type="checkbox" id="deselectAll" name="deselectAll" value="deselectAll">
                                        <label for="deselectAll">Deselect All</label>
                                    </div>

                                    <table class="table table-striped">

                                        <?php
                                        foreach ($agentResults as $agent) {
                                            echo "<tr>
                                            <td>";
                                            echo '<label><input id="checkboxFilter" type="checkbox" class="flat-red" value="' . $agent['userId'] . '" checked> ' . $agent['firstName'] . " " . $agent['lastName'] . '</label>';
                                            echo "</td>
                                            </tr>";
                                        }
                                        ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->
        
        <?php include "staffEventModal.php" ?>

        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "templates-staff/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "templates-staff/default-js.php" ?>
        <!-- END TEMPLATE default-js.php INCLUDE -->

        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/footable.min.js"></script>
        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/moment-with-locales.min.js"></script>
        <!--        <script src="../dist/js/vendor/fullcalendar/gcal.min.js"></script>-->
        <script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>





        <script>
            // jQuery(function($) {
            //     $('.table').footable({});
            // });

        </script>
        <script>
            $(document).ready(function () {
                $('[data-toggle="popover"]').popover({
                    html: true
                });
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

            function deleteMeeting() {
                var id = $('#id').text();
                $.post("deleteMeeting.php", {
                    id: id,
                });
                $('#calendar').fullCalendar('removeEvents', id.replace(" ", "T"));
                // alert(id);
                alert("meeting deleted");
            }
            function hideHouses()
            {
                $("#houseId > option").each(function() {
                                        $(this).show();
                });

                var agentSelectedId = $('#agentName').children(":selected").attr("id");
                $("#houseId > option").each(function() {
                    if($(this).attr("id") != agentSelectedId && $(this).attr("id") != "empty")
                    {
                        $(this).hide();
                    }
                });
            }

            function addNewTransaction()
            {
                var houseSelected = $('#houseId').children(":selected").attr("value");   
                var agentSelected = $('#agentName').children(":selected").attr("value"); 
                var accDate = $('#newAccDate').val();
                // alert(accDate);
                // alert(agentSelected);
                $.post("addTransactionStaff.php", {userId: agentSelected, houseId: houseSelected, accDate: accDate});
                alert("House In-Contract");
            }
            $(document).ready(function () {
                var currentEvents = "getTransactions.php?all=true";
                $('#calendar').fullCalendar({

                    eventSources: [{
                            url: currentEvents, // use the `url` property
                            color: 'yellow', // an option!
                            textColor: 'black' // an option!
                        }],
                    header: {
                        left: 'title',
                        center: 'month,agendaWeek,basicDay',
                        right: 'today prev,next'
                    },
                    firstDay: 6,
                    customButtons: {
                        myCustomButton: {
                            text: 'custom!',
                            click: function () {
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
                    defaultView: 'month',
                    duration: {
                        days: 7
                    },
                    selectable: true,
                    selectHelper: true,
                    eventLimit: false,
                    // firstHour: 12,
                    minTime: '07:00:00',
                    maxTime: '21:00:00',
                    slotDuration: '00:15:00',
                    height: "parent",
                    navLinks: true, // can click day/week names to navigate views
                    eventLimit: true, // allow "more" link when too many events

                    select: function (start, end) {
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
                    eventClick: function (event, element) {
                        var id = event.id.replace("T", " ");

                        var formData = {
                            id: id
                        };

                        $.ajax({
                            url: "getMeetingInfo.php",
                            type: "POST",
                            data: formData,
                            success: function (data, textStatus, jqXHR) {
                                var meetingInfo = JSON.parse(data);
                                $('#titleName').html(meetingInfo['firstName'] + " " + meetingInfo['lastName']);

                                $('#firstName').html(meetingInfo['firstName']);

                                $('#lastName').html(meetingInfo['lastName']);
                                $('#phone').html(meetingInfo['phone']);
                                $('#minBed').html(meetingInfo['bedroomsMin']);
                                $('#minBath').html(meetingInfo['bathroomsMin']);
                                $('#minPrice').html(meetingInfo['priceMin']);
                                $('#maxPrice').html(meetingInfo['priceMax']);
                                $('#purchaseWithin').html(meetingInfo['howSoon']);
                                $('#notes').html(meetingInfo['note']);
                                $('#id').html(meetingInfo['meeting']);
                                $('#textArea').append(meetingInfo['note']);

                                $('#meetingTime').html(meetingInfo['meetingFormat'].substring(10, 16));
                                $('#meetingDay').html(meetingInfo['meetingFormat'].substring(0, 10));

                            }
                        });
                        $("#modal-primary").modal();
                        // alert(event.id);

                    },

                    eventDrop: function (event, delta, revertFunc, jsEvent, ui, view) {

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
                                success: function (data, textStatus, jqXHR) {
                                    // alert("finished");
                                }
                            });

                        }

                    },
                    eventResize: function (event, delta, revertFunc, jsEvent, ui, view) {

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
                $("input[name=selectAll]").click(function ()
                {
                    if ($("input[name=selectAll]")[0].checked)
                    {
                        $('#deselectAll').prop('checked', false);
                        $.each($("[id=checkboxFilter]"), function ()
                        {
                            $(this).prop('checked', true);
                        });
                        refreshEvents();
                    }
                    // alert("Select All");
                });
                $("input[name=deselectAll]").click(function ()
                {
                    if ($("input[name=deselectAll]")[0].checked)
                    {
                        $('#selectAll').prop('checked', false);
                        $.each($("[id=checkboxFilter]"), function ()
                        {
                            $(this).prop('checked', false);
                        });
                        refreshEvents();
                    }
                    // alert("Deselect All");
                });

                $("input[id=checkboxFilter]").click(function ()
                {
                    var getFilteredEvents = "";
                    var filterCount = 0;
                    $.each($("[type=checkbox]:checked"), function ()
                    {
                        if ($(this).attr('name') == "selectAll" || $(this).attr('name') == "deselectAll")
                        {

                        } else
                        {
                            getFilteredEvents += "userId" + filterCount + "=" + $(this).val() + "&";
                            filterCount++;
                        }
                    });

                    $('#calendar').fullCalendar('removeEventSource', currentEvents);

                    var newEvents = "getTransactions.php?" + getFilteredEvents;
                    // alert(newEvents);
                    $('#calendar').fullCalendar('addEventSource', newEvents);
                    // $('#calendar').fullCalendar('refetchEvents');

                    currentEvents = newEvents;

                });

                function refreshEvents()
                {
                    var getFilteredEvents = "";
                    var filterCount = 0;
                    $.each($("[type=checkbox]:checked"), function ()
                    {
                        if ($(this).attr('name') == "selectAll" || $(this).attr('name') == "deselectAll")
                        {

                        } else
                        {
                            getFilteredEvents += "userId" + filterCount + "=" + $(this).val() + "&";
                            filterCount++;
                        }
                    });

                    $('#calendar').fullCalendar('removeEventSource', currentEvents);

                    var newEvents = "getTransactions.php?" + getFilteredEvents;
                    // alert(newEvents);
                    $('#calendar').fullCalendar('addEventSource', newEvents);
                    // $('#calendar').fullCalendar('refetchEvents');

                    currentEvents = newEvents;
                }

            });



            //iCheck for checkbox and radio inputs
            // $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            //     checkboxClass: 'icheckbox_minimal-blue',
            //     radioClass: 'iradio_minimal-blue'
            // })



        </script>
        <script src="../../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            
            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })
            $('#iconified').on('keyup', function () {
                var input = $(this);
                if (input.val().length === 0) {
                    input.addClass('empty');
                } else {
                    input.removeClass('empty');
                }
            });
        </script>

    </body>

</html>
