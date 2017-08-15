<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp17.org/login.php");
}
?>



    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Re/Max Salinas | Listing Information</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-oh/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
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
                    <section class="content-header">
                        <h1 class="col-md-6 col-sm-6 col-xs-12">
                            321 Tynan WAY Salinas California, 93906
                        </h1>
                         <h1 class="col-md-3 col-sm-3 col-xs-6">
                            Current Flyer
                        </h1>
                        <h1 class="col-md-3 col-sm-3 col-xs-6">
                         <a href="create-flyer.php"><button type="button" class="btn btn-danger">Create New Flyer</button></a>
                             </h1>

                    </section>
                    <section class="content">
                        <div class="container col-md-6 col-sm-6 col-xs-12">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="listingImg/exim1.png" alt="img" style="width:100%;">
                                    </div>

                                    <div class="item">
                                        <img src="listingImg/exim2.png" alt="img" style="width:100%;">
                                    </div>

                                    <div class="item">
                                        <img src="listingImg/exim3.png" alt="img" style="width:100%;">
                                    </div>
                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="fa fa-angle-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="fa fa-angle-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 col-xs-3">$569,900</div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">3 Bed</div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">2 Bath</div>
                                    <div class="col-md-3 col-sm-3 col-xs-3">MLS# ML81656426</div>
                                </div>

                            </div>

                            <div class="row" style="margin-top:20px;">
                                <p>Beautifully remodeled. Great neighborhood to raise a family. Designed for entertaining. Located in the desirable Harrod Homes neighborhood, this home features a grand formal living room with vaulted ceilings. The formal dining room's ceiling and wall trims make it the perfect place to dine with friends and family. The kitchen has been remodeled with new engraved cabinets, quarts counter tops, subway tile back-splash, and stainless steel appliances. The kitchen opens up to a family room with vaulted ceilings and a cozy fireplace. Spacious master bedroom with large walk-in closet and private sliding door access to backyard.</p>
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
    </body>

    </html>
