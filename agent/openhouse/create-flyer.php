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

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-oh/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <!-- Custom Theme Style ...Added for smart wizard-->
        <link href="../build/css/custom.min.css" rel="stylesheet">

        <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <style>
            .selectedImages {
                display: table;
                width: 100%;
                table-layout: fixed;    /* For cells of equal size */
            }
            .selectedImages div {
                display: table-cell;
                text-align: center;
            }

            .theIMG {
                -webkit-transform: scale(0.5);
            }
        </style>

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
                <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->
                <!-- Content Header (Page header) -->
                <section>
                     <div class="modal fade" id="myModal" data-backdrop="static" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">PDF has been saved</h4>
                                </div>
                                <!-- /.box-header -->
                                <div class="modal-body">

                                    <!-- textarea -->
                                    <div class="form-group">
                                        <!-- <label>Additional Notes</label> -->
                                        <!-- <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea> -->
                                        <h3>What would you like to do now?</h3>
                                    </div>

                                    <div class="modal-footer">
                                        <?php echo '<a href=../signIn.php?id=' . $listingId . ' target="_blank"><button type="button" class="btn btn-default">House Sign-In sheet</button></a>';?>
                                        <a href="visitors.php"><button type="button" class="btn btn-default">Send Flyer</button></a>
                                        <a href="listings-openhouse.php"><button type="button" class="btn btn-default">Main Page</button></a>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Save</button> -->
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
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

                        <div class="col-md-6 col-sm-6 col-xs-12" style="height:70px; width:100%;">

                            <img id="image0" class="col-md-2 col-sm-6 col-xs-12" style="height:70px; border:2px solid; margin-left: 10px;" src="http://www.clipartbay.com/cliparts/red-number-1-clip-art-gc8rlnb.png">

                            <img id="image1" class="col-md-2 col-sm-6 col-xs-12" style="height:70px; border:2px solid; margin-left: 10px;" src="http://pngimg.com/uploads/number2/Number%202%20PNG%20images%20free%20download_PNG14940.png">

                            <img id="image2" class="col-md-2 col-sm-6 col-xs-12" style="height:70px; border:2px solid; margin-left: 10px;" src="http://www.clker.com/cliparts/U/4/Y/A/Y/6/number-3-button-hi.png">

                            <img id="image3" class="col-md-2 col-sm-6 col-xs-12" style="height:70px; border:2px solid; margin-left: 10px;" src="http://www.clker.com/cliparts/J/p/g/I/c/L/number-4-button-hi.png">

                            <img id="image4" class="col-md-2 col-sm-6 col-xs-12" style="height:70px; border:2px solid; margin-left: 10px;" src="http://www.clker.com/cliparts/5/P/q/M/g/J/number-5-button-hi.png">

                            
                        </div>
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



                                    <div id="step-2">
                                        <h2 class="StepTitle">Step 2: Select flyer content</h2>
                                        <div class="form-group">
                                           
                                              <input checked type="hidden" name="bedrooms" value=<?php echo $response[$keys[$index]]['bedrooms']?>/> 
                                           
                                              <input checked type="hidden" name="bathrooms" value=<?php echo $response[$keys[$index]]['fullBaths']?>/> 
                                           
                                              <input type="hidden" name="sqft" value=<?php echo $response[$keys[$index]]['sqFt']?>/> 
                                    
                                            <label>
                                              <input type="checkbox" class="js-switch" name="lotSize" id="lotSize" value=<?php if(((float)$response[$keys[$index]]['acres'])< 1)
                                                                                                                                                echo (float)$response[$keys[$index]]['acres'] * 43560;
                                                                                                                                                else
                                                                                                                                                 echo (float)$response[$keys[$index]]['acres']; ?>/> 
                                                                                                                                             <?php if(((float)$response[$keys[$index]]['acres'])< 1)
                                                                                                                                                echo (float)$response[$keys[$index]]['acres'] * 43560;
                                                                                                                                                else
                                                                                                                                                 echo (float)$response[$keys[$index]]['acres'];?>sqFt Lot Size
                                            </label> 
                                        </br>
                                         </br>
                                            <label>
                                           
                                                <input type="text" id="age" value="" placeholder="Enter Age if wanted"/>
                                            </label>

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

                                        // echo '<iframe id="pdf" src="../../../test/' . $result['flyer'] . '" style="width:600px; height:600px;" frameborder="0"></iframe>'; //local

                                        echo '<iframe id="pdf" src="../../uploadFlyers/' . substr ($result['flyer'],0,-3)  . 'pdf" 
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

        <script>
            var array = [];
            var limit = 5;
            $('input[type=checkbox]').on('change', function (e) {

                if($('input[type=checkbox]:checked').length > limit) {
                    $(this).prop('checked', false);
                    alert("Only 5 allowed");
                }

                //add new checked elements to array
                if ($(this).attr('checked')) {
                    alert(this.value);
                    array.push($(this).attr('value'));
                }
                //remove unchecked elements
                else {
                    for (var i = 0; i < array.length; i++) {
                        if (array[i] == $(this).attr('value')) {
                            array.splice(i, 1);
                        }
                    }
                }

                for(var i = 0; i < array.length; i++){
                    $('#image'+i).attr("src", array[i]);
                }

                /*var count = 0;
                $('input[type=checkbox]:checked').each(function() {
                    //$('#image'+count).prepend('<img class="theImg" style="-webkit-transform: scale(0.1);" src=' + this.value + ' />');
                    $('#image'+count).attr("src", this.value);
                    //alert(imager);
                    //window.open(this.value);
                    count++;
                });*/
            });
        </script>

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

                else
                {
                    var allVals = [];
                    
                    var description = $("input[name='description']").val();
                    var lotSize = "";
                    var age = "";
                    var addressC = $("input[name='address']").val();
                    var cityC = $("input[name='city']").val();
                    var stateC = $("input[name='state']").val();
                    var zipC = $("input[name='zip']").val();
                    var priceC = $("input[name='price']").val();

                    var bedrooms = $("input[name='bedrooms']").val();
                    var bathrooms = $("input[name='bathrooms']").val();
                    var squareFeet = $("input[name='sqft']").val();

                    var mlsId = $("input[name='mlsId']").val();
                    // var lotSize = $("input[name='lotSize']").val();


                    $('input[name="imageURL"]:checked').each(function() {
                    allVals.push($(this).val());
                    });

                    $('input[name="flyerContent"]:checked').each(function() {
                    flyerContent.push($(this).val());
                    });


                    if($('#lotSize').is(":checked"))
                    {
                        lotSize = $('#lotSize').val();
                    }
                    else if ($('#lotSize').is(":not(:checked)") == false){
                        lotSize = "";
                    }
                    if($("#age").val() != "")
                        age = $("#age").val();
                    // alert("Post");
                    // console.log(allVals[0]);
                    // alert(allVals[1]);
                    // alert(allVals[2]);
                    // $.post( "generatePDF.php", { imageOne: allVals[0], imageTwo: allVals[1], imageThree: allVals[2], imageFour: allVals[3], imageFive: allVals[4],
                    //  bedrooms:flyerContent[0], bathrooms: flyerContent[1], sqft: flyerContent[2], mlsId:flyerContent[3], address: addressC, city: cityC, 
                    //  state: stateC, zip: zipC, price: priceC, description: description },
                    //  function(data, status)
                    //  {
                        
                            
                        
                    // });
                    alert("Your pdf will auto load.");
                    // alert(lotSize);
                    $.ajax({
                      type: "POST",
                      url: "generatePDF.php",
                      data: { imageOne: allVals[0], imageTwo: allVals[1], imageThree: allVals[2], imageFour: allVals[3], imageFive: allVals[4],
                        bedrooms:bedrooms, bathrooms: bathrooms, sqft: squareFeet, lotSize:lotSize, age: age, mlsId:mlsId, address: addressC, city: cityC, 
                        state: stateC, zip: zipC, price: priceC, description: description },
                        success:function(data) 
                        {
                            // alert(data); //=== Show Success Message==

                            // $("#pdf").attr('src','../../../test/generateExample.pdf'); //local 

                            $("#pdf").attr('src','../../uploadFlyers/' + addressC + ".pdf"); // server
                            $("#noPdf").replaceWith('<iframe id="pdf" src="../../uploadFlyers/' + addressC  + '.pdf" style="width:600px; height:500px;" frameborder="0"></iframe>'); //server when no pdf found
                        
                            $('#myModal').modal('show');
                        },
                        error:function(data)
                        {
                        alert(data.responseText); //===Show Error Message====
                        }
                    });
                      
                    
                    // alert("Flyer created! Refres page");
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

            // $("#sendPdf").click(function (event){
            //     event.preventDefault();
            //     var formData = new FormData();
            //     formData.append('pdfFile', $('#pdfFile').prop('files')[0]);
            //     // console.log(formData);
            //     for (var value of formData.values()) {
            //            console.log(formData); 
            //         }
            //     var ajaxUrl = "uploadFlyer.php";
                
            //     $.ajax({
            //         url : ajaxUrl,
            //         type : "POST",
            //         data : formData,
            //         // both 'contentType' and 'processData' parameters are
            //         // required so that all data are correctly transferred
            //         contentType : false,
            //         processData : false,
            //         cache: false,
            //         success:function(data) 
            //         {
            //             alert(data);
            //         }
            //     });
            // });
            
        </script>
                 <script type='text/javascript' src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                 <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script>
            /*
             * For demonstration porpuse, all JavaScript code was incorporated in
             * the HTML file. But when developing your application, your JavaScript code
             * should be in a separated file. Check this page for more information:
             * https://developer.yahoo.com/performance/rules.html#external
             */

            $("#button-send").click(sendFormData);
            
            function sendFormData(){
                var formData = new FormData($("#form-demo").get(0));
                formData.append('listingId', $("input[name='mlsId']").val());
                var ajaxUrl = "uploadFlyer.php";
                
                $.ajax({
                    url : ajaxUrl,
                    type : "POST",
                    data : formData,
                    // both 'contentType' and 'processData' parameters are
                    // required so that all data are correctly transferred
                    contentType : false,
                    processData : false
                }).done(function(response){
                    // In this callback you get the AJAX response to check
                    // if everything is right...
                    // alert(response);

                    // $("#pdf").attr('src','../../../test/' + response); //local

                    $("#pdf").attr('src','../../uploadFlyers/' + response); //server
                    $("#noPdf").replaceWith('<iframe id="pdf" src="../../uploadFlyers/' + response.slice(0,-3) + 'pdf" style="width:600px; height:500px;" frameborder="0"></iframe>'); //server when no pdf found
                    
                    $('#myModal').modal('show');
                }).fail(function(){
                    // Here you should treat the http errors (e.g., 403, 404)
                }).always(function(){
                    // alert("AJAX request finished!");
                });
            }
        </script>

    </body>

    </html>
