<?php
session_start();
clearstatcache();
date_default_timezone_set('America/Los_Angeles');
if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

$url = 'https://api.idxbroker.com/clients/featured';

$method = 'GET';

// headers (required and optional)
$headers = array(
    'Content-Type: application/x-www-form-urlencoded', // required
    'accesskey: e1Br0B5DcgaZ3@JXI9qib5', // required - replace with your own
    'outputtype: json' // optional - overrides the preferences in our API control page
);

// set up cURL
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

// exec the cURL request and returned information. Store the returned HTTP code in $code for later reference
$response = curl_exec($handle);
$code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

if ($code >= 200 || $code < 300) {
    $response = json_decode($response, true);
} else {
    $error = $code;
}

// print_r($response);

$keys = array_keys($response);

$houseHistorySql = "SELECT * FROM commInfo WHERE license = :license";
$historyParam = array();
$historyParam[':license'] = $_SESSION['license'];

$historyStmt = $dbConn->prepare($houseHistorySql);
$historyStmt->execute($historyParam);
$historyResults = $historyStmt->fetchAll();



?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | Dashboard</title>

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
            
            .btn-group {
                display: inline-block!important
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


            <?php include "./fullcalendar/links.php" ?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                  



                    <!-- /.modal -->
                    <div class="container">
                        <!--MODAL AREA-->
                    </div>


                    <!-- END example modal-->
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-12">
                            
                            <div class="box box-success">
                                <div class="box-header">
                                    <h4>House History</h4>
                                </div>
                                <div class="box-body">
                                    <table class="table footable table-bordered table-striped"  >
                                        <thead>
                                        <tr>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip<th</>
                                            <th data-breakpoints="xs sm">Final House Price</th>
                                            <th data-breakpoints="xs sm">Commission</th>
                                            <th data-breakpoints="xs sm">Settlement Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            foreach ($historyResults as $history) 
                                            {
                                                echo "<tr>";
                                                echo "<td>" . $history['address'] . "</td>"; 
                                                echo "<td>" . $history['city'] . "</td>"; 
                                                echo "<td>" . $history['state'] . "</td>"; 
                                                echo "<td>" . $history['zip'] . "</td>"; 
                                                echo "<td>$" . number_format($history['finalHousePrice']) . "</td>"; 
                                                echo "<td>$" . number_format($history['finalComm']) . "</td>"; 
                                                echo "<td>" . date("m-d-Y", strtotime($history['settlementDate'])) . "</td>"; 
                                                echo "</tr>";
                                            }
                                     
                                    
                                            ?>

                                        </tbody>
                                    </table>
                                </div> <!-- /.box-body -->
                            </div> <!-- /.box -->

                           

                           
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
        <script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.buttons.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.nonblock.js"></script>

        <!-- Custom Theme Scripts -->

        <!-- date-range-picker -->
        <script src="../plugins/moment/moment.min.js"></script>
        <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
        
            //Date picker
            $('#datepicker').datepicker();
           
            jQuery(function($){
                $('.footable').footable({
                    "paging": {
                        "enabled": true,
                        "size": 4,
                        "position": "right"
                    }

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
                alert("Note Saved");
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
                        center: 'month,agendaWeek,agendaDay',
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
                                $('#textArea').val(meetingInfo['note']);

                                $('#meetingTime').html(meetingInfo['meetingFormat'].substring(10,16));
                                $('#meetingDay').html(meetingInfo['meetingFormat'].substring(0,10));

                            }
                        });
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
        
        function takeTransNote(transId)
        {
            var prevNote = $("#" + transId).html();
            var noteEntered = prompt("Enter Note:", prevNote);
            if (noteEntered == null || noteEntered == "") {
            } else {
                $("#" + transId).html(noteEntered);
                // alert(houseId + " " + buyerID);
                $.post("saveTransNote.php", {
                    transId: transId,
                    note: noteEntered
                });
                
            }

        }

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

            
            function saveNameMisc(transId,type,name)
            {
                // alert(name.value);
                $.post( "../staff/saveMiscName.php", { transId: transId, type:type, name:name.value });
            }

            function saveOrdDate(transId,type,date)
            {
                var sendDate = date.value;
                if(sendDate == "")
                {
                    sendDate = "NULL";
                    $('#' + type + 'Ord' + transId).html("Ordered: N/A");
                }
                else
                    $('#' + type + 'Ord' + transId).html("Ordered: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                $.post( "../staff/saveOrdDates.php", { transId: transId, type:type, date:sendDate });
            }
            function saveCompDate(transId,type,date)
            {

                
                var sendDate = date.value;
                if( type == "recieved")
                {
                    if(sendDate == "")
                    {
                        sendDate = "NULL";
                        $('#' + type + 'Comp' + transId).html("Date Recieved: N/A");
                        $("#status" + transId+type).attr('class', '');
                        $("#status" + transId+type).css('color', "");
                    }
                    else
                    {
                        $('#' + type + 'Comp' + transId).html("Date Recieved: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                        $("#status" + transId+type).attr('class', 'fa fa-check-circle');
                        $("#status" + transId+type).css('color', "#5cb85c");
                    }
                }
                else if( type == "signed")
                {
                    if(sendDate == "")
                    {
                        sendDate = "NULL";
                        $('#' + type + 'Comp' + transId).html("Signed: N/A");
                        $("#status" + transId+type).attr('class', '');
                        $("#status" + transId+type).css('color', "");
                    }
                    else
                    {
                        $('#' + type + 'Comp' + transId).html("Signed: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                        $("#status" + transId+type).attr('class', 'fa fa-check-circle');
                        $("#status" + transId+type).css('color', "#5cb85c");
                    }
                }
                else
                {
                    if(sendDate == "")
                    {
                        sendDate = "NULL";
                        $('#' + type + 'Comp' + transId).html("Completed: N/A");
                        $("#status" + transId+type).attr('class', '');
                        $("#status" + transId+type).css('color', "");
                    }
                    else
                    {
                        $('#' + type + 'Comp' + transId).html("Completed: " + sendDate.substring(5,7) + "/" + sendDate.substring(8,10) + "/" + sendDate.substring(0,4) );
                        $("#status" + transId+type).attr('class', 'fa fa-check-circle');
                        $("#status" + transId+type).css('color', "#5cb85c");
                    }
                }

                // updateStatus(transId, type date);
                $.post( "../staff/saveCompDates.php", { transId: transId, type:type, date:sendDate });

                

            }
             function saveDateCalendar(transId,type,date)
             {
          
                var aprvDay = $("#aprvDay"+transId).val();
                $("#aprvDay" + transId).val(date.value);
                updateStatus(transId,type,date);
                $.post( "../staff/saveNewDates.php", { transId: transId, type:type, date:date.value, aprvDay: aprvDay });
                
            }
            
            function saveDaysNum(transId,type,date)
             {
           
                $.post( "../staff/saveNewDaysNum.php", { transId: transId, type:type, date:date.value });
                updateStatus(transId,date);
                  
            }

            function saveNewDates(transId)
            {

                $("#editDateModal"+transId).modal("toggle");
                

                alert( "Dates Saved" );
                location.reload();


            }

            function deleteInContract(inContractId)
            {
                // alert(inContractId);


                $.post( "../staff/deleteInContract.php", { inContractId: inContractId })
                  .done(function( data ) {
                    alert("In-contract Deleted");
                    $("#editDateModal"+inContractId).modal("toggle");

                    $('#inContract' + inContractId).remove();
                  });


                
            }

            function updateStatus(transId, type, date)
            {
                var aprvDay = $("#aprvDay"+transId).val();
                // alert(aprvDay);
                var newDate = moment(date.value).format("YYYY-MM-DD"); 
                var todayDate = moment().format("YYYY-MM-DD"); 
                var inThreeDays = moment(todayDate).add(3, 'days').format("YYYY-MM-DD");
               
                
                if(moment(newDate).isSameOrBefore(inThreeDays) && moment(newDate).isSameOrAfter(todayDate))
                {
                    $("#status" + transId + type).attr('class', 'fa fa-warning');
                    $("#status" + transId + type).css('color', "#ffae42");
                    // alert("caution");
                }
                else if(moment(newDate).isSameOrAfter(todayDate))
                {
                    
                    $("#status" + transId + type).attr('class', '');
                    // $("#status" + transId + type).css('color', "#5cb85c");
                    // alert("late");
                }
                else if(moment(newDate).isSameOrBefore(todayDate))
                {
                    $("#status" + transId + type).attr('class', 'fa fa-flag blink');
                    $("#status" + transId + type).css('color', "#d9534f");
                    // $("#status" + transId + type).attr('class', 'fa fa-check-circle');
                    // $("#status" + transId + type).css('color', "#5cb85c");
                    // alert("onTime");
                }
            }
        </script>


    </body>

    </html>
