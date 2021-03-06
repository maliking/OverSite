<?php
session_start();
require("databaseConnection.php");
$dbConn = getConnection();
if (!isset($_SESSION['userId'])) {
    header("Location: index.html?error=wrong username or password");
}

$sql = "SELECT * FROM UsersInfo ";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
//$stmt->execute();
$sqlHouse = "SELECT * FROM HouseInfo ORDER BY address";
$stmtHouse = $dbConn->prepare($sqlHouse);
$stmtHouse->execute();
$results = $stmt->fetchAll();
$houses = $stmtHouse->fetchAll();


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
    <title>RE/MAX Salinas | Commission Sheet</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <link rel="stylesheet" href="plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css">

    <style>
        label.col-xs-9 {
            text-align: right;
        }

    </style>

    <script src="commAlgoJS.js?t=1500963597208"></script>
    <script>
        $(function () {
            $('#today-date').datetimepicker({
                defaultDate: new Date(),
                format: "M/D/YYYY",
            });
            $('#settlement-date').datetimepicker({
                format: "M/D/YYYY"

            });
        });

        function getLicense() {

            var x = document.getElementById("agentName").value;
            document.getElementById("agent").value = x;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var data = JSON.parse(this.responseText);
                    // alert(data.TYGross);
                    var TYGross = data.TYGross;
                    // alert(TYGross);
                    if (TYGross == undefined) {
                        document.getElementById("beg-comm").value = "0";
                        TYGross = "";
                    }
                    else {
                        document.getElementById("beg-comm").value = data.TYGross;
                        TYGross = "";
                    }

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

                    // agentFeeToPay(x);
                }
            };
            xhttp.open("GET", "agentCommission.php?license=" + x, true);
            xhttp.send();
        }

        function setPercentage(commission) {
            var housePrice = document.getElementById("housePrice").value;

            document.getElementById("percentage").value = numeral((commission.replace(/,/g,"") / housePrice.replace(/,/g,"")) * 100).format('0,0.00') + "%";
            document.getElementById("gross-comm").value = numeral(commission).format('0,0.00');
            calculateCommission();
        }
        function addComa(number)
        {   
            document.getElementById("housePrice").value = numeral(number).format('0,0.00');
        }
        function getOwners() {

        }
        function agentFeeToPay(license)
        {
            $.post( "remaxFeeCalculation.php", { license: license })
              .done(function( data ) {
                var results = JSON.parse(data);
                $('#remaxFee').val(results.fee);
                // alert( "Fee: " + results.fee );
              });
            // alert(license);
        }
    </script>
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

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h4>Commission Sheet Breakdown</h4>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <form action="sendCommissionSheet.php" method="post">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Transaction Details</strong>
                                                            </h3>
                                                        </div>
                                                        <div class="panel-body">

                                                            <div class="form-group col-xs-3">
                                                                <label for="agentName">Agent Name</label>
                                                                <select class="form-control" id="agentName"
                                                                        onchange="getLicense()" name="agentName">
                                                                        <option value=''>Select Agent</option>
                                                                    <?php
                                                                    $license = "";
                                                                    foreach ($results as $result) {
                                                                        if ($result['userType'] == 0) {
                                                                        } else
                                                                        echo "<option id=agent" . $result['mlsId'] . " value='" . $result['license'] . "'>" . $result['firstName'] . " " . $result['lastName'] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-xs-2">
                                                                <label class="control-label" for="pwd">
                                                                    License #</label>
                                                                <input type="text" class="form-control" id="agent"
                                                                       placeholder="" name="license" value="" readonly>
                                                            </div>
                                                            <div class="form-group col-xs-3">

                                                                <label class="control-label" for="pwd">Client
                                                                    Name(s)</label>
                                                                <input type="text" class="form-control" id="client"
                                                                       placeholder="" name="clients">

                                                            </div>

                                                            <div class="form-group col-xs-4">
                                                                <label for="houseId">Property Address</label>
                                                                <input type="text" class="form-control" id="houseId"
                                                                       name="propertyAddress"
                                                                       placeholder="Enter Property Address">
                                                                <!-- <select class="form-control" id="houseId"
                                                                        onchange="getOwners()" name="propertyAddress">
                                                                        < option id='empty' value=''>Select House</option> -->
                                                                    <?php

                                                                    // for ($i = 0; $i < sizeof($keys); $i++) 
                                                                    // {
                                                                    //     echo "<option id=agent" . $response[$keys[$i]]['listingAgentID'] . " value='" . $response[$keys[$i]]['listingID'] . "'>" 
                                                                    //     . $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] . "</option>";

                                                                    // }

                                                                    // foreach ($houses as $house) {
                                                                    //     echo "<option id=agent" . $house['userId'] . " value='" . $house['houseId'] . "'>" . $house['address'] . " " . $house['city'] . " " . $house['state'] . " " . $house['zip'] . "</option>";
                                                                    // }
                                                                    ?>
                                                                <!-- </select> -->
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="form-group col-xs-2">
                                                                <label class="control-label " for="email">Date</label>
                                                                <input type="text" data-provide="datepicker"
                                                                       class="form-control" id="today-date"
                                                                       name="today-date"
                                                                       placeholder="Enter today's date">
                                                            </div>
                                                            <div class="form-group col-xs-2">
                                                                <label class="control-label  " for="email">Settlement
                                                                    Date</label>
                                                                <input type="text" data-provide="datepicker"
                                                                       class="form-control" id="settlement-date"
                                                                       name="settlementDate"
                                                                       placeholder="Click to set date">
                                                            </div>
                                                            <div class="form-group col-xs-4">
                                                                <label class="control-label  " for="pwd">Beginning Gross
                                                                    Commission (GCYTD)</label>
                                                                <input type="text" class="form-control" id="beg-comm"
                                                                       name="TYGross" placeholder="" readonly>
                                                            </div>
                                                            <!-- <div class="form-group col-xs-4">
                                                                <label class="control-label  " for="datetimepicker4">Check
                                                                    Number</label>
                                                                <input type="text" class="form-control" id="check"
                                                                       name="checkNum" placeholder="">
                                                            </div> -->

                                                            <!-- Commission Lead Type -->
                                                            <div class="form-group col-xs-2">
                                                                <label for="leadType">Lead Type</label>
                                                                <select required class="form-control" id="leadType"
                                                                        name="leadType" onChange="updateComm()">
                                                                        <option>Select Lead Type</option>
                                                                        <option value="Zillow">Zillow(50)</option>
                                                                        <option value="ZillowSixty">Zillow(60)</option>
                                                                        <option value="Realtor.com">Realtor.com</option>
                                                                        <option value="Referral">Referral</option>
                                                                        <option value="Past Client">Past Client</option>
                                                                        <option value="Open House">Open House</option>
                                                                        <option value="Other">Other</option>

                                                                </select>

                                                            </div>

                                                            <div class="form-group col-xs-2">
                                                                <label for="type">Type</label>
                                                                <select required class="form-control" id="type"
                                                                        name="type">
                                                                        <option>Select Type</option>
                                                                        <option value="Seller">Seller</option>
                                                                        <option value="Buyer">Buyer</option>
                                                                        <option value="Seller/Buyer">Seller/Buyer</option>
                                                                        <option value="co-agent">Co-Agent</option>

                                                                </select>

                                                            </div>
                                                            <!--  -->

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="panel panel-success">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"><strong>Earnings &
                                                                    Deductions</strong></h3>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label " for="pwd">*Final
                                                                    House Price</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="housePrice" placeholder=""
                                                                           name="finalHousePrice" onchange="addComa(this.value)">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label " for="pwd">*Gross
                                                                    Commission</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="gross-comm" placeholder=""
                                                                           name="InitialGross"
                                                                           onchange="setPercentage(this.value)">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">Broker
                                                                    Fee</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control" id="broker"
                                                                           name="brokerFee" placeholder="" 
                                                                           onChange="updateAgentNet()">
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">Percentage</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="percentage" name="percentage"
                                                                           placeholder="" readonly>
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label"
                                                                       for="pwd">Subtotal</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="subtotal" placeholder="" readonly>
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">Transaction
                                                                    Coordinator</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="trans-coor" name="trans-coor" placeholder="" value="200.00"
                                                                           onchange="calculateCommission()">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">TC. Tech
                                                                    Fee</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control" id="tech" name="tech"
                                                                           placeholder="" value="50.00" onchange="calculateCommission()">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">E&O
                                                                    Insurance</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="eo_insurance" name="eo_insurance" placeholder=""
                                                                           value="99.00" onchange="calculateCommission()">
                                                                </div>


                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">RE/MAX
                                                                    Fee</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="remaxFee" name="remaxFee" placeholder=""
                                                                           onchange="calculateCommission()" value="0">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label"
                                                                       for="pwd">*Misc.</label>
                                                                <div class="col-xs-3">

                                                                    <input type="text" class="form-control" id="miscTitle"
                                                                           name="miscTitle" placeholder="Misc title" value="">

                                                                    <input type="text" class="form-control" id="misc"
                                                                           name="miscell" placeholder=""
                                                                           onchange="calculateCommission()" value="0">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">Agent
                                                                    Net Commission</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="agent_net" name="netCommission"
                                                                           placeholder="" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-11 col-xs-offset-11">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </section>
    </div>

    <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- Moment -->
<script src="./dist/js/vendor/moment-with-locales.min.js"></script>
<!-- Bootstrap DatePicker -->
<script src="./dist/js/vendor/bootstrap-datetimepicker.min.js"></script>

<script>
    var placeSearch, autocomplete;

    var options = {
        componentRestrictions: {country: 'usa'},

    };

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('address')),
            {types: ['geocode'], options});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }


    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

    function updateComm()
    {
        if($('#gross-comm').val() != "" && $('#gross-comm').val() != null)
        {
            calculateCommission();
        }
        else{
           
        }
    }

    function updateAgentNet()
    {
        var initialCommission = parseFloat(document.getElementById("gross-comm").value.replace(",",""));
        var brokerFee = parseFloat(document.getElementById("broker").value.replace(",",""));
        var misc = parseFloat(document.getElementById("misc").value.replace(",",""));
        var remaxFee = parseFloat(document.getElementById("remaxFee").value.replace(",",""));
        var transactionCoordFee = parseFloat(document.getElementById("trans-coor").value.replace(",",""));
        var techFee = parseFloat(document.getElementById("tech").value.replace(",",""));
        var eoInsurance = parseFloat(document.getElementById("eo_insurance").value.replace(",",""));

        document.getElementById("agent_net").value = numeral(initialCommission - brokerFee  - misc - remaxFee - transactionCoordFee - techFee - eoInsurance).format('0,0.00');
        // alert("update agent net");
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK_Tffqf_2RClIjnuOPoz6wk1lZy4dAeg&libraries=places&callback=initAutocomplete"
        async defer></script>
</body>

</html>
