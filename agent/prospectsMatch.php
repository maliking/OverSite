<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

$prospectInfoSql = "SELECT * FROM favorites WHERE favoriteId = :favoriteId";
$prospectParameters = array();
$prospectParameters[':favoriteId'] = $_GET['visitorId'];
$prospectStmt = $dbConn->prepare($prospectInfoSql);
$prospectStmt->execute($prospectParameters);
$prospectResult = $prospectStmt->fetch();

$houseMatchSql = "SELECT HouseInfo.* , UsersInfo.firstName as fName, UsersInfo.lastName as lName FROM HouseInfo LEFT JOIN UsersInfo ON HouseInfo.agentMlsId = UsersInfo.mlsId 
                WHERE HouseInfo.bedrooms <= :bedroom AND HouseInfo.bathrooms <= :bathroom AND HouseInfo.price BETWEEN :lessPrice AND :morePrice AND HouseInfo.houseId != '0'
                AND UsersInfo.userType != '0'
                ORDER BY price DESC";
$namedParameters = array();
$namedParameters[':morePrice'] = $prospectResult['price'] + 70000;
$namedParameters[':lessPrice'] = $prospectResult['price'] - 50000;
$namedParameters[':bedroom'] = $prospectResult['bedroom'] ;
$namedParameters[':bathroom'] = $prospectResult['bathroom'] ;
$stmt = $dbConn->prepare($houseMatchSql);
$stmt->execute($namedParameters);
$results = $stmt->fetchAll();
?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>RE/MAX Salinas | Sales Breakdown</title>

        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
        <?php include "./templates-agent/default-css.php" ?>
        <!-- END TEMPLATE default-css.php INCLUDE -->
        <style>
            .modal-title {
                font-size: 150%;
                font-weight: bold;
            }
            
            #modal-table {
                color: black;
            }

        </style>
        <!-- NOTIFICATION Links-->
        

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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content" style="min-height:initial;">
                    <!-- Content Wrapper. Contains page content -->
                    <!-- Small boxes (Stat box) -->
                <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <h4>Active Prospects</h4>
                                    <!-- <button onClick="showProspectModal()">Add Prospect</button> -->
                                </div>
                                <div class="box-body" style="height:200px; overflow: auto;">
                                    <table class="table footable table-bordered table-striped">
                                        <thead>
                                            
                                            <!-- <th style="width:20px;">Favorite</th> -->
                                            <th>Agent</th>
                                            <th>Address</th>
                                            <th>Price</th>
                                            <th>Bedroom</th>
                                            <th>Bathroom</th>
                                            <th>Zip</th>
                                            <th>SQFT</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Prospect</td>
                                            <td></td>
                                            <td><?php echo $prospectResult['price'];  ?></td>
                                            <td><?php echo $prospectResult['bedroom'];  ?></td>
                                            <td><?php echo $prospectResult['bathroom'];  ?></td>
                                            <td><?php echo $prospectResult['zip'];  ?></td>
                                            <td><?php echo $prospectResult['sqft'];  ?></td>
                                        </tr>

                                            <?php

                                            foreach ($results as $house) 
                                            {                                            
                                                echo "<tr>";
                                                echo "<td>" . $house['fName'] . " " . $house['lName'] . "</td>";
                                                echo "<td>" . $house['address'] . " " . $house['city'] . " " . $house['state'] . " " . $house['zip'] . "</td>";
                                                echo "<td>" . $house['price'] . "</td>";
                                                echo "<td>" . $house['bedrooms'] . "</td>";
                                                echo "<td>" . $house['bathrooms'] . "</td>";
                                                echo "<td>" . $house['zip'] . "</td>";
                                                echo "<td>" . $house['sqft'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                            <!-- <tr>
                                            <td class="fa fa-usd"  style="color: green; text-align: center;" onClick="deleteFavorite()"></td>
                                            <td>test</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><a href="prospectsMatch.php">House Matches</a></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

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


      
        <!-- Custom Theme Scripts -->
        <script src="build/js/custom.min.js"></script>

        <!-- date-range-picker -->
        <script src="../plugins/moment/min/moment.min.js"></script>
        <script src="../plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

        <script>
            jQuery(function($){
                $('.footable').footable({

                    // "paging": {
                    //     "enabled": true,
                    //     "size": 4,
                    //     "position": "right"
                    // }

                });
            });
           
        </script>


    </body>

    </html>
