<?php
session_start();
date_default_timezone_set('America/Los_Angeles');

// echo($_SESSION['userType']);
if (!isset($_SESSION['userId']) ) {
    header("Location: login.php");
}
if($_SESSION['username'] == 'demo')
{
    header("Location: demo/index.php");
}
else if($_SESSION['userType'] == "1" && ($_SESSION['userId'] != "34" && $_SESSION['userId'] != "37"))
{
    header("Location: agent/index.php");
}
if($_SESSION['userType'] == "2"){
    header("Location: staff/index.php");
}
require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT status, count(*) AS num FROM HouseInfo GROUP BY status";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$houseStatus = $stmt->fetchAll();

$dbConnEarn = getConnection();
$sqlEarn = "SELECT AVG(finalComm) as average, SUM(finalComm) AS earnings, AVG(percentage) AS avgPercent FROM commInfo";
$stmtEarn = $dbConnEarn->prepare($sqlEarn);
$stmtEarn->execute();
$sumEarnings = $stmtEarn->fetch();


$dbConnRank = getConnection();
$sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm FROM UsersInfo LEFT JOIN commInfo on UsersInfo.license = commInfo.license group by UsersInfo.license order by sold Desc ";
$stmtRank = $dbConnRank->prepare($sqlRank);
$stmtRank->execute();
$rank = $stmtRank->fetchAll();

$dbConnInContract = getConnection();
$inContractSql = "SELECT *, UsersInfo.firstName, UsersInfo.lastName  FROM transactions LEFT JOIN UsersInfo ON 
                        transactions.userId = UsersInfo.userId";
$stmtInContract = $dbConnInContract->prepare($inContractSql);
$stmtInContract->execute();
$inContractResults = $stmtInContract->fetchAll();

$inContractCountSql = "SELECT count(*) as count FROM transactions";
$stmtInContractCount = $dbConnInContract->prepare($inContractCountSql);
$stmtInContractCount->execute();
$inContractCountResult = $stmtInContractCount->fetch();

$sqlTransactions = "SELECT transactions.*, UsersInfo.firstName as fName, UsersInfo.lastName lName FROM transactions LEFT JOIN UsersInfo ON UsersInfo.userId = transactions.userId  ORDER BY UsersInfo.firstName DESC";
$transParameters = array();
$transParameters[':userId'] = $_SESSION['userId'];
$transStmt = $dbConn->prepare($sqlTransactions);
$transStmt->execute();
$transResults = $transStmt->fetchAll();

$sqlGetAgents = "SELECT userId, firstName, lastName, mlsId FROM UsersInfo";

$agentStmt = $dbConn->prepare($sqlGetAgents);
$agentStmt->execute();
$agentResults = $agentStmt->fetchAll();


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


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Dashboard</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/ca.js"></script>
</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">

    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-admin/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-admin/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Admin Dashboard
                <small>Week Overview</small>
            </h1>
            <ol class="breadcrumb">
                <li>Overview</li>
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Admin Dashboard</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-2 col-xs-6" onclick="location.href='inventory.php';">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo count($keys); ?></h3>
                            <p>Active Listings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-flash"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $inContractCountResult['count']; ?></h3>
                            <p>Pending Listings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?php //echo $houseStatus[2]['num']; ?></h3>
                            <p>Sold Listings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-tag"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>
                                <sup style="font-size: 20px">$</sup><?php //echo number_format($sumEarnings['average'], 0) ?>
                            </h3>
                            <p>Avg. Agent Commission</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3><?php //echo number_format((float)$sumEarnings['avgPercent'], 2, '.', ''); ?><sup
                                        style="font-size: 20px">%</sup></h3>

                            <p>Avg. Agent Commission </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-percent"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <sup style="font-size: 20px">$</sup> <?php //echo number_format($sumEarnings['earnings'], 0); ?>
                            </h3>
                            <p>Total Net Earnings</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bank"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12" style="height:100vh">
                    <?php include 'inContractTableAdmin.php'; ?>
                    <!-- <div class="box">
                        <div class="box-header">
                            <h4>Office Active/Active Contingent Properties</h4>
                        </div>
                        <div class="box-body"> -->
                            <!-- <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th>Property</th>
                                    <th data-breakpoints="all">Client Name</th>
                                    <th data-breakpoints="all">Client Number</th>
                                    <th data-breakpoints="all">Client Email</th>
                                    <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Accepted Date">Acc. </a></th>
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
                                    <th data-breakpoints="xs sm">Notes</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // foreach ($inContractResults as $inContract) 
                                    // {
                                        // $day = $inContract['accDay'];
                                        // echo "<tr>";
                                        // echo "<td>" . $inContract['firstName'] . " " . $inContract['lastName'] . "</td>";
                                        // echo "<td>" . $inContract['address'] . "</td>";
                                        // echo "<td>" . $inContract['clientName'] . "</td>";
                                        // echo "<td>" . $inContract['clientNum'] . "</td>";
                                        // echo "<td>" . $inContract['clientEmail'] . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day)) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['emdDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['sellerDiscDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['genInspecDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['appraisalDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['lcDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . date('m/d/y', strtotime($day . ' + '. $inContract['coeDays'] . ' days' )) . "</td>";
                                        // echo "<td>" . $inContract['notes'] . "</td>";
                                        // echo "</tr>";
                                    // }
                                    ?>
                                <tr>

                                    <td>1204 Rogers Ct. Salinas, CA 94934</td>
                                    <td>Patty Hershang</td>
                                    <td>831-382-4833</td>
                                    <td>phershang@gmail.com</td>

                                    <td>3/1/17
                                        <br>
                                        <span class="label label-success">Done! <i
                                                    class="fa fa-check-circle-o"></i></span>
                                    </td>
                                    <td>3/1/17
                                        <br>
                                        <span class="label label-success">Done! <i
                                                    class="fa fa-check-circle-o"></i></span>
                                    </td>
                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"><i
                                                    class="fa fa-chevron-circle-right"></i></a>
                                        <br>
                                        <span class="label label-danger">Overdue</span>
                                    </td>

                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"><i
                                                    class="fa fa-chevron-circle-right"></i></a>
                                        <br>
                                        <span class="label label-warning">Due in 8d</span>
                                    </td>

                                    <td>3/1/17 <a href="#" data-trigger="hover focus" title="<b>Ordered:</b> 3/2/17"
                                                  data-toggle="popover" data-Oplacement="right"
                                                  data-content="<b>Completed:</b> 3/4/17"><i
                                                    class="fa fa-chevron-circle-right"></i></a>
                                        <br>
                                        <span class="label label-warning">Due in 8d</span>
                                    </td>

                                    <td>3/1/17
                                        <br>
                                        <span class="label label-default">Incomplete</span>
                                    </td>
                                    <td>3/1/17
                                        <br>
                                        <span class="label label-default">Incomplete</span>
                                    </td>
                                    <td>Write some notes here!</td>
                                </tr> -->
                               <!--  </tbody>
                            </table> --> 
                        <!-- </div> -->
                        <!-- /.box-body -->
                    <!-- </div> -->
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

<?php include "staff/staffEventModal.php" ?>

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="./dist/js/vendor/footable.min.js"></script>

<script>
    jQuery(function ($) {
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
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });
</script>
<script>

            function editClientName(id)
            {
                // alert("edit client name");
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $(".clientName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractClientName.php", {
                        transId: id,
                        clientName: clientName
                    });
                }

            }

            function editClientNum(id)
            {
                var clientNum = prompt("Enter client number:");
                if (clientNum == null || clientNum == "") {
                } else {
                    $("#clientNum" + id + "-detail").html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractClientNum.php", {
                        transId: id,
                        clientNum: clientNum
                    });
                }
            }

            function editClientEmail(id)
            {
                var clientEmail = prompt("Enter client email:");
                if (clientEmail == null || clientEmail == "") {
                } else {
                    $("#clientEmail" + id+ "-detail").html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractClientEmail.php", {
                        transId: id,
                        clientEmail: clientEmail
                    });
                }
            }

            function editClientTwoName(id)
            {
                // alert("edit client name");
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $(".clientTwoName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/updateClientTwoData.php", {
                        transId: id,
                        clientTwoName: clientName,
                        type: "name"
                    });
                }

            }

            function editClientTwoNum(id)
            {
                var clientNum = prompt("Enter client number:");
                if (clientNum == null || clientNum == "") {
                } else {
                    $("#clientTwoNum" + id).html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/updateClientTwoData.php", {
                        transId: id,
                        clientTwoNum: clientNum,
                        type: "number"
                    });
                }
            }

            function editClientTwoEmail(id)
            {
                var clientEmail = prompt("Enter client email:");
                if (clientEmail == null || clientEmail == "") {
                } else {
                    $("#clientTwoEmail" + id).html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/updateClientTwoData.php", {
                        transId: id,
                        clientTwoEmail: clientEmail,
                        type: "email"
                    });
                }
            }

            function takeNote(id)
            {
                // alert(id);
                var today = moment().format("MM-DD-YYYY");
                var prevNote = $("#" + id).html();
                if(prevNote == "" || prevNote == " ")
                {
                    var noteEntered = prompt("Enter Note:", today + " " + prevNote );
                }
                else
                {
                    var noteEntered = prompt("Enter Note:", prevNote + " " + today );
                }
                if (noteEntered == null || noteEntered == "") {
                } else {
                    $("#" + id).html(noteEntered);
                    // alert(houseId + " " + buyerID);
                    $.post("agent/saveInContractNote.php", {
                        transId: id,
                        note: noteEntered
                    });
                }
            }

            function saveNameMisc(transId,type,name)
            {
                // alert(name.value);
                $.post( "staff/saveMiscName.php", { transId: transId, type:type, name:name.value });
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
                $.post( "staff/saveOrdDates.php", { transId: transId, type:type, date:sendDate });

                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }
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
                $.post( "staff/saveCompDates.php", { transId: transId, type:type, date:sendDate });
                
                

            }
             function saveDateCalendar(transId,type,date)
             {
                var dateValue = date.value;
                if(dateValue == "")
                    dateValue = moment($("#aprvDay"+transId).val()).format("YYYY-MM-DD");

                var aprvDay = $("#aprvDay"+transId).val();
                // $("#aprvDay" + transId).val(date.value);
                updateStatus(transId,type,date);
                $.post( "staff/saveNewDates.php", { transId: transId, type:type, date:dateValue, aprvDay: aprvDay });
                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }
            }
            
            function saveDaysNum(transId,type,date)
             {
           
                $.post( "staff/saveNewDaysNum.php", { transId: transId, type:type, date:date.value });
                updateStatus(transId,date);
                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }
            }

            function saveNewDates(transId)
            {

                $("#editDateModal"+transId).modal("toggle");
                // if(confirm("Do you want to download Extension Form?"))
                // {

                // }

                alert( "Dates Saved" );
                location.reload();


            }

            function deleteInContract(inContractId)
            {
                // alert(inContractId);

                if(confirm("Are you sure you want to delete?"))
                {
                    $.post( "staff/deleteInContract.php", { inContractId: inContractId })
                      .done(function( data ) {
                        alert("In-contract Deleted");
                        $("#editDateModal"+inContractId).modal("toggle");

                        $('#inContract' + inContractId).remove();
                      });

                }
                
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

            function takeTransNote(transId)
        {
            var prevNote = $("#" + transId).html();
            var noteEntered = prompt("Enter Note:", prevNote);
            if (noteEntered == null || noteEntered == "") {
            } else {
                $("#" + transId).html(noteEntered);
                // alert(houseId + " " + buyerID);
                $.post("agent/saveTransNote.php", {
                    transId: transId,
                    note: noteEntered
                });
                
            }

        }

function addNewTransaction()
            {
                var houseSelected = $('#houseId').children(":selected").attr("value");   
                var agentSelected = $('#agentName').children(":selected").attr("value"); 
                var accDate = $('#newAccDate').val();

                var inputAddress = $('#inputAddress').val();;
                var inputCity = $('#inputCity').val();;
                var inputState = $('#inputState').val();;
                var inputZip = $('#inputZip').val();;

                // alert(accDate);

                // alert(agentSelected);

                // alert(houseSelected);

                if(houseSelected == "" && inputAddress != "" && inputState != "" && inputCity != "" && inputZip != "" && accDate != "")
                {
                    $.post("staff/addTransactionStaffInput.php", {userId: agentSelected, address: inputAddress, state: inputState, 
                                                            city: inputCity, zip: inputZip , accDate: accDate});
                    alert("House In-Contract");
                    
                }
                else if(houseSelected != "" && inputAddress == "" && inputState == "" && inputCity == "" && inputZip == "" && accDate != "")
                {
                    $.post("staff/addTransactionStaff.php", {userId: agentSelected, houseId: houseSelected, accDate: accDate});
                    alert("House In-Contract");
                }
                else
                {
                    alert("Choose House from dropdown, input house data, or check date.");
                }
                
                
            }

    function editLendorInfo(type, id)
            {
                var input = prompt("Enter new lender " + type);
                if(input != null && input != "")
                {
                    $.post("editLendorInfo.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#lendor'+type+id).html(input);
                      });
                }
            }
            function editEscrowInfo(type, id)
            {
                var input = prompt("Enter new escrow " + type);
                if(input != null && input != "")
                {
                    $.post("editEscrowInfo.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#escrow'+type+id).html(input);
                      });
                }
            }
            function editAgentInfo(type, id)
            {
                var input = prompt("Enter new agent " + type);
                if(input != null && input != "")
                {
                    $.post("editAgentInfo.php", {
                            type: type,
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#agent'+type+id).html(input);
                      });
                }
            }
            function editProperty(id)
            {
                var input = prompt("Enter new property address: ");
                if(input != null && input != "")
                {
                    $.post("editPropertyAddress.php", {
                            id: id,
                            newData: input
                        })
                    .done(function( data ) {
                            alert( "Data updated");
                            $('#propertyAddress'+id).html(input);
                      });
                }
            }
</script>
</body>

</html>
