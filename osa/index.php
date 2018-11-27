<?php
session_start();
// echo($_SESSION['userType']);
// if (!isset($_SESSION['userId'])) {
//     header("Location: ../login.php");
// }

// if ($_SESSION['userType'] == "0") {
//     header("Location: ../index.php");
// }

// if ($_SESSION['userType'] == "1") {
//     header("Location: ../agent/index.php");
// }

require '../databaseConnection.php';

$dbConn = getConnection();

$sqlGetVisitors = "SELECT BuyerInfo.*, UsersInfo.firstName as agentF, UsersInfo.lastName as agentL, UsersInfo.email as agentEmail, UsersInfo.phone as agentPhone, 
                    HouseInfo.address
                    FROM BuyerInfo LEFT JOIN UsersInfo ON BuyerInfo.userId = UsersInfo.userId LEFT JOIN HouseInfo ON BuyerInfo.houseId = HouseInfo.houseId WHERE 
                    junk != 'yes'";

$visitorStmt = $dbConn->prepare($sqlGetVisitors);
$visitorStmt->execute();
$visitorResults = $visitorStmt->fetchAll();

$favoriteSql = "SELECT * FROM favorites";
$favoriteParameters = array();
// $favoriteParameters[':userId'] = $_SESSION['userId'];
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);
$favoriteResults = $favoriteStmt->fetchAll();

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | OverSite Admin</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "templates-osa/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->

        <!-- PAGE-SPECIFIC CSS -->
        <link rel="stylesheet" href="../dist/css/vendor/footable.bootstrap.min.css">
        <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="../dist/css/vendor/fullcalendar.min.css">

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="../plugins/iCheck/all.css">
    </head>

    <body class="hold-transition skin-black sidebar-mini">

        <!-- Site Wrapper -->
        <div class="wrapper">

            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "templates-osa/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "templates-osa/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Admin View
                        <!-- <small>Week Overview</small> -->
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

                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                <h3>Leads</h3>

                                    <div class="box-body no-padding" style="height:600px; overflow:auto;">
                                        <!-- THE CALENDAR -->
                                        <!-- <div id="calendar"></div> -->
                                        <table class="table table-striped" data-filtering="true">
                                            <thead>
                                                <tr>
                                                    <!-- 
                                                    Name
                                                    Phone
                                                    Email
                                                    Date submitted
                                                    Social Media
                                                    Price
                                                    Bedroom 
                                                    Bathroom
                                                    Zip
                                                    Pre-approved
                                                    Note
                                                    -->
                                                    <!-- <th>Type</th> -->
                                                    <th>Last Contacted Date</th>
                                                    <!-- <th>Agent</th> -->
                                                    <!-- <th>ID</th> -->
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Social Media</th>
                                                    <th>Zip</th>
                                                    <!-- <th>Property</th> -->
                                                    <th>Pre-Approved?</th>
                                                    <!-- <th>How soon?</th> -->
                                                    <th>Price</th>
                                                    <th>Bedroom</th>
                                                    <th>Bathroom</th>
                                                    <th>Notes</th>
                                                    <th>Admin Notes</th>
                                                    <!-- <th>House Match</th> -->
                                                    <!-- <th>Delete</th> -->
                                                    <!-- <th data-breakpoints="all">Agent Email</th> -->
                                                    <!-- <th data-breakpoints="all">Agent Phone</th> -->
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                                    foreach ($favoriteResults as $lead) 
                                                    {
                                                        //echo "<tr id=buyer" . $lead['buyerID'] . ">";
                                                        // echo "<td>";
                                                        // if ($lead['address'] == 'Lead'){
                                                        //     echo "<span title=\"Lead\" class=\"label label-warning\">ML</span>";
                                                        // } else {
                                                        //     echo "<span title=\"Open House Visitor\" class=\"label label-info\">OHV</span>";
                                                        // }
                                                        // echo "</td>";
                                                        echo "<td>" . $lead['lastContacted'] . "</td>";
                                                        // echo "<td>" . $lead['agentF'] . " " . $lead['agentL'] . "</td>";
                                                        // echo "<td>" . $lead['buyerID'] . "</td>";
                                                        echo "<td>" . $lead['firstName'] . " " . $lead['lastName'] . "</td>";
                                                        echo "<td>" . $lead['phone'] . "</td>";
                                                        echo "<td>" . $lead['email'] . "</td>";
                                                        echo "<td>" . "Social Media" . "</td>";
                                                        echo "<td>" . $lead['zip'] . "</td>";
                                                        // echo "<td>" . $lead['address']. "</td>";
                                                        echo "<td>" . $lead['approved'] . "</td>";
                                                        // echo "<td>" . $lead['howSoon'] . "</td>";
                                                        echo "<td>$" . number_format($lead['price']) . "</td>";
                                                        echo "<td>" . $lead['bedroom'] . "</td>";
                                                        echo "<td>" . $lead['bathroom'] . "</td>";
                                                        echo "<td>" . $lead['note'] . "</td>";
                                                        echo '<td><button data-toggle="modal" onClick="openNoteModal(\'' . $lead['favoriteId'] . '\')" >Add Note</button></td>';
                                                        // echo "<td>" . "Admin Notes" . "</td>";
                                                        // echo '<td><a target="_blank" href="prospectsMatch.php?visitorId=' . $lead['buyerID'] . ' ">House Matches</a></td>';
                                                        // echo "<td><button onClick=moveToTrash('" . $lead['buyerID'] . "')>Delete</button></td>";
                                                        // echo "<td>" . $lead['agentEmail'] . "</td>";
                                                        // echo "<td>" . $lead['agentPhone'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-xs-3">

                            
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->

        <div id="noteModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="height:100%;">

        <!-- Modal content-->
        <div class="modal-content" style="height:95%;">
          <div class="modal-header" style="border-bottom: solid 2px black">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Notes</h4>
            <p id="favoriteId" hidden></p>
          </div>
          <div class="modal-body" style="height:70%; overflow: auto;">

            <table id="noteTable" style="border-collapse:separate; border-spacing: 0 15px;" >

          </table>
          </div>
          <div class="modal-footer" style="border-top: solid 2px black">
            <textarea class="form-control" rows="2" id="addNewNoteArea" style="resize:none;" placeholder="Add new note"></textarea>
          </br>
            <button type="button" class="btn btn-default" onClick="addNewNote()">Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "templates-osa/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "templates-osa/default-js.php" ?>
        <!-- END TEMPLATE default-js.php INCLUDE -->

        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/footable.min.js"></script>
        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/moment-with-locales.min.js"></script>
        <!--        <script src="../dist/js/vendor/fullcalendar/gcal.min.js"></script>-->
        <script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/ca.js"></script>



        <script>
            jQuery(function($) {
                $('.table').footable({
                     "sorting": {
                "enabled": true
                },
                "filtering": {
                "connectors": false,
                "position": "center"
                }
                });
            });

            function moveToTrash(buyerId)
            {
                // alert(buyerId);
                $.post( "addToJunk.php", { buyerId: buyerId })
                  .done(function( data ) {
                    alert( "Added to Junk" );
                    $("#buyer" + buyerId).hide();
                  });
            }

            function openNoteModal(favoriteId)
            {
                //erase all when opening modal
                $('#favoriteId').html('');
                $('#addNewNoteArea').val('');
                $("#noteTable").empty();

                //populate data
                $('#favoriteId').html(favoriteId);
                $.post( "getFavoriteNotesOsa.php", { favoriteId: favoriteId })
                      .done(function( data ) {
                        notesResult = JSON.parse(data);
                        var x;
                        var table = document.getElementById("noteTable");
                        for(x in notesResult)
                        {
                            var row = table.insertRow(0);
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            cell2.className = "favoriteNoteRow";
                            cell1.innerHTML = "<h4>" + moment(notesResult[x].noteDate).format('MM/DD/YYYY h:mma')+ "</h4>";
                            cell2.innerHTML = "<textarea class='form-control' rows='2' id='note" + notesResult[x].noteId + "' style='resize:none; border: solid 1px black' onchange='saveNote(this)'>" + notesResult[x].note + "</textarea>";
                            cell3.innerHTML = "<input type='checkbox' class='notesChecked' value=" + x + ">";
                            
                        }
                        
                      });
                // Open Modal
                $('#noteModal').modal('toggle');
            }

            function addNewNote()
            {
                var favoriteId = $('#favoriteId').html();
                var note = $('#addNewNoteArea').val();
                // alert(note);

                if(note != "" && note != null)
                {
                    $.post( "addNewFavoriteNoteOsa.php", { favoriteId: favoriteId, note:note })
                      .done(function( data ) {
                        var table = document.getElementById("noteTable");
                        var row = table.insertRow(0);
                        var cell1 = row.insertCell(0);
                        var cell2 = row.insertCell(1);
                        cell2.className = "favoriteNoteRow";
                        cell1.innerHTML = "<h4>" + moment().format('L') + "</h4>";
                        cell2.innerHTML = "<textarea class='form-control' rows='2' id='comment' style='resize:none; border: solid 1px black' onchange='saveNote(this)'>" + note + "</textarea>";
                        alert( "Note Added");
                        $('#addNewNoteArea').val("");
                      });
                }
                else
                    alert("Note Empty");
            }

            function saveNote(textArea)
            {
                var noteId = textArea.id.replace("note", "");
                var newNote = textArea.value;
                // alert(areaId);
                // alert(textArea.value);
                $.post( "updateFavoriteNoteOsa.php", { noteId: noteId, note: newNote })
                      .done(function( data ) {
                        alert("Note Updated");
                      });
            }

        </script>
        <script>
            

        </script>

        <script>
           

        </script>
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

       

    </body>

</html>
