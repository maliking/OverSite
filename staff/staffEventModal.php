<?php
// session_start();
// require("../databaseConnection.php");
// $dbConn = getConnection();

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

$keys = array_keys($response);
?>
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel">Add a New Date</h3>
            </div>
            <div class="modal-body">

                <!-- content goes here -->
                <form>
                    <div class="form-group">
                        <label for="agent">Agent:</label>
                        <select class="form-control" id="agentName" onChange="hideHouses()">
                            <option value="">--Select Agent--</option>
                            <?php
                            foreach($agentResults as $agent)
                            {
                                echo "<option id=agent" . $agent['mlsId'] . " value=" . $agent['userId'] . " >" 
                                . $agent['firstName'] . " " . $agent['lastName'] . "</option>";
                            }
                            ?>
                            
                           <!--  <option>Jane Smith</option> -->
                        </select>

                        <br>
                        <label for="address">Address:</label>
                        <select class="form-control" id="houseId">
                            <option value="" id="empty">--Select House--</option>
                            <?php
                            for ($i = 0; $i < sizeof($keys); $i++) 
                            {
                                echo "<option id=agent" . $response[$keys[$i]]['listingAgentID'] . " value=" . $response[$keys[$i]]['listingID'] . " >"
                                 . $response[$keys[$i]]['address'] . " " .$response[$keys[$i]]['cityName'] . " " . 
                                $response[$keys[$i]]['state'] . "</option>";
                            }
                            ?>
                            <!-- <option>1234 House St.</option>
                            <option>492 Example Dr.</option> -->
                        </select>

                        <br>
                        <label>Date In-Contract:</label>
                        <div>
                            <input type="date" name="accDate" id="newAccDate">
                        </div>
                        <!-- <div class="radio">
                            <label><input type="radio" name="optradio">EMD - Earnest Money Deposit</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Seller Disclosure</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Inspection</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">Appr. - Appraisal</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">LC - Loan Contingences</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio">COE - Close of Escrow</label>
                        </div> -->

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" role="button" id="resetButton" class="btn btn-success btn-block" data-dismiss="modal" onClick="addNewTransaction()" >Submit</button>
            </div>
        </div>
    </div>
</div>


<!--
<div class="modal modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">

                    <div class="row">
                        <div class="box">

                            <div class="box-body no-padding">

                                <form>
                                    <label for="address"> Address</label>  <select id="address">
                                        <option value="">1234 House st</option>
                                        <option value="">5678 App Lane</option>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="agent">Agent</label> <select id="agent">
                                        <option value="">John Doe</option>
                                        <option value="">Jane Smith</option>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="type">Type</label> <select id="type">
                                        <option value="">APRV</option>
                                        <option value="">EMD</option>
                                        <option value="">DISC</option>
                                        <option value="">INSP</option>
                                        <option value="">APPR</option>
                                        <option value="">LC</option>
                                        <option value="">COE</option>
                                    </select>
                                    <br>
                                    <br>
                                    <label for="datepicker">Date</label>
                                    <input type="text"  class="form-control pull-right" id="datepicker" placeholder="&#xf073;">
                                    <br>
                                    <br>
                                </form>
                            </div>
                             /.box-body 
                        </div>
                         /.box 




                    </div>


                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close
                    </button>
                    <button type="button" class="btn btn-default">Save 
                    </button>
                </div>
            </div>
        </div>
    </div>
     /.modal-content 
</div>
 /.modal-dialog -->
