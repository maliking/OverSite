<?php
session_start();
// echo($_SESSION['userType']);
if (!isset($_SESSION['userId']) ) {
    header("Location: login.php");
}


require 'databaseConnection.php';

$dbConn = getConnection();
$feeSql = "SELECT remaxFee.userId, remaxFee.paid, remaxFee.date, MONTH(remaxFee.date) as month, UsersInfo.firstName, UsersInfo.lastName FROM remaxFee
        LEFT JOIN UsersInfo ON remaxFee.userId = UsersInfo.userId WHERE YEAR(remaxFee.date) = YEAR(CURRENT_DATE()) ORDER BY UsersInfo.firstName ASC, month ASC";
$stmt = $dbConn->prepare($feeSql);
$stmt->execute();
$agentPaidFees = $stmt->fetchAll();

$dbConnAgents = getConnection();
$agentsSql = "SELECT userId, firstName, lastName FROM UsersInfo WHERE userId != :userId AND userType != 0 ORDER BY firstName ASC";
$agentParam = array();
$agentParam[':userId'] = $_SESSION['userId'];

$stmtAgents = $dbConnAgents->prepare($agentsSql);
$stmtAgents->execute($agentParam);
$agents = $stmtAgents->fetchAll();

$months = array("Jan", "Feb", "March", "April", "May", "June", "July", "Aug", "Sept", "Oct", "Nov", "Dec");
// $dbConnRank = getConnection();
// $sqlRank = "SELECT UsersInfo.firstName, UsersInfo.lastName, count(*) as sold, sum(finalComm) as YTDComm FROM UsersInfo LEFT JOIN commInfo on UsersInfo.license = commInfo.license group by UsersInfo.license order by sold Desc ";
// $stmtRank = $dbConnRank->prepare($sqlRank);
// $stmtRank->execute();
// $rank = $stmtRank->fetchAll();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RE/MAX Salinas | Dashboard</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- BEGIN TEMPLATE default-css.php INCLUDE -->
    <?php include "./templates-admin/default-css.php" ?>
    <!-- END TEMPLATE default-css.php INCLUDE -->

    <!-- PAGE-SPECIFIC CSS -->
    <link rel="stylesheet" href="./dist/css/vendor/footable.bootstrap.min.css">
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Agent Remax Fee
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                       
                        <div class="box-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Agent</th>
                                    <th data-breakpoints="xs sm">Jan</th>
                                    <th data-breakpoints="xs sm">Feb</th>
                                    <th data-breakpoints="xs sm">March</th>
                                    <th data-breakpoints="xs sm">April</th>
                                    <th data-breakpoints="xs sm">May</th>
                                    <th data-breakpoints="xs sm">June</th>
                                    <th data-breakpoints="xs sm">July</th>
                                    <th data-breakpoints="xs sm">Aug</th>
                                    <th data-breakpoints="xs sm">Sept</th>
                                    <th data-breakpoints="xs sm">Oct</th>
                                    <th data-breakpoints="xs sm">Nov</th>
                                    <th data-breakpoints="xs sm">Dec</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($agents as $agent) 
                                {
                                    $monthCounter = 1;
                                    echo "<tr>";

                                    echo "<td>" . $agent['firstName'] . " " . $agent['lastName'] . "</td>";
                                    for ($i=0; $i < 12; $i++) 
                                    { 
                                        $endOfArray = 0;
                                        
                                        foreach ($agentPaidFees as $paid) 
                                        {
                                        
                                            if($paid['userId'] == $agent['userId'] && $paid['month'] == $monthCounter)
                                            {
                                                echo "<td>$ " . $paid['paid'] . "</td>";
                                                break;
                                            }
                                            else if($endOfArray == sizeof($agentPaidFees)-1)
                                            {
                                                echo "<td>$0</td>";
                                            }
                                            $endOfArray++;
                                            
                                        }
                                        $monthCounter++;
                                         
                                    } 
                                    
                                        
                                    

                                    
                                    
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
<script src="./dist/js/vendor/footable.min.js"></script>

<script>
    jQuery(function ($) {
        $('.table').footable({});
    });
</script>
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            html: true
        });
    });
</script>
</body>

</html>
