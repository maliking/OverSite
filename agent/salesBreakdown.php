<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: http://jjp2017.org/login.php");
}
require '../databaseConnection.php';
$dbConn = getConnection();

$sql = "SELECT * FROM commInfo WHERE license = :license";
$param = array();
$param[':license'] = $_SESSION['license'];
$stmt = $dbConn->prepare($sql);
$stmt->execute($param);
$commSales = $stmt->fetchAll();

$dbConn = getConnection();
$sql = "SELECT COUNT(*) as totalClosed, SUM(finalHousePrice) as volResult, SUM(InitialGross) as grossResult, SUM(finalComm) as finalCommResult, AVG(finalHousePrice) as avgPercentResult FROM commInfo WHERE license = :license";
$stmt = $dbConn->prepare($sql);
$stmt->execute($param);
$totalClosed = $stmt->fetch();

// $sumVolSql = "SELECT SUM(finalHousePrice) as volResult FROM commInfo";
// $volStmt = $dbConn->prepare($sumVolSql);
// $volStmt->execute();
// $volResult = $volStmt->fetch();

// $grossSql = "SELECT SUM(InitialGross) as grossResult FROM commInfo";
// $grossStmt = $dbConn->prepare($grossSql);
// $grossStmt->execute();
// $grossResult = $grossStmt->fetch();

// $officeSql = "SELECT SUM(brokerFee) as officeResult FROM commInfo";
// $officeStmt = $dbConn->prepare($officeSql);
// $officeStmt->execute();
// $officeResult = $officeStmt->fetch();

// $avgPercentSql = "SELECT AVG(percentage) as avgPercentResult FROM commInfo";
// $avgPercentStmt = $dbConn->prepare($avgPercentSql);
// $avgPercentStmt->execute();
// $avgPercentResult = $avgPercentStmt->fetch();

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
                        <div class="box-header">
                            <!-- <button onClick="formatNumbers()">Recalculate numbers</button> -->
                            <div class="clearfix"></div>

                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped" data-filtering="true">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>Date Settled</th>
                                    <th>Property Address</th>
                                    <th data-type="text">Agent</th>
                                    <th>Gross Comm.</th>
                                    <!-- <th>Office</th> -->
                                    <th data-breakpoints="all">E&O <a href="#" data-toggle="tooltip"
                                                                      data-placement="top" title="Errors & Omissions"><i
                                                    class="fa fa-question-circle"></i></a></th>
                                    <th data-breakpoints="all">Tech Fee</th>
                                    <th data-breakpoints="all">Processing</th>
                                    <th data-breakpoints="all">RE/MAX FF</th>
                                    <th data-breakpoints="all">Misc</th>
                                    <!-- <th>Agent Net Commission</th> -->
                                    <th>YTD Ending Gross Comm.</th>
                                    <th data-breakpoints="all">Client</th>
                                    <th>House Price</th>
                                    <th>Avg. Perc.</th>
                                    <th>Listing/Buyer</th>
                                    <!-- <th data-breakpoints="all">Notes</th> -->
                                    <th data-breakpoints="all">Commission Sheet</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($commSales as $sales) {
                                    echo "<tr id=commSheet" . $sales['commId'] . " >";
                                    echo "<td></td>";
                                    echo "<td class=rowNumber ></td>";
                                    echo "<td ondblclick=editCommInfo('settlementDate','". $sales['commId'] ."') >" . date("m-d-Y", strtotime($sales['settlementDate'])) . "</td>";
                                    echo "<td ondblclick=editCommInfo('address','". $sales['commId'] ."') >" . $sales['address'] . "</td>";
                                    // echo "<td ondblclick=editCommInfo('name') >" . $sales['firstName'] . " " . $sales['lastName'] . "</td>";
                                    echo "<td>" . $sales['firstName'] . " " . $sales['lastName'] . "</td>";
                                    echo "<td ondblclick=editCommInfo('initialGross','". $sales['commId'] ."') >" . '$' . number_format($sales['InitialGross'], 2) . "</td>"; //Total
                                    // echo "<td>" . '$' . number_format($sales['brokerFee'], 2) . "</td>"; //office
                                    echo "<td ondblclick=editCommInfo('eoFee','". $sales['commId'] ."') >$" . number_format($sales['eoFee'],2) . "</td>"; //eo
                                    echo "<td ondblclick=editCommInfo('techFee','". $sales['commId'] ."') >$" . number_format($sales['techFee'],2) . "</td>"; //tech
                                    echo "<td ondblclick=editCommInfo('procFee','". $sales['commId'] ."') >$" . number_format($sales['procFee'],2) . "</td>"; //processing
                                    echo "<td ondblclick=editCommInfo('remaxFee','". $sales['commId'] ."') >" . '$' . number_format($sales['remaxFee'], 2) . "</td>"; //remax_ff
                                    echo "<td><span ondblclick=editCommInfo('miscTitle','". $sales['commId'] ."')>" . $sales['miscTitle'] . ' :</span> <span ondblclick=editCommInfo("miscFee","'. $sales['commId'] .'")>$' . number_format($sales['misc'], 2) . "</span></td>"; //misc
                                    // echo "<td>" . '$' . number_format($sales['finalComm'], 2) . "</td>"; //commission
                                    echo "<td>" . '$' . number_format($sales['TYGross'], 2) . "</td>"; //commission
                                    echo "<td ondblclick=editCommInfo('clients','". $sales['commId'] ."') >" . $sales['clients'] . "</td>"; //client
                                    echo "<td ondblclick=editCommInfo('finalHousePrice','". $sales['commId'] ."') >" . '$' . number_format($sales['finalHousePrice'], 2) . "</td>"; //price
                                    echo "<td>" . number_format($sales['percentage'], 2, '.','') . "%</td>"; //Avg Percent
                                    echo "<td ondblclick=editCommInfo('type','". $sales['commId'] ."') >" . $sales['type'] . "</td>"; //listing buyer
                                    // echo "<td>" . $sales['notes'] . "</td>"; //notes
                                    echo '<td> <a href="viewCommissionSheet.php?comm=' . $sales['commId'] . '" target="_blank"> <button>View Commission Sheet</button> </a> </td>';
                                    echo "<td><button onClick=deleteCommSheet(" . $sales['commId'] . ") >Delete</button></td>";
                                    echo "</tr>";
                                }
                                ?>

                                <?php
                                ?>

                                </tbody>
                            </table>
                            <table class="table table-bordered table-striped">
                                
                            <tbody>
                            <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td><?php echo "Units: " . $totalClosed['totalClosed']; ?></td>
                                    <td><?php echo "YTD GCI: $" . number_format($totalClosed['grossResult']); ?></td>
                                    <td><?php echo "YTD NET: $" . number_format($totalClosed['finalCommResult']); ?></td>
                                    <td><?php echo "Vol Sold: $" . number_format($totalClosed['volResult']); ?></td>
                                    <td><?php echo "AVG House Price: $" . number_format($totalClosed['avgPercentResult'], 2, '.',','); ?></td>
                                    <!-- <td><?php //echo "Office: $" . number_format($totalClosed['officeResult']); ?></td> -->
                                </tr>
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


                <!-- Main content -->
                <!-- <section class="content" style="min-height:initial;"> -->
                    <!-- Content Wrapper. Contains page content -->
                    <!-- Small boxes (Stat box) -->
                   <!-- <img src="underConstruction.jpg" style="width:100%;height:100%;"> -->
                <!-- </section> -->
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
        <!-- <script src="salesBreakdownAgentJS.js"></script> -->
        <script>
           jQuery(function ($) {
        $('.table').footable({
            "sorting": {
                "enabled": true
            },
            "filtering": {
            "connectors": false,
            "position": "center"
            }
        });

        $('.table').bind({
                'after.ft.sorting': function (e) {
                addRowCount('.table');
                },
                'footable_filtering': function (e) {
                addRowCount('.table');
                },
                'ready.ft.table': function (e){
                    addRowCount('.table');
                }
                });
        function addRowCount(tableAttr) {
                var PageNumber = 0;
                $(tableAttr).each(function () {
                var RowCount = $('td.rowNumber', this).length;
                // alert(RowCount);
                $('td.rowNumber', this).each(function (i) {
                
                $(this).html( i + 1);

                });
                });
                }
    });

           function deleteCommSheet(commId)
    {
        bootbox.confirm({
            message: "Are you sure you want to delete the commission sheet?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result == true)
                {
                    $.post( "../deleteCommSheet.php", { commId: commId })
                      .done(function( data ) {
                        alert( "Commission Sheet Deleted");
                        $('#commSheet' + commId).remove();
                      });
                }
                
            }
        });
    }

           
        </script>


    </body>

    </html>
