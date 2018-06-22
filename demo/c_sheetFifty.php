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
                }
            };
            xhttp.open("GET", "agentCommission.php?license=" + x, true);
            xhttp.send();
        }

        function setPercentage(commission) {
            var housePrice = document.getElementById("housePrice").value;

            document.getElementById("percentage").value = ((commission.replace(/,/g,"") / housePrice.replace(/,/g,"")) * 100) + "%";
            document.getElementById("gross-comm").value = formatNumber(commission.replace(/,/g,""));
        }
        function addComa(number)
        {   
            document.getElementById("housePrice").value = formatNumber(number.replace(/,/g,""));
        }
        function getOwners() {

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
                            <h4>Commission Sheet Breakdown (50/50)</h4>
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
                                                                    <?php
                                                                    $license = "";
                                                                    foreach ($results as $result) {
                                                                        if ($result['userType'] == 0 || $result['license'] == $_SESSION['license']) {
                                                                        } else
                                                                            echo "<option value='" . $result['license'] . "'>" . $result['firstName'] . " " . $result['lastName'] . "</option>";
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
                                                                <select class="form-control" id="houseId"
                                                                        onchange="getOwners()" name="propertyAddress">

                                                                    <?php

                                                                    foreach ($houses as $house) {
                                                                        echo "<option value='" . $house['houseId'] . "'>" . $house['address'] . " " . $house['city'] . " " . $house['state'] . " " . $house['zip'] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
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
                                                            <div class="form-group col-xs-4">
                                                                <label class="control-label  " for="datetimepicker4">Check
                                                                    Number</label>
                                                                <input type="text" class="form-control" id="check"
                                                                       name="checkNum" placeholder="">
                                                            </div>

                                                            <!-- Commission Lead Type -->
                                                            <div class="form-group col-xs-2">
                                                                <label for="leadType">Lead Type</label>
                                                                <select required class="form-control" id="leadType"
                                                                        name="leadType">
                                                                        <option>Select Lead Type</option>
                                                                        <option value="Zillow">Zillow</option>
                                                                        <option value="Realtor.com">Realtor.com</option>
                                                                        <option value="Referral">Referral</option>
                                                                        <option value="Past Client">Past Client</option>
                                                                        <option value="Open House">Open House</option>

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
                                                                           name="brokerFee" placeholder="" readonly>
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
                                                                           id="trans-coor" placeholder="" value="200.00"
                                                                           readonly>
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">TC. Tech
                                                                    Fee</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control" id="tech"
                                                                           placeholder="" value="50.00" readonly>
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">E&O
                                                                    Insurance</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="eo_insurance" placeholder=""
                                                                           value="99.00" readonly>
                                                                </div>


                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label" for="pwd">RE/MAX
                                                                    Fee</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control"
                                                                           id="remaxFee" name="remaxFee" placeholder=""
                                                                           onchange="calculateCommissionFifty()">
                                                                </div>

                                                            </div>
                                                            <div class="clearfix"></div>

                                                            <div class="form-group col-xs-12">
                                                                <label class="col-xs-9 control-label"
                                                                       for="pwd">*Misc.</label>
                                                                <div class="col-xs-3">
                                                                    <input type="text" class="form-control" id="misc"
                                                                           name="miscell" placeholder=""
                                                                           onchange="calculateCommissionFifty()">
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
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK_Tffqf_2RClIjnuOPoz6wk1lZy4dAeg&libraries=places&callback=initAutocomplete"
        async defer></script>
</body>

</html>
