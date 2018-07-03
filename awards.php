<?php
session_start();

require 'databaseConnection.php';

$dbConn = getConnection();
$sql = "SELECT COUNT(*) as totalClosed FROM commInfo";
$stmt = $dbConn->prepare($sql);
$stmt->execute();
$totalClosed = $stmt->fetch();

$sumVolSql = "SELECT SUM(finalHousePrice) as volResult FROM commInfo";
$volStmt = $dbConn->prepare($sumVolSql);
$volStmt->execute();
$volResult = $volStmt->fetch();

$grossSql = "SELECT SUM(finalComm) as grossResult FROM commInfo";
$grossStmt = $dbConn->prepare($grossSql);
$grossStmt->execute();
$grossResult = $grossStmt->fetch();

$avgPercentSql = "SELECT AVG(percentage) as avgPercentResult FROM commInfo";
$avgPercentStmt = $dbConn->prepare($avgPercentSql);
$avgPercentStmt->execute();
$avgPercentResult = $avgPercentStmt->fetch();
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
                Awards
            </h1>
            <ol class="breadcrumb">
                <li>Transactions</li>
                <li class="active"><a href="#"><i class="fa fa-archive"></i>Awards</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <button class="load-rows" type="button" data-url="yearToDateAwards.php">Year To Date</button>
                            <button class="load-rows" type="button" data-url="quarterOneAwards.php">Q1</button>
                            <button class="load-rows" type="button" data-url="quarterTwoAwards.php">Q2</button>
                            <button class="load-rows" type="button" data-url="quarterThreeAwards.php">Q3</button>
                            <button class="load-rows" type="button" data-url="quarterFourAwards.php">Q3</button>
                            <table class="table table-bordered table-striped" data-filtering="true">
                                
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
        // var ft = $('.table').footable({
        //     "sorting": {
        //         "enabled": true
        //     },
        //     "filtering": {
        //     "connectors": false,
        //     "position": "center"
        //     }
        // });
    var ft = FooTable.init('.table', {
        // we only load the column definitions as the row data is loaded through the button clicks
        "columns": $.getJSON('awardsColumns.json'),
            "sorting": {
                "enabled": true
            },
            "filtering": {
            "connectors": false,
            "position": "center"
            }
    });

        // bind the buttons to load the rows
    $('.load-rows').on('click', function (e) {
        e.preventDefault();
        $( ".load-rows" ).each(function() {
          $(this).css( 'background-color','' );
        });
        $(this).css('background-color','red');
        // get the url to load off the button
        var url = $(this).data('url');
        // ajax fetch the rows
        $.getJSON(url).then(function (rows) {
            // and then load them using either
            ft.rows.load(rows);
            // or
            // ft.loadRows(rows);
        });
    });

    });

</script>
</body>

</html>
