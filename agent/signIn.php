<?php
    require("../databaseConnection.php");  
    session_start();
    $dbConn = getConnection();
    if(!isset($_SESSION['userId'])) {
      header("Location: index.php?error=wrong username or password");
    } 
    // $houseId = $_GET['houseId'];

    $sql = "SELECT houseId FROM HouseInfo WHERE listingId = :listingId";

    $namedParameters = array();
    $namedParameters[':listingId'] = $_GET['id'];


    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
    $result = $stmt->fetch();
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


        <!-- bootstrap slider -->
        <!--        <link rel="stylesheet" href="../plugins/bootstrap-slider/slider.css">-->

    </head>



    <body>


        <section class="content">
            <center>
                <img alt="Interesting Image" border="0" class="simage float_center" height="101" src="../dist/img/remax-logo.png" style="margin-left: 0px; margin-right: 0px;" title="Interesting Image" width="280" />
            </center>
            <form method="post" action="addBuyer.php">

            <input type="hidden" name="houseId" value="<?= $result['houseId'];?>" />

                <div class="x_title" style="margin-top: 20px;">
                    <center>
                        <h3><label>Welcome! Please sign in:</label></h3>
                    </center>


                </div>

                <div class="row" style="margin-top: 30px;">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-2">
                        <input type="text" name="firstName" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name">
                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" name="lastName" class="form-control" id="inputSuccess3" placeholder="Last Name">
                        <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-2">
                        <input type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email">
                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Phone">
                        <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2" style="margin-top: 40px;">
                        <label>How soon are you looking to purchase a home?</label>
                        <select id="" name="howSoon" class="form-control" required>
                            <option value="">1-3 months</option>
                            <option value="">4-6 months</option>
                            <option value="">7-12 months</option>
                            <option value="">Just visiting</option>
                          </select>
                    </div>

                </div>
             
                </div>
                <div class="row" style="margin-top: 20px;">

                    <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-2">
                        <label>Bedrooms</label>
                        <select id="" name="bedroomsMax" class="form-control" required>
                            <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option>
                            <option value="">4</option>
                            <option value="">5</option>
                           
                          </select>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-65">
                        <label>Bathrooms</label>
                        <select id="" name="bathroomsMax" class="form-control" required>
                            <option value="">1</option>
                            <option value="">1.5</option>
                            <option value="">2</option>
                            <option value="">2.5</option>
                            <option value="">3</option>
                            <option value="">3.5</option>
                            <option value="">4</option>
                            <option value="">4.5</option>
                          </select>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-2">
                        <input type="text" name="priceMin" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Minimum Price">
                        <span class="fa fa-dollar form-control-feedback left" aria-hidden="true"></span>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback">
                        <input type="text" name="priceMax" class="form-control" id="inputSuccess3" placeholder="Maximum Price">
                        <span class="fa  fa-dollar form-control-feedback right" aria-hidden="true"></span>
                    </div>
                    <!--
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2">
                        <p>Price Range</p>
                       
                        <input class="slider" type="text" value="" class="slider form-control" data-slider-min="0" data-slider-max="200000000" data-slider-step="50000" data-slider-value="[1000000,200000000]" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show" data-slider-id="blue">


                    </div>
-->


                </div>

                <div class="row">
                    <br />
                    <br />
                    <center>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </center>





                </div>


            </form>



        </section>



        <!-- Bootstrap slider -->
        <script src="../plugins/bootstrap-slider/bootstrap-slider.js"></script>


        <script>
            $("#phone").change(checkPhone);
            //
            //            $(function() {
            //                /* BOOTSTRAP SLIDER */
            //                $('.slider').slider();
            //            })

        </script>




    </body>

    </html>
