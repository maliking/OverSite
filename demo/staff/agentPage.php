<?php
session_start();
 // echo($_SESSION['userType']);

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

$agentSql = "SELECT * FROM UsersInfo WHERE userId = :userId";

$namedParameters = array();
$namedParameters[':userId'] = $_GET['userId'];


$agentStmt = $dbConn->prepare($agentSql);
$agentStmt->execute($namedParameters);
$agentResult = $agentStmt->fetch();

$transactionsSql = "SELECT * FROM transactions WHERE userId = :userId";

$transParameters = array();
$transParameters[':userId'] = $_GET['userId'];

$transStmt = $dbConn->prepare($transactionsSql);
$transStmt->execute($transParameters);
$transResults = $transStmt->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas</title>

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
                <p hidden id="hiddenUserId"><?php echo $_GET['userId']; ?></p>
                <p hidden id="hiddenPhone"><?php echo $agentResult['phone']; ?></p>
                <?php echo $agentResult['firstName'] . " " . $agentResult['lastName']; ?>
                <small><strong><?php echo $agentResult['phone'] . "  |  " . $agentResult['email']; ?></strong></small> 
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
                                                                    title="Approval Date">Acc. </a></th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Earnest Money Deposit">EMD </a>
                                    </th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="Disclosures">Disc. </a>
                                    </th>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="SignedDisc">Signed Disc. </a>

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
                                                                    
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                    data-placement="top" title="miscOne">Misc. 1 </a>

                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top" title="miscTwo">Misc. 2 </a>
                                    <th data-breakpoints="xs sm">Edit Dates</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                   

                                    <?php

                                    $count = 1;
                                    foreach($transResults as $trans)
                                    {
                                        $day = $trans['accDay'];
                                        echo "<tr id=inContract" . $trans['transId']  . " ><td>" . $trans['address'] . "</td>"; 
                                        echo "<td>" . date('m/d/y', strtotime($day)) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['emdDays'] . ' days')) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days')) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['signedDiscDays'] . ' days')) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['genInspecDays'] . ' days')) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['appraisalDays'] . ' days')) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['lcDays'] . ' days')) . "</td>";
                                        echo "<td>" . date('m/d/y', strtotime($day . ' + '. $trans['coeDays'] . ' days')) . "</td>";
                                        echo "<td>" . $trans['miscOneName'] . " " . date('m/d/y', strtotime($day . ' + '. $trans['miscOneDays'] . ' days')) . "</td>";
                                        echo "<td>" . $trans['miscTwoName'] . " " . date('m/d/y', strtotime($day . ' + '. $trans['miscTwoDays'] . ' days')) . "</td>";

                                        echo"<td>";
                                        ?>
                                        <?php include "editDates.php"; ?>
                                    <?php
                                    echo "</td></tr>";
                                    $count++;
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

            function saveNameMisc(transId,type,name)
            {
                // alert(name.value);
                $.post( "saveMiscName.php", { transId: transId, type:type, name:name.value });
            }

            function saveOrdDate(transId,type,date)
            {
                var sendDate = date.value;
                if(sendDate == "")
                {
                    sendDate = "NULL";
                }
                $.post( "saveOrdDates.php", { transId: transId, type:type, date:sendDate });
            }
            function saveCompDate(transId,type,date)
            {
                // alert("saveCompDate");
                // alert(type);
                // alert(date.value);
                // alert(transId);
                var sendDate = date.value;
                if(sendDate == "")
                {
                    sendDate = "NULL";
                }
                $.post( "saveCompDates.php", { transId: transId, type:type, date:sendDate });

                // alert(date);
            }
             function saveDateCalendar(transId,type,date)
             {
            //     // alert("saveDate");
            //     // alert(type);
            //     // alert(date.value);
            //     // alert(transId);
                var aprvDay = $("#aprvDay"+transId).val();
                $.post( "saveNewDates.php", { transId: transId, type:type, date:date.value, aprvDay: aprvDay });
                  
            }
            
            function saveDaysNum(transId,type,date)
             {
            //     // alert("saveDate");
                // alert(type);
                // alert(date.value);
                // alert(transId);
                // var aprvDay = $("#aprvDay"+transId).val();
                $.post( "saveNewDaysNum.php", { transId: transId, type:type, date:date.value });
                  
            }

            function saveNewDates(transId)
            {

                $("#editDateModal"+transId).modal("toggle");
                // alert("saving dates from: " + transId);

                // var aprvDay = $("#aprvDay"+transId).val();
                // var emdDay = $("#emdDay"+transId).val();
                // var sellDay = $("#sellDay"+transId).val();
                // var genDay = $("#genDay"+transId).val();
                // var apprvDay = $("#apprvDay"+transId).val();
                // var lcDay = $("#lcDay"+transId).val();
                // var coeDay = $("#coeDay"+transId).val();

                // alert(aprvDay);
                // alert(emdDay);
                // alert(sellDay);
                // alert(genDay);
                // alert(apprvDay);
                // alert(lcDay);
                // alert(coeDay);

                // $.post( "saveNewDates.php", { transId:transId, aprvDay:aprvDay, emdDay:emdDay , sellDay:sellDay,
                //                               genDay:genDay, apprvDay:apprvDay, lcDay:lcDay, coeDay:coeDay})
                //   .done(function( data ) {
                //     alert( "Dates Saved" );
                //     location.reload();
                //   });

                alert( "Dates Saved" );
                location.reload();


            }

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
                        url: 'getTransactions.php?userId=' + $("#hiddenUserId").html(), // use the `url` property
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
                        // var id = event.id.replace("T", " ");

                        // var formData = {
                        //     id: id
                        // };

                       
                        // $("#modal-primary").modal();
                        // alert(event.id);
                        $("#editDateModal"+event.id).modal('toggle');
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
 
        </script>

</body>

</html>
