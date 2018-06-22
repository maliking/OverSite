<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- Sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <a href="../index.php" class="logo">
            <!-- Logo -->
            <img class="img-responsive" src="../../dist/img/remax-logo.png">
        </a>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <!--            <li class="active"><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>-->
            <li><a href="../my-inventory.php"><i class="fa fa-home"></i> <span>Listings</span></a></li>
            <!-- <li><a href="visitors.php"><i class="fa fa-male"></i> <span>My Visitors</span></a></li> -->

            <li class="header-style treeview">
                <a href="visitors.php"><span class="header-color">My Visitors</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="visitors.php"><i class="fa fa-male"></i> <span>My Visitors</span></a></li>
                    <li><a href="#"><i class="fa fa-list-alt"></i> <span id="exportVisitors">Export Visitors</span></a>
                    </li>
                </ul>
            </li>


            <?php echo '<li><a href=../signIn.php?id=' . $listingId  . ' target="_blank"><i class="fa fa-edit"></i> <span>Sign In Sheet</span></a></li>'; ?>
            <li><a href="#"><i class="fa fa-globe"></i> <span>Geofencing</span></a></li>
            <li><a href="../index.php"><i class="fa fa-arrow-left"></i> <span>Return to Agent Dashboard</span></a></li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
