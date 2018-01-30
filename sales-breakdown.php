<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT * FROM commInfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Sales Breakdown</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->
    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="dist/css/vendor/footable.bootstrap.min.css">
</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site Wrapper -->
<div class="wrapper">
    <!-- BEGIN TEMPLATE header.php INCLUDE -->
    <?php include "./templates-admin/header.php" ?>
    <!-- END TEMPLATE header.php INCLUDE -->

    <!-- BEGIN TEMPLATE nav.php INCLUDE -->
    <?php include "./templates-admin/nav.php" ?>
    <!-- END TEMPLATE nav.php INCLUDE -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Sales Breakdown
            </h1>
            <ol class="breadcrumb">
                <li>Transactions</li>
                <li class="active"><a href="#"><i class="fa fa-archive"></i> Sales Breakdown</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered table-striped" data-filtering="true">
                                <thead>
                                <tr>
                                    <th>Date Settled</th>
                                    <th>Property Address</th>
                                    <th>Agent</th>
                                    <th>Total</th>
                                    <th data-breakpoints="all">Office</th>
                                    <th data-breakpoints="all">E&O <a href="#" data-toggle="tooltip"
                                                                      data-placement="top" title="Errors & Omissions"><i
                                                    class="fa fa-question-circle"></i></a></th>
                                    <th data-breakpoints="all">Tech Fee</th>
                                    <th data-breakpoints="all">Processing</th>
                                    <th data-breakpoints="all">RE/MAX FF</th>
                                    <th data-breakpoints="all">Misc</th>
                                    <th>Commission</th>
                                    <th data-breakpoints="all">Client</th>
                                    <th>Price</th>
                                    <th>Listing/Buyer</th>
                                    <th data-breakpoints="all">Notes</th>
                                    <th data-breakpoints="all">Commission Sheet</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($result as $sales) {
                                    echo "<tr>";
                                    echo "<td>" . date("m-d-Y", strtotime($sales['settlementDate'])) . "</td>";
                                    echo "<td>" . $sales['address'] . "</td>";
                                    echo "<td>" . $sales['firstName'] . " " . $sales['lastName'] . "</td>";
                                    echo "<td>" . '$' . number_format($sales['InitialGross'], 0) . "</td>"; //Total
                                    echo "<td>" . '$' . number_format($sales['brokerFee'], 0) . "</td>"; //office
                                    echo "<td>" . '$99.00' . "</td>"; //eo
                                    echo "<td>" . '$50.00' . "</td>"; //tech
                                    echo "<td>" . '$200.00' . "</td>"; //processing
                                    echo "<td>" . '$' . number_format($sales['remaxFee'], 0) . "</td>"; //remax_ff
                                    echo "<td>" . '$' . number_format($sales['misc'], 0) . "</td>"; //misc
                                    echo "<td>" . '$' . number_format($sales['finalComm'], 0) . "</td>"; //commission
                                    echo "<td>" . $sales['clients'] . "</td>"; //client
                                    echo "<td>" . '$' . number_format($sales['finalHousePrice'], 0) . "</td>"; //price
                                    echo "<td>" . $sales['clients'] . "</td>"; //listing buyer
                                    echo "<td>" . $sales['notes'] . "</td>"; //notes
                                    echo '<td> <a href="viewCommissionSheet.php?comm=' . $sales['commId'] . '" target="_blank"> <button>View Commission Sheet</button> </a> </td>';
                                    echo "</tr>";
                                }
                                ?>

                                <?php
                                //                                                $dbConn = getConnection();
                                //
                                //                                                $sql = "SELECT status, houseId, date(dateTimes) as dateTimes, address, city, state, zip, bedrooms, bathrooms, price
                                //                                                            FROM HouseInfo
                                //                                                            WHERE userId = :userId
                                //                                                            ORDER BY dateTimes ASC";
                                //
                                //                                                //$namedParameters = array();
                                //                                                //$namedParameters[':userId'] = $_SESSION['userId'];
                                //                                                //$stmt = $dbConn -> prepare($sql);
                                //                                                /*$stmt->execute($namedParameters);
                                //                                                //$stmt->execute();
                                //                                                $results = $stmt->fetchAll();
                                //
                                //                                                foreach($results as $result){
                                //                                                    echo "<tr>";
                                //                                                    echo "<td>" . $result['houseId'] . "</td>";
                                //                                                    echo "<td>" . $result['address'] . "</td>";
                                //                                                    echo "<td>King</td>";
                                //                                                    echo "<td>Mali</td>";
                                //                                                    echo "<td>4083488336</td>":
                                //                                                    echo "<td>5/6/17</td>";
                                //                                                    echo "<td>5/9/17</td>";
                                //                                                    echo "<td>5/12/17</td>";
                                //                                                    echo "<td>5/12/17</td>";
                                //                                                    echo "<td>5/12/17</td>";
                                //                                                    echo "<td>Notes</td>";
                                //                                                    echo "</tr>";
                                //                                                } //closes foreach*/
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- /.wrapper -->


<!-- BEGIN TEMPLATE default-footer.php INCLUDE -->
<?php include "./templates-admin/default-footer.php" ?>
<!-- END TEMPLATE default-footer.php INCLUDE -->

<!-- Sidebar Background -->
<div class="control-sidebar-bg">
</div>
<!-- BEGIN TEMPLATE default-js.php INCLUDE -->
<?php include "./templates-admin/default-js.php" ?>
<!-- END TEMPLATE default-js.php INCLUDE -->

<!-- PAGE-SPECIFIC JS -->
<script src="dist/js/vendor/footable.min.js"></script>

<script>
    jQuery(function ($) {
        $('.table').footable();
    });
</script>
</body>

</html>
