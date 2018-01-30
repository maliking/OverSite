<?php
require("../../databaseConnection.php");
session_start();
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

// for($i = 0; $i < sizeof($keys); $i++){
//     echo "<img src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error'>";
// }
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Open House Listings</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-oh/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="../../dist/css/vendor/footable.bootstrap.min.css">
</head>

<body class="hold-transition skin-black sidebar-mini">
<style>

    /*            For the overlay*/
    /*            Source for the css are links below. */
    /*<!--    <link href="../build/css/custom.min.css" rel="stylesheet">-->*/
    /*<!--    <link href="../build/css/custom.css" rel="stylesheet">-->*/

    .thumbnail .image {
        height: 120px;
        overflow: hidden
    }

    .caption {
        padding: 9px 5px;
        background: #F7F7F7
    }

    .caption p {
        margin-bottom: 5px
    }

    .thumbnail {
        height: 190px;
        overflow: hidden
    }

    .view {
        overflow: hidden;
        position: relative;
        text-align: center;
        box-shadow: 1px 1px 2px #e6e6e6;
        cursor: default
    }

    .view .mask,
    .view .content {
        position: absolute;
        width: 100%;
        overflow: hidden;
        top: 0;
        left: 0
    }

    .view img {
        display: block;
        position: relative
    }

    .view .tools {
        text-transform: uppercase;
        color: #fff;
        text-align: center;
        position: relative;
        font-size: 17px;
        padding: 3px;
        background: rgba(0, 0, 0, 0.35);
        margin: 43px 0 0 0
    }

    .mask.no-caption .tools {
        margin: 90px 0 0 0
    }

    .view .tools a {
        display: inline-block;
        color: #FFF;
        font-size: 18px;
        font-weight: 400;
        padding: 0 4px
    }

    .view p {
        font-family: Georgia, serif;
        font-style: italic;
        font-size: 12px;
        position: relative;
        color: #fff;
        padding: 10px 20px 20px;
        text-align: center
    }

    .view a.info {
        display: inline-block;
        text-decoration: none;
        padding: 7px 14px;
        background: #000;
        color: #fff;
        text-transform: uppercase;
        box-shadow: 0 0 1px #000
    }

    .view-first img {
        transition: all 0.2s linear
    }

    .view-first .mask {
        opacity: 0;
        background-color: rgba(0, 0, 0, 0.5);
        transition: all 0.4s ease-in-out
    }

    .view-first .tools {
        transform: translateY(-100px);
        opacity: 0;
        transition: all 0.2s ease-in-out
    }

    .view-first p {
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.2s linear
    }

    .view-first:hover img {
        transform: scale(1.1)
    }

    .view-first:hover .mask {
        opacity: 1
    }

    .view-first:hover .tools,
    .view-first:hover p {
        opacity: 1;
        transform: translateY(0px)
    }

    .view-first:hover p {
        transition-delay: 0.1s
    }

    .form-group.has-feedback span {
        display: block !important;
    }

    .form-group .btn {
        margin-bottom: -6px;
    }

    /*End css for overlay*/

</style>
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
        <section class="content">
            <div class="row">

                <div class="box">
                    <div class="box-header">
                        <h3>Open House Listings</h3>
                    </div>
                    <div class="box-body">


                        <table class="table">
                            <?php
                            $dbConn = getConnection();
                            $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip, bedrooms, bathrooms, price
                        FROM HouseInfo
                        WHERE userId = :userId";
                            $namedParameters = array();
                            $namedParameters[':userId'] = $_SESSION['userId'];
                            $stmt = $dbConn->prepare($sql);
                            $stmt->execute($namedParameters);
                            //$stmt->execute();
                            $results = $stmt->fetchAll();
                            // foreach($results as $result) {

                            //     echo "<tr>";
                            //     echo "<td><img width=\"100px\" height=\"100px\" src=\"../../dist/img/placeholder.jpg\"></td>";
                            //     echo "<td>";
                            //     echo $result['address'] . "<br>" . $result['city'] . " " . $result['state'] . ", " . $result['zip'];
                            //     echo "</td>";
                            //     echo "<td>
                            //                                             <div class=\"dropdown\">
                            //                                                 <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">
                            //                                                     Options
                            //                                                     <span class=\"caret\"></span>
                            //                                                 </button>
                            //                                                 <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">
                            //                                                     <li><a href=\"#\">Create a New Flyer</a></li>
                            //                                                     <li><a href=\"#\">Flyer Info</a></li>
                            //                                                     <li><a href=\"#\">Sign-In</a></li>
                            //                                                     <li role=\"separator\" class=\"divider\"></li>
                            //                                                     <li><a href=\"#\">Remove</a></li>
                            //                                                 </ul>
                            //                                             </div>
                            //                                         </td>";
                            //     echo "</tr>";
                            // }

                            for ($i = 0; $i < sizeof($keys); $i++) {
                                // echo "<img src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error'>";

                                echo "<tr>";
                                // echo "<td><img width=\"100px\" height=\"100px\" src=\"../../dist/img/placeholder.jpg\"></td>";
                                echo "<td style=\"padding-left:10%\"><img src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error' width=\"225px\" height=\"200px\"></td>";
                                echo "<td>";
                                // echo $result['address'] . "<br>" . $result['city'] . " " . $result['state'] . ", " . $result['zip'];
                                echo $response[$keys[$i]]['address'] . "<br>" . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . ", " . $response[$keys[$i]]['zipcode'];
                                echo "</td>";
                                echo "<td>";
                                //                                         <div class=\"dropdown\">
                                //                                             <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">
                                //                                                 Options
                                //                                                 <span class=\"caret\"></span>
                                //                                             </button>
                                //                                             <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">";
                                // echo "                                      <li><a href=\"create-flyer.php?id=" . $response[$keys[$i]]['listingID']  ."\">Create a New Flyer</a></li>";
                                // echo "                                          // <li><a href=\"listing-info.php?id=" .$response[$keys[$i]]['listingID']  ."\">Flyer Info</a></li>
                                //                                                 <li><a href=\"../signIn.php?id=" . $response[$keys[$i]]['listingID']  ." \">Sign-In</a></li>
                                //                                                 <li role=\"separator\" class=\"divider\"></li>
                                //                                                 <li><a href=\"#\">Remove</a></li>
                                //                                             </ul>
                                //                                         </div>
                                echo '<a href="create-flyer.php?id=' . $response[$keys[$i]]['listingID'] . '"><button type="button" class="btn btn-primary ">Create a New Flyer</button></a></br></br>';
                                echo '<a href=../signIn.php?id=' . $response[$keys[$i]]['listingID'] . ' target="_blank"><button type="button" class="btn btn-primary">Sign-In</button></a></br></br>';
                                echo '<a href="singleListingVisitors.php?id=' . $response[$keys[$i]]['listingID'] . '"><button type="button" class="btn btn-primary ">Listing Visitors</button></a></br></br>';
                                echo '<button type="button" class="btn btn-danger">Remove</button></br></br>';
                                echo "                               </td>";
                                echo "</tr>";

                            }
                            ?>
                        </table>


                        <?php
                        for ($i = 0; $i < 2; $i++) {
                            echo '<div class="col-md-3 col-sm-3 col-xs-4">
                         <div class="thumbnail">
                            <div class="image view view-first">';
                            echo "<img src='" . $response[$keys[$i]]['image']['0']['url'] . "' alt='error' width=\"50%\" height=\"100%\">";
                            echo '           <div class="mask">
                                    <p>Options</p>
                                    <div class="tools tools-bottom">
                                        <a href="../openhouse/create-flyer.php" data-toggle="tooltip" title="Create Flyer"><i class="fa fa-paint-brush"></i></a>
                                        <a href="../openhouse/listing-info.php" data-toggle="tooltip" title="Listing Information"><i class="fa fa-info-circle"></i></a>
                                        <a href="../signIn.php" data-toggle="tooltip" title="Sign In Sheet"><i class="fa fa-edit"></i></a>  
                                        <a href="#" data-toggle="tooltip" title="Remove"><i class="fa fa-trash-o"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="caption">';
                            echo '    <p>' . $response[$keys[$i]]['address'] . "<br>" . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . ", " . $response[$keys[$i]]['zipcode'] . '</p>';
                            echo '</div>
                        </div>
                    </div>';
                        }
                        ?>
                        <!-- <div class="col-md-4 col-sm-2 col-xs-6">
                             <div class="thumbnail">
                                <div class="image view view-first">
                                    <img style="width: 50%;  display: block;" src="listingImg/mockHouse.jpg" alt="image" />
                                    <div class="mask">
                                        <p>Settings</p>
                                        <div class="tools tools-bottom">
                                            <a href="../openhouse/create-flyer.php" data-toggle="tooltip" title="Create Flyer"><i class="fa fa-paint-brush"></i></a>
                                            <a href="../openhouse/listing-info.php" data-toggle="tooltip" title="Listing Information"><i class="fa fa-info-circle"></i></a>
                                            <a href="../signIn.php" data-toggle="tooltip" title="Sign In Sheet"><i class="fa fa-edit"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <p>Address here</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-2 col-xs-6">
                             <div class="thumbnail">
                                <div class="image view view-first">
                                    <img style="width: 50%;  display: block;" src="listingImg/mockHouse.jpg" alt="image" />
                                    <div class="mask">
                                        <p>Settings</p>
                                        <div class="tools tools-bottom">
                                            <a href="../openhouse/create-flyer.php" data-toggle="tooltip" title="Create Flyer"><i class="fa fa-paint-brush"></i></a>
                                            <a href="../openhouse/listing-info.php" data-toggle="tooltip" title="Listing Information"><i class="fa fa-info-circle"></i></a>
                                            <a href="../signIn.php" data-toggle="tooltip" title="Sign In Sheet"><i class="fa fa-edit"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="caption">
                                    <p>Address here</p>
                                </div>
                            </div>
                        </div> -->
                        <!------END example-->

                    </div>


                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            <!-- /.col -->
    </div>
    <!-- /.row -->
    </section>
</div>
<!-- /.content-wrapper -->

</div>
<!-- /.wrapper -->

<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-oh/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-oh/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- Custom Theme Scripts -->
<!--        <script src="../build/js/custom.min.js"></script>-->

<script type="text/javascript" src="../../dist/js/footable.min.js"></script>
<script>
    jQuery(function ($) {
        $('.table').footable();
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Enter Export Dates</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <span>Start Date:  </span><input id="startDate" type="date" data-date-inline-picker="false"
                                                     data-date-open-on-focus="true"/>
                </div>
                <div class="form-group">
                    <span>End Date:  </span><input id="endDate" type="date" data-date-inline-picker="false"
                                                   data-date-open-on-focus="true"/>
                </div>

                <div class="form-group">
                    <span>Select House:  </span>
                    <select id="house">
                        <?php
                        for ($i = 0; $i < sizeof($keys); $i++) {
                            echo '<option value=' . $response[$keys[$i]]['listingID'] . '>' . $response[$keys[$i]]['address'] .
                                " " . $response[$keys[$i]]['cityName'] . " " . $response[$keys[$i]]['state'] . ", " .
                                $response[$keys[$i]]['zipcode'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="downloadVisitors">Download
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    $('#exportVisitors').click(function () {

        $("#myModal").modal();
    });
    $('#downloadVisitors').click(function () {
        // alert($('#startDate').val());
        // alert($('#endDate').val());

        window.location = "exportVisitors.php?id=" + $("#house").val() + "&startDate=" + $('#startDate').val() + "&endDate=" + $('#endDate').val();
    });

</script>

</body>

</html>
