<?php

$sql = "SELECT * FROM UsersInfo WHERE userType = :userType";

$namedParameters = array();
$namedParameters[':userType'] = "1";
$stmt = $dbConn->prepare($sql);
$stmt->execute($namedParameters);
$agentResults = $stmt->fetchAll();

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- Sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <a href="index.php" class="logo">
            <!-- Logo -->
            <img class="img-responsive" src="../dist/img/remax-logo.png">
        </a>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <?php
                foreach ($agentResults as $agent) {
                    // echo '<li class="header" style="color: white;">' . $agent['firstName'] . " " . $agent['lastName'] . '</li>';
                    // echo '<li style="color: white;"><a href="#"><span>Phone: ' . $agent['phone'] . '</span></a></li>';
                    // echo '<li style="color: white;"><a href="#"><span>Email: ' . $agent['email'] . '</span></a></li>';

                    echo '<li class="header-style treeview">
                            <a href="#"><span class="header-color">' . $agent['firstName'] . " " . $agent['lastName'] . ' </span>
                            <span class="pull-right-container">
                             <i class="fa fa-angle-left pull-right"></i>
                             </span>
                            </a>
                        <ul class="treeview-menu">
                    <li><a class="dropdown-text" href="#"> <span>Phone: ' . $agent['phone'] . '</span></a></li>
                    <li><a class="dropdown-text" href="#"><span>Email: ' . $agent['email'] . '</span></a></li>
                </ul>
            </li>';
                }
            ?>
            <!-- <li class="header-style treeview">
                <a href="#"><span class="header-color">PROPERTIES</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                    <li><a class="dropdown-text" href="my-inventory.php"><i class="fa fa-home"></i>
                            <span>My Inventory</span></a></li>
                    <li><a class="dropdown-text" href="office-inventory.php"><i class="fa fa-building"></i> <span>Office Inventory</span></a>
                    </li>
                    <li><a class="dropdown-text" href="inputNewListing.php"><i class="fa fa-upload"></i> <span>Input New  Listing</span></a>
                    </li>
                </ul>
            </li> -->

         <!--    
            <li class="active"><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li><a href="agent-roster.php"><i class="fa fa-users"></i> <span>Agent Roster</span></a></li>
            <li class="header">PROPERTIES</li>
            <li><a href="inventory.php"><i class="fa fa-home"></i> <span>Office Inventory</span></a></li>
            <li><a href="coming-soon.php"><i class="fa fa-flag"></i> <span>Coming Soon</span></a></li>
            <li><a href="past-sales.php"><i class="fa fa-archive"></i> <span>Past Sales</span></a></li>
            <li class="header">TRANSACTIONS</li>
            <li><a href="sales-breakdown.php"><i class="fa fa-list-alt"></i> <span> Sales Breakdown</span></a></li>
            <li><a href="monthly-report.php"><i class="fa fa-line-chart"></i> <span>Monthly Report</span></a></li>
            <li><a href="c_sheet.php"><i class="fa fa-file-text-o"></i> <span>Commission Sheet</span></a></li>
            <li class="header">STATISTICS</li>
            <li><a href="analytics.php"><i class="fa fa-line-chart"></i> <span> Analytics</span></a></li> 
        -->
        </ul> 
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
