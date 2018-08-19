<?php include "./templates-agent/default-css.php" ?> 
<?php
// session_start();
// clearstatcache();
date_default_timezone_set('America/Los_Angeles');
if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
// require '../databaseConnection.php';
// $dbConn = getConnection();

$favoriteSql = "SELECT * FROM favorites WHERE userId = :userId";
$favoriteParameters = array();
$favoriteParameters[':userId'] = $_SESSION['userId'];
$favoriteStmt = $dbConn->prepare($favoriteSql);
$favoriteStmt->execute($favoriteParameters);
$favoriteResults = $favoriteStmt->fetchAll();


// $sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm FROM UsersInfo LEFT JOIN commInfo on UsersInfo.license = commInfo.license group by UsersInfo.license order by sold Desc ";
// $stmtRank = $dbConnRank->prepare($sqlRank);
// $stmtRank->execute();
// $rank = $stmtRank->fetchAll();
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


// $pendingListings = (int)$addedHouseResults['added'];
// for($i = 0; $i < sizeof($keys); $i++) 
// {
//     if($response[$keys[$i]]['listingAgentID'] == $licenseResult['mlsId'])
//     {
//         $pendingListings++;
//     }
// }

?>

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


            .top, .bottom {
                padding: 0 5px;    
            }

            

            .bottom{
                border-top: 1px solid #000;
                display: block;
            }

            .favoriteNoteRow{
                width: 100%;
            }
        </style>
        <style type "text/css">


        .blink {
            -webkit-animation: blink .75s linear infinite;
            -moz-animation: blink .75s linear infinite;
            -ms-animation: blink .75s linear infinite;
            -o-animation: blink .75s linear infinite;
             animation: blink .75s linear infinite;
        }
        @-webkit-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @-moz-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @-ms-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @-o-keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 1; }
            50.01% { opacity: 0; }
            100% { opacity: 0; }
        }
        </style>
<div class="box box-success" id="inContractTable" style="height:90%; overflow: auto;">
                                <div class="box-header">
                                    <h4 style='cursor:pointer;'>In-Contract Property<button type="button" onClick="collapseInContract()">
                                        <span class="fa fa-compress" aria-hidden="true"></span></button></h4>
                                    <button><a href="my-inventory.php">Add New In-Contract</a></button>
                                    <button style="margin-bottom: 10px" type="button" data-toggle="modal" data-target="#modal">Add New Transaction</button>
                                    <!-- <button onClick="showTransactionModal()">Add New Transaction</button> -->
                                </div>
                                <div class="box-body" style="height:100%;">
                                    <table class="table footable table-bordered table-striped" data-sorting="true" data-filtering="true" style="height:100%;">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Type</th>
                                            <th>Client</th>
                                            <th>Client 2</th>
                                            <th>Property</th>

                                            <th data-breakpoints="all">Info</th>
                                            <!-- <th data-breakpoints="all">Client Email</th> -->
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Accepted Date">Acc. </a></th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="Earnest Money Deposit">EMD </a>
                                            </th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="Disclosures">Seller Disc. </a>
                                            </th>

                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top" title="signedDisclousres">Exec. Disc. </a>
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

                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Close of Escrow">Misc. 1 </a></th>
                                            <th data-breakpoints="xs sm"><a class="dotted" href="#" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Close of Escrow">Misc. 2 </a></th>
                                            <th data-breakpoints="xs sm">Prev. Note</th>
                                            <th data-breakpoints="xs sm">Add Note</th>
                                            <th data-breakpoints="xs sm">To Past Clients</th>
                                            <!-- <th data-breakpoints="xs sm"></th> -->
                                            <th data-breakpoints="xs sm">Edit Dates</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $count = 1;
                                            foreach ($transResults as $trans) {
                                                # code...
                                                $day = $trans['accDay'];
                                                // if($count % 5 == 0)
                                                // {
                                                //     echo "<tr>";
                                                //     echo "<td></td>";
                                                //     echo "<td><b>Type</b></td>";
                                                //     echo "<td><b>Client</b></td>";
                                                //     echo "<td><b>Property</b></td>";
                                                //     echo "<td></td>";
                                                //     echo "<td><b>Acc.</b></td>";
                                                //     echo "<td><b>EMD</b></td>";
                                                //     echo "<td><b>Seller Disc.</b></td>";
                                                //     echo "<td><b>Sign Disc.</b></td>";
                                                //     echo "<td><b>Insp.</b></td>";
                                                //     echo "<td><b>Appr</b></td>";
                                                //     echo "<td><b>LC</b></td>";
                                                //     echo "<td><b>COE</b></td>";
                                                //     echo "<td><b>Misc 1</b></td>";
                                                //     echo "<td><b>Misc 2</b></td>";
                                                //     echo "<td><b>Notes</b></td>";
                                                //     echo "<td><b>Edit Dates</b></td>";
                                                //     echo "</tr>";
                                                // }
                                                $count++;
                                                echo '<tr id=inContract' . $trans['transId'] . ' >';
                                                // if ($trans['transType'] == 'Listing') {
                                                //     echo '<b>LIST</b>';
                                                // } else {
                                                //     echo '<b>BUY</b>';
                                                // }
                                                echo "<td class='inContractRowNumber'></td>";
                                                echo "<td>" . $trans['transType'] . "</td>";
                                            echo '<td class=clientName'. $trans['transId'] . ' ondblclick="editClientName(' . $trans['transId'] . ')">' . $trans['clientName'] . '</td>';
                                            echo '<td class=clientTwoName'. $trans['transId'] . ' ondblclick="editClientTwoName(' . $trans['transId'] . ')">' . $trans['clientTwoName'] . '</td>';
                                            echo '<td id=propertyAddress'. $trans['transId'] . ' ondblclick="editProperty(' . $trans['transId'] . ')">' . $trans['address'] . '</td>';
                                            // echo '<td id=clientNum' . $trans['transId'] . ' onClick="editClientNum(' . $trans['transId'] . ')">' . $trans['clientNum'] . '</td>';
                                            echo '<td><table border="1">
                                          
                                            <tr>
                                            <td></td>
                                            <td><b>Client</b></td>
                                            <td><b>Client 2</b></td>
                                            <td><b>Lender</b></td>
                                            <td><b>Escrow</b></td>
                                            <td><b>Agent</b></td>
                                            </tr>
                                            <tr>
                                            <td><b>Name</b></td>
                                            <td style="color:#0000FF;" class=clientName'. $trans['transId'] . ' ondblclick="editClientName(' . $trans['transId'] . ')">' . $trans['clientName'] . '</td>
                                            <td style="color:#0000FF;" class=clientTwoName'. $trans['transId'] . ' ondblclick="editClientTwoName(' . $trans['transId'] . ')">' . $trans['clientTwoName'] . '</td>
                                            <td style="color:#0000FF;" id=lendorName' . $trans['transId'] . ' ondblclick=editLendorInfo("Name",' . $trans['transId']  . ') >' . $trans['lendorName'] . '</td>
                                            <td style="color:#0000FF;" id=escrowName' . $trans['transId'] . ' ondblclick=editEscrowInfo("Name",' . $trans['transId']  . ') >' . $trans['escrowName'] . '</td>
                                            <td style="color:#0000FF;" id=agentName' . $trans['transId'] . ' ondblclick=editAgentInfo("Name",' . $trans['transId']  . ') >' . $trans['agentName'] . '</td>
                                            </tr>
                                            <tr>
                                            <td><b>Phone</b></td>
                                            <td style="color:#0000FF;" id=clientNum' . $trans['transId'] . ' ondblclick="editClientNum(' . $trans['transId'] . ')">' . $trans['clientNum'] . '</td>
                                            <td style="color:#0000FF;" id=clientTwoNum' . $trans['transId'] . ' ondblclick="editClientTwoNum(' . $trans['transId'] . ')">' . $trans['clientTwoNum'] . '</td>
                                            <td style="color:#0000FF;" id=lendorNum' . $trans['transId'] . ' ondblclick=editLendorInfo("Num",' . $trans['transId']  . ') >' . $trans['lendorNum'] . '</td>
                                            <td style="color:#0000FF;" id=escrowNum' . $trans['transId'] . ' ondblclick=editEscrowInfo("Num",' . $trans['transId']  . ') >' . $trans['escrowNum'] . '</td>
                                            <td style="color:#0000FF;" id=agentNum' . $trans['transId'] . ' ondblclick=editAgentInfo("Num",' . $trans['transId']  . ') >' . $trans['agentNum'] . '</td>
                                            </tr>
                                            <tr>
                                            <td><b>Email</b></td>
                                            <td style="color:#0000FF;" id=clientEmail'. $trans['transId'] . ' ondblclick="editClientEmail(\'' . $trans['transId'] . '\')">' . $trans['clientEmail'] . '</td>
                                            <td style="color:#0000FF;" id=clientTwoEmail'. $trans['transId'] . ' ondblclick="editClientTwoEmail(\'' . $trans['transId'] . '\')">' . $trans['clientTwoEmail'] . '</td>
                                            <td style="color:#0000FF;" id=lendorEmail' . $trans['transId'] . ' ondblclick=editLendorInfo("Email",' . $trans['transId']  . ') >' . $trans['lendorEmail'] . '</td>
                                            <td style="color:#0000FF;" id=escrowEmail' . $trans['transId'] . ' ondblclick=editEscrowInfo("Email",' . $trans['transId']  . ') >' . $trans['escrowEmail'] . '</td>
                                            <td style="color:#0000FF;" id=agentEmail' . $trans['transId'] . ' ondblclick=editAgentInfo("Email",' . $trans['transId']  . ') >' . $trans['agentEmail'] . '</td>
                                            </tr>
                                            
                                            </table></td>';

                                            echo '<td>
                                                <div class="btn-group">
                                                    ' . date('m/d/y', strtotime($day)) . ' 
                                                </div>
                                                <i class="fa fa-check-circle" style="color:#5cb85c"></i>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['emdDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
                                                  if($trans['emdComp'] != NULL && $trans['emdComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=emdComp' . $trans['transId'] . ' >Completed: ' . date('m/d/y', strtotime($trans['emdComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate("' . $trans['transId'] . '",\'emd\',this) value=' . $trans['emdComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=emdComp' . $trans['transId'] . '>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'emd\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  $today = new DateTime('today');
                                                  $emdOnTime = new DateTime($trans['accDay']);
                                                  $emdOnTime = $emdOnTime->add(new DateInterval('P'.$trans['emdDays'] .'D'));

                                                  $emdReduced = new DateTime($trans['accDay']);
                                                  $emdReduced = $emdReduced->add(new DateInterval('P'.$trans['emdDays'] .'D'));
                                                  $emdReduced = $emdReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['emdComp'] != NULL && $trans['emdComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] . 'emd' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $emdReduced && $today < $emdOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'emd' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $emdOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'emd' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['sellerDiscDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  
                                                  if($trans['sellerDiscRec'] != NULL && $trans['sellerDiscRec'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=recievedComp' . $trans['transId'] . '>Date Recieved: ' . date('m/d/y', strtotime($trans['sellerDiscRec'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'recieved\',this) value=' . $trans['sellerDiscRec'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=recievedComp' . $trans['transId'] . '>Date Recieved: N/A</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'recieved\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['sellerDiscComp'] != NULL && $trans['sellerDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=sellerComp' . $trans['transId'] . '>Completed: ' . date('m/d/y', strtotime($trans['sellerDiscComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'seller\',this) value=' . $trans['sellerDiscComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=sellerComp' . $trans['transId'] . '>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'seller\',this)></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $sellerOnTime = new DateTime($trans['accDay']);
                                                  $sellerOnTime = $sellerOnTime->add(new DateInterval('P'.$trans['sellerDiscDays'] .'D'));

                                                  $sellerReduced = new DateTime($trans['accDay']);
                                                  $sellerReduced = $sellerReduced->add(new DateInterval('P'.$trans['sellerDiscDays'] .'D'));
                                                  $sellerReduced = $sellerReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['sellerDiscComp'] != NULL && $trans['sellerDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'seller' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $sellerReduced && $today < $sellerOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'seller' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $sellerOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'seller' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['signedDiscDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
/////////
                                                
                                                  if($trans['signedDiscComp'] != NULL && $trans['signedDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=signedComp'. $trans['transId'] .'>Signed: ' . date('m/d/y', strtotime($trans['signedDiscComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\''.$trans['transId'] . '\',"signed",this)  value='.$trans['signedDiscComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=signedComp'. $trans['transId'] .'>Signed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\''.$trans['transId'] . '\',"signed",this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $signedOnTime = new DateTime($trans['accDay']);
                                                  $signedOnTime = $signedOnTime->add(new DateInterval('P'.$trans['signedDiscDays'] .'D'));

                                                  $signedReduced = new DateTime($trans['accDay']);
                                                  $signedReduced = $signedReduced->add(new DateInterval('P'.$trans['signedDiscDays'] .'D'));
                                                  $signedReduced = $signedReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['signedDiscComp'] != NULL && $trans['signedDiscComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'signed' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $signedReduced && $today < $signedOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'signed' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $signedOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'signed' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['genInspecDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['genInspecOrd'] != NULL && $trans['genInspecOrd'] != '0000-00-00')
                                                    {
                                                        echo '<li><a href="#" id=generalInspecOrd' . $trans['transId'] . '>Ordered: ' . date('m/d/y', strtotime($trans['genInspecOrd'])) . '</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"generalInspec",this)  value='.$trans['genInspecOrd'] . '></li>';
                                                    }
                                                    else
                                                    {
                                                        echo '<li><a href="#" id=generalInspecOrd' . $trans['transId'] . '>Ordered: N/A</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"generalInspec",this)></li>';
                                                    }

                                                    echo '<li role="separator" class="divider"></li>';

                                                  if($trans['genInspecComp'] != NULL && $trans['genInspecComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=generalInspecComp' . $trans['transId']  . '>Completed: ' . date('m/d/y', strtotime($trans['genInspecComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'generalInspec\',this) value=' . $trans['genInspecComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=generalInspecComp' . $trans['transId']  . '>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'generalInspec\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $genOnTime = new DateTime($trans['accDay']);
                                                  $genOnTime = $genOnTime->add(new DateInterval('P'.$trans['genInspecDays'] .'D'));

                                                  $genReduced = new DateTime($trans['accDay']);
                                                  $genReduced = $genReduced->add(new DateInterval('P'.$trans['genInspecDays'] .'D'));
                                                  $genReduced = $genReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if(($trans['genInspecComp'] != NULL && $trans['genInspecComp'] != '0000-00-00') || $trans['genInspecDays'] == "0")
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'generalInspec' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $genReduced && $today < $genOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'generalInspec' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $genOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'generalInspec' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>               
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                  ' . date('m/d/y', strtotime($day . ' + '. $trans['appraisalDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['apprOrdered'] != NULL && $trans['apprOrdered'] != '0000-00-00')
                                                    {
                                                        echo '<li><a href="#" id=apprOrd' .$trans['transId'].'>Ordered: ' . date('m/d/y', strtotime($trans['apprOrdered'])) . '</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"appr",this) value='. $trans['apprOrdered'].'></li>';
                                                    }
                                                    else
                                                    {
                                                        echo '<li><a href="#" id=apprOrd' .$trans['transId'].'>Ordered: N/A</a>
                                                        <input type="date" onChange=saveOrdDate(\''.$trans['transId'] . '\',"appr",this)></li>';
                                                    }
                                                    
                                                echo '<li role="separator" class="divider"></li>';

                                                  if($trans['apprComp'] != NULL && $trans['apprComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=apprComp' . $trans['transId'] . '>Completed: ' . date('m/d/y', strtotime($trans['apprComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'appr\',this) value='. $trans['apprComp'] . ' ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=apprComp' . $trans['transId'] . ' >Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'appr\',this)></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                
                                                    
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $apprOnTime = new DateTime($trans['accDay']);
                                                  $apprOnTime = $apprOnTime->add(new DateInterval('P'.$trans['appraisalDays'] .'D'));

                                                  $apprReduced = new DateTime($trans['accDay']);
                                                  $apprReduced = $apprReduced->add(new DateInterval('P'.$trans['appraisalDays'] .'D'));
                                                  $apprReduced = $apprReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['apprComp'] != NULL && $trans['apprComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'appr' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $apprReduced && $today < $apprOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'appr' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $apprOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'appr' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['lcDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';
                                                  if($trans['lcComp'] != NULL && $trans['lcComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=lcComp' . $trans['transId'] .'>Completed: ' . date('m/d/y', strtotime($trans['lcComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'lc\',this) value=' . $trans['lcComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=lcComp' . $trans['transId'] .'>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'lc\',this)></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $lcOnTime = new DateTime($trans['accDay']);
                                                  $lcOnTime = $lcOnTime->add(new DateInterval('P'.$trans['lcDays'] .'D'));

                                                  $lcReduced = new DateTime($trans['accDay']);
                                                  $lcReduced = $lcReduced->add(new DateInterval('P'.$trans['lcDays'] .'D'));
                                                  $lcReduced = $lcReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['lcComp'] != NULL && $trans['lcComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'lc' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $lcReduced && $today < $lcOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'lc' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $lcOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'lc' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ' . date('m/d/y', strtotime($day . ' + '. $trans['coeDays'] . ' days' )) . ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  if($trans['coeOrgDate'] != NULL && $trans['coeOrgDate'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Original Due Date: ' . date('m/d/y', strtotime($trans['coeOrgDate'])) . '</a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Original Due Date: N/A </a></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }

                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['coeComp'] != NULL && $trans['coeComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#" id=coeComp'. $trans['transId'] .'>Completed: ' . date('m/d/y', strtotime($trans['coeComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'coe\',this) value=' . $trans['coeComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#" id=coeComp'. $trans['transId'] .'>Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'coe\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }
                                                    // <li><a href="#">Ordered: 12/12/12</a></li>
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $coeOnTime = new DateTime($trans['accDay']);
                                                  $coeOnTime = $coeOnTime->add(new DateInterval('P'.$trans['coeDays'] .'D'));

                                                  $coeReduced = new DateTime($trans['accDay']);
                                                  $coeReduced = $coeReduced->add(new DateInterval('P'.$trans['coeDays'] .'D'));
                                                  $coeReduced = $coeReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['coeComp'] != NULL && $trans['coeComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'coe' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $coeReduced && $today < $coeOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'coe' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $coeOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'coe' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ';
                                                    if($trans['miscOneDays']  == "0")
                                                      echo "mm/dd/yyyy";
                                                    else
                                                      echo  date('m/d/y', strtotime($day . ' + '. $trans['miscOneDays'] . ' days' ));
                                                  echo ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  echo '<li><a href="#">' . $trans['miscOneName'] . '</a></li>';

                                                  echo '<li role="separator" class="divider"></li>';
                                                  if($trans['miscOneComp'] != NULL && $trans['miscOneComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['miscOneComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscOne\',this) value=' . $trans['miscOneComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscOne\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }

                                                 
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $miscOneOnTime = new DateTime($trans['accDay']);
                                                  $miscOneOnTime = $miscOneOnTime->add(new DateInterval('P'.$trans['miscOneDays'] .'D'));

                                                  $miscOneReduced = new DateTime($trans['accDay']);
                                                  $miscOneReduced = $miscOneReduced->add(new DateInterval('P'.$trans['miscOneDays'] .'D'));
                                                  $miscOneReduced = $miscOneReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if ($trans['miscOneDays'] == "0")
                                                  {
                                                    echo "";
                                                  }
                                                  else if($trans['miscOneComp'] != NULL && $trans['miscOneComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'miscOne' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $miscOneReduced && $today < $miscOneOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscOne' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $miscOneOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscOne' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }



                                            echo '</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    ';
                                                    if($trans['miscTwoDays'] == "0")
                                                      echo "mm/dd/yyyy";
                                                    else
                                                      echo date('m/d/y', strtotime($day . ' + '. $trans['miscTwoDays'] . ' days' ));
                                                  echo ' <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">';

                                                  echo '<li><a href="#">' . $trans['miscTwoName'] . '</a></li>';

                                                  echo '<li role="separator" class="divider"></li>';

                                                  if($trans['miscTwoComp'] != NULL && $trans['miscTwoComp'] != '0000-00-00')
                                                  {
                                                    echo '<li><a href="#">Completed: ' . date('m/d/y', strtotime($trans['miscTwoComp'])) . '</a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscTwo\',this) value=' . $trans['miscTwoComp'] . '></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                  }
                                                else
                                                {
                                                    echo '<li><a href="#">Completed: N/A </a>
                                                    <input type="date" onChange=saveCompDate(\'' . $trans['transId'] . '\',\'miscTwo\',this) ></li>';
                                                    // echo '<li role="separator" class="divider"></li>';
                                                }

                                                  
                                                  echo '</ul>
                                                </div>';
                                                  echo '&nbsp';
                                                  // $today = new DateTime('today');
                                                  $miscTwoOnTime = new DateTime($trans['accDay']);
                                                  $miscTwoOnTime = $miscTwoOnTime->add(new DateInterval('P'.$trans['miscTwoDays'] .'D'));

                                                  $miscTwoReduced = new DateTime($trans['accDay']);
                                                  $miscTwoReduced = $miscTwoReduced->add(new DateInterval('P'.$trans['miscTwoDays'] .'D'));
                                                  $miscTwoReduced = $miscTwoReduced->modify('-3 days');

                                                  // $emdOnTime = strtotime($day . ' + '. ($trans['emdDays'] - 3) . ' days' );
                                                  if($trans['miscTwoDays'] == "0")
                                                  {
                                                    echo "";
                                                  }
                                                  else if($trans['miscTwoComp'] != NULL && $trans['miscTwoComp'] != '0000-00-00')
                                                  {
                                                    echo '<i id=status' . $trans['transId'] .  'miscTwo' . ' class="fa fa-check-circle" style="color:#5cb85c"></i>';
                                                  }
                                                    else if($today >= $miscTwoReduced && $today < $miscTwoOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscTwo' . ' class="fa fa-warning" style="color:#ffae42"></i>';
                                                    }
                                                    else if($today >= $miscTwoOnTime)
                                                    {
                                                        echo '<i id=status' . $trans['transId'] .  'miscTwo' . ' class="fa fa-flag blink" style="color:#d9534f"></i>';
                                                    }
                                            echo '</td>
                                            <td>' . substr($trans['notes'],0,15)  . '</td>
                                           <td> <button onClick=takeNote(' .$trans['transId'] . ')>  <i class="fa fa-edit" style="color:#000000"></i> </button></td>';
                                           echo '<td class="fa fa-archive" style="text-align: center;" onClick="sendToPastCleints(' . $trans['transId'] . ')"></td>';
                                           
                                           echo '<td>';
                                           ?>
                                           <?php include "../staff/editDates.php"; ?>
                                           <?php

                                           echo '</td>
                                        </tr>';
                                    }
                                            ?>

                                        </tbody>
                                    </table>
                                </div> <!-- /.box-body -->
                            </div> <!-- /.box -->