<?php
// session_start();
// require("../databaseConnection.php");
// $dbConn = getConnection();

$allAgentsSql = "SELECT firstName, lastName, userId, mlsId FROM UsersInfo WHERE userId != :userId AND userType != \"0\" ";
$allAgentParam = array();
$allAgentParam['userId'] = $_SESSION['userId'];
$allAgentStmt = $dbConn->prepare($allAgentsSql);
$allAgentStmt->execute($allAgentParam);
$allAgentResults = $allAgentStmt->fetchAll();

$agentMls = "SELECT firstName, lastName, userId, mlsId FROM UsersInfo WHERE userId = :userId";
$agentMlsParam = array();
$agentMlsParam['userId'] = $_SESSION['userId'];
$agentMlsStmt = $dbConn->prepare($agentMls);
$agentMlsStmt->execute($agentMlsParam);
$agentMlsRes = $agentMlsStmt->fetch();

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
                        <p hidden id="agentName"><?php echo $_SESSION['userId']; ?></p>
                        <p hidden id="agentMlsId"><?php echo $agentMlsRes['mlsId']; ?></p>
                       <!--  <label for="agent">Agent:</label>
                        <select class="form-control" id="agentName" onChange="hideHouses()">
                            <option value="">--Select Agent--</option>
                            <?php
                            //foreach($agentResults as $agent)
                            {
                            //    echo "<option id=agent" . $agent['mlsId'] . " value=" . $agent['userId'] . " >" 
                            //    . $agent['firstName'] . " " . $agent['lastName'] . "</option>";
                            }
                            ?>
                            
                        </select>

                        <br> -->

                        
                        <label for="type">Agency Type:</label>
                        <select class="form-control" id="typeEntered" onchange="displayLabelAgentInfo()">
                            <option value="" id="emptyType">--Select House--</option>
                            <option value="buyer" id="buyer">Buyer</option>
                            <option value="seller" id="seller">Seller</option>
                            <option value="dual" id="dual">Dual</option>
                            
                        </select>

                        <br>

                        <div hidden id="agentInfoDiv">
                        <label for="sellBuyAgent" id="agentInfoLabel"></label>
                        <!-- <input type="text" id="coAgentName" value="" placeholder="If applicable"> -->

                        <select class="form-control" id="agentInfo">
                            <option value="" id="empty">--Select Agent--</option>
                            <?php
                            foreach($allAgentResults as $agent)
                            {
                                echo "<option value=" . $agent['userId'] . " >" . $agent['firstName'] . " " . $agent['lastName'] . "</option>";
                            }
                            ?>
                            <!-- <option>1234 House St.</option>
                            <option>492 Example Dr.</option> -->
                        </select>

                        <label for="agentInfoOther" id="agentInfoOther">Other: </label>
                        <input type="text" id="agentInfoOtherName" value="" placeholder="If applicable">
                    </div>

                    <br>

                        <label for="coAgent" id="coAgentLabel">Co-Agent Name: </label>
                        <!-- <input type="text" id="coAgentName" value="" placeholder="If applicable"> -->

                        <select class="form-control" id="coAgentId">
                            <option value="" id="empty">--None--</option>
                            <?php
                            foreach($allAgentResults as $agent)
                            {
                                echo "<option value=" . $agent['userId'] . " >" . $agent['firstName'] . " " . $agent['lastName'] . "</option>";
                            }
                            ?>
                            <!-- <option>1234 House St.</option>
                            <option>492 Example Dr.</option> -->
                        </select>

                        <label for="coAgentOther" id="coAgentOther">Non-In House Agent Name: </label>
                        <input type="text" id="coAgentNameOther" value="" placeholder="If applicable" onChange="showOutsideAgentDiv()">

                        <br>
                        
                        <div hidden id="outsideAgentInfoDiv">
                        <label for="outsideAgent" id="outSideAgentInfo"></label>
                        

                        <label for="outsideAgentAgencyField" id="outSideAgentAgencyField">Agency: </label>
                        <input type="text" id="outSideAgentAgency" value="">
                        <br>
                       <!--  <label for="outsideAgentNameField" id="outSideAgentNameField">Name: </label>
                        <input type="text" id="outSideAgentName" value="">
                        <br> -->
                        <label for="outsideAgentPhoneField" id="outSideAgentPhoneField">Phone: </label>
                        <input type="text" id="outSideAgentPhone" value="">
                        <br>
                        <label for="outsideAgentEmailField" id="outSideAgentEmailField">Email: </label>
                        <input type="text" id="outSideAgentEmail" value="">

                    </div>

                    
                        <br>
                        <label for="address">Office Listing:</label>
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
                        
                        </select>

                        
                        

                        
                        <br>

                            <strong>OR ENTER MANUALLY</strong>
                        <br>
                        Address:&nbsp&nbsp<input type="text" name="address" id="inputAddress" placeholder="Address"><br>
                        City:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="city" id="inputCity" placeholder="City"><br>
                        State:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="state" id="inputState" placeholder="State"><br>
                        Zip:&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="zip" id="inputZip" placeholder="Zip"><br>

                        <br>
                        <label>Date In-Contract:</label>
                        <div>
                            <input type="date" name="accDate" id="newAccDate">
                        </div>
                        
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" role="button" id="resetButton" class="btn btn-success btn-block" onClick="addNewTransaction()" >Submit</button>
            </div>
        </div>
    </div>
</div>


