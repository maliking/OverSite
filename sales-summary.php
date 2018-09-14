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

$grossSql = "SELECT SUM(InitialGross) as grossResult FROM commInfo";
$grossStmt = $dbConn->prepare($grossSql);
$grossStmt->execute();
$grossResult = $grossStmt->fetch();

$officeSql = "SELECT SUM(brokerFee) as officeResult FROM commInfo";
$officeStmt = $dbConn->prepare($officeSql);
$officeStmt->execute();
$officeResult = $officeStmt->fetch();

$avgPercentSql = "SELECT AVG(percentage) as avgPercentResult FROM commInfo";
$avgPercentStmt = $dbConn->prepare($avgPercentSql);
$avgPercentStmt->execute();
$avgPercentResult = $avgPercentStmt->fetch();

$otherSumSql = "SELECT SUM(eoFee) as eoFee, SUM(techFee) as techFee, SUM(procFee) as procFee,
                SUM(remaxFee) as remaxFee, SUM(misc) as misc FROM commInfo";
$otherStmt = $dbConn->prepare($otherSumSql);
$otherStmt->execute();
$otherResult = $otherStmt->fetch();
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
                Sales Summarys
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
                                    <th>Rank</th>
                                    <th>Name</th>
                                    <th>closed Units</th>
                                    <th>Vol Sold</th>
                                    <th>GCI</th>
                                    <th>Avg. Percentage</th>
                                    <th>Broker Fee</th>
                                    <th>E&O Fee</th>
                                    <th>Tech Fee</th>
                                    <th>Processing Fee</th>
                                    <th>Remax Fee</th>
                                    <th>Misc</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $rank = 1;
                                $sql = "SELECT UsersInfo.firstName, UsersInfo.lastName, COUNT(commInfo.license) as closedUnits, commInfo.license, 
                                        SUM(commInfo.finalHousePrice) as volSold, SUM(commInfo.InitialGross) as GCI, AVG(commInfo.percentage) as avgPercent,
                                        SUM(commInfo.brokerFee) as brokerFee, SUM(commInfo.eoFee) as eoFee, SUM(commInfo.techFee) as techFee,
                                        SUM(commInfo.procFee) as procFee, SUM(commInfo.remaxFee) as remaxFee, SUM(commInfo.misc) as misc
                                        FROM UsersInfo LEFT JOIN commInfo ON UsersInfo.license = commInfo.license WHERE UsersInfo.userType != '0' GROUP BY commInfo.license
                                        ORDER BY closedUnits DESC";

                                $namedParameters = array();
                                $namedParameters[':userId'] = $_SESSION['userId'];
                                $stmt = $dbConn->prepare($sql);
                                $stmt->execute($namedParameters);
                                $results = $stmt->fetchAll();

                                foreach($results as $result) {
                                    $license = $result['license'];
                                    if($result['license'] == null)
                                        $license = 0;
                                    if($result['volSold'] == "")
                                        $result['volSold'] = 0;
                                    if($result['GCI'] == "")
                                        $result['GCI'] = 0;
                                    echo "<tr style='cursor:pointer;' class='clickable-row' data-href='sales-breakdown-individual.php?license=".$license."'>";
                                    // Rank
                                    echo "<td>";
                                    echo $rank;
                                    echo "</td>";

                                    // Name
                                    echo "<td>";
                                    echo $result['firstName'] . " " . $result['lastName'];
                                    echo "</td>";

                                   
                                    // Closed Unites
                                    echo "<td>";
                                    echo $result['closedUnits'];
                                    echo "</td>";

                                    // Volume sold
                                    echo "<td>";
                                    echo "$" . number_format($result['volSold']);
                                    echo "</td>";

                             
                                    // Initial Gross
                                    echo "<td>";
                                    echo "$" . number_format($result['GCI']);
                                    echo "</td>";

                                    // Avg Percentage
                                    echo "<td>";
                                    echo number_format($result['avgPercent'], 2, '.','') . "%";
                                    echo "</td>";

                                    // Broker Fee Total
                                    echo "<td>";
                                    echo "$" . number_format($result['brokerFee']);
                                    echo "</td>";

                                    // E&O Fee
                                    echo "<td>";
                                    echo "$" . number_format($result['eoFee'],2);
                                    echo "</td>";

                                    // Tech Fee
                                    echo "<td>";
                                    echo "$" . number_format($result['techFee'],2);
                                    echo "</td>";

                             
                                    // Proc Fee
                                    echo "<td>";
                                    echo "$" . number_format($result['procFee'],2);
                                    echo "</td>";

                                    // Remax Fee
                                    echo "<td>";
                                    echo "$" . number_format($result['remaxFee'], 2, '.','');
                                    echo "</td>";

                                    // Misc
                                    echo "<td>";
                                    echo "$" . number_format($result['misc'],2);
                                    echo "</td>";

                                    echo "</tr>";
                                    $rank++;
                                }
                                ?>
                                
                                </tbody>
                            </table>
                            <table class="table table-bordered table-striped">
                                
                            <tbody>
                            <tr>
                                    <td>Total</td>
                                    <td></td>
                                    <td><?php echo "Units: " . $totalClosed['totalClosed']; ?></td>
                                    <td><?php echo "Vol Sold: $" . number_format($volResult['volResult']); ?></td>
                                    <td><?php echo "GCI: $" . number_format($grossResult['grossResult']); ?></td>
                                    <td><?php echo "AVG: " . number_format($avgPercentResult['avgPercentResult'], 2, '.','') . "%"; ?></td>
                                    <td><?php echo "Office: $" . number_format($officeResult['officeResult']); ?></td>

                                    <td><?php echo "E&O Fee: $" . number_format($otherResult['eoFee'],2); ?></td>
                                    <td><?php echo "Tech Fee: $" . number_format($otherResult['techFee'],2); ?></td>
                                    <td><?php echo "Procc. Fee: $" . number_format($otherResult['procFee'],2); ?></td>
                                    <td><?php echo "Remax Fee: $" . number_format($otherResult['remaxFee'], 2, '.',''); ?></td>
                                    <td><?php echo "Misc: $" . number_format($otherResult['misc'],2); ?></td>

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
        $('.table').footable({
            "sorting": {
                "enabled": true
            },
            "filtering": {
            "connectors": false,
            "position": "center"
            }
        });
    });

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
</body>

</html>
