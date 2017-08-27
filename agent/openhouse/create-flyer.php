<?php
//session_start();
//
//if (!isset($_SESSION['userId'])) {
//    header("Location: http://jjp17.org/login.php");
//}
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
                                        <div class="row">
                                            <label class="item col-md-4 col-sm-4 col-xs-6">
                              <input type="checkbox" class="js-switch" />
<!--                                                <div class="item col-md-4 col-sm-4 col-xs-6">-->
                                                <img src="listingImg/exim1.png" alt="img" style="width:100%;">
<!--                                            </div>-->
                            </label>
                                            <label class="item col-md-4 col-sm-4 col-xs-6">
                              <input type="checkbox" class="js-switch" /> 
<!--                                                <div class="item col-md-4 col-sm-4 col-xs-6">-->
                                                <img src="listingImg/exim2.png" alt="img" style="width:100%;">
<!--                                            </div>-->
                            </label>
                                            <label class="item col-md-4 col-sm-4 col-xs-6">
                              <input type="checkbox" class="js-switch" /> 
<!--                                                <div class="item col-md-4 col-sm-4 col-xs-6">-->
                                                <img src="listingImg/exim3.png" alt="img" style="width:100%;">
<!--                                            </div>-->
                            </label>
                                        </div>

                                    </div>



                                    <div id="step-2">
                                        <h2 class="StepTitle">Step 2: Select flyer content</h2>
                                        <div class="form-group">
                                            <label>
                              <input type="checkbox" class="js-switch" /> $569,900
                            </label> <br /><label>
                              <input type="checkbox" class="js-switch" /> MLS# ML81656426
                            </label> <br /><label>
                              <input type="checkbox" class="js-switch" /> 3 Bed
                            </label><br /> <label>
                              <input type="checkbox" class="js-switch" />2 Bath
                            </label> <br /><label>
                              <input type="checkbox" class="js-switch" />2057 sqft
                            </label>


                                        </div>
                                    </div>
                                    <div id="step-3">
                                        <h2 class="StepTitle">Step 3: Select listing description</h2>
                                        <div class="form-group">
                                            <label>
                              <input type="checkbox" class="js-switch" />  <p>Beautifully remodeled. Great neighborhood to raise a family. Designed for entertaining. Located in the desirable Harrod Homes neighborhood, this home features a grand formal living room with vaulted ceilings. The formal dining room's ceiling and wall trims make it the perfect place to dine with friends and family. The kitchen has been remodeled with new engraved cabinets, quarts counter tops, subway tile back-splash, and stainless steel appliances. The kitchen opens up to a family room with vaulted ceilings and a cozy fireplace. Spacious master bedroom with large walk-in closet and private sliding door access to backyard.</p>
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




                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div>
                                <img src="listingImg/flyerPlaceHolder.png" alt="pdf" style="width:80%; margin-top:10px;">
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
                onFinish: null // triggers when Finish button is clicked
            });

        </script>

    </body>

    </html>
