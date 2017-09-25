<?php
    require("../databaseConnection.php");  
    session_start();
     if(!isset($_SESSION['listingId']))
     {
         $_SESSION['listingId'] = $_GET['id'];
     }
    
    $dbConn = getConnection();
    if(!isset($_SESSION['userId'])) {
      header("Location: index.php?error=wrong username or password");
    } 
    // $houseId = $_GET['houseId'];
    if(isset($_GET['id']))
        $_SESSION['listingId'] = $_GET['id'];

    $sql = "SELECT houseId, address, flyer FROM HouseInfo WHERE listingId = :listingId";

    $namedParameters = array();
    // $namedParameters[':listingId'] = $_GET['id'];
    
    $namedParameters[':listingId'] = $_SESSION['listingId'];


    $stmt = $dbConn->prepare($sql);
    $stmt->execute($namedParameters);
    $result = $stmt->fetch();

    $_SESSION['flyer'] = $result['flyer'];
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
                <img alt="Interesting Image" border="0" class="simage float_center" height="200px" src="../dist/img/remax-logo.png" style="margin-left: 0px; margin-right: 0px;" title="Interesting Image" width="280" />
            </center>
            <form method="post" action="addBuyer.php">

            <input type="hidden" name="houseId" value="<?= $result['houseId'];?>" />

                <div class="x_title" style="margin-top: 20px;">
                    <center>
                        <h3><label>Welcome to <?php echo $result['address'] . " " . $_SESSION['flyer'];  ?></label></h3>
                    </center>


                </div>

                <div class="row" style="margin-top: 30px;">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-4">
                        <input type="text" name="firstName" class="form-control has-feedback-left" id="inputSuccess2" placeholder="First Name">
                        <span class="form-control-feedback left" aria-hidden="true"></span>

                    </br>
                        <input type="text" name="lastName" class="form-control" id="inputSuccess3" placeholder="Last Name">
                        <span class="form-control-feedback right" aria-hidden="true"></span>

                    </div>

                  
                </div>
                <div class="row">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-4">
                        <input type="text" name="email" class="form-control has-feedback-left" id="inputSuccess4" placeholder="Email">
                        <span class="form-control-feedback left" aria-hidden="true"></span>
                    </br>
                        <input type="text" name="phone" class="form-control" id="inputSuccess5" placeholder="Phone">
                        <span class=" form-control-feedback right" aria-hidden="true"></span>
                    </div>

                   
                </div>
                <div class="row">

                    <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4" style="margin-top: 40px;">
                        <label>How soon are you looking to purchase a home?</label>
                        <select id="" name="howSoon" class="form-control" required>
                            <option value="0">--Select One--</option>
                            <option value="1-3">1-3 months</option>
                            <option value="4-6">4-6 months</option>
                            <option value="7-12">7-12 months</option>
                            <option value="Visit">Just visiting</option>
                          </select>
                    </div>

                </div>
             
                </div>
                <div class="row" style="margin-top: 20px;">

                    <div class="col-md-4 col-sm-4 col-xs-12 col-md-offset-4">
                        <label>Min Bedrooms</label>
                        <select id="" name="bedroomsMin" class="form-control" required>
                            <option value="0">--Select One--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                           
                          </select>
                      </br>
                      <label>Min Bathrooms</label>
                        <select id="" name="bathroomsMin" class="form-control" required>
                            <option value="0">--Select One--</option>
                            <option value="1">1</option>
                            <option value="1.5">1.5</option>
                            <option value="2">2</option>
                            <option value="2.5">2.5</option>
                            <option value="3">3</option>
                            <option value="3.5">3.5</option>
                            <option value="4">4</option>
                            <option value="4.5">4.5</option>
                          </select>
                         
                    </div>
                    
                </div>
                <div class="row" style="margin-top: 20px;">

                    <div class="col-md-4 col-sm-4 col-xs-12 form-group has-feedback col-md-offset-4">
                        <input type="text" name="priceMin" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Minimum Price">
                        <span class="form-control-feedback left" aria-hidden="true"></span>
                    </br>
                         <input type="text" name="priceMax" class="form-control" id="inputSuccess3" placeholder="Maximum Price">
                        <span class="form-control-feedback right" aria-hidden="true"></span>
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
