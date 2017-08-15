
<?php
require("../../databaseConnection.php");  
session_start();
$dbConn = getConnection();
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

        <!-- PAGE-SPECIFIC CSS -->
        <link rel="stylesheet" href="../../dist/css/vendor/footable.bootstrap.min.css">
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
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
                        <div class="col-xs-6">
                            <div class="box">
                                <div class="box-header">
                                    <h3>Open House Listings</h3>
                                </div>
                                <div class="box-body">

                                    <div class="row">
                                        <table class="table">
                                             <?php 
                                            foreach($results as $result) {
                                                $dbConn = getConnection();
                                                $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip, bedrooms, bathrooms, price
                                                                                                                                            FROM HouseInfo
                                                                                                                                            WHERE userId = :userId";
                                                $namedParameters = array();
                                                $namedParameters[':userId'] = $_SESSION['userId'];
                                                $stmt = $dbConn -> prepare($sql);
                                                $stmt->execute($namedParameters);
                                                //$stmt->execute();
                                                $results = $stmt->fetchAll();
                                                echo "<tr>";
                                                echo "<td><img width=\"100px\" height=\"100px\" src=\"../../dist/img/placeholder.jpg\"></td>";
                                                echo "<td>";
                                                echo $result['address'] . $result['city'] . $result['state'] . $result['zip'];
                                                echo "</td>";                                                
                                                echo "<td>
                                                    <div class=\"dropdown\">
                                                        <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"true\">
                                                            Options
                                                            <span class=\"caret\"></span>
                                                        </button>
                                                        <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu1\">
                                                            <li><a href=\"#\">Create a New Flyer</a></li>
                                                            <li><a href=\"#\">Flyer Info</a></li>
                                                            <li><a href=\"#\">Sign-In</a></li>
                                                            <li role=\"separator\" class=\"divider\"></li>
                                                            <li><a href=\"#\">Remove</a></li>
                                                        </ul>
                                                    </div>
                                                </td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                        </table>


                                       
                                    </div>


                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
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

        <script type="text/javascript" src="../../dist/js/footable.min.js"></script>
        <script>
            jQuery(function($){
                $('.table').footable();
            });
        </script>

    </body>

</html>
