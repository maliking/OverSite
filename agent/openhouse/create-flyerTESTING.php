<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
clearstatcache();
$listingId = $_GET['id'];

require '../../databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM  HouseInfo WHERE listingId = :listingId";
$stmt = $dbConn->prepare($sql);
$namedParameters = array();
$namedParameters[':listingId'] = $listingId;
$stmt->execute($namedParameters);
$result = $stmt->fetch();




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
        <title>Re/Max Salinas | Home</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    </head>

    <body class="hold-transition skin-black sidebar-mini">
            <!-- END TEMPLATE nav.php INCLUDE -->

            <p>If you click on me, I will disappear.</p>
            <p>Click me away!</p>
            <p>Click me too!</p>



            <!-- Content Wrapper. Contains page content -->

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section>
                    <section class="content-header" style="margin-top: 50px; padding-top: 30px; padding-bottom: 20px;">
                        <h1 class="col-md-6 col-sm-6 col-xs-12">
                            Create New Flyer
                        </h1>
                        <h1 class="col-md-3 col-sm-3 col-xs-6">
                            Current Flyer
                        </h1>

                        <h5 class="col-md-3 col-sm-3 col-xs-6">
                            <form id="form-demo" onsubmit="return false">
                                <p>Upload your own flyer</p>
                                <input type="file" id="image" name="file"><br>
                                <button id="button-send">Send</button>
                            </form>
                           
                        </h5>
                    </section>
                    <section class="content">
                        <div class="col-md-6 col-sm-6 col-xs-12">


                            <div class="row" style="margin-top:20px;">

                                <!-- Smart Wizard -->
                                <div id="wizard" class="form_wizard wizard_horizontal">
                                    <!--class="swMain"-->
                                    <ul class="wizard_steps anchor">
                                        <li>

                                        </li>
                                        <li>
                                            <a href="#step-1">
                                                <label class="stepNumber">Step 1</label>
                                                <span class="stepDesc">

            <p>If you click on me, I will disappear.</p>
            <p>Click me away!</p>
            <p>Click me too!</p>
             <br />
             <small>Step 1 Select Images</small>
          </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#step-2">
                                                <label class="stepNumber">Step 2</label>
                                                <span class="stepDesc">
            <br />
             <small>Step 2 Listing Information</small>
          </span>
                                            </a>
                                        </li>
                                       <!--  <li>
                                            <a href="#step-3">
                                                <label class="stepNumber">Step 3</label>
                                                <span class="stepDesc">
             <br />
             <small>Step 3 Listing Description</small>
          </span>
                                            </a>
                                        </li> -->

                                    </ul>

                                    <div id="step-1">
                                        <h2 class="StepTitle">Step 1: Select flyer images</h2>
                                        <div class="row" id="imageSerialize">

                                           

                                            <?php
                                            for($i = 0; $i < sizeof($keys); $i++)
                                            {

                                                if($response[$keys[$i]]['listingID'] == $listingId)
                                                {
                                                    $index = $i;
                                                    for($j = 0; $j < (int)$response[$keys[$i]]['image']['totalCount']; $j++ )
                                                    {
                                                        echo '<label class="item col-md-4 col-sm-4 col-xs-6">
                                                                <input class="js-switch" type="checkbox" name="imageURL" value="' . $response[$keys[$i]]['image'][$j]['url']  . '"/> 
                                                                <img src="' . $response[$keys[$i]]['image'][$j]['url']  . '" style="width:100%; height:100%" >
                                                            </label>';
                                                    }
                                                    break;
                                                }
                                            }
                                            ?>
                                        </div>

                                    </div>



                                    
                                    <!-- <div id="step-3">
                                        <h2 class="StepTitle">Step 3: Select listing description</h2>
                                        <div class="form-group">
                                            <label>
                             <?php// echo '<input type="checkbox" class="js-switch" name="description" value="' . $response[$keys[$index]]['remarksConcat'] .'"/>'; ?>  <p> <?php echo $response[$keys[$index]]['remarksConcat']?></p>
                            </label>
                                            <label>
                              <input type="checkbox" class="js-switch" />No Description
                            </label>



                                        </div>
                                    </div> -->

                                </div>
                                <!-------end smart wizard-->
                            </div>

                        </div>

                        <?php echo '<input type="hidden" name="address" value="'. $response[$keys[$index]]['address'] . '" />'; ?>
                        <input type="hidden" name="city" value=<?php echo $response[$keys[$index]]['cityName'];?>/>
                        <input type="hidden" name="state" value=<?php echo $response[$keys[$index]]['state'];?>/>
                        <input type="hidden" name="zip" value=<?php echo $response[$keys[$index]]['zipcode'];?>/>
                        <input type="hidden" name="price" value=<?php echo $response[$keys[$index]]['listingPrice'];?>/>
                        <input type="hidden" name="mlsId" value=<?php echo $listingId;?>/>
                        <?php echo '<input type="hidden" name="description" value="' . $response[$keys[$index]]['remarksConcat'] . '" />'; ?>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div>
                                <?php
                                    if($result['flyer'] == NULL)
                                    {
                                        echo '<img id="noPdf" src="listingImg/flyerPlaceHolder.png" alt="pdf" style="width:80%; margin-top:10px;">';
                                    }
                                    else
                                    {
                                        // echo '<img src="../../uploadFlyers/' . $result['flyer'] . '" alt="pdf" style="width:80%; margin-top:10px;">';

                                        // echo '<iframe id="pdf" src="../../../test/' . $result['flyer'] . '" style="width:600px; height:600px;" frameborder="0"></iframe>';

                                        echo '<iframe id="pdf" src="../../uploadFlyers/' . $result['flyer']  . '" 
                                        style="width:600px; height:500px;" frameborder="0"></iframe>';
                                    }
                                ?>
                                
                            </div>
                        </div>

                    </section>

                </section>


            </div>
        </div>



            
        <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
            $(document).ready(function(){
                $("p").click(function(){
                    $(this).hide();
                });
            });
            /*
             * For demonstration porpuse, all JavaScript code was incorporated in
             * the HTML file. But when developing your application, your JavaScript code
             * should be in a separated file. Check this page for more information:
             * https://developer.yahoo.com/performance/rules.html#external
             */
            $('.js-switch :checkbox').change(function () {
                alert("Hello! I am an alert box!!");
                var $cs = $(this).closest('.js-switch').find(':checkbox:checked');
                if ($cs.length > 3) {
                    this.checked = false;
                }
            });
        </script>

    </body>

    </html>
