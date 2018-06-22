<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}

require '../../databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM HouseInfo WHERE listingId = :listingId";

$namedParameters = array();
$namedParameters[':listingId'] = $_GET['id'];


$stmt = $dbConn->prepare($sql);
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

$listingId = $_GET['id'];
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Listing Information</title>

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
                    <!-- 321 Tynan WAY Salinas California, 93906 -->
                    <?php echo $result['address'] . " " . $result['city'] . " " . $result['state'] . ", " . $result['zip']; ?>
                </h1>
                <h1 class="col-md-3 col-sm-3 col-xs-6">
                    Current Flyer
                </h1>
                <h1 class="col-md-3 col-sm-3 col-xs-6">
                    <?php
                    echo "<a href='create-flyer.php?id=" . $listingId . "'><button type=\"button\" class=\"btn btn-danger\">Create New Flyer</button></a>";
                    ?>
                </h1>

            </section>
            <section class="content">
                <div class="container col-md-6 col-sm-6 col-xs-12">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">


                        <?php
                        for ($i = 0; $i < sizeof($keys); $i++) {

                            if ($response[$keys[$i]]['listingID'] == $listingId) {
                                echo '<div class="carousel-inner">
                                                    <div class="item active">
                                                        <img src="' . $response[$keys[$i]]['image'][0]['url'] . '" alt="img" style="width:100%;">
                                                    </div>';
                                for ($j = 1; $j < (int)$response[$keys[$i]]['image']['totalCount']; $j++) {
                                    echo '<div class="item">
                                                        <img src="' . $response[$keys[$i]]['image'][$j]['url'] . '" alt="img" style="width:100%;">
                                                    </div>';
                                }
                                echo '</div>';
                                $message = $response[$keys[$i]]['remarksConcat'];
                                $picAmount = (int)$response[$keys[$i]]['image']['totalCount'];
                                break;
                            }
                        }
                        ?>

                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                            <?php
                            if ((int)$response[$keys[$i]]['image']['totalCount'] > 0) {
                                for ($j = 1; $j < $picAmount; $j++) {
                                    echo '<li data-target="#myCarousel" data-slide-to="' . $j . '">';
                                }
                            }
                            ?>
                            <!--  <li data-target="#myCarousel" data-slide-to="1"></li>
                             <li data-target="#myCarousel" data-slide-to="2"></li> -->
                        </ol>
                        <!-- Wrapper for slides -->
                        <!-- <div class="carousel-inner">
                            <div class="item active">
                                <img src="listingImg/exim1.png" alt="img" style="width:100%;">
                            </div>

                            <div class="item">
                                <img src="listingImg/exim2.png" alt="img" style="width:100%;">
                            </div>

                            <div class="item">
                                <img src="listingImg/exim3.png" alt="img" style="width:100%;">
                            </div>
                        </div> -->

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
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                $ <?php echo number_format($result['price'], 2); ?></div>
                            <div class="col-md-3 col-sm-3 col-xs-3"><?php echo $result['bedrooms']; ?> Bed</div>
                            <div class="col-md-3 col-sm-3 col-xs-3"><?php echo $result['bathrooms']; ?> Bath</div>
                            <div class="col-md-3 col-sm-3 col-xs-3">MLS# <?php echo $result['listingId']; ?></div>
                        </div>

                    </div>

                    <div class="row" style="margin-top:20px;">
                        <p><?php echo $message; ?></p>
                    </div>

                </div>


                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div>
                        <?php
                        // if(isset($result['flyer']))
                        //     echo '<img src="../../uploadFlyers/' . $result['flyer'] . '" alt="pdf" style="width:80%; margin-top:10px;">';
                        // else{
                        //     echo '<img src="listingImg/flyerPlaceHolder.png" alt="pdf" style="width:80%; margin-top:10px;">';
                        // }
                        if ($result['flyer'] == NULL) {
                            echo '<img src="listingImg/flyerPlaceHolder.png" alt="pdf" style="width:80%; margin-top:10px;">';
                        } else {


                            echo '<iframe id="pdf" src="../../uploadFlyers/' . $result['flyer'] . '" 
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
</body>

</html>
