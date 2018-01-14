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
             <li><a href="./index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="header-style treeview">
                            <a href="#"><span class="header-color">AGENTS</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
        <ul class="treeview-menu">
            <!-- <li><a class="dropdown-text" href="agentPage.php"> <span>John Doe</span></a></li> -->
            <?php
                foreach ($agentResults as $agent) {
               

                    echo '<li class="header-style treeview">
                            <a href="#"><span class="header-color">' . $agent['firstName'] . " " . $agent['lastName'] . ' </span>
                            <span class="pull-right-container">
                             <i class="fa fa-angle-left pull-right"></i>
                             </span>
                            </a>
                        <ul class="treeview-menu">
                    <li><a class="dropdown-text" href="agentPage.php?userId='.$agent['userId'] .'"> <span>Agent Page</span></a></li>
                    <li><a class="dropdown-text" href="#"> <span>Phone: ' . $agent['phone'] . '</span></a></li>
                    <li><a class="dropdown-text" href="#"><span>Email: ' . $agent['email'] . '</span></a></li>
                </ul>
            </li>';
                }
            ?>
           
        </ul>
           </li>
               <li><a href="./office-inventory.php"><i class="fa fa-building"></i> <span>Office Inventory</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
