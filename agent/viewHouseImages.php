<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

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
$mlsId = $_GET['id'];

?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | House Images</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <link href="lightbox2/dist/css/lightbox.css" rel="stylesheet">
        <script src="lightbox2/dist/js/lightbox-plus-jquery.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


        <style>
            .modal-title {
                font-size: 150%;
                font-weight: bold;
            }
            
            #modal-table {
                color: black;
            }
            table{
                width: 600px;
                /*height: 100%;*/
            }
            td {
                padding-bottom: 50px;
                padding-right: 50px;
            }

            .mySlides {display:none}
            .demo {cursor:pointer}
        </style>
        <!-- NOTIFICATION Links-->
        <link href="../plugins/pnotify/dist/pnotify.css" rel="stylesheet">
        <link href="../plugins/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
        <link href="../plugins/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">

        <!-- daterange picker -->
        <link rel="stylesheet" href="../plugins/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

    </head>

    <body class="hold-transition skin-red-light sidebar-mini">
        <!-- Site Wrapper -->
        <div class="wrapper">

            <!-- BEGIN TEMPLATE header.php INCLUDE -->
            <?php include "./templates-agent/header.php" ?>
            <!-- END TEMPLATE header.php INCLUDE -->

            <!-- BEGIN TEMPLATE nav.php INCLUDE -->
            <?php include "./templates-agent/nav.php" ?>
            <!-- END TEMPLATE nav.php INCLUDE -->

            <!-- PAGE-SPECIFIC CSS -->
            <link rel="stylesheet" href="../dist/css/vendor/fullcalendar.min.css">



            <?php include "./fullcalendar/links.php" ?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                    <!-- <div style="overflow:auto; height:600px">
                        <table>
                            <tr> -->

                     <?php
                                // foreach ($result as $house) {
                                // for ($i = 0; $i < sizeof($keys); $i++) {

                                //     if($response[$keys[$i]]['listingID'] == $mlsId)
                                //     {
                                //         for ($j = 0; $j < $response[$keys[$i]]['mlsPhotoCount']; $j++) 
                                //         {
                                //             if($j % 6 == 0 )
                                //                 echo '</tr><tr>';
                                //             echo '<td><a href="' . $response[$keys[$i]]['image'][$j]['url'] .'" data-lightbox="image' . $j . '"><img src="' . $response[$keys[$i]]['image'][$j]['url'] .'" style="width:150px;height:150px;" ></a></td>';
                                            
                                //         }
                                //         break;

                                //     }

                                    
                                // }
                                ?>
                                
                                <div class="w3-container" style=" width:75%; height:700px">
                                    <div>
                                        <?php
                                        for ($i = 0; $i < sizeof($keys); $i++) 
                                        {
                                            if($response[$keys[$i]]['listingID'] == $mlsId)
                                            {
                                                echo $response[$keys[$i]]['address'] . " " . $response[$keys[$i]]['cityName'] . ", " . $response[$keys[$i]]['state'] . " " . $response[$keys[$i]]['zipcode'] . "</br>";
                                                echo "Bedrooms: " . $response[$keys[$i]]['bedrooms'] . "&nbsp&nbsp Bathrooms: " . $response[$keys[$i]]['fullBaths']
                                                . "." . $response[$keys[$i]]['partialBaths'] . "&nbsp&nbsp SqFt: " . $response[$keys[$i]]['sqFt'] . "&nbsp&nbsp Price: " . $response[$keys[$i]]['listingPrice'];
                                                break;
                                            }
                                                
                                        }
                                        ?>
                                    </div>
                                <button class="w3-button w3-display-left w3-black" onclick="plusDivs(-1)" style="position:sticky;">&#10094;</button>
                                <button class="w3-button w3-display-right w3-black" onclick="plusDivs(+1)" style="position:sticky; left:100%;">&#10095;</button>
                                    <?php
                                        for ($i = 0; $i < sizeof($keys); $i++) 
                                        {
                                            if($response[$keys[$i]]['listingID'] == $mlsId)
                                            {
                                                for ($j = 0; $j < $response[$keys[$i]]['mlsPhotoCount']; $j++) 
                                                {
                                                    echo '<img class="mySlides" src="' . $response[$keys[$i]]['image'][$j]['url']  . '" style="width:100%; height: 500px">';
                                                }
                                                break;
                                            }
                                        }
                                    ?>
                                  <!-- <img class="mySlides" src="img_nature_wide.jpg" style="width:100%">
                                  <img class="mySlides" src="img_fjords_wide.jpg" style="width:100%">
                                  <img class="mySlides" src="img_mountains_wide.jpg" style="width:100%">
 -->
                                  <div class="w3-section" style="overflow:auto; height: 200px;">

                                    <?php
                                    for ($i = 0; $i < sizeof($keys); $i++) 
                                        {
                                            if($response[$keys[$i]]['listingID'] == $mlsId)
                                            {
                                                for ($j = 0; $j < $response[$keys[$i]]['mlsPhotoCount']; $j++) 
                                                {
                                                    echo '<div class="w3-col s2">
                                                      <img class="demo w3-opacity w3-hover-opacity-off w3-padding" src="' . $response[$keys[$i]]['image'][$j]['url'] . '" style="width:100%" onclick="currentDiv(' . ($j + 1). ')">
                                                    </div>';
                                                }
                                                break;
                                            }
                                        }
                                    ?>
                                    <!-- <div class="w3-col s4">
                                      <img class="demo w3-opacity w3-hover-opacity-off" src="img_nature_wide.jpg" style="width:100%" onclick="currentDiv(1)">
                                    </div>
                                    <div class="w3-col s4">
                                      <img class="demo w3-opacity w3-hover-opacity-off" src="img_fjords_wide.jpg" style="width:100%" onclick="currentDiv(2)">
                                    </div>
                                    <div class="w3-col s4">
                                      <img class="demo w3-opacity w3-hover-opacity-off" src="img_mountains_wide.jpg" style="width:100%" onclick="currentDiv(3)">
                                    </div> -->


                                  </div>
                                </div>
                            
                            <!-- </tr>
                            </table>
                            </div> -->
                   
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->
        </div>
        <!-- /.content-wrapper -->
        </div>
        <!-- /.wrapper -->


        <!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
        <?php include "./templates-agent/default-footer.php" ?>
        <!-- END TEMPLATE default-footer.php INCLUDE -->

        <!-- BEGIN TEMPLATE default-js.php INCLUDE -->
        <?php include "./templates-agent/default-js.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->


        <script type="text/javascript" src="../dist/js/vendor/footable.min.js"></script>

        <!-- PAGE-SPECIFIC JS -->
        <script src="../dist/js/vendor/moment-with-locales.min.js"></script>
        <script src="../dist/js/vendor/fullcalendar/gcal.min.js"></script>
        <script src="../dist/js/vendor/fullcalendar/fullcalendar.min.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.buttons.js"></script>
        <script type="text/javascript" src="../plugins/pnotify/dist/pnotify.nonblock.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>

        <!-- date-range-picker -->
        <script src="../plugins/moment/min/moment.min.js"></script>
        <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
           
        var slideIndex = 1;
        showDivs(slideIndex);

        function plusDivs(n) {
          showDivs(slideIndex += n);
        }

        function currentDiv(n) {
          showDivs(slideIndex = n);
        }

        function showDivs(n) {
          var i;
          var x = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("demo");
          if (n > x.length) {slideIndex = 1}
          if (n < 1) {slideIndex = x.length}
          for (i = 0; i < x.length; i++) {
             x[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
             dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
          }
          x[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " w3-opacity-off";
        }

        </script>


    </body>

    </html>
