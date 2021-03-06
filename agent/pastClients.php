<?php
session_start();
date_default_timezone_set('America/Los_Angeles');

if (!isset($_SESSION['userId'])) {
    header("Location: http://www.oversite.cc/login.php");
}
require '../databaseConnection.php';
require '../keys/cred.php';
require '../twilio-php-master/Twilio/autoload.php';

use Twilio\Jwt\ClientToken;

$dbConn = getConnection();
$dbConnTwo = getConnection();

$sqlMlsId = "SELECT  mlsId FROM UsersInfo WHERE userId = :userId";

$namedParameters = array();
$namedParameters[':userId'] = $_SESSION['userId'];


$mlsIdStmt = $dbConn->prepare($sqlMlsId);
$mlsIdStmt->execute($namedParameters);
$mlsIdResult = $mlsIdStmt->fetch();

$addedHouses = "SELECT * FROM HouseInfo WHERE userId = :userId AND status = :status";
$addedHouseParam = array();
$addedHouseParam[':userId'] = $_SESSION['userId'];
$addedHouseParam[':status'] = "added";

$addedHousesStmt = $dbConn->prepare($addedHouses);
$addedHousesStmt->execute($addedHouseParam);
$addedHouseResults = $addedHousesStmt->fetchAll();

$houses = $addedHousesStmt->rowCount();

$otherHouses = "SELECT * FROM HouseInfo WHERE userId = :userId AND status != :status";
$otherHouseParam = array();
$otherHouseParam[':userId'] = $_SESSION['userId'];
$otherHouseParam[':status'] = "added";

$otherHousesStmt = $dbConn->prepare($otherHouses);
$otherHousesStmt->execute($otherHouseParam);
$otherHouseResults = $otherHousesStmt->fetchAll();


//Twilio call functionality
$accountSid = $sid;
$authToken  = $token;
$capability = new ClientToken($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$capability->allowClientIncoming('joey');
$token = $capability->generateToken();

//End Twilio Functionality

function updateSort($sort)
{
    if ($sort == 1) {
        return 0;
    } else {
        return 1;
    }
}

//sort variables; 1 will be alphabetical; 0 will be reverse alphabetical
$visitorSort = 1;
$emailSort = 1;
$addressSort = 1;
$bedroomSort = 1;
$bathroomSort = 1;

if (isset($_GET['visitorSort'])) {
    $visitorSort = $_GET['visitorSort'];
}
if (isset($_GET['emailSort'])) {
    $emailSort = $_GET['emailSort'];
}
if (isset($_GET['addressSort'])) {
    $addressSort = $_GET['addressSort'];
}
if (isset($_GET['bedroomSort'])) {
    $bedroomSort = $_GET['bedroomSort'];
}
if (isset($_GET['bathroomSort'])) {
    $bathroomSort = $_GET['bathroomSort'];
}
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
for ($h = 0; $h < sizeof($keys); $h++)
{
    for ($g = 0; $g < sizeof($otherHouseResults); $g++)
    {
        if($response[$keys[$h]]['listingID'] == $otherHouseResults[$g]['listingID'])
        {
            unset($otherHouseResults[$g]);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Past Clients</title>

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

        html, body {
    height: 100%;
}

    </style>
    <!-- NOTIFICATION Links-->
    <link href="../plugins/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

    <!-- daterange picker -->
    <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/locale/ca.js"></script>

    <style>
        .panel-heading a:after {
            font-family:'Glyphicons Halflings';
            content:"\e114";
            float: right;
            color: grey;
        }
        .panel-heading a.collapsed:after {
            content:"\e079";
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="addLeadModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Lead</h4>
                </div>
                <div class="modal-body">
                    <form action="addLead.php" method="POST">
                        <input type="text" name="firstName" class="form-control has-feedback-left" id="inputSuccess2"
                               placeholder="First Name">
                        <span class="form-control-feedback left" aria-hidden="true"></span>

                        </br>
                        <input type="text" name="lastName" class="form-control" id="inputSuccess3" placeholder="Last Name">
                        </br>
                        <input type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4"
                               placeholder="Email">
                        </br>
                        <input type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Phone">
                        </br>

                        <label>How soon are you looking to purchase a home?</label>
                        <select id="" name="howSoon" class="form-control" required>
                            <option value="0">--Select One--</option>
                            <option value="1-3">1-3 months</option>
                            <option value="4-6">4-6 months</option>
                            <option value="7-12">7-12 months</option>
                            <option value="Visit">Just visiting</option>
                        </select>
                        </br>

                        <label>Have you been pre-approved?</label>
                        <select id="" name="preApproved" class="form-control" required>
                            <option value="0">--Select One--</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        </br>

                        <label>Price</label>
                        <select id="" name="price" class="form-control" required>
                            <option value="">--Select One--</option>
                            <option value="100000">$100,000</option>
                            <option value="150000">$150,000</option>
                            <option value="200000">$200,000</option>
                            <option value="250000">$250,000</option>
                            <option value="300000">$300,000</option>
                            <option value="350000">$350,000</option>
                            <option value="400000">$400,000</option>
                            <option value="450000">$450,000</option>
                            <option value="500000">$500,000</option>
                            <option value="550000">$550,000</option>
                            <option value="600000">$600,000</option>
                            <option value="650000">$650,000</option>
                            <option value="700000">$700,000</option>
                            <option value="750000">$750,000</option>
                            <option value="800000">$800,000</option>
                            <option value="850000">$850,000</option>
                            <option value="900000">$900,000</option>
                            <option value="950000">$950,000</option>
                            <option value="1000000">$1,000,000+</option>
                        </select>

                        </br>

                        <label>Min Bedrooms</label>
                        <select id="" name="bedroomsMin" class="form-control" required>
                            <option value="">--Select One--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>
                        </br>
                        <label>Min Bathrooms</label>
                        <select id="" name="bathroomsMin" class="form-control" required>
                            <option value="">--Select One--</option>
                            <option value="1">1</option>
                            <option value="1.5">1.5</option>
                            <option value="2">2</option>
                            <option value="2.5">2.5</option>
                            <option value="3">3</option>
                            <option value="3.5">3.5</option>
                            <option value="4">4</option>
                            <option value="4.5">4.5</option>
                        </select>
                        </br></br>
                        <button type="submit" class="btn btn-default" >Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="visitorHouseMatchModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Houses Matched</h4>
                </div>
                <div class="modal-body">
                    1. <span id="house0"></span>
                    <br><br>
                    2. <span id="house1"></span>
                    <br><br>
                    3. <span id="house2"></span>
                    <br><br>
                    4. <span id="house3"></span>
                    <br><br>
                    5. <span id="house4"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="sendEmail" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Email</h4>
          <p id="sendToEmail"></p>
        </div>
        <div class="modal-body">
          <textarea id="emailText" name="emailText" rows="10" cols="70" style="color:black;" placeholder="Text"></textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="sendEmail()">Send Email</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="sendText" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Send Text</h4>
          <p id="sendToText"></p>
        </div>
        <div class="modal-body">
          <textarea id="messageText" name="messageText" rows="10" cols="70" style="color:black;" placeholder="Text"></textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="sendText()">Send Text</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="hangUpCall" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Call</h4>
          <p id="callTo"></p>
        </div>
        <div class="modal-body">
            <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal" onClick="hangup()">Hang Up</button>
        </div>
       
      </div>
    </div>
  </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->

        <section class="content" style="min-height:initial;">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3>My Past Clients</h3>
                            <button class="load-rows" type="button" onclick="window.location.pathname='agent/visitors.php'">Current Leads</button>
                            <button class="load-rows" type="button" onclick="window.location.pathname='agent/pastClients.php'">Past Clients</button>

                            <!-- <button type="button" class="btn btn-success" style="float: right; margin-left: 7px;"
                                    onClick="leadModal()">Add Lead</button>
                            <button class="btn btn-default pull-right" id="exportVisitors">Export</button> -->
                            <div class="clearfix"></div>
                        </div>

                        <div class="box-body" style="height: 600px; overflow: auto;">
                            <table class="table table-striped" data-filtering="true">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <!-- <th>Type</th> -->
                                    <th>ID</th>
                                    <!-- <th data-type="date">Date Added</th> -->
                                    <th>Name</th>
                                    <th data-breakpoints="xs">Phone</th>
                                    <th data-breakpoints="xs">Email</th>

                                    <th>Name 2</th>
                                    <th data-breakpoints="xs">Phone 2</th>
                                    <th data-breakpoints="xs">Email 2</th>


                                    <th>Date Closed</th>
                                    <th data-breakpoints="xs">Address</th>
                                    <th data-breakpoints="xs">Final Price</th>

                                    <th data-breakpoints="xs">Loan Type</th>
                                    <th data-breakpoints="xs">Loan Amount</th>
                                    <th data-breakpoints="xs">Loan Interest Rate</th>

                                    <th data-breakpoints="xs">Listing Type</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $sql = "SELECT * FROM pastClients WHERE userId = :userId AND junk != \"junk\"";

                                $namedParameters = array();
                                $namedParameters[':userId'] = $_SESSION['userId'];
                                $stmt = $dbConn->prepare($sql);
                                $stmt->execute($namedParameters);
                                $results = $stmt->fetchAll();

                                foreach($results as $result) {
                                    if($result['dateClosed'] == "0000-00-00")
                                        $date = "NA";
                                    else
                                        $date = date('m-d-Y', strtotime($result['dateClosed']));
                                    echo "<tr id=visitor" . $result['buyerId']." class=visitor" . $result['pastClientId'] . " >";
                                    echo "<td></td>";

                                    echo "<td>";
                                    echo "<span title=\"Lead\" class=\"label label-warning\">Past Client</span>";
                                    echo "</td>";

                                    echo "<td>" . $result['buyerId']  . "</td>";

                                    // Name
                                    echo '<td class=clientName'. $result['pastClientId'] . ' ondblclick="editClientName(' . $result['pastClientId'] . ')">';
                                    echo $result['firstName'] . " " . $result['lastName'];
                                    echo "</td>";

                                    // Phone Number
                                    echo '<td id=clientNum' . $result['pastClientId'] . ' ondblclick="editClientNum(' . $result['pastClientId'] . ')">';
                                    echo $result['phone'];
                                    echo "</td>";

                                    // Email
                                    echo '<td id=clientEmail'. $result['pastClientId'] . ' ondblclick="editClientEmail(\'' . $result['pastClientId'] . '\')">';
                                    echo $result['email'];
                                    echo "</td>";

                                    // Name 2
                                    echo '<td class=clientTwoName'. $result['pastClientId'] . ' ondblclick="editClientTwoName(' . $result['pastClientId'] . ')">';
                                    echo $result['secondName'];
                                    echo "</td>";

                                    // Phone Number 2
                                    echo '<td id=clientTwoNum' . $result['pastClientId'] . ' ondblclick="editClientTwoNum(' . $result['pastClientId'] . ')">';
                                    echo $result['secondNumber'];
                                    echo "</td>";

                                    // Email 2
                                    echo '<td id=clientTwoEmail'. $result['pastClientId'] . ' ondblclick="editClientTwoEmail(\'' . $result['pastClientId'] . '\')">';
                                    echo $result['secondEmail'];
                                    echo "</td>";

                                    // Date Closed
                                    echo "<td>";
                                    echo $date;
                                    echo "</td>";

                                    // Address
                                    echo "<td>";
                                    echo $result['address'];
                                    echo "</td>";

                                    // Final House Price
                                    echo "<td>";
                                    echo "$" . number_format((float)$result['finalHousePrice'],2);
                                    echo "</td>";

                                    // Loan type
                                    echo "<td>";
                                    echo $result['loanType'];
                                    echo "</td>";

                                    //Loan Amount
                                    echo "<td>";
                                    echo "$" . number_format($result['loanAmount'],2);
                                    echo "</td>";

                                    //Loan Interest Rate
                                    echo "<td>";
                                    echo $result['loanRate'] . "%";
                                    echo "</td>";

                                    //Listing Type
                                    echo "<td>";
                                    echo $result['listingType'];
                                    echo "</td>";

                                    //Delte
                                    echo "<td>";
                                    echo "<button onClick=deletePastClient(" . $result['pastClientId'] . ")>Delete</button>";
                                    echo "</td>";
                                    
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
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Enter Export Dates</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <span>Start Date:  </span><input id="startDate" type="date" data-date-inline-picker="false"
                                                         data-date-open-on-focus="true"/>
                    </div>
                    <div class="form-group">
                        <span>End Date:  </span><input id="endDate" type="date" data-date-inline-picker="false"
                                                       data-date-open-on-focus="true"/>
                    </div>

                    <div class="form-group">
                        <span>Select House:  </span>
                        <select id="house">
                            <option>--Select One--</option>
                            <option value="all">All</option>
                            <?php
                            for ($i = 0; $i < sizeof($keys); $i++)
                            {
                                if($mlsIdResult['mlsId'] == $response[$keys[$i]]['listingAgentID'])
                                {

                                    echo '<option value=' . $response[$keys[$i]]['listingID'] . '>' . $response[$keys[$i]]['address'] .
                                         " " . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . ", " .
                                         $response[$keys[$i]]['zipcode'] . '</option>';
                                }
                            }

                            for($j = 0; $j < $houses; $j++)
                            {
                                echo '<option value=' . $addedHouseResults[$j]['listingId'] . '>' . $addedHouseResults[$j]['address'] .
                                     " " . $addedHouseResults[$j]['city'] . " " . $addedHouseResults[$j]['state'] . ", " .
                                     $addedHouseResults[$j]['zip'] . '</option>';
                            }
                            echo "<option>--Closed Houses--</option>";
                            for($k = 0; $k < sizeof($otherHouseResults); $k++)
                            {
                                echo '<option value=' . $otherHouseResults[$k]['listingId'] . '>' . $otherHouseResults[$k]['address'] .
                                     " " . $otherHouseResults[$k]['city'] . " " . $otherHouseResults[$k]['state'] . ", " .
                                     $otherHouseResults[$k]['zip'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="downloadAllLeads">All Leads</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="downloadVisitors">Download</button>
                    </button>
                </div>
            </div>

        </div>
    </div>
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
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<script type='text/javascript'
        src="https://cdnjs.cloudflare.com/ajax/libs/floatthead/2.0.3/jquery.floatThead.js"></script>

<script type="text/javascript" src="//media.twiliocdn.com/sdk/js/client/v1.3/twilio.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        });

    });

    function takeNote(house, buyer) {
        var today = moment().format("MM-DD-YYYY");
        var prevNote = $("#" + buyer).html();
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
            $("#" + buyer).html(noteEntered);
            // alert(houseId + " " + buyerID);
            $.post("openhouse/saveNote.php", {
                houseId: house,
                buyerID: buyer,
                note: noteEntered
            });
        }
    }

    // $('table').floatThead({
    //     position: 'absolute'
    //
    // });


    function toggleIcon(e) {
        $(e.target)
            .prev('.panel-heading')
            .find(".more-less")
            .toggleClass('fa-plus fa-minus');

    }

    $('.panel-group').on('hidden.bs.collapse', toggleIcon);
    $('.panel-group').on('shown.bs.collapse', toggleIcon);

    function openFlyerModal() {
        $('#flyerModal').modal('toggle');
    }
    $('#exportVisitors').click(function () {

        $("#myModal").modal();
    });

    $('#downloadVisitors').click(function () {
        // alert($('#startDate').val());
        // alert($('#endDate').val());

        window.location = "openhouse/exportVisitors.php?id=" + $("#house").val() + "&startDate=" + $('#startDate').val() + "&endDate=" + $('#endDate').val();
    });

    $('#downloadAllLeads').click(function () {
        window.location = "openhouse/exportVisitors.php?id=all" + "&startDate=" + $('#startDate').val() + "&endDate=" + $('#endDate').val();
    });

    function leadModal()
    {
        $('#addLeadModal').modal('toggle');
    }


    function addLead()
    {
        var firstName = $('input[name=firstName]').val();
        var lastName = $('input[name=lastName]').val();
        var email = $('input[name=email]').val();
        var phone = preg_replace('/[^0-9.]+/', '', $('input[name=phone]').val());
        var howSoon = $('select[name=howSoon]').val();
        var price = $('select[name=price]').val();
        var minBed = $('select[name=bedroomsMin]').val();
        var minBath = $('select[name=bathroomsMin]').val();
        // alert(firstName);
        // alert(lastName);
        // alert(email);
         alert(phone);
        // alert(howSoon);
        // alert(price);
        // alert(minBed);
        // alert(minBath);
        // $('input[name=firstName]').val("");

        $.post( "addLead.php", { firstName: firstName, lastName: lastName, email: email, phone: phone, howSoon: howSoon, price: price, bedroomsMin: minBed, bathroomsMin: minBath})
            .done(function( data ) {
                alert("lead Added");
                $('input[name=firstName]').val("");
                $('input[name=lastName]').val("");
                $('input[name=email]').val("");
                $('input[name=phone]').val("");
                $('input[name=howSoon]').val("");
                $('input[name=price]').val("");
                $('input[name=bedroomsMin]').val("");
                $('input[name=bathroomsMin]').val("");
                $('#addLeadModal').modal('toggle');
                location.reload(true);
            });

    }

    function showHouseMatchModal(price,bed,bath)
    {
        for(var i = 0; i < 5; i++ )
        {
            $('#house' + i).text(" ");
        }
        $.post( "getHouseMatch.php", {price: price, bed: bed, bath: bath})
            .done(function( data ) {
                var houseData = JSON.parse(data);
                // alert(data);
                for(var i = 0; i < 5; i++ )
                {
                    $('#house' + i).text("Not Available");
                }
                for(var i = 0; i < 5; i++ )
                {
                    $('#house' + i).text("Agent: " + houseData[i]['listingAgentID'] + " --- " +
                        houseData[i]['address'] + ", " + houseData[i]['cityName'] + ", " + houseData[i]['state'] + ", " + houseData[i]['zipcode']);

                }
            });

        $('#visitorHouseMatchModal').modal('toggle');

    }
    //
    // function barSearch()
    // {
    //     var input, filter, table, tr, td, i;
    //     input = document.getElementById("searchBar");
    //     filter = input.value.toUpperCase();
    //     table = document.getElementById("freeze");
    //     tr = table.getElementsByTagName("tr");
    //     for (i = 0; i < tr.length; i++)
    //     {
    //         td = tr[i].getElementsByTagName("td")[2];
    //         if (td)
    //         {
    //             if (td.innerHTML.toUpperCase().indexOf(filter) > -1)
    //             {
    //                 tr[i].style.display = "";
    //             } else
    //             {
    //                 tr[i].style.display = "none";
    //             }
    //         }
    //     }
    
// function makeCall()
// {
//     alert("Call");

// }

function makeText(phone)
{
    // alert("Text");
    $('#sendToText').text(phone);
    $('#sendText').modal('toggle');
}
function sendText()
{
    var number = $('#sendToText').text();
    var messageText = $('#messageText').val();

    $.post( "sendText.php", { phone: number, text: messageText })
      .done(function( data ) {
        alert( "Text Sent" );
        $('#messageText').val("");
        $('#sendText').modal('toggle');
      });
    // alert(number);
    // alert(messageText);

}

function makeEmail(email)
{
    // alert("Email");
    $('#sendToEmail').text(email);
    $('#sendEmail').modal('toggle');
    
}
function sendEmail()
{
    var email = $('#sendToEmail').text();
    var emailText = $('#emailText').val();

    $.post( "sendEmail.php", { email: email, emailText: emailText })
      .done(function( data ) {
        alert( "Email Sent" );
        $('#emailText').val("");
        $('#sendEmail').modal('toggle');
      });
    // alert(email);
    // alert(emailText);
}

function deleteVisitor(visitorId)
{
    if(confirm("Are you sure you want to delete the isitor?"))
    {
        $.post( "deleteBuyer.php", { buyerID: visitorId })
          .done(function( data ) {
            alert("Visitor Deleted");
            $('#visitor' + visitorId).remove();
          });
    }
}
</script>

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
            // "paging": {
            //     "enabled": true,
            //     "size": 15
            // }

        });
    });
</script>

<script type="text/javascript">

      Twilio.Device.setup("<?php echo $token; ?>");

      Twilio.Device.ready(function (device) {
        // $("#log").text("Ready");
      });

      Twilio.Device.error(function (error) {
        // $("#log").text("Error: " + error.message);
      });

      Twilio.Device.connect(function (conn) {
        // $("#log").text("Successfully established call");
      });

      Twilio.Device.disconnect(function (conn) {
        // $("#log").text("Call ended");
      });

      Twilio.Device.incoming(function (conn) {
        // $("#log").text("Incoming connection from " + conn.parameters.From);
        // accept the incoming connection and start two-way audio
        conn.accept();
      });

      function makeCall(phone) {
        // get the phone number to connect the call to
        params = {"PhoneNumber": phone};
        $('#hangUpCall').modal('toggle');
        $('#callTo').text(phone);
        // alert(phone);
        Twilio.Device.connect(params);
      }

      function hangup() {
        Twilio.Device.disconnectAll();
        $('#hangUpCall').modal('toggle');
      }

      function addFavorite(buyerId)
      {
        // alert(buyerId);
        $.post( "addFavorite.php", { buyerId: buyerId })
          .done(function( data ) {
            alert( "Favorite added" );
          });
      }

      // bind the buttons to load the rows
    $('.load-rows').on('click', function (e) {
        e.preventDefault();
        // get the url to load off the button
        var url = $(this).data('url');
        // ajax fetch the rows
        $.get(url).then(function (rows) {
            // and then load them using either
            ft.rows.load(rows);
            // or
            // ft.loadRows(rows);
        });
    });

    function deletePastClient(pastClientId, )
    {
        bootbox.confirm({
        message: "Are you sure you want to delete the Past Client?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            // alert(result);
            if(result == true)
            {
                $.post( "deletePastClient.php", { pastClientId: pastClientId})
              .done(function( data ) {
                $('.visitor' + pastClientId).remove();
                alert( "Past Client Deleted");
              });
            }
        }
    });
        
    }
// });

            function editClientName(id)
            {
                // alert("edit client name");
                var clientName = prompt("Enter client name:");
                if (clientName == null || clientName == "") {
                } else {
                    $(".clientName" + id).html(clientName);
                    // alert(houseId + " " + buyerID);
                    $.post("updatePastClientOneData.php", {
                        clientPastId: id,
                        clientName: clientName,
                        type: "name"
                    });
                }

            }

            function editClientNum(id)
            {
                var clientNum = prompt("Enter client number:");
                if (clientNum == null || clientNum == "") {
                } else {
                    $("#clientNum" + id).html(clientNum);
                    // alert(houseId + " " + buyerID);
                    $.post("updatePastClientOneData.php", {
                        clientPastId: id,
                        clientNum: clientNum,
                        type: "number"
                    });
                }
            }

            function editClientEmail(id)
            {
                var clientEmail = prompt("Enter client email:");
                if (clientEmail == null || clientEmail == "") {
                } else {
                    $("#clientEmail" + id).html(clientEmail);
                    // alert(houseId + " " + buyerID);
                    $.post("updatePastClientOneData.php", {
                        clientPastId: id,
                        clientEmail: clientEmail,
                        type: "email"
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
                    $.post("updatePastClientTwoData.php", {
                        clientPastId: id,
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
                    $.post("updatePastClientTwoData.php", {
                        clientPastId: id,
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
                    $.post("updatePastClientTwoData.php", {
                        clientPastId: id,
                        clientTwoEmail: clientEmail,
                        type: "email"
                    });
                }
            }
    </script>
<!-- Modal -->

</body>

</html>
