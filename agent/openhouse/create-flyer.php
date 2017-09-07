<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
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

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-oh/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <!-- Custom Theme Style ...Added for smart wizard-->
        <link href="../build/css/custom.min.css" rel="stylesheet">
    </head>

    <body class="hold-transition skin-black sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">
            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-oh/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-oh/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->




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
                                        <li>
                                            <a href="#step-3">
                                                <label class="stepNumber">Step 3</label>
                                                <span class="stepDesc">
             <br />
             <small>Step 3 Listing Description</small>
          </span>
                                            </a>
                                        </li>

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
                                                                <input type="checkbox" class="js-switch" name="imageURL" value="' . $response[$keys[$i]]['image'][$j]['url']  . '"/> 
                                                                <img src="' . $response[$keys[$i]]['image'][$j]['url']  . '" style="width:100%; height:100%" >
                                                            </label>';
                                                    }
                                                    break;
                                                }
                                            }
                                            ?>
                                        </div>

                                    </div>



                                    <div id="step-2">
                                        <h2 class="StepTitle">Step 2: Select flyer content</h2>
                                        <div class="form-group">
                                            <label>
                                          <input type="checkbox" class="js-switch" name="flyerContent" value=<?php echo $response[$keys[$index]]['bedrooms']?>/> <?php echo $response[$keys[$index]]['bedrooms']?> Bedrooms
                                        </label> 
                                        <br />
                                        <label>
                                          <input type="checkbox" class="js-switch" name="flyerContent" value=<?php echo $response[$keys[$index]]['fullBaths']?>/> <?php echo $response[$keys[$index]]['fullBaths']?> Bathrooms
                                        </label> 
                                        <br />
                                        <label>
                                          <input type="checkbox" class="js-switch" name="flyerContent" value=<?php echo $response[$keys[$index]]['sqFt']?>/> <?php echo $response[$keys[$index]]['sqFt']?> SQFT
                                        </label>
                                        <br /> 
                                        <label>
                                          <input type="checkbox" class="js-switch" name="flyerContent" value=<?php echo $response[$keys[$index]]['listingID']?>/> <?php echo $response[$keys[$index]]['listingID']?> MLSID
                                        </label> 
                                       


                                        </div>
                                    </div>
                                    <div id="step-3">
                                        <h2 class="StepTitle">Step 3: Select listing description</h2>
                                        <div class="form-group">
                                            <label>
                             <?php echo '<input type="checkbox" class="js-switch" name="description" value="' . $response[$keys[$index]]['remarksConcat'] .'"/>'; ?>  <p> <?php echo $response[$keys[$index]]['remarksConcat']?></p>
                            </label>
                                            <label>
                              <input type="checkbox" class="js-switch" />No Description
                            </label>



                                        </div>
                                    </div>

                                </div>
                                <!-------end smart wizard-->
                            </div>

                        </div>

                        <?php echo '<input type="hidden" name="address" value="'. $response[$keys[$index]]['address'] . '" />'; ?>
                        <input type="hidden" name="city" value=<?php echo $response[$keys[$index]]['cityName'];?>/>
                        <input type="hidden" name="state" value=<?php echo $response[$keys[$index]]['state'];?>/>
                        <input type="hidden" name="zip" value=<?php echo $response[$keys[$index]]['zipcode'];?>/>
                        <input type="hidden" name="price" value=<?php echo $response[$keys[$index]]['listingPrice'];?>/>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div>
                                <?php
                                    if($result['flyer'] == NULL)
                                    {
                                        echo '<img src="listingImg/flyerPlaceHolder.png" alt="pdf" style="width:80%; margin-top:10px;">';
                                    }
                                    else
                                    {
                                        // echo '<img src="../../uploadFlyers/' . $result['flyer'] . '" alt="pdf" style="width:80%; margin-top:10px;">';
                                        echo '<iframe src="../../uploadFlyers/' . $result['flyer']  . '" 
                                        style="width:600px; height:500px;" frameborder="0"></iframe>';
                                    }
                                ?>
                                
                            </div>
                        </div>

                    </section>

                </section>


            </div>
        </div>


        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-oh/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-oh/default-js.php" ?>
        <!-- END TEMPLATE default-js.php INCLUDE -->

        <!--BEGIN Smart wizard links-->
        <script type="text/javascript" src="../jQuery-Smart-Wizard/js/jquery-1.4.2.min.js"></script>
        <!--                    <link href="../jQuery-Smart-Wizard/styles/smart_wizard.css" rel="stylesheet" type="text/css">-->
        <!--                            <link href="../jQuery-Smart-Wizard/styles/demo_style.css" rel="stylesheet" type="text/css">-->
        <script type="text/javascript" src="../jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

        <!--for smart wizard css-->
        <!-- Custom Theme Scripts -->
        <script src="../build/js/custom.min.js"></script>

        <!--END Smart wizard links-->


        <script type="text/javascript">
            $(document).ready(function() {
                // Initialize Smart Wizard with ajax content load and cache disabled
                $('#wizard').smartWizard({
                    contentURL: 'services/ajaxcontents.php',
                    contentCache: false
                });
            });

            $('#wizard').smartWizard({
                // Properties
                selected: 0, // Selected Step, 0 = first step   
                keyNavigation: true, // Enable/Disable key navigation(left and right keys are used if enabled)
                enableAllSteps: false, // Enable/Disable all steps on first load
                transitionEffect: 'fade', // Effect on navigation, none/fade/slide/slideleft
                contentURL: null, // specifying content url enables ajax content loading
                contentURLData: null, // override ajax query parameters
                contentCache: true, // cache step contents, if false content is fetched always from ajax url
                cycleSteps: false, // cycle step navigation
                enableFinishButton: false, // makes finish button enabled always
                hideButtonsOnDisabled: false, // when the previous/next/finish buttons are disabled, hide them instead
                errorSteps: [], // array of step numbers to highlighting as error steps
                labelNext: 'Next', // label for Next button
                labelPrevious: 'Previous', // label for Previous button
                labelFinish: 'Finish', // label for Finish button        
                noForwardJumping: false,
                // Events
                onLeaveStep: null, // triggers when leaving a step
                onShowStep: null, // triggers when showing a step
                onFinish: finishClicked // triggers when Finish button is clicked
            });

            function finishClicked()
            {
                if($("input[name='imageURL']:checked").length > 5)
                {
                    alert("Only choose 5 pictures.");
                }
                else if($("input:[name='imageURL']checked").length < 5)
                {
                    alert("Choose at least 5 pictures.");
                }
                else if($("input:[name='flyerContent']checked").length > 4)
                {
                    alert("Only choose 4 content options");
                }
                else if($("input:[name='flyerContent']checked").length < 4)
                {
                    alert("Choose at least 4 content options.");
                }

                else
                {
                    var allVals = [];
                    var flyerContent= [];
                    var description = "";
                    var addressC = $("input[name='address']").val();
                    var cityC = $("input[name='city']").val();
                    var stateC = $("input[name='state']").val();
                    var zipC = $("input[name='zip']").val();
                    var priceC = $("input[name='price']").val();
                    $('input[name="imageURL"]:checked').each(function() {
                    allVals.push($(this).val());
                    });
                    $('input[name="flyerContent"]:checked').each(function() {
                    flyerContent.push($(this).val());
                    });
                    if($('input[name="description"]:checked'))
                    {
                        description = $('input[name="description"]:checked').val();
                    }
                    else
                    {
                        description="";
                    }
                    // alert("Post");
                    // console.log(allVals[0]);
                    // alert(allVals[1]);
                    // alert(allVals[2]);
                    $.post( "generatePDF.php", { imageOne: allVals[0], imageTwo: allVals[1], imageThree: allVals[2], imageFour: allVals[3], imageFive: allVals[4],
                     bedrooms:flyerContent[0], bathrooms: flyerContent[1], sqft: flyerContent[2], mlsId:flyerContent[3], address: addressC, city: cityC, 
                     state: stateC, zip: zipC, price: priceC, description: description } );
                    .done(function( data ) {
                        alert( "Data Loaded: ");
                      });
                    alert("Flyer created!");
                    // console.log(allVals);
                }
                // $('input[name="imageURL"]:checked').each(function() {
                //    // alert($(this).val()); 
                //    alert();
                // });

             //    var allVals = [];
             //     $('#imageSerialize label input :checked').each(function() {
             //       allVals.push($(this).val());
             //     });
             // console.log(allVals);
            }
        </script>

    </body>

    </html>
