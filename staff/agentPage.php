<?php
session_start();
 echo($_SESSION['userType']);
if (!isset($_SESSION['userId']) ) {
    header("Location: login.php");
}

if($_SESSION['userType'] == "0"){
    header("Location: ../index.php");
}

if($_SESSION['userType'] == "1"){
    header("Location: ../agent/index.php");
}
require '../databaseConnection.php';

$dbConn = getConnection();




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Re/Max Salinas</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "templates-staff/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="../dist/css/vendor/footable.bootstrap.min.css">
           <!-- PAGE-SPECIFIC CSS -->
            <link rel="stylesheet" href="../dist/css/vendor/fullcalendar.min.css">
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
                John Doe
                <small><strong>(831)-123-4567  |  jdoe@gmail.com</strong></small> 
                &nbsp;<?php include "textAgent.php" ?>
            </h1>
            <ol class="breadcrumb">
                <li>Overview</li>
                <li class="active"><a href="#"><i class="fa fa-male"></i> Agent</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h4>Active/Active Contingent Properties</h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                              
                                    <th>Property</th>
                                  
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Approval Date">Aprv. </a></th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Earnest Money Deposit">EMD </a>
                                    </th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Disclosures">Disc. </a>
                                    </th>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Inspection">Insp. </a>
                                    </th>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Appraisal">Appr. </a>
                                    </th>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Loan Contingencies">LC </a></th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Close of Escrow">COE </a></th>
                                    <th data-breakpoints="xs sm">Edit Dates</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                              
                                    <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                  

                                    <td>3/1/17
                                       
                                       
                                    </td>
                                    <td>3/1/17
                                        
                                    </td>
                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"></a>
                                       
                                    </td>

                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"></a>
                                        
                                    </td>

                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"></a>
                                        <br>
                                       

                                    <td>3/1/17
                                        
                                    </td>
                                    <td>3/1/17
                                       
                                    </td>
                                    <td><?php include "editDates.php"?></td>
                                </tr>
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
            <div class="row">
                <div class="col-xs-12">
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
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->

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
    jQuery(function ($) {
        $('.table').footable({
                "paging": {
                        "enabled": true,
                        "size": 4,
                        "position": "right"
                    }
            
        });
    });
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

            function deleteMeeting()
            {
                var id = $('#id').text();
                $.post("deleteMeeting.php", {
                    id: id,
                });
                $('#calendar').fullCalendar('removeEvents', id.replace(" ", "T" ));
                // alert(id);
                alert("meeting deleted");
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
                        center: 'month,agendaWeek,basicDay',
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

                       
                        $("#modal-primary").modal();
                        // alert(event.id);

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

 
        </script>

</body>

</html>
