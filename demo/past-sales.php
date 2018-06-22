<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT HouseInfo.address, HouseInfo.city, HouseInfo.zip, HouseInfo.bedrooms, HouseInfo.bathrooms, HouseInfo.price, HouseInfo.sqft FROM HouseInfo
  INNER JOIN commInfo ON HouseInfo.houseId = commInfo.houseId";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Past Sales</title>

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
                Past Sales
            </h1>
            <ol class="breadcrumb">
                <li>Properties</li>
                <li class="active"><a href="#"><i class="fa fa-archive"></i> Past Sales</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered table-striped" data-filtering="true" data-sorting="true">
                                <thead>
                                <tr>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Zip</th>
                                    <th><i class="fa fa-bed"></i></th>
                                    <th><i class="fa fa-bath"></i></th>
                                    <th>Sqft</th>
                                    <th>Lot</th>
                                    <th>Price</th>
                                    <th>DOM <a href="#" data-toggle="tooltip" data-placement="top"
                                               title="Days on the market"><i class="fa fa-question-circle"></i></a></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($result as $house) {
                                    echo "<tr>";
                                    echo "<td>" . $house['address'] . "</td>";
                                    echo "<td>" . $house['city'] . "</td>";
                                    echo "<td>" . $house['zip'] . "</td>";
                                    echo "<td>" . $house['bedrooms'] . "</td>";
                                    echo "<td>" . $house['bathrooms'] . "</td>";
                                    echo "<td>" . $house['sqft'] . "</td>";
                                    echo "<td>" . "NA" . "</td>";
                                    echo "<td>" . '$' . number_format($house['price'], 0) . "</td>";
                                    echo "<td>" . "NA" . "</td>";
                                    echo "</tr>";
                                }
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
