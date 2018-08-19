<?php
session_start();

require 'databaseConnection.php';
$individual_license = 0;
if(isset($_GET['license']))
    $individual_license = $_GET['license'];
$dbConn = getConnection();
$sql = "SELECT * FROM commInfo where commInfo.license = $individual_license";
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
                Agent Sales Breakdown
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
                            <button onClick="formatNumbers()">Recalculate numbers</button>
                            <div class="clearfix"></div>

                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-striped" data-filtering="true">
                                <thead>
                                <tr>
                                    <th>Date Settled</th>
                                    <th>Property Address</th>
                                    <th data-type="text">Agent</th>
                                    <th>Gross Comm.</th>
                                    <th>Office</th>
                                    <th data-breakpoints="all">E&O <a href="#" data-toggle="tooltip"
                                                                      data-placement="top" title="Errors & Omissions"><i
                                                    class="fa fa-question-circle"></i></a></th>
                                    <th data-breakpoints="all">Tech Fee</th>
                                    <th data-breakpoints="all">Processing</th>
                                    <th data-breakpoints="all">RE/MAX FF</th>
                                    <th data-breakpoints="all">Misc</th>
                                    <th>Agent Net Commission</th>
                                    <th>Ending Comm.</th>
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
                                foreach ($result as $sales) {
                                    echo "<tr id=commSheet" . $sales['commId'] . " >";
                                    echo "<td ondblclick=editCommInfo('settlementDate','". $sales['commId'] ."') >" . date("m-d-Y", strtotime($sales['settlementDate'])) . "</td>";
                                    echo "<td ondblclick=editCommInfo('address','". $sales['commId'] ."') >" . $sales['address'] . "</td>";
                                    // echo "<td ondblclick=editCommInfo('name') >" . $sales['firstName'] . " " . $sales['lastName'] . "</td>";
                                    echo "<td>" . $sales['firstName'] . " " . $sales['lastName'] . "</td>";
                                    echo "<td ondblclick=editCommInfo('initialGross','". $sales['commId'] ."') >" . '$' . number_format($sales['InitialGross'], 2) . "</td>"; //Total
                                    echo "<td>" . '$' . number_format($sales['brokerFee'], 2) . "</td>"; //office
                                    echo "<td ondblclick=editCommInfo('eoFee','". $sales['commId'] ."') >$" . number_format($sales['eoFee'],2) . "</td>"; //eo
                                    echo "<td ondblclick=editCommInfo('techFee','". $sales['commId'] ."') >$" . number_format($sales['techFee'],2) . "</td>"; //tech
                                    echo "<td ondblclick=editCommInfo('procFee','". $sales['commId'] ."') >$" . number_format($sales['procFee'],2) . "</td>"; //processing
                                    echo "<td ondblclick=editCommInfo('remaxFee','". $sales['commId'] ."') >" . '$' . number_format($sales['remaxFee'], 2) . "</td>"; //remax_ff
                                    echo "<td><span ondblclick=editCommInfo('miscTitle','". $sales['commId'] ."')>" . $sales['miscTitle'] . ' :</span> <span ondblclick=editCommInfo("miscFee","'. $sales['commId'] .'")>$' . number_format($sales['misc'], 2) . "</span></td>"; //misc
                                    echo "<td>" . '$' . number_format($sales['finalComm'], 2) . "</td>"; //commission
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script src="salesBreakdownJS.js"></script>
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
                    $.post( "deleteCommSheet.php", { commId: commId })
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
