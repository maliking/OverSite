<div class="box box-success">
                                <div class="box-header">
                                    <h4>In-Contract Properties</h4>
                                    <div class="col-xs-2" >
                                    <button style="margin-bottom: 10px" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal">Add New Transaction</button>
                                  </div>
                                    <!-- <button><a href="my-inventory.php">Add New In-Contract</a></button>
                                    <button onClick="showTransactionModal()">Add New Transaction</button> -->
                                </div>
                                <div class="box-body" style="height:300px; overflow: auto;">
                                    <table class="table footable table-bordered table-striped" data-filtering="true">
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Agent</th>
                                            <th>Client</th>
                                            <th>Property</th>

                                            <th data-breakpoints="all">Client Number</th>
                                            <th data-breakpoints="all">Client Email</th>
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
                                                                            data-placement="top" title="signedDisclousres">Sign. Disc. </a>
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
                                            <th data-breakpoints="xs sm">Notes</th>
                                            <!-- <th data-breakpoints="xs sm"></th> -->
                                            <th data-breakpoints="xs sm">Edit Dates</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            <?php

                                            foreach ($transResults as $trans) {
                                                # code...
                                                $day = $trans['accDay'];

                                                echo '<tr id=inContract' . $trans['transId'] . ' ><td>';
                                                // if ($trans['transType'] == 'Listing') {
                                                //     echo '<b>LIST</b>';
                                                // } else {
                                                //     echo '<b>BUY</b>';
                                                // }
                                                echo $trans['transType'];
                                                echo '</td>';
                                                echo '<td>' . $trans['fName'] . " " .$trans['lName'];
                                            echo '<td id=clientName'. $trans['transId'] . ' onClick="editClientName(' . $trans['transId'] . ')">' . $trans['clientName'] . '</td>
                                            <td>' . $trans['address'] . '</td>
                                            <td id=clientNum' . $trans['transId'] . ' onClick="editClientNum(' . $trans['transId'] . ')">' . $trans['clientNum'] . '</td>
                                            <td id=clientEmail'. $trans['transId'] . ' onClick="editClientEmail(' . $trans['transId'] . ')">' . $trans['clientEmail'] . '</td>
                                            <td>
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
                                                  if($trans['genInspecComp'] != NULL && $trans['genInspecComp'] != '0000-00-00')
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
                                                  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                                                  if($trans['miscOneDays'] == "0")
                                                    echo "mm/dd/yyyy";
                                                  else
                                                    echo date('m/d/y', strtotime($day . ' + '. $trans['miscOneDays'] . ' days' )); 
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
                                                  if($trans['miscOneDays'] == "0")
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
                                                      echo  date('m/d/y', strtotime($day . ' + '. $trans['miscTwoDays'] . ' days' ));
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
                                            <td id=' . $trans['transId'] . ' onClick="takeNote(' . $trans['transId'] . ')" > ' . $trans['notes']  . ' </td>';
                                           // <td> <button onClick=takeTransNote(' .$trans['transId'] . ')>  <i class="fa fa-edit" style="color:#d3d3d3"></i> </button></td>
                                           echo '<td>';
                                           ?>
                                           <?php include "staff/editDates.php"; ?>
                                           <?php

                                           echo '</td>
                                        </tr>';
                                    }
                                            ?>

                                        </tbody>
                                    </table>
                                </div> <!-- /.box-body -->
                            </div> <!-- /.box -->