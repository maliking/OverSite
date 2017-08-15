<?php
//    require("databaseConnection.php");  
//    session_start();
//    $dbConn = getConnection();
//    if(!isset($_SESSION['userId'])) {
//      header("Location: index.php?error=wrong username or password");
//    } 
    //$houseId = $_GET['houseId'];
 ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">

        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->


        <title>Re/Max Salinas | Sign In Form</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>



        <script>
            function displayError(id, message) {
                $(id + "Error").html(message);
                $(id).css("background-color", "red");
                $(id).focus();
                $(id + "Error").css("color", "red");
            }

            function checkPhone() {
                if (!/^\d{3}\s*\d{3}\d{4}$/.test($("#phone").val())) {
                    displayError("#phone", "Please enter a 10-digit phone number");
                    return false;
                } else {
                    $("#phoneError").html("");
                    $("#phone").css("background-color", "#66FF66");
                }
            }

        </script>



        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->

        <!--Slider plugins-->
        <link href="../plugins/ionslider/ion.rangeSlider.css" rel="stylesheet">
        <link href="../plugins/ionslider/ion.rangeSlider.skinFlat.css" rel="stylesheet">
        <!--End Slider plugins-->


    </head>



    <body>


        <section class="content">
            <center>
                <img alt="Interesting Image" border="0" class="simage float_center" height="101" src="../dist/img/remax-logo.png" style="margin-left: 0px; margin-right: 0px;" title="Interesting Image" width="280" />
            </center>

            <form method="post" action="addBuyer.php">



                <div class="x_title">
                    <center>
                        <h3><label>Welcome! Please sign in:</label></h3>
                    </center>


                </div>

                <div class="row">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-2">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess3" placeholder="Last Name">
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-2">
                        <input type="text" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" class="form-control" id="inputSuccess5" placeholder="Phone">
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <label>How soon are you looking to purchase a home?</label>
                        <select id="" class="form-control" required>
                            <option value="">1-3 months</option>
                            <option value="">4-6 months</option>
                            <option value="">7-12 months</option>
                            <option value="">Just visiting</option>
                          </select>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-offset-2" style="margin-top:10px;">
                        <label>Do we have your permission to contact you?</label>
                        <br>

                        <label><input type="radio" name="yes">&nbsp Yes, Please contact me</label>
                        <br>
                        <label><input type="radio" name="no">&nbsp No, Please do not contact me</label>
                    </div>

                </div>
                <div class="row">



                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <p>Bedroom Range</p>
                        <input type="text" id="bedRange" value="" name="range" />
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <p>Bathroom Range</p>
                        <input type="text" id="bathRange" value="" name="range" />
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <p>Price Range</p>
                        <input type="text" id="priceRange" value="" name="range" />
                    </div>

                </div>

                <div class="row">
                    <center>

                        <button type="submit" class="btn btn-success">Submit</button>
                        <!--                  
                    </center>


                </div>


            </form>



        </section>




        <!-- Ion.RangeSlider -->
                        <script src="../plugins/ionslider/ion.rangeSlider.min.js"></script>


                        <script>
                            $("#phone").change(checkPhone);


                            $(function() {

                                $("#bedRange").ionRangeSlider({
                                    hide_min_max: true,
                                    keyboard: true,
                                    min: 0,
                                    max: 10,
                                    from: 0,
                                    to: 1,
                                    type: 'double',
                                    step: 1,
                                    prefix: "",
                                    grid: true
                                });

                            });
                            $(function() {

                                $("#bathRange").ionRangeSlider({
                                    hide_min_max: true,
                                    keyboard: true,
                                    min: 0,
                                    max: 10,
                                    from: 0,
                                    to: 1,
                                    type: 'double',
                                    step: 1,
                                    prefix: "",
                                    grid: true
                                });

                            });
                            $(function() {

                                $("#priceRange").ionRangeSlider({
                                    hide_min_max: true,
                                    keyboard: true,
                                    min: 100000,
                                    max: 4000000,
                                    from: 0,
                                    to: 1,
                                    type: 'single',
                                    step: 5000,
                                    prefix: "$",
                                    grid: true
                                });

                            });

                        </script>




    </body>

    </html>
